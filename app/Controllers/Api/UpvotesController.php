<?php

namespace App\Controllers\Api;

use CodeIgniter\API\ResponseTrait;
use CodeIgniter\RESTful\ResourceController;

class UpvotesController extends ResourceController
{
    use ResponseTrait;

    protected $format = 'json';

    protected $custom_model;

    protected $jwt_config;

    public function __construct()
    {
        $this->custom_model = Model('App\Models\Custom_model');
        helper('jwt');
        $this->jwt_config = new \App\Config\JWT();
    }

    public function index()
    {
    }

    public function update($feedback_id=null)
    {
        $user_data  = DecodeJWTtoken($this->request->getHeaderLine('authtoken'), $this->jwt_config->jwt_key);
        $is_upvoted = $this->custom_model->getCount('users_upvotes_detail', ['user_email'=>$user_data->email, 'feedback_id'=>$feedback_id]);

        if (0 == $is_upvoted) {
            $data         = $this->custom_model->getSingleRow('feedbacks', ['id'=>$feedback_id]);
            $user_details = $this->custom_model->getSingleRow('users_front', ['email'=>$user_data->email]);
            $upvotes      = [
                'upvotes'=> $data->upvotes + 1,
            ];
            $feedback_data=[
                'feedback_id' => $data->id,
                'user_id'     => $user_details->id,
                'user_name'   => $user_details->name,
                'user_email'  => $user_details->email,
            ];
            $this->custom_model->insertRow('users_upvotes_detail', $feedback_data);
            $this->custom_model->updateRow('feedbacks', $upvotes, ['id'=>$feedback_id]);
        }

        $response = [
            'status' => 'success',
            'message'=> app_lang('update_successfully'),
        ];

        return $this->respond($response);
    }

    public function delete($feedback_id=null)
    {
        $jwt_token = $this->request->getHeaderLine('authtoken');

        $user_data = DecodeJWTtoken($jwt_token, $this->jwt_config->jwt_key);

        $is_upvoted = $this->custom_model->getCount('users_upvotes_detail', ['user_email'=>$user_data->email, 'feedback_id'=>$feedback_id]);

        if ($is_upvoted > 0) {
            $data = $this->custom_model->getSingleRow('feedbacks', ['id'=>$feedback_id]);

            $upvotes = [
                'upvotes'=> $data->upvotes - 1,
            ];
            $this->custom_model->updateRow('feedbacks', $upvotes, ['id'=>$feedback_id]);
            $this->custom_model->deleteRow('users_upvotes_detail', ['feedback_id'=>$feedback_id, 'user_email'=>$user_data->email]);
        }
        $response = [
            'status' => 'success',
            'message'=> app_lang('update_successfully'),
        ];

        return $this->respond($response);
    }
}
