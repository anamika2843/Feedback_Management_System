<?php

namespace App\Controllers\Api;

use CodeIgniter\API\ResponseTrait;
use CodeIgniter\RESTful\ResourceController;

class UsersController extends ResourceController
{
    use ResponseTrait;

    protected $format = 'json';

    protected $custom_model;

    public function __construct()
    {
        $this->custom_model = Model('App\Models\Custom_model');
        helper('jwt');
    }

    public function index()
    {
    }

    public function show($id = null)
    {
    }

    public function search($key = '')
    {
    }

    public function create()
    {
        $posted_data = $this->request->getPost(null,FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        $user = $this->custom_model->getSingleRow('users_front', ['email'=>$posted_data['email']]);

        if ($user) {
            $id        = $user->id;
            $token     = $user->token;
            $user_data = [
                    'name'=> $posted_data['name'],
                ];
            $response = [
                    'name'     => $posted_data['name'],
                    'email'    => $posted_data['email'],
                    'authtoken'=> $token,
                ];
        } else {
            $user_data = [
                    'name' => $posted_data['name'],
                    'email'=> $posted_data['email'],
                ];
            $user_data['token'] = EncodeJWTtoken($user_data);
            $token              = $user_data['token'];
            $response           = [
                    'name'     => $posted_data['name'],
                    'email'    => $posted_data['email'],
                    'authtoken'=> $token,
                ];
        }
        $this->custom_model->insertorupdate('users_front', $user_data, ['email'=>$posted_data['email']]);

        return $this->respond($response);
    }

    public function update($id = null)
    {
    }

    public function delete($id = null)
    {
    }
}
