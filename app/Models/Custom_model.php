<?php

namespace App\Models;

use CodeIgniter\Model;

class Custom_model extends Model
{
    public function __construct()
    {
        parent::__construct();

        $this->db=\Config\Database::connect();
    }

    public function getRows($table, $where = [], $orWhere = [], $groupBy = null, $columns = '*', $result_type = 'object')
    {
        $builder=$this->db->table($table);
        $builder->select($columns);
        $builder->where($where);
        if (\is_array($orWhere)) {
            $builder->orWhere($orWhere);
        }
        if (null !== $groupBy) {
            $builder->groupBy($groupBy);
        }
        $query = $builder->get();
        if ('array' == $result_type) {
            return $query->getResultArray();
        }
        return $query->getResult();
    }

    public function getTotalCount($table)
    {
        $builder=$this->db->table($table);

        return $builder->countAllResults();
    }

    public function getSingleRow($table, $where = [], $return_type = 'object')
    {
        $builder=$this->db->table($table);
        $query  = $builder->select('*')->where($where)->get();
        if ('array' == $return_type) {
            return $query->getRowArray();
        }

        return $query->getRow();
    }

    public function getRowsWhereJoin($table, $where, $join, $join_condition)
    {
        $builder=$this->db->table($table);
        $builder->select(' * ');
        for ($i = 0; $i < \count($join); ++$i) {
            $builder->join($join[$i], $join_condition[$i]);
        }
        $builder->where($where);
        $query = $builder->get();

        return $query->getResult();
    }

    public function insertRow($table, $data, $batch = false)
    {
        $builder=$this->db->table($table);
        if ($batch) {
            $result = $builder->insertBatch($data);
        } else {
            $result = $builder->insert($data);
        }
        if ($result) {
            return $this->db->insertID();
        }

        return 'error';
    }

    public function updateRow($table, $data, $where, $orWhere = [])
    {
        $builder=$this->db->table($table);
        $builder->where($where);
        $builder->orWhere($orWhere);
        $result = $builder->update($data);
        if ($result) {
            return 'updated';
        }

        return 'error';
    }

    public function deleteRow($table, $where, $orWhere = [])
    {
        $builder=$this->db->table($table);
        $builder->where($where);
        $builder->orWhere($orWhere);
        $result = $builder->delete();
        if ($result) {
            return 'deleted';
        }

        return 'error';
    }

    public function getResult($query_result, $array = false)
    {
        if (!empty($query_result->getResult())) {
            if ($array) {
                return $query_result->getResultArray();
            }

            return $query_result->getResult();
        }

        return null;
    }

    public function insertorupdate($table, $value, $where)
    {
        $res= $this->getSingleRow($table, $where);
        if (null === $res) {
            $this->insertRow($table, $value);
        } else {
            $this->updateRow($table, $value, $where);
        }
    }

    public function getRandomRecord($table)
    {
        $db = $this->db->table('category');
        $db->orderBy('RAND()');

        return $results = $db->get()->getRow();
    }

    public function getCategoryRowsWithCount($board_id='')
    {
        $builder = $this->db->table('category');
        $builder->select('category.*,COUNT(category) as total_feedbacks');
        $builder->join('feedbacks', 'feedbacks.category=category.id', 'LEFT');
        if (is_numeric($board_id)) {
            $builder->where('board_id', $board_id);
            $builder->where('approval_status', 1);
        }
        $builder->groupBy('category.id');
        $query = $builder->get();

        return $query->getResult();
    }

    public function getFeedbackCount()
    {
        $builder = $this->db->table('feedbacks')->orderBy('upvotes', 'DESC');
        $query   = $builder->get();

        return $query->getResult();
    }

    public function getCount($table, $where = []): int
    {
        $builder=$this->db->table($table);
        $query  = $builder->where($where)->get();

        return $this->db->affectedRows();
    }

    public function getFeedback($where)
    {
        $builder = $this->db->table('feedbacks');
        $builder->select('feedbacks.id,feedback_description,board.name,user_name,user_email,category.title');
        $builder->where($where);
        $builder->join('board','board.id=feedbacks.board_id','LEFT');
        $builder->join('category','category.id=feedbacks.category','LEFT');
        $builder->join('roadmap','roadmap.id=feedbacks.status','LEFT');
        return $builder->get()->getRow();
    }

    public function executeCustomQuery($sql){
        return $this->db->query($sql);
    }
}
