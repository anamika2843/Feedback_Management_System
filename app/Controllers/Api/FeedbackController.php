<?php

namespace App\Controllers\Api;

use CodeIgniter\API\ResponseTrait;
use CodeIgniter\I18n\Time;
use CodeIgniter\RESTful\ResourceController;

class FeedbackController extends ResourceController
{
    use ResponseTrait;

    protected $format = 'json';

    protected $custom_model;

    protected $common_model;

    protected $jwt_config;

    protected $parser;

    public function __construct()
    {
        $this->custom_model = Model('App\Models\Custom_model');
        $this->common_model = Model('App\Models\CommonModel');
        helper(['jwt', 'general']);
        $this->jwt_config = new \App\Config\JWT();
        $this->parser = \Config\Services::parser();
    }

    public function index($board_id = null)
    {
        $posted_data = $this->request->getPost(null,FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        $sorted_by      = 'popularity';
        $roadmap_filter = null;
        $search         = null;
        $category_id    = null;
        $feedback_id    = null;

        if (isset($posted_data['sorting'])) {
            $sorted_by = $posted_data['sorting'];
        }
        if (isset($posted_data['roadmap_id']) && 'all' != $posted_data['roadmap_id']) {
            $roadmap_filter = $posted_data['roadmap_id'];
        }
        if (isset($posted_data['search'])) {
            $search = $posted_data['search'];
        }
        if (isset($posted_data['category_id']) && 'all' != $posted_data['category_id']) {
            $category_id = $posted_data['category_id'];
        }
        if (isset($posted_data['feedback_id'])) {
            $feedback_id = $posted_data['feedback_id'];
        }

        $user_email = null;
        if ($this->request->getHeaderLine('authtoken')) {
            $user_data  = DecodeJWTtoken($this->request->getHeaderLine('authtoken'), $this->jwt_config->jwt_key);
            $user_email = $user_data->email;
        }
        $data                         = $this->common_model->getFeedbacks($board_id, $user_email, $feedback_id, $sorted_by, $roadmap_filter, $search, $category_id, $posted_data['limit'] ?? null, $posted_data['offset'] ?? 0);
        $count = $this->common_model->executeCustomQuery("SELECT FOUND_ROWS() as count")->getRow('count');
        $days_after_new_status_expire = get_option('new_status_expiry_date');

        //get a current date to compare
        $current = Time::parse(Time::now());

        foreach ($data as $key => $value) {
            //Compare the current date and expiry date from the admin settings
            $diff = $current->difference(date('Y-m-d H:i:s', strtotime($value->created_at.' + '.$days_after_new_status_expire.' DAYS')), app_timezone());

            if (0 == $value->roadmap_id) {
                //If the $diff->getDays() is less then 0 than means new status expired.
                if ($diff->getDays() >= 0) {
                    $data[$key]->status_icon = '💡';
                } else {
                    $data[$key]->status_icon = '';
                    $data[$key]->status_text = '';
                }
            } elseif (1 == $value->roadmap_id) {
                $data[$key]->status_icon = '📅';
            }
            if (2 == $value->roadmap_id) {
                $data[$key]->status_icon = '🕙';
            }
            if (3 == $value->roadmap_id) {
                $data[$key]->status_icon = '🚀';
            }
            if (4 == $value->roadmap_id) {
                $data[$key]->status_icon = '🚫';
            }
            unset($data[$key]->roadmap_id);
            unset($data[$key]->created_at);
            $comments = $this->common_model->getFeedbackComments(['feedback_id'=>$value->id,'approved'=>1]);
            $data[$key]->comments = $comments;
        }

        return $this->respond(["records" => $data,  "count" => (int)$count]);
    }

    public function show($id = null)
    {
        $user_email = null;
        if ($this->request->getHeaderLine('authtoken')) {
            $user_data  = DecodeJWTtoken($this->request->getHeaderLine('authtoken'), $this->jwt_config->jwt_key);
            $user_email = $user_data->email;
        }
        $feedback = $this->common_model->getFeedbacks(null, $user_email, $id);

        return $this->respond($feedback);
    }

    public function search($key = '')
    {
    }

    public function create($board_id=null)
    {
        $posted_data        = $this->request->getPost(null,FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $is_feedback_exists = $this->custom_model->getCount('feedbacks', ['feedback_description'=>$posted_data['feedback_description'], 'board_id'=>$board_id]);
        if ($is_feedback_exists > 0) {
            if (!isset($posted_data['anonymous_feedback'])) {
                if ($this->request->getHeaderLine('authtoken')) {
                    $jwt_token = DecodeJWTtoken($this->request->getHeaderLine('authtoken'), $this->jwt_config->jwt_key);
                    $user      = $this->custom_model->getSingleRow('users_front', ['email'=>$jwt_token->email]);
                    $token     = $user->token;
                    $return_data['userDetails'] = [
                        'name'     => $jwt_token->name,
                        'email'    => $jwt_token->email,
                        'authtoken'=> $user->token,
                    ];
                } else {
                    $user = $this->custom_model->getSingleRow('users_front', ['email'=>$posted_data['user_email']]);
                    if (!$user) {
                        $user_data = [
                            'name' => $posted_data['user_name'],
                            'email'=> $posted_data['user_email'],
                        ];
                        $user_data['token'] = EncodeJWTtoken($user_data);
                        $id                 = $this->custom_model->insertRow('users_front', $user_data);
                        $token              = $user_data['token'];
                        $return_data['userDetails'] = [
                            'name'     => $posted_data['user_name'],
                            'email'    => $posted_data['user_email'],
                            'authtoken'=> $token,
                        ];
                    } else {
                        $return_data['userDetails'] = [
                            'name'     => $posted_data['user_name'],
                            'email'    => $posted_data['user_email'],
                            'authtoken'=> $user->token,
                        ];
                    }
                }
            }
            $response = [
                'status' => 'success',
                'message'=>  app_lang('feedback_submitted'),
            ];
            if(!empty($return_data)){
                $response = $response + $return_data;
            }

            return $this->respond($response);
        }

        $posted_data = $this->request->getPost(null,FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        //anonymous feedback
        if (isset($posted_data['anonymous_feedback'])) {
            $data = [
                'feedback_description'=> $posted_data['feedback_description'],
                'board_id'            => $board_id,
            ];
            $insertedId = $this->custom_model->insertRow('feedbacks', $data);

            $response = [
                'status' => 'success',
                'message'=>  app_lang('feedback_submitted'),
            ];

            $this->send_feedback_mail_to_admin($insertedId);

            return $this->respond($response);
        }
        //For logged in user when getting authtoken from header
        if ($this->request->getHeaderLine('authtoken')) {
            $jwt_token = DecodeJWTtoken($this->request->getHeaderLine('authtoken'), $this->jwt_config->jwt_key);
            $user      = $this->custom_model->getSingleRow('users_front', ['email'=>$jwt_token->email]);
            $token     = $user->token;
            $data      = [
                'user_id'             => $user->id,
                'user_name'           => $jwt_token->name,
                'user_email'          => $jwt_token->email,
                'feedback_description'=> $posted_data['feedback_description'],
                'board_id'            => $board_id,
            ];

            $insertedId = $this->custom_model->insertRow('feedbacks', $data);

            if ($insertedId) {
                $this->send_feedback_mail_to_admin($insertedId,'logged_in');
                $response = [
                    'status'   => 'success',
                    'message'  =>  app_lang('feedback_submitted'),
                    'userDetails' => [
                        'name'     => $jwt_token->name,
                        'email'    => $jwt_token->email,
                        'authtoken'=> $user->token,
                    ],
                ];

                return $this->respond($response);
            }
        }
        //For non logged in user witout authtoken but having email and not an anonymous feedback
        $user = $this->custom_model->getSingleRow('users_front', ['email'=>$posted_data['user_email']]);
        if (!$user) {
            $user_data = [
                'name' => $posted_data['user_name'],
                'email'=> $posted_data['user_email'],
            ];
            $user_data['token'] = EncodeJWTtoken($user_data);
            $id                 = $this->custom_model->insertRow('users_front', $user_data);
            $token              = $user_data['token'];
            $data               = [
                'user_id'             => $id,
                'user_name'           => $posted_data['user_name'],
                'user_email'          => $posted_data['user_email'],
                'feedback_description'=> $posted_data['feedback_description'],
                'board_id'            => $board_id,
            ];

            $insertedId = $this->custom_model->insertRow('feedbacks', $data);

            if ($insertedId) {
                $this->send_feedback_mail_to_admin($insertedId,'logged_in');
                $response = [
                    'status'   => 'success',
                    'message'  =>  app_lang('feedback_submitted'),
                    'userDetails' => [
                        'name'     => $posted_data['user_name'],
                        'email'    => $posted_data['user_email'],
                        'authtoken'=> $token,
                    ],
                ];

                return $this->respond($response);
            }
        } else {
            $data = [
                'user_id'             => $user->id,
                'user_name'           => $posted_data['user_name'],
                'user_email'          => $posted_data['user_email'],
                'feedback_description'=> $posted_data['feedback_description'],
                'board_id'            => $board_id,
            ];

            $insertedId = $this->custom_model->insertRow('feedbacks', $data);

            if ($insertedId) {
                $this->send_feedback_mail_to_admin($insertedId,'logged_in');
                $response = [
                    'status'   => 'success',
                    'message'  =>  app_lang('feedback_submitted'),
                    'userDetails' => [
                        'name'     => $posted_data['user_name'],
                        'email'    => $posted_data['user_email'],
                        'authtoken'=> $user->token,
                    ],
                ];

                return $this->respond($response);
            }
        }
    }

    public function update($id = null)
    {
    }

    public function delete($id = null)
    {
    }

    public function feedbacks_status_count($id = null)
    {
        $feedback = $this->custom_model->getRowsWhereJoin('feedbacks', ['feedbacks.status'=>$id], ['category', 'board'], ['feedbacks.category = category.id', 'feedbacks.board_id = board.id']);

        return $this->respond($feedback);
    }

    public function feedbacks_vote_count()
    {
        $feedback = $this->custom_model->getFeedbackCount();

        return $this->respond($feedback);
    }

    public function send_feedback_mail_to_admin($feedback_id, $feedback_type='anonymous')
    {
       $email_template = $this->custom_model->getSingleRow('emailtemplates', ['slug'=>'new-feature-request']);

       if($email_template && $email_template->active)
       {
            $feedback       = $this->custom_model->getSingleRow('feedbacks', ['id'=>$feedback_id]);
            $parser_data = parse_merge_fields('new-feature-request', ["feedback" => $feedback]);

            $email_template->message;

            $mail_body = get_option('email_header');
            $mail_body .= $email_template->message;
            $mail_body .= get_option('email_signature');
            $mail_body .= get_option('email_footer');

            $message = $this->parser->setData($parser_data)->renderString($mail_body);

            $flag = true;
            $error_message ="";
            $users = array_flatten(get_users_list());
            $to = array_shift($users);
            $options['cc'] = implode(',',$users);
            $options['reply_to'] = (!empty(get_option('reply_to')) ? get_option('reply_to') : get_option('smtp_email'));

            send_app_mail($to, $email_template->subject, $message,$options);
        }
    }

}
