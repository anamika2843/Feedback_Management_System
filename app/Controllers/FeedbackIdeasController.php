<?php

namespace App\Controllers;
use Hermawan\DataTables\DataTable;

class FeedbackIdeasController extends App_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->data['menu_item']     ='comments';
        $this->data['title']         = app_lang('feedback-view-comments');
        $this->data['collapse_menu'] = true;
        $this->data['breadcrumb']    = ['/admin/comments'=>'Comments'];
        $this->custom_model          = Model('App\Models\Custom_model');
    }

    public function index()
    {
        $id = $this->request->uri->getSegment(4);
        if($id){
            $this->data['feedback'] = $this->custom_model->getFeedback(['feedbacks.id'=>$id]);
        }
        return view('comments/manage', $this->data);
    }

    public function table()
    {
        $posted_data = $this->request->getPost(null,FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $builder = $this->db->table('feedbacks_ideas')->select('id,approved,description,(CASE WHEN user_name IS NULL THEN "Anonymous User" ELSE user_name END) as username,(CASE WHEN user_email IS NULL THEN "Anonymous User" ELSE user_email END) as useremail',false);
        return DataTable::of($builder)
        ->filter(function ($builder, $request) {
            if($request->feedback_id){
                $builder->where('feedback_id', $request->feedback_id);            
            }
        })        
        ->setSearchableColumns(['description','user_name','user_email'])
        ->add('status',function($data){
            return "<select class='feedback-comment-status-table form-select form-control-sm form-control' data-id='".$data->id."'>
                <option value='0' ".($data->approved=="0" ? 'selected' : '')." >".app_lang('pending_moderation')."</option>
                <option value='1' ".($data->approved=="1" ? 'selected' : '')." >".app_lang('approved')."</option>
                <option value='2' ".($data->approved=="2" ? 'selected' : '')." >".app_lang('dis_approved')."</option>
            </select>";
        })
        ->add('action',function($data){
             return '<button type="button" aria-haspopup="true" data-bs-toggle="dropdown" aria-expanded="false" class="btn btn-link">
           <i class="fa fa-ellipsis-h"></i></button>
           <div tabindex="-1" aria-hidden="true" class="dropdown-menu-rounded dropdown-menu" >

           <ul class="nav flex-column">
           <li class="nav-item">
           <a href="'.site_url('admin/comment/'.$data->id.'/edit').'" class="nav-link btn btn-link text-primary view-info"><i class="nav-link-icon lnr-pencil"></i>'.app_lang('edit').'</a>
           <a href="'.site_url('admin/comment/'.$data->id.'/delete').'" class="nav-link btn btn-link text-primary view-info _delete")"><i class="nav-link-icon lnr-trash"></i>'.app_lang('delete').'</a></li></ul></div>';

        })
        ->toJson(true);
    }

    public function change_comment_status()
    {
        $posted_data = $this->request->getPost(null,FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $query = $this->custom_model->updateRow('feedbacks_ideas',['approved'=>$posted_data['status']],['id'=>$posted_data['id']]);
        if($query){
            $response = [
                'status'=>'success',
                'title'=> app_lang('feedback_comments'),
                'message'=>app_lang('feedback_comments_status_chaned_successfully'),
            ];
            echo json_encode($response);
            return true;
        }
        $response = [
            'status'=>'danger',
            'title'=> app_lang('feedback_comments'),
            'message'=>app_lang('feedback_comments_status_chaned_failed'),
        ];
        echo json_encode($response);
        return true;
    }

    public function edit_comment($id)
    {
        $posted_data=$this->request->getPost(null,FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if($posted_data){            
            $data['description'] = $posted_data['comment_description'];
            $data['approved'] = $posted_data['approved'];
            if($this->custom_model->updateRow('feedbacks_ideas',$data,['id'=>$id])){
                set_alert('success',app_lang('feedback_comments'),app_lang('feedback_comments_updated'));
                return redirect()->to('admin/comment/'.$id.'/edit');
            }
            return redirect()->to('admin/comment/'.$id.'/edit');
        }        
        $this->data['comment'] = $this->custom_model->getSingleRow('feedbacks_ideas',['id'=>$id]);
        $this->data['feedback'] = $this->custom_model->getSingleRow('feedbacks',['id'=>$this->data['comment']->feedback_id]);
        return view('comments/comments',$this->data);
    }

    public function delete_comment($id)
    {
        if($this->custom_model->deleteRow('feedbacks_ideas',['id'=>$id])){
            set_alert('success',app_lang('feedback_comments'),app_lang('feedback_comments_deleted'));
            return redirect()->back();
        }
        set_alert('success',app_lang('feedback_comments'),app_lang('feedback_comments_deleted_fail'));
        return redirect()->back();
    }
}
