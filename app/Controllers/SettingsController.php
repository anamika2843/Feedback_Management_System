<?php

namespace App\Controllers;

use App\Libraries\Envapi;

if (!class_exists('\WpOrg\Requests\Autoload')) {
    require_once APPPATH.'ThirdParty/Requests/src/Autoload.php';
}
\WpOrg\Requests\Autoload::register();

class SettingsController extends App_Controller
{
    protected $cache_lib;

    public function __construct()
    {
        parent::__construct();
        helper('general');
        $this->cache_lib               = \Config\Services::cache();
        $this->data['menu_item']       = 'settings';
        $this->data['title']           = 'Settings';
        $this->data['breadcrumb']      = ['/admin/settings'=>'Settings'];
        $this->custom_model            = Model('App\Models\Custom_model');
        $this->data['email_protocol']  = get_option('email_protocol');
        $this->data['smtp_encryption'] = get_option('smtp_encryption');
        $this->data['usage']           = get_option('usage');
        $this->data['privacy_policy']  = get_option('privacy_policy');
    }

    public function index()
    {
        $this->data['tab'] =  $this->request->getGet('group');
        if (!$this->data['tab']) {
            $this->data['tab'] = 'general';
        }
        $this->data['left_side_tabs'] = ['general', 'email', 're-captcha', 'miscellaneous', 'policy', 'custom-javascript', 'purchase-code'];
        $this->data['language_list']  = get_language_list();
        $this->data['verified']       = Envapi::validatePurchase('idea_feedback');

        return view('settings/all', $this->data);
    }

    public function save()
    {
        $posted_data  = $this->request->getPost(null,FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $company_logo = $this->request->getFile('company_logo');
        $favicon_logo = $this->request->getFile('favicon_logo');
        $tab          =  $this->request->getGet('group');

        if ('purchase-code' == $tab) {
            $res = $this->check_code();
            if (!$res['status']) {
                set_alert('danger', app_lang('error'), $res['message']);
            }
            return redirect()->to(route_to('admin/settings').'?group='.$tab);
        }

         if (!isset($posted_data['settings']['disable_copyright'])) {
            update_option('disable_copyright', 'no');
        }
        if (!isset($posted_data['settings']['allow_posting'])) {
            update_option('allow_posting', 'no');
        }
        if (!isset($posted_data['settings']['allow_guest_posting'])) {
            update_option('allow_guest_posting', 'no');
        }
        if (!isset($posted_data['settings']['allow_guest_commenting'])) {
            update_option('allow_guest_commenting', 'no');
        }
        if (!isset($posted_data['settings']['enable_while_login'])) {
            update_option('enable_while_login', 'no');
        }
        if (!isset($posted_data['settings']['enable_while_registration'])) {
            update_option('enable_while_registration', 'no');
        }
        if (!isset($posted_data['settings']['enable_while_forgot_password'])) {
            update_option('enable_while_forgot_password', 'no');
        }
        if (!isset($posted_data['settings']['disable_copyright'])) {
            update_option('disable_copyright', 'no');
        }

        if ($company_logo && $company_logo->isValid()) {
            _maybe_create_upload_path(FCPATH.'public/uploads');
            _maybe_create_upload_path(FCPATH.'public/uploads/company');
            $rules = [
                'company_logo'=> 'uploaded[company_logo]|mime_in[company_logo,image/jpeg,image/jpg,image/png]|is_image[company_logo]|ext_in[company_logo,png,jpeg,jpg]',
            ];
            $error=[
                'company_logo'=> ['uploaded'=> app_lang('select_file_to_upload'), 'mime_in'=> app_lang('onlyExtension'), 'ext_in'=> app_lang('onlyExtension'), 'is_image'=> app_lang('only_image')],
            ];

            if (!$this->validate($rules, $error)) {
                return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
            }

            $company_logo_name = $company_logo->getRandomName();
            $company_logo->move(FCPATH.'public/uploads/company/', $company_logo_name);
            $posted_data['settings']['company_logo'] = $company_logo_name;

            $old_image = get_option('company_logo');
            if (!empty($old_image) && file_exists(FCPATH.'public/uploads/company/'.$old_image)) {
                unlink(FCPATH.'public/uploads/company/'.$old_image);
            }
            $this->cache_lib->save('company_logo', $company_logo_name);
        }
        if ($favicon_logo && $favicon_logo->isValid()) {
            _maybe_create_upload_path(FCPATH.'public/uploads');
            _maybe_create_upload_path(FCPATH.'public/uploads/company');
            $rules = [
                'favicon_logo'=> 'uploaded[favicon_logo]|mime_in[favicon_logo,image/jpeg,image/jpg,image/png]|is_image[favicon_logo]|ext_in[favicon_logo,png,jpeg,jpg]',
            ];
            $error=[
                'favicon_logo'=> ['uploaded'=> app_lang('select_file_to_upload'), 'mime_in'=> app_lang('onlyExtension'), 'ext_in'=> app_lang('onlyExtension'), 'is_image'=> app_lang('only_image')],
            ];

            if (!$this->validate($rules, $error)) {
                return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
            }

            $favicon_logo_name = $favicon_logo->getRandomName();
            $favicon_logo->move(FCPATH.'public/uploads/company/', $favicon_logo_name);
            $posted_data['settings']['favicon_logo'] = $favicon_logo_name;

            $old_image = get_option('favicon_logo');
            if (!empty($old_image) && file_exists(FCPATH.'public/uploads/company/'.$old_image)) {
                unlink(FCPATH.'public/uploads/company/'.$old_image);
            }
            $this->cache_lib->save('favicon_logo', $favicon_logo_name);
        }
        foreach ($posted_data['settings'] as $key=>$value) {
            if ('smtp_password' == $key) {
                $value = encode_values($value, 'smtp_pass');
            }
            if ('copyright_text' == $key) {
                $value = htmlentities($value);
            }
            $this->custom_model->insertorupdate('options', ['name'=>$key, 'value'=>$value], ['name'=>$key]);
        }
        set_alert('success', app_lang('success'), app_lang('settings_updated'));

        return redirect()->to(route_to('admin/settings').'?group='.$tab);
    }

    public function send_test_email()
    {
        $posted_data = $this->request->getPost(null,FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if (empty($posted_data['email'])) {
            echo json_encode(['success'=>false, 'message'=>app_lang('email_required')]);
        }
        if (send_app_mail($posted_data['email'], 'SMTP Setup Testing', get_option('email_header').app_lang('testing_smtp_mail_success_message').get_option('email_footer'))) {
            echo json_encode(['success'=>true, 'message'=>app_lang('testing_smtp_mail_success_message_success')]);
        } else {
            echo json_encode(['success'=>false, 'message'=>app_lang('testing_smtp_mail_success_message_fail')]);
        }
    }

    public function remove_logo($type)
    {
        $old_image = get_option($type);
        if ('company_logo' == $type && !empty($old_image)) {
            if (file_exists(FCPATH.'public/uploads/company/'.$old_image)) {
                unlink(FCPATH.'public/uploads/company/'.$old_image);
            }
            update_option('company_logo', '');
            $this->cache_lib->delete('company_logo');
        }
        if ('favicon_logo' == $type && !empty($old_image)) {
            $old_image = get_option('favicon_logo');
            if (file_exists(FCPATH.'public/uploads/company/'.$old_image)) {
                unlink(FCPATH.'public/uploads/company/'.$old_image);
            }
            update_option('favicon_logo', '');
            $this->cache_lib->delete('favicon_logo');
        }
        set_alert('success', app_lang('success'), app_lang('settings_updated'));

        return redirect()->to(route_to('admin/settings'));
    }

    private function check_code()
    {
		return ['status'=> true];
    }
}
