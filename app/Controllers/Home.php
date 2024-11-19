<?php

namespace App\Controllers;

class Home extends App_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->data['menu_item']  = 'dashboard';
        $this->data['title']      = 'Dashboard';
        $this->data['breadcrumb'] = [site_url('/admin')=>'Home'];
        $this->custom_model       = Model('App\Models\Custom_model');
        $this->common_model       = Model('App\Models\CommonModel');
    }

    public function index()
    {
        $this->data['total_user']     =$this->custom_model->getTotalCount('users_front');
        $this->data['total_comments'] =$this->custom_model->getTotalCount('feedbacks_ideas');
        $this->data['total_roadmap']  =$this->custom_model->getTotalCount('roadmap');
        $this->data['total_feedbacks']=$this->custom_model->getTotalCount('feedbacks');
        $top_ten_chart                =$this->common_model->get_top_ten_feedbacks();
        $top_ten_chart_series         = '';
        foreach ($top_ten_chart as $key => $value) {
            $top_ten_chart_series .= "{name:'".$value->upvotes."',y:".$value->upvotes.",board:'".$value->name."',board:'".$value->name."'},";
        }
        $this->data['top_ten_chart_series'] = $top_ten_chart_series;

        $this->data['boards'] = $this->custom_model->getRows('board');

        return view('index', $this->data);
    }

    public function refresh_chart_data()
    {
        $posted_data = $this->request->getPost();
        if ($posted_data['board_id'] || $posted_data['range']) {
            $data                 = $this->common_model->get_charts_data($posted_data);
            $top_ten_chart        =$this->common_model->get_top_ten_feedbacks(true, $posted_data);
            $top_ten_chart_series = [];
            foreach ($top_ten_chart as $key => $value) {
                $temp_data['name']      = $value->upvotes;
                $temp_data['y']         = (int) $value->upvotes;
                $temp_data['board']     = $value->name;
                $top_ten_chart_series[] = $temp_data;
            }
        } else {
            $data['total_user']     =$this->custom_model->getTotalCount('users_front');
            $data['total_comments'] =$this->custom_model->getTotalCount('feedbacks_ideas');
            $data['total_roadmap']  =$this->custom_model->getTotalCount('roadmap');
            $data['total_feedbacks']=$this->custom_model->getTotalCount('feedbacks');
            $top_ten_chart          =$this->common_model->get_top_ten_feedbacks();
            $top_ten_chart_series   = [];
            foreach ($top_ten_chart as $key => $value) {
                $temp_data['name']      = $value->upvotes;
                $temp_data['y']         = (int) $value->upvotes;
                $temp_data['board']     = $value->name;
                $top_ten_chart_series[] = $temp_data;
            }
        }
        echo json_encode(['data'=>$data, 'top_ten_chart_series'=>$top_ten_chart_series]);
    }
}
