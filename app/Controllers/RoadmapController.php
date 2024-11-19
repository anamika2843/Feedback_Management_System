<?php

namespace App\Controllers;

use Hermawan\DataTables\DataTable;

class RoadmapController extends App_Controller
{
    public function __construct()
    {
        $this->data['menu_item']  = 'roadmap';
        $this->data['title']      = 'Roadmap';
        $this->data['breadcrumb'] = ['/admin/roadmap'=>'Roadmap'];
        $this->custom_model       = Model('App\Models\Custom_model');
    }

    public function index()
    {
        return view('roadmap/manage', $this->data);
    }

    public function table()
    {
        $builder = $this->db->table('roadmap')->select('id,value');

        return DataTable::of($builder)
        ->addNumbering('no')
        ->setSearchableColumns(['value'])
        ->add('action', function ($data) {
            return '<button type="button" aria-haspopup="true" data-bs-toggle="dropdown" aria-expanded="false" class="btn btn-link">
            <i class="fa fa-ellipsis-h"></i></button>
            <div tabindex="-1" aria-hidden="true" class="dropdown-menu-rounded dropdown-menu-right dropdown-menu " style="width:10%">
             <ul class="nav flex-column">
                <li class="nav-item">
                     <button class="nav-link btn btn-link text-primary drop edit-roadmap" data-id="'.$data->id.'" data-value="'.$data->value.'"><i class="nav-link-icon lnr-book"></i>'.app_lang('edit').'</button>
                </li>
            </ul>

            </div>
            </div>';
        })
        ->toJson(true);
    }

    public function update()
    {
        $posted_data = $this->request->getPost(null,FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $rules       =[
            'roadmap_name'=> 'required|is_unique[roadmap.value,id,{id}]',
        ];
        $error=[
            'roadmap_name'=> ['required'=>app_lang('roadmap_required'), 'is_unique'=>app_lang('roadmap_exists')],
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
            'value' => trim($posted_data['roadmap_name']),
        ];
        set_alert('success', app_lang('roadmap'), app_lang('roadmap_updated_successfully'));
        $this->custom_model->updateRow('roadmap', $data, $where);
        $response = [
            'status' => 'success',
            'message'=> app_lang('roadmap_updated_successfully'),
        ];

        return $this->response->setJSON($response);
    }
}
