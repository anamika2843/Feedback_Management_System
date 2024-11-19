<?php

namespace App\Controllers\Api;

use CodeIgniter\API\ResponseTrait;
use CodeIgniter\RESTful\ResourceController;

class BoardController extends ResourceController
{
    use ResponseTrait;

    protected $format = 'json';

    protected $custom_model;

    public function __construct()
    {
        $this->custom_model = Model('App\Models\Custom_model');
    }

    public function index()
    {
        $board = $this->custom_model->getRows('board');

        return $this->respond($board);
    }

    public function show($id = null)
    {
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
