<?php

namespace App\Models;

class CommonModel extends Custom_model
{
    public function __construct()
    {
        parent::__construct();

        $this->db        =\Config\Database::connect();
        $this->feedbacks = '';
        $this->roadmap   = '';
        $this->category  = '';
        $this->board     = '';
    }

    public function getFeedbacks($board_id = null, $email=null, $feedback_id=null, $upvote = 'popularity', $roadmap_id=null, $search=null, $category_id=null, $limit = null, $offset = 0)
    {
        $this->feedbacks            = db_prefix().'feedbacks';
        $this->roadmap              = db_prefix().'roadmap';
        $this->category             = db_prefix().'category';
        $this->board                = db_prefix().'board';
        $this->users_upvotes_detail = db_prefix().'users_upvotes_detail';
        $this->feedbacks_ideas      = db_prefix().'feedbacks_ideas';

        $builder=$this->db->table($this->feedbacks);

        $builder->select("SQL_CALC_FOUND_ROWS feedback_description", false);
        $builder->select("$this->feedbacks.id as id, upvotes,$this->feedbacks.user_name, feedback_description as feedback, $this->feedbacks.created_at, (SELECT COUNT(feedback_id) FROM $this->feedbacks_ideas WHERE $this->feedbacks.id=$this->feedbacks_ideas.feedback_id ) as total_comments, (SELECT COUNT(feedback_id) FROM $this->users_upvotes_detail WHERE $this->feedbacks.id=$this->users_upvotes_detail.feedback_id AND $this->users_upvotes_detail.user_email = '$email') AS upvoted");
        $builder->select("$this->roadmap.value as status_text, $this->roadmap.id as roadmap_id");
        $builder->select("$this->category.title as category_text");
        $builder->select("$this->board.name as board_name");

        $builder->join($this->roadmap, $this->roadmap.'.id = '.$this->feedbacks.'.status', 'LEFT');
        $builder->join($this->category, $this->category.'.id = '.$this->feedbacks.'.category', 'LEFT');
        $builder->join($this->board, $this->board.'.id = '.$this->feedbacks.'.board_id', 'LEFT');

        $builder->where(['approval_status'=> 1]);

        if (is_numeric($board_id)) {
            $builder->where($this->feedbacks.'.board_id', $board_id);
        }
        if (is_numeric($feedback_id)) {
            $builder->where($this->feedbacks.'.id', $feedback_id);
        }
        if (null !== $roadmap_id) {
            $builder->where($this->feedbacks.'.status', $roadmap_id);
        }
        if (null !== $search) {
            $builder->like('feedback_description', $search);
        }
        if (null !== $category_id) {
            $builder->where($this->feedbacks.'.category', $category_id);
        }

        if ('popularity' == $upvote) {
            $builder->orderBy('total_comments', 'DESC');
        } else {
            $builder->orderBy($this->feedbacks.'.upvotes', $upvote);
        }
        $builder->groupBy($this->feedbacks.'.feedback_description');
        if(!empty($limit)){
            $builder->limit($limit, $offset);
        }
        $query = $builder->get();
        if ($query) {
            return $query->getResult();
        }

        return [];
    }

    public function getRoadmapFeedbacks($board_id = null, $email=null, $feedback_id=null, $roadmap_id=null)
    {
        $this->feedbacks            = db_prefix().'feedbacks';
        $this->roadmap              = db_prefix().'roadmap';
        $this->category             = db_prefix().'category';
        $this->board                = db_prefix().'board';
        $this->users_upvotes_detail = db_prefix().'users_upvotes_detail';

        $builder=$this->db->table($this->feedbacks);

        $builder->select("$this->feedbacks.id as id, upvotes, feedback_description as feedback, $this->feedbacks.created_at, users_upvotes_detail.user_id as upvoted_user_id");
        $builder->select("$this->roadmap.value as status_text, $this->roadmap.id as roadmap_id");
        $builder->select("$this->category.title as category_text");
        $builder->select("$this->board.name as board_name, $this->board.board_slug as board_slug");

        if (null !== $email) {
            $builder->select('
                     (CASE
                     WHEN '.$this->users_upvotes_detail.".user_email = '".$email."' THEN 1 ELSE 0 END)
                     AS upvoted");
        } else {
            $builder->select('0 AS upvoted');
        }

        $builder->join($this->roadmap, $this->roadmap.'.id = '.$this->feedbacks.'.status', 'LEFT');
        $builder->join($this->category, $this->category.'.id = '.$this->feedbacks.'.category', 'LEFT');
        $builder->join($this->board, $this->board.'.id = '.$this->feedbacks.'.board_id', 'LEFT');
        $builder->join($this->users_upvotes_detail, $this->users_upvotes_detail.'.feedback_id = '.$this->feedbacks.'.id', 'LEFT');

        $builder->where(['approval_status'=> 1, $this->feedbacks.'.status'=> $roadmap_id]);
        if (is_numeric($board_id)) {
            $builder->where($this->feedbacks.'.board_id', $board_id);
        }
        if (is_numeric($feedback_id)) {
            $builder->where($this->feedbacks.'.id', $feedback_id);
        }
        $builder->groupBy('id');
        $query = $builder->get();
        if ($query) {
            return $query->getResult();
        }

        return [];
    }

    public function get_charts_data($posted_data)
    {
        $this->feedbacks       = db_prefix().'feedbacks';
        $this->front_users     = db_prefix().'users_front';
        $this->feedbacks_ideas = db_prefix().'feedbacks_ideas';

        $builder = $this->db->table($this->feedbacks);
        $builder->distinct('id');
        $builder->select('COUNT('.$this->front_users.'.id) as total_user,COUNT('.$this->feedbacks_ideas.'.id) as total_comments,COUNT('.$this->feedbacks.'.id) as total_feedbacks');

        if ($posted_data['board_id']) {
            $builder->where($this->feedbacks.'.board_id', $posted_data['board_id']);
        }
        if ($posted_data['range']) {
            if ('period' != $posted_data['range']) {
                $range = json_decode($posted_data['range']);
                $builder->where('DATE('.$this->feedbacks.'.created_at)>=', $range[0]);
                $builder->where('DATE('.$this->feedbacks.'.created_at) <=', $range[1]);
            } else {
                $range = explode('-', $posted_data['from_date']);
                $builder->where('DATE('.$this->feedbacks.'.created_at) >=', trim(_d($range[0])));
                $builder->where('DATE('.$this->feedbacks.'.created_at) <=', trim(_d($range[1])));
            }
        }

        $builder->join($this->front_users, $this->front_users.'.id='.$this->feedbacks.'.user_id', 'LEFT');
        $builder->join($this->feedbacks_ideas, $this->feedbacks_ideas.'.feedback_id='.$this->feedbacks.'.id', 'LEFT');
        $query = $builder->get();

        return $query->getRow();
    }

    public function get_top_ten_feedbacks($where=false, $posted_data=[])
    {
        if ($where) {
            $this->feedbacks = db_prefix().'feedbacks';
            $this->board     = db_prefix().'board';
            $builder         = $this->db->table($this->feedbacks);
            $builder->select('upvotes,feedback_description,name')->limit(10)->orderBy('upvotes', 'DESC');
            $builder->where('approval_status', 1);
            if ($posted_data['board_id']) {
                $builder->where($this->feedbacks.'.board_id', $posted_data['board_id']);
            }
            if ($posted_data['range']) {
                if ('period' != $posted_data['range']) {
                    $range = json_decode($posted_data['range']);
                    $builder->where('DATE('.$this->feedbacks.'.created_at)>=', $range[0]);
                    $builder->where('DATE('.$this->feedbacks.'.created_at) <=', $range[1]);
                } else {
                    $range = explode('-', $posted_data['from_date']);
                    $builder->where('DATE('.$this->feedbacks.'.created_at) >=', trim(_d($range[0])));
                    $builder->where('DATE('.$this->feedbacks.'.created_at) <=', trim(_d($range[1])));
                }
            }
            $builder->join($this->board, $this->board.'.id='.$this->feedbacks.'.board_id', 'LEFT');
            $query = $builder->get();

            return $query->getResult();
        }
        $this->feedbacks = db_prefix().'feedbacks';
        $this->board     = db_prefix().'board';
        $builder         = $this->db->table($this->feedbacks);
        $builder->select('upvotes,feedback_description,name')->limit(10)->orderBy('upvotes', 'DESC');
        $builder->where('approval_status', 1);
        $builder->join($this->board, $this->board.'.id='.$this->feedbacks.'.board_id', 'LEFT');
        $query = $builder->get();

        return $query->getResult();
    }

    public function getFeedbackComments($where=[])
    {
        $this->feedbacks_ideas = db_prefix().'feedbacks_ideas';
        $builder = $this->db->table("$this->feedbacks_ideas");
        $builder->select("$this->feedbacks_ideas.description as comment_description,IF(user_id IS NULL,0,user_id) as user_id,user_name,user_email,DATE_FORMAT(created_at,'%Y-%m-%d %h:%i:%s %p') as commented_at,
                         (CASE $this->feedbacks_ideas.approved
                            WHEN 0 THEN '".app_lang('pending_moderation')."'
                            WHEN 1 THEN '".app_lang('approved')."'
                            ELSE '".app_lang('dis_approved')."' END) as approval_status"
        );
        $query = $builder->getWhere($where);
        return $query->getResult();
    }
}
