<?php

namespace App\Controllers\Api;

use CodeIgniter\API\ResponseTrait;
use CodeIgniter\RESTful\ResourceController;

class CategoryController extends ResourceController
{
    use ResponseTrait;

    protected $format = 'json';

    protected $custom_model;

    public function __construct()
    {
        $this->custom_model = Model('App\Models\Custom_model');
    }

    public function index($board_id= null)
    {
        $category = $this->custom_model->getCategoryRowsWithCount($board_id);

        return $this->respond($category);
    }

    public function show($id = null)
    {
        $category = $this->custom_model->getRows('category', ['id'=>$id]);

        return $this->respond($category);
    }

    public function search($key = '')
    {
    }

    public function create()
    {
    }

    public function update($id = null)
    {
    }

    public function delete($id = null)
    {
    }
}
