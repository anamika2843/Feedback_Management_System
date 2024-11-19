<?php

namespace App\Controllers;

use Hermawan\DataTables\DataTable;

class CategoryController extends App_Controller
{
    public function __construct()
    {
        $this->data['menu_item']  = 'category';
        $this->data['title']      = 'Category';
        $this->data['breadcrumb'] = ['/admin/category'=>'Category'];
        $this->custom_model       = Model('App\Models\Custom_model');
    }

    public function index()
    {
        return view('category/index', $this->data);
    }

    public function table()
    {
        $builder = $this->db->table('category')->select('id,title,description');

        return DataTable::of($builder)
        ->addNumbering('no')
        ->setSearchableColumns(['title', 'description'])
        ->add('action', function ($data) {
            return '<button type="button" aria-haspopup="true" data-bs-toggle="dropdown" aria-expanded="false" class="btn btn-link">
            <i class="fa fa-ellipsis-h"></i></button>
            <div tabindex="-1" aria-hidden="true" class="dropdown-menu-rounded dropdown-menu-right dropdown-menu " style="width:10%">

             <ul class="nav flex-column">
                <li class="nav-item">
                    <a href="category/edit/'.$data->id.'" class="nav-link"> <i class="nav-link-icon lnr-book"></i>'.app_lang('edit').'</a>
                </li>
                 <li class="nav-item">
                 '.form_open('admin/category/delete/'.$data->id).csrf_field().'
                    <button type="submit" class="nav-link btn btn-link text-primary"><i class="nav-link-icon lnr-trash"></i> '.app_lang('delete').'</a>
                '.form_close().'

                 </li>
            </ul>


            </div>
            </div>';
        })->toJson(true);
    }

    public function create()
    {
        return view('category/form', $this->data);
    }

    public function store()
    {
        $posted_data=$this->request->getPost(null,FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $segment    =$this->request->uri->getSegment(4);

        $rules=[
            'title'      => 'required|is_unique[category.title,id,'.$segment.']',
            'description'=> 'required',
        ];

        $error=[
            'title'      => ['required'=>app_lang('category_title_required'), 'is_unique'=>app_lang('category_title_exists')],
            'description'=> ['required'=>app_lang('category_desc_required')],
        ];
        if (!$this->validate($rules, $error)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data=[
            'title'       => $posted_data['title'],
            'description' => $posted_data['description'],
        ];

        if (null == $segment) {
            $where=['id'=>0];
            set_alert('success', app_lang('category'), app_lang('category_created_successfully'));
        } else {
            $where['id']= $segment;
            set_alert('success', app_lang('category'), app_lang('category_update_successfully'));
        }
        $this->custom_model->insertorupdate('category', $data, $where);

        return redirect()->to(route_to('admin/category'));
    }

    public function edit($id)
    {
        $this->data['category']=$this->custom_model->getSingleRow('category', ['id'=>$id]);

        return view('category/form', $this->data);
    }

    public function delete($id)
    {
        set_alert('success', app_lang('category'), app_lang('category_delete_successfully'));
        $this->custom_model->deleteRow('category', ['id'=>$id]);

        return redirect()->to(route_to('admin/category'));
    }
}
