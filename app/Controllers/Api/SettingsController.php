<?php

namespace App\Controllers\Api;

use CodeIgniter\API\ResponseTrait;
use CodeIgniter\RESTful\ResourceController;

class SettingsController extends ResourceController
{
    use ResponseTrait;

    protected $format = 'json';

    protected $custom_model;

    public function __construct()
    {
        helper(['general']);
        $this->custom_model = Model('App\Models\Custom_model');
    }

    public function index()
    {
        $data['recaptcha']           = $this->recaptcha_settings();
        $data['cookie_settings']     = $this->cookie_settings();
        $data['favicon_logo']        = $this->get_favicon();
        $data['company_logo']        = $this->get_logo();
        $data['copyright_text']      = $this->get_copyright_text();
        $data['custom_js_header']    = $this->get_custom_js_header();
        $data['custom_js_footer']    = $this->get_custom_js_footer();
        $data['boards']              = $this->custom_model->getRows('board');
        $data['allow_guest_posting'] = $this->allow_guest_posting();
        $data['lingual_data']        = $this->lingual_data();

        return $this->respond($data);
    }

    public function lingual_data(){

        //get default language and load front_lang.php
        $language = get_option('default_language');
        if (!empty($language)) {
            $front_lang = require_once(APPPATH.'Language/'.$language.'/front_lang.php');
        }
        else{
            $front_lang = require_once(APPPATH.'Language/en/front_lang.php');
        }

        return $front_lang;
    }

    public function cookie_settings()
    {
        $data['cookie_notice_text'] = get_option('cookie_notice_text');
        $data['cookie_button_text'] = get_option('cookie_area');
        $data['cookie_longtext']    = get_option('cookie_longtext');
        $data['terms_usage']        = get_option('usage');
        $data['privacy_policy']     = get_option('privacy_policy');

        return $data;
    }

    public function get_favicon()
    {
        $data['favicon']               = get_option('favicon_logo');
        $data['favicon_logo_with_url'] = base_url('public/uploads/company/'.get_option('favicon_logo'));

        return $data;
    }

    public function get_logo()
    {
        $data['company']               = get_option('company_logo');
        $data['company_logo_with_url'] = base_url('public/uploads/company/'.get_option('company_logo'));

        return $data;
    }

    public function recaptcha_settings()
    {
        $data['recaptcha_site_key']   = get_option('site_key');
        $data['recaptcha_secret_key'] = get_option('secret_key');

        return $data;
    }

    public function get_copyright_text()
    {
        $data['disable_copyright'] = 'yes' == get_option('disable_copyright') ? true : false;
        $data['copyright_text']    = html_entity_decode(get_option('copyright_text'));

        return $data;
    }

    public function get_custom_js_header()
    {
        $data['custom_js_header'] = get_option('custom_js_header');

        return $data;
    }

    public function get_custom_js_footer()
    {
        $data['custom_js_foter'] = get_option('custom_js_foter');

        return $data;
    }

    public function allow_guest_posting()
    {
        $data['allow_guest_posting']    = ('yes' == get_option('allow_guest_posting') ? true : false);
        $data['allow_guest_commenting'] = ('yes' == get_option('allow_guest_commenting') ? true : false);

        return $data;
    }
}
