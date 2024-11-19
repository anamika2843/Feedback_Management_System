<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use Models\Custom_model;

class SettingSeeder extends Seeder
{
    public function __construct()
    {      
        $this->custom_model = Model('App\Models\Custom_model');
    }
    public function run()
    {
        $settings=[        
            'company_name'=>'Idea',
            'company_main_domain'=>'themesic.com',
            'copyright_text' => 'themesic.com',
            'cookie_notice_text' => 'We use cookies to ensure you get the best experience',
            'cookie_area' => 'Got it',
            'cookie_longtext' => 'you confirm that you are in agreement with and bound by the terms of service contained in the Terms & Conditions outlined below. These terms apply to the entire website and any email or other type of communication between you and our company.',
            'usage' => 'We use Terms of Usage to ensure you get the best experience',
            'privacy_policy' => 'Please Read our Privacy Policies'
        ];
        foreach ($settings as $key => $value) 
        {
            $this->custom_model->insertorupdate('options',['name'=> $key,'value'=>$value],['name'=>$key]);            
        }
    }
}
