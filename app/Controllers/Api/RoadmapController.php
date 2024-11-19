<?php

namespace App\Controllers\Api;

use CodeIgniter\API\ResponseTrait;
use CodeIgniter\RESTful\ResourceController;

class RoadmapController extends ResourceController
{
    use ResponseTrait;

    protected $format = 'json';

    protected $custom_model;

    public function __construct()
    {
        $this->custom_model = Model('App\Models\Custom_model');
        $this->common_model = Model('App\Models\CommonModel');
        helper(['jwt', 'general']);
    }

    public function index()
    {
        $roadmap=$this->custom_model->getRows('roadmap');
        foreach ($roadmap as $key=>$value) {
            if (0 == $value->id) {
                $roadmap[$key]->icon = '💡';
            }
            if (1 == $value->id) {
                $roadmap[$key]->icon = '📅';
            }
            if (2 == $value->id) {
                $roadmap[$key]->icon = '🕙';
            }
            if (3 == $value->id) {
                $roadmap[$key]->icon = '🚀';
            }
            if (4 == $value->id) {
                $roadmap[$key]->icon = '🚫';
            }
        }

        return $this->respond($roadmap);
    }

    public function get_roadmap_wise_feedback()
    {
        $posted_data = $this->request->getPost(null,FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        $data        =$this->custom_model->getRows('roadmap');
        $final_array = [];
        foreach ($data as $key=>$value) {
            $array = [];
            if (0 == $value->id) {
                continue;
                //$array['title'] = "💡 ".$value->value;
            }
            if (1 == $value->id) {
                $array['title'] = '📅 '.$value->value;
            }
            if (2 == $value->id) {
                $array['title'] = '🕙 '.$value->value;
            }
            if (3 == $value->id) {
                $array['title'] = '🚀 '.$value->value;
            }
            if (4 == $value->id) {
                continue;
                //$array['title'] = "🚫".$value->value;
            }
            $array['id'] = $value->id;
            // $array['label'] = (string)$this->custom_model->getCount('feedbacks',['status'=>$value->id,'approval_status'=>1]);
            $array['cards'] = [];
            $feedback       = $this->common_model->getRoadmapFeedbacks($posted_data['board_id'], null, null, $value->id);
            $array['label'] = (string) \count($feedback);
            foreach ($feedback as $feedback_key => $feedback) {
                $feedback_val['id']          =  $feedback->id;
                $feedback_val['title']       =  (!empty($feedback->feedback)) ? ((strlen($feedback->feedback)) > 30 ? substr($feedback->feedback, 0, 30)."..." : $feedback->feedback) : '';
                $feedback_val['draggable']   = true;
                $feedback_val['metadata']    = json_encode($feedback);
                $array['cards'][]            = $feedback_val;
            }
            $array['draggable'] = false;
            $final_array[]      = $array;
        }

        return $this->respond($final_array);
    }
}
