<?php

namespace App\Controllers;

use CodeIgniter\I18n\Time;
use Hermawan\DataTables\DataTable;

class FeedbackController extends App_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->data['menu_item']     ='feedback';
        $this->data['title']         = 'Feedback';
        $this->data['collapse_menu'] = true;
        $this->data['breadcrumb']    = ['/admin/feedback'=>'Feedback'];
        $this->custom_model          = Model('App\Models\Custom_model');
    }

    public function index()
    {
        $this->data['status']  =$this->custom_model->getRows('roadmap');
        $this->data['category']=$this->custom_model->getRows('category');
        $this->data['boards']  = $this->custom_model->getRows('board');

        return view('feedback/manage', $this->data);
    }

    public function table()
    {
        $posted_data = $this->request->getPost(null,FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        $builder = $this->db->table('feedbacks')->select('id,user_name,user_email,status,feedback_description,category,approval_status,board_id');

        return DataTable::of($builder)
        ->filter(function ($builder, $request) {
            if ($request->board_id) {
                $builder->where('board_id', $request->board_id);
            }
        })
        ->addNumbering('no')
        ->setSearchableColumns(['user_name', 'user_email', 'status', 'category', 'approval_status','total_comments'])
        ->add('status', function ($data) {
            $html = "<select class='table_status_dropdown form-select form-control-sm form-control' data-feedback-id='".$data->id."' name='status'  id='status'>
            ";
            $status = $this->custom_model->getRows('roadmap');

            foreach ($status as $value) {
                $selected = '';
                if ($value->id == $data->status) {
                    $selected = 'selected';
                }
                $html .= "<option value='".$value->id."' ".$selected.' >'.$value->value.'</option>';
            }
            $html .= '</select>';

            return $html;
        })
        ->add('category', function ($data) {
            $category = "<select class='table_category_dropdown form-select form-control-sm form-control' name='category' id='category' data-feedbacks-id='".$data->id."'>
            ";
            $category .= "<option value=''>Select Category</option>";
            $status = $this->custom_model->getRows('category');
            foreach ($status as $value) {
                $selected = '';
                if ($value->id == $data->category) {
                    $selected = 'selected';
                }
                $category .= "<option value='".$value->id."' ".$selected.'>'.$value->title.'</option>';
            }
            $category .= '</select>';

            return $category;
        })
        ->add('approval_status', function ($approval_status) {
            if (1 == $approval_status->approval_status) {
                $value='<a href="#" class="text-success">'.app_lang('approved').'</a>';
            } else {
                $value='<a type="button" class=" edit-feedback" data-id="'.$approval_status->id.'" data-value="'.htmlspecialchars(json_encode($approval_status), ENT_QUOTES, 'UTF-8').'">'.app_lang('view_and_approve').'</a>';
            }

            return $value;
        })
        ->add('total_comments',function($data){
            return anchor('/admin/feedback/comments/'.$data->id,$this->custom_model->getCount('feedbacks_ideas',['feedback_id'=>$data->id,]),['target'=>'_blank','data-bs-toggle'=>'tooltip','title'=>app_lang('feedback-view-comments')]);
        })
        ->add('action', function ($data) {
            return "<button type='button' aria-haspopup='true' data-bs-toggle='dropdown' aria-expanded='false' class='btn btn-link'>
            <i class='fa fa-ellipsis-h'></i></button>
            <div tabindex='-1' aria-hidden='true' class='dropdown-menu-rounded dropdown-menu' >

            <ul class='nav flex-column'>
            <li class='nav-item'>
            <button class='nav-link btn btn-link text-primary view-info' data-id='".$data->id."' data-value='".htmlspecialchars(json_encode($data), ENT_QUOTES, 'UTF-8')."'><i class='nav-link-icon lnr-file-empty'></i> ".app_lang('view_info')."</button>
            </li>
            <li class='nav-item'>
            <button class='nav-link btn btn-link text-primary edit-feedback' data-id='".$data->id."' data-value='".htmlspecialchars(json_encode($data), ENT_QUOTES, 'UTF-8')."'><i class='nav-link-icon lnr-book'></i> ".app_lang('edit')."</button>
            </li>
            <li class='nav-item'>

            ".form_open('admin/feedback/delete/'.$data->id,['class'=>'_delete']).csrf_field()."
            <button type='submit' class='nav-link btn-link text-primary border-0 btn-transition btn link'><i class='nav-link-icon lnr-trash'></i> ".app_lang('delete').'</button>
            '.form_close()."
            </li>
            <li class='nav-item'>
            ".form_open('admin/feedback/request_more_info/'.$data->id).csrf_field()."
            <button class='nav-link btn btn-link text-primary' data-id='".$data->id."'><i class='nav-link-icon lnr-layers'></i> ".app_lang('request_more_info').'</button>
            '.form_close().'
            </li>
            </ul>
            </div>';
        })->toJson(true);
    }

    public function create()
    {
        $this->data['category']=$this->custom_model->getRows('category');
        $this->data['status']  =$this->custom_model->getRows('roadmap');
        $this->data['boards']  = $this->custom_model->getRows('board');

        return view('feedback/add_new_feedback_form', $this->data);
    }
    
    public function store()
    {
        $posted_data = $this->request->getPost(null,FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $rules       =[
            'feedback_description'=> 'required',
            'category'            => 'required',
            'board_id'            => 'required',
            'status'              => 'required',
        ];
        $error=[
            'feedback_description'=> ['required'=>app_lang('feedback_description_required')],
            'category'            => ['required'=>app_lang('select_Categories')],
            'board_id'            => ['required'=>app_lang('select_board')],
            'status'              => ['required'=>app_lang('select_roadmap')],
        ];
        if (!$this->validate($rules, $error)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $feedback_exists= $this->custom_model->getCount('feedbacks', ['feedback_description'=>$posted_data['feedback_description'], 'board_id'=>$posted_data['board_id']]);

        if ($feedback_exists > 0) {
            set_alert('warning', app_lang('feedback_title'), app_lang('feedback_exists'));

            return redirect()->back();
        }

        $user= get_user();
        $data=[
            'user_name'             => $user->username,
            'user_email'            => $user->email,
            'feedback_description'  => $posted_data['feedback_description'],
            'category'              => $posted_data['category'],
            'board_id'              => $posted_data['board_id'],
            'status'                => $posted_data['status'],
        ];
        set_alert('success', app_lang('feedback'), app_lang('feedback_store_successfully'));
        $this->custom_model->insertRow('feedbacks', $data);

        return redirect()->to(route_to('admin/feedback'));
    }

    public function update()
    {
        $posted_data = $this->request->getPost(null,FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        $rules=[
            'category'  => 'required',
        ];
        $error=[
            'category'=> ['required'=>app_lang('select_Categories')],
        ];
        if (!$this->validate($rules, $error)) {
            $response = [
                'status' => 'error',
                'message'=> $this->validator->listErrors(),
            ];

            return $this->response->setJSON($response);
        }

        $email= get_user();

        $status   = '' == isset($posted_data['status']) ? '' : $posted_data['status'];
        $category = '' == isset($posted_data['category']) ? '' : $posted_data['category'];

        $where['id'] = $posted_data['id'];
        $feedback    = $this->custom_model->getSingleRow('feedbacks', ['id'=>$where]);
        $data        = [
            'feedback_description' => $posted_data['feedback_description'],
            'status'               => $status,
            'category'             => $category,
            'approval_status'      => (isset($posted_data['approval_status']) ? 1 : 0),
        ];
        set_alert('success', app_lang('feedback'), app_lang('feedback_update_successfully'));
        $this->custom_model->updateRow('feedbacks', $data, $where);
        $response = [
            'status' => 'success',
            'message'=> app_lang('feedback_update_successfully'),
        ];
        if ($feedback->approval_status != (isset($posted_data['approval_status']) ? 1 : 0)) {
            if ('1' == $data['approval_status']) {
                $email_template = $this->custom_model->getSingleRow('emailtemplates', ['slug'=>'feature-request-approved']);
                if($email_template)
                {
                    if($email_template->active)
                    {
                        $feedback       = $this->custom_model->getSingleRow('feedbacks', ['id'=>$where]);

                        $email_template->message;
                        $parser_data = parse_merge_fields('feature-request-approved', ["feedback" => $feedback]);

                        $mail_body = get_option('email_header');
                        $mail_body .= $email_template->message;
                        $mail_body .= get_option('email_signature');
                        $mail_body .= get_option('email_footer');

                        $message = $this->parser->setData($parser_data)->renderString($mail_body);
                        if (filter_var($feedback->user_email, FILTER_VALIDATE_EMAIL)) {
                              if (!send_app_mail($feedback->user_email, $email_template->subject, $message)) {
                                $response = [
                                    'status' => 'fail',
                                    'message'=> app_lang('check_your_smtp_setting'),
                                ];
                                return $this->response->setJSON($response);
                            }
                        }
                        
                        
                        $response = [
                            'status' => 'success',
                            'message'=> app_lang('feedback_update_successfully'),
                        ];
                        return $this->response->setJSON($response);
                    }
                }
                $response = [
                    'status' => 'fail',
                    'message' => app_lang('fail_to_send_mail'),
                ];
                return $this->response->setJSON($response);
            }
        }
        if ($feedback->status != $posted_data['status']) {
            if ($feedback->user_email) {
                $email_template = $this->custom_model->getSingleRow('emailtemplates', ['slug'=>'new-feature-request', $feedback->user_email]);
                if($email_template)
                {
                   if($email_template->active)
                   {
                    $feedbacks      = $this->custom_model->getRowsWhereJoin('feedbacks', ['feedbacks.id'=>$where], ['roadmap'], ['feedbacks.status = roadmap.id']);

                    foreach ($feedbacks as $feedback) {
                        $email_template->message;

                        $parser_data = parse_merge_fields('new-feature-request', ["feedback" => $feedback]);

                        $mail_body = get_option('email_header');
                        $mail_body .= $email_template->message;
                        $mail_body .= get_option('email_signature');
                        $mail_body .= get_option('email_footer');

                        $message = $this->parser->setData($parser_data)->renderString($mail_body);
                        if (!send_app_mail($feedback->user_email, $email_template->subject, $message)) {
                            $response = [
                                'status' => 'fail',
                                'message'=> app_lang('check_your_smtp_setting'),
                            ];
                            return $this->response->setJSON($response);
                        }
                        $response = [
                            'status' => 'success',
                            'message'=> app_lang('feedback_update_successfully'),
                        ];
                        return $this->response->setJSON($response);
                    }
                }
            }
            $response = [
                'status' => 'fail',
                'message' => app_lang('fail_to_send_mail'),
            ];
            return $this->response->setJSON($response);
        }
    }

    return $this->response->setJSON($response);
}

public function status_edit()
{
    $posted_data = $this->request->getPost(null,FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    $where['id']= $posted_data['dataString']['feedback_id'];
    $feedback   = $this->custom_model->getSingleRow('feedbacks', ['id'=>$where]);

    $data=[
        'status' => $posted_data['dataString']['status_id'],
    ];
    set_alert('success', app_lang('feedback'), app_lang('feedback_update_successfully'));
    $this->custom_model->updateRow('feedbacks', $data, $where);
    $response = [
        'status' => 'success',
        'message'=> app_lang('feedback_update_successfully'),
    ];

    if ($feedback->user_email) {
        $email_template = $this->custom_model->getSingleRow('emailtemplates', ['slug'=>'new-feature-request', $feedback->user_email]);
        if($email_template)
        {
            if($email_template->active)
            {
                $feedbacks      = $this->custom_model->getRowsWhereJoin('feedbacks', ['feedbacks.id'=>$where], ['roadmap'], ['feedbacks.status = roadmap.id']);

                foreach ($feedbacks as $feedback) {
                    $email_template->message;
                    $parser_data = parse_merge_fields('new-feature-request', ["feedback" => $feedback]);

                    $mail_body = get_option('email_header');
                    $mail_body .= $email_template->message;
                    $mail_body .= get_option('email_signature');
                    $mail_body .= get_option('email_footer');

                    $message = $this->parser->setData($parser_data)->renderString($mail_body);
                    if (!send_app_mail($feedback->user_email, $email_template->subject, $message)) {
                        $response = [
                            'status' => 'fail',
                            'message'=> app_lang('check_your_smtp_setting'),
                        ];
                        return $this->response->setJSON($response);
                    }
                    $response = [
                        'status' => 'success',
                        'message' => app_lang('feedback_update_successfully'),
                    ];
                    return $this->response->setJSON($response);
                }
            }
        }
        $response = [
            'status' => 'fail',
            'message' => app_lang('fail_to_send_mail'),
        ];
        return $this->response->setJSON($response);
    }

    return $this->response->setJSON($response);
}

public function category_edit()
{
    $posted_data = $this->request->getPost(null,FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    if (null == $posted_data['dataString']['category_id']) {
        set_alert('error', app_lang('feedback'), app_lang('select_Categories'));
        $response = [
            'status' => 'error',
            'message'=> app_lang('select_Categories'),
        ];

        return $this->response->setJSON($response);
    }

    $where['id']= $posted_data['dataString']['feedbacks_id'];

    $data=[
        'category' => $posted_data['dataString']['category_id'],
    ];
    set_alert('success', app_lang('feedback'), app_lang('feedback_update_successfully'));
    $this->custom_model->updateRow('feedbacks', $data, $where);
    $response = [
        'status' => 'success',
        'message'=> app_lang('feedback_update_successfully'),
    ];

    return $this->response->setJSON($response);
}

public function request_more_info($id=null)
{
    $email_template = $this->custom_model->getSingleRow('emailtemplates', ['slug'=>'request-more-info']);
    if($email_template)
    {
        if($email_template->active)
        {
            $feedback       = $this->custom_model->getSingleRow('feedbacks', ['id'=>$id]);

            $email_template->message;
            $parser_data = parse_merge_fields('request-more-info', ["feedback" => $feedback]);

            $mail_body = get_option('email_header');
            $mail_body .= $email_template->message;
            $mail_body .= get_option('email_signature');
            $mail_body .= get_option('email_footer');

            $message = $this->parser->setData($parser_data)->renderString($mail_body);

            if (!send_app_mail(get_option('reply_to'), $email_template->subject, $message)) {
                set_alert('warning', app_lang('feedback'), app_lang('check_your_smtp_setting'));
                return redirect()->to(route_to('admin/feedback'));
            } else {
                set_alert('success', app_lang('feedback'), app_lang('mail_send_successfully'));
                return redirect()->to(route_to('admin/feedback'));
            }
        }
    }
    set_alert('warning', app_lang('feedback'), app_lang('fail_to_send_mail'));
    return redirect()->to(route_to('admin/feedback'));
}

public function delete($id)
{
    set_alert('success', app_lang('feedback'), app_lang('feedback_deleted_successfully'));
    $this->custom_model->deleteRow('feedbacks', ['id'=>$id]);

    return redirect()->to(route_to('admin/feedback'));
}
}
