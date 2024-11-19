<?php

namespace App\Controllers;

class App_Controller extends BaseController
{
    protected $parser;

    public function __construct()
    {
        $this->data   = [];
        $this->parser = \Config\Services::parser();
    }

    public function index()
    {
    }

    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger); //don't edit this line
    }
}
