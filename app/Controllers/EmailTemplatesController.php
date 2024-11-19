<?php

namespace App\Controllers;

use App\Models\Email_Model;

class EmailTemplatesController extends App_Controller
{
    public $email_model;

    public function __construct()
    {
        parent::__construct();
        $this->email_model        = new Email_Model();
        $this->custom_model       = Model('App\Models\Custom_model');
        $this->data['menu_item']  = 'email_template';
        $this->data['title']      = 'Email Templates';
        $this->data['breadcrumb'] = ['admin/emailtemplates'=>'Email Templates'];
        helper(['url']);
    }

    public function index()
    {
        $this->data['template'] = $this->email_model->getEmailTemplate();

        return view('emails/email_templates', $this->data);
    }

    public function getEmailTemplate($id)
    {
        $where['emailtemplateid'] = $id;
        $this->data['template']   = $this->email_model->getEmailTemplate($where);
        $this->data['merge_fields'] = get_merge_fields($this->data['template']['slug']);

        return view('emails/email', $this->data);
    }

    public function updateTemplate()
    {
        $where['emailtemplateid'] = $this->request->getPost('emialtemplateid');
        $insert_data              = [
            'subject'         => $this->request->getPost('subject'),
            'fromname'        => $this->request->getPost('fromname'),
            'active'          => ('on' == $this->request->getPost('active') ? 0 : 1),
            'message'         => $this->request->getPost('message'),
            'emialtemplateid' => $this->request->getPost('emialtemplateid'),
        ];
        if ($this->email_model->updateTemplate($where, $insert_data)) {
            set_alert('success', app_lang('email_templates'), app_lang('update_success'));
            return redirect()->to(route_to('admin/email'));
        }
    }

    public function enable_template($id)
    {
        $where['emailtemplateid'] = $id;
        $enable['active']         = '1';
        $this->email_model->updateTemplate($where, $enable);

        return redirect()->to(route_to('admin/email'));
    }

    public function disable_template($id)
    {
        $where['emailtemplateid'] = $id;
        $disable['active']        = '0';
        $this->email_model->updateTemplate($where, $disable);

        return redirect()->to(route_to('admin/email'));
    }
}
