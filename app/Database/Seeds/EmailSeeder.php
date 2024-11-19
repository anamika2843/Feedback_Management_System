<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class EmailSeeder extends Seeder
{
     public function __construct()
    {      
        $this->custom_model = Model('App\Models\Custom_model');
    }

    public function run()
    {
        $email=[
            [
                'type' => 'feedback',
                'slug' => 'new-feature-request',
                'language' => null,
                'name' => 'New Feature Request',
                'subject' => 'New Feature Request',
                'message' => '<p><span style=\"color: #495057; font-family: system-ui, -apple-system, \'Segoe UI\', Roboto, \'Helvetica Neue\', Arial, \'Noto Sans\', \'Liberation Sans\', sans-serif, \'Apple Color Emoji\', \'Segoe UI Emoji\', \'Segoe UI Symbol\', \'Noto Color Emoji\'; font-size: 14.08px;\">{DESCRIPTION}</span></p>',
                'fromname' => 'Test',
                'fromemail' => 'test@gmail.com',
                'plaintext' => '0',
                'active' => '1',
                'order' => '1',
            ],
            [
                'type' => 'feedback',
                'slug' => 'request-more-info',
                'language' => null,
                'name' => 'Request More Information',
                'subject' => 'Request More Information',
                'message' => '
                <p><span style=\"color: #495057; font-family: system-ui, -apple-system, \'Segoe UI\', Roboto, \'Helvetica Neue\', Arial, \'Noto Sans\', \'Liberation Sans\', sans-serif, \'Apple Color Emoji\', \'Segoe UI Emoji\', \'Segoe UI Symbol\', \'Noto Color Emoji\'; font-size: 14.08px;\">{HEADER}</span></p>
                <b>Your Name:</b>
                <p><span style=\"color: #495057; font-family: system-ui, -apple-system, \'Segoe UI\', Roboto, \'Helvetica Neue\', Arial, \'Noto Sans\', \'Liberation Sans\', sans-serif, \'Apple Color Emoji\', \'Segoe UI Emoji\', \'Segoe UI Symbol\', \'Noto Color Emoji\'; font-size: 14.08px;\">{USER_NAME}</span></p>
                <b>Your Email:</b>
                <p><span style=\"color: #495057; font-family: system-ui, -apple-system, \'Segoe UI\', Roboto, \'Helvetica Neue\', Arial, \'Noto Sans\', \'Liberation Sans\', sans-serif, \'Apple Color Emoji\', \'Segoe UI Emoji\', \'Segoe UI Symbol\', \'Noto Color Emoji\'; font-size: 14.08px;\">{USER_EMAIL}</span></p>
                <b>Description:</b>
                <p><span style=\"color: #495057; font-family: system-ui, -apple-system, \'Segoe UI\', Roboto, \'Helvetica Neue\', Arial, \'Noto Sans\', \'Liberation Sans\', sans-serif, \'Apple Color Emoji\', \'Segoe UI Emoji\', \'Segoe UI Symbol\', \'Noto Color Emoji\'; font-size: 14.08px;\">{DESCRIPTION}</span></p>',
                'fromname' => 'Test',
                'fromemail' => 'test@gmail.com',
                'plaintext' => '0',
                'active' => '1',
                'order' => '1',
            ]
        ];
        foreach ($email as $value) {                    
            $data['type'] = $value['type'];
            $data['slug'] = $value['slug'];
            $data['language'] = $value['language'];
            $data['name'] = $value['name'];
            $data['subject'] = $value['subject'];
            $data['message'] = $value['message'];
            $data['fromname'] = $value['fromname'];
            $data['fromemail'] = $value['fromemail'];
            $data['plaintext'] = $value['plaintext'];
            $data['active'] = $value['active'];
            $data['order'] = $value['order'];

            $query= $this->custom_model->insertorupdate('emailtemplates',$data,['slug'=>$value['slug']]);

        }
    }
}
