<?php

namespace App\Controllers;

use Hermawan\DataTables\DataTable;

class BoardsController extends App_Controller
{
    public function __construct()
    {
        $this->data['menu_item']  = 'boards';
        $this->data['title']      = 'Boards';
        $this->data['breadcrumb'] = ['/admin/boards'=>'Boards'];
        $this->custom_model       = Model('App\Models\Custom_model');
    }

    public function index()
    {
        return view('board/manage', $this->data);
    }

    public function table()
    {
        $builder = $this->db->table('board')->select('id,name,intro_text');

        return DataTable::of($builder)
    ->addNumbering('no')
    ->setSearchableColumns(['name', 'intro_text'])
    ->add('action', function ($data) {
        return '<button type="button" aria-haspopup="true" data-bs-toggle="dropdown" aria-expanded="false" class="btn btn-link">
     <i class="fa fa-ellipsis-h"></i></button>
     <div tabindex="-1" aria-hidden="true" class="dropdown-menu-rounded dropdown-menu-right dropdown-menu " style="width:10%">

      <ul class="nav flex-column">
                <li class="nav-item">
                    <a href="boards/edit/'.$data->id.'" class="nav-link"><i class="nav-link-icon lnr-book"></i> '.app_lang('edit').'</a>
                </li>
                <li class="nav-item">
                 '.form_open('admin/boards/delete/'.$data->id).csrf_field().'
                 <button type="submit" class="nav-link btn btn-link text-primary" ><i class="nav-link-icon lnr-trash"></i>'.app_lang('delete').'</a>
                 '.form_close().'
                </li>
            </ul>
     </div>
     </div>';
    })->toJson(true);
    }

    public function create()
    {
        return view('board/form', $this->data);
    }

    public function store()
    {
        $posted_data=$this->request->getPost(null,FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $segment    =$this->request->uri->getSegment(4);
        $rules      =[
        'name'      => 'required|is_unique[board.name,id,'.$segment.']',
        'intro_text'=> 'required',
    ];
        $error=[
        'name'      => ['required'=>app_lang('board_name_required'), 'is_unique'=>app_lang('board_exists')],
        'intro_text'=> ['required'=>app_lang('board_intro_text')],
    ];
        if (!$this->validate($rules, $error)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
        'name'       => $posted_data['name'],
        'intro_text' => $posted_data['intro_text'],
        'board_slug' => generate_slug($posted_data['name']),
    ];

        if (null == $segment) {
            $where=['id'=>0];
            set_alert('success', app_lang('board'), app_lang('board_create_successfully'));
        } else {
            $where['id'] = $segment;
            set_alert('success', app_lang('board'), app_lang('board_update_successfully'));
        }

        $this->custom_model->insertorupdate('board', $data, $where);

        return redirect()->to(route_to('admin/boards'));
    }

    public function edit($id)
    {
        $this->data['data'] ='board';
        $this->data['board']=$this->custom_model->getSingleRow('board', ['id'=>$id]);

        return view('board/form', $this->data);
    }

    public function delete($id)
    {
        $feedback= $this->custom_model->getCount('feedbacks', ['board_id'=>$id]);

        if ($feedback > 0) {
            set_alert('warning', app_lang('board'), app_lang('cant_delete_board'));
        } else {
            set_alert('success', app_lang('board'), app_lang('board_delete'));
            $this->custom_model->deleteRow('board', ['id'=>$id]);
        }

        return redirect()->to(route_to('admin/boards'));
    }
}
