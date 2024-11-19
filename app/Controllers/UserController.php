<?php

namespace App\Controllers;

use Hermawan\DataTables\DataTable;

class UserController extends App_Controller
{
    public function __construct()
    {
        $this->data['menu_item']     ='users';
        $this->data['title']         ='Users';
        $this->data['breadcrumb']    =['/admin/users'=>'Users'];
        $this->data['menu_collapse'] = true;
        $this->custom_model          = Model('App\Models\Custom_model');
    }

    public function index()
    {
        return view('users/manage', $this->data);
    }

    public function table()
    {
        $builder = $this->db->table('users_front')->select('id,name,email');

        return DataTable::of($builder)
        ->addNumbering('no')
        ->setSearchableColumns(['name', 'email'])
        ->add('action', function ($data) {
            return "<button type='button' aria-haspopup='true' data-bs-toggle='dropdown' aria-expanded='false' class='btn btn-link'>
                <i class='fa fa-ellipsis-h'></i></button>
                <div tabindex='-1' aria-hidden='true' class='dropdown-menu dropdown-menu-right' style='width:10%''>
                <ul class='nav flex-column'>
                <li class='nav-item'>
                    <button class='nav-link btn btn-link text-primary edit-users' data-id='".$data->id."' data-value='".json_encode($data, \ENT_QUOTES)."'><i class='nav-link-icon lnr-book'></i> <span>".app_lang('edit')."</span></button>
                </li>
                <li class='nav-item'>
                ".form_open('admin/users/delete/'.$data->id).csrf_field()."
                <button type='submit' class='nav-link btn btn-link text-primary'><i class='nav-link-icon lnr-trash'></i> ".app_lang('delete').'</a>
                '.form_close().'
                </li>
                </ul>
                </div>
                </div>';
        })->toJson(true);
    }

    public function update()
    {
        $posted_data = $this->request->getPost(null,FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $rules       =[
            'name' => 'required|is_unique[users_front.name,id,{id}]',
            'email'=> 'required|is_unique[users_front.email,id,{id}]',
        ];
        $error=[
            'name' => ['required'=>app_lang('user_name_required'), 'is_unique'=>app_lang('user_name_exists')],
            'email'=> ['required'=>app_lang('user_email_required'), 'is_unique'=>app_lang('email_exists')],
        ];
        if (!$this->validate($rules, $error)) {
            $response = [
                'status' => 'error',
                'message'=> $this->validator->listErrors(),
            ];

            return $this->response->setJSON($response);
        }
        $where['id'] = $posted_data['id'];
        $data        = [
                'name'  => $posted_data['name'],
                'email' => $posted_data['email'],
            ];
        set_alert('success', app_lang('user'), app_lang('user_update'));
        $this->custom_model->updateRow('users_front', $data, $where);
        $response = [
            'status' => 'success',
            'message'=> app_lang('user_update'),
        ];

        return $this->response->setJSON($response);
    }

    public function delete($id)
    {
        set_alert('success', app_lang('user'), app_lang('user_delete'));
        $this->custom_model->deleteRow('users_front', ['id'=>$id]);

        return redirect()->to(route_to('admin/users'));
    }
}
