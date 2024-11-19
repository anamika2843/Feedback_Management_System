<?php

namespace App\Controllers\Api;

use CodeIgniter\API\ResponseTrait;
use CodeIgniter\RESTful\ResourceController;

class IdeasFeedbackController extends ResourceController
{
    use ResponseTrait;

    protected $format = 'json';

    protected $custom_model;

    public function __construct()
    {
        helper(['jwt','general']);
        $this->parser = \Config\Services::parser();        
        $this->custom_model = Model('App\Models\Custom_model');
    }

    public function index()
    {
    }

    public function create($board_id=null, $feedback_id=null)
    {
        $jwt_config = new \App\Config\JWT();

        $posted_data=$this->request->getPost(null,FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        //anonymous feedback
        if(isset($posted_data['anonymous_feedback'])){
            $data=[
                'description' => $posted_data['description'],
                'feedback_id' => $feedback_id,
                'board_id'    => $board_id,
                'created_at'  => date('Y-m-d H:i:s')
            ];
            $comment_id = $this->custom_model->insertRow('feedbacks_ideas', $data);
            if ($comment_id) {
                $response = [
                    'status' => 'success',
                    'message'=> app_lang('update_successfully'),
                ];
                $this->send_comment_mail_to_admin($comment_id);
                return $this->respond($response);
            }
        }
        if ($this->request->getHeaderLine('authtoken')) {
            $user_data = DecodeJWTtoken($this->request->getHeaderLine('authtoken'), $jwt_config->jwt_key);
            $user      = $this->custom_model->getSingleRow('users_front', ['email'=>$user_data->email]);

            $data=[
                'description' => $posted_data['description'],
                'feedback_id' => $feedback_id,
                'user_id'     => $user->id,
                'user_name'   => $user_data->name,
                'user_email'  => $user_data->email,
                'board_id'    => $board_id,
                'created_at'  => date('Y-m-d H:i:s')
            ];
            $comment_id = $this->custom_model->insertRow('feedbacks_ideas', $data);
            if ($comment_id) {
                $response = [
                    'status' => 'success',
                    'message'=>  app_lang('update_successfully'),
                    'userDetails' => [
                        'name'     => $user_data->name,
                        'email'    => $user_data->email,
                        'authtoken'=> $user->token,
                    ],
                ];
                $this->send_comment_mail_to_admin($comment_id);
                return $this->respond($response);
            }
        }
        $user = $this->custom_model->getSingleRow('users_front', ['email'=>$posted_data['user_email']]);
        if(!$user){

             $user_data = [
                'name'=>$posted_data['user_name'],
                'email'=> $posted_data['user_email'],
            ];
            $user_data['token'] = EncodeJWTtoken($user_data);
            $id                 = $this->custom_model->insertRow('users_front', $user_data);
            $token              = $user_data['token'];

            $data=[
                'description' => $posted_data['description'],
                'feedback_id' => $feedback_id,
                'user_id'     => $id,
                'user_name'   => $posted_data['user_name'],
                'user_email'  => $posted_data['user_email'],
                'board_id'    => $board_id,
                'created_at'  => date('Y-m-d H:i:s')
            ];
            $comment_id = $this->custom_model->insertRow('feedbacks_ideas', $data);
            if ($comment_id) {
                $response = [
                    'status'   => 'success',
                    'message'  =>  app_lang('update_successfully'),
                    'userDetails' => [
                        'name'     => $posted_data['user_name'],
                        'email'    => $posted_data['user_email'],
                        'authtoken'=> $token,
                    ],
                ];
                $this->send_comment_mail_to_admin($comment_id);
                return $this->respond($response);
            }
        } else {
            $data=[
                'description' => $posted_data['description'],
                'feedback_id' => $feedback_id,
                'user_id'     => $user->id,
                'user_name'   => $user->name,
                'user_email'  => $user->email,
                'board_id'    => $board_id,
                'created_at'  => date('Y-m-d H:i:s')
            ];
            $comment_id = $this->custom_model->insertRow('feedbacks_ideas', $data);
            if ($comment_id) {
                $response = [
                    'status'   => 'success',
                    'message'  =>  app_lang('update_successfully'),
                    'userDetails' => [
                        'name'     => $user->name,
                        'email'    => $user->email,
                        'authtoken'=> $user->token,
                    ],
                ];
                $this->send_comment_mail_to_admin($comment_id);
                return $this->respond($response);
            }
        }
    }

    private function send_comment_mail_to_admin($comment_id)
    {
        $admin_users      = $this->custom_model->getRowsWhereJoin('auth_groups_users', ['auth_groups_users.user_id'=>1], ['users'], ['auth_groups_users.user_id = users.id']);
        $posted_data = $this->request->getPost(null,FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $email_template = $this->custom_model->getSingleRow('emailtemplates', ['slug'=>'new-feedback-comment-added']);
        if($email_template)
        {
            if($email_template->active)
            {
                $comment = $this->custom_model->getSingleRow('feedbacks_ideas',['id'=>$comment_id]); 
                $feedback = $this->custom_model->getSingleRow('feedbacks',['id'=>$comment->feedback_id]);
                foreach ($admin_users as $user_key => $user_value) {
                    $email_template->message;
                    $parser_data = parse_merge_fields('new-feedback-comment-added',["comment" => $comment,"feedback_comment" => $feedback,"comment_id" => $comment_id]);            
                    $mail_body = get_option('email_header');
                    $mail_body .= $email_template->message;
                    $mail_body .= get_option('email_signature');
                    $mail_body .= get_option('email_footer');
                    $message = $this->parser->setData($parser_data)->renderString($mail_body);
                    send_app_mail($user_value->email,$email_template->subject,$message);
                }
            }
        }
    }
}
