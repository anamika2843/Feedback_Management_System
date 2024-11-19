<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use Models\Custom_model;

class RoadmapSeeder extends Seeder
{
    public function __construct()
    {      
        $this->custom_model = Model('App\Models\Custom_model');
    }
    public function run()
    {
        $roadmaps=[ 
            '0' =>'New',           
            '1' =>'Planned',
            '2' =>'In Progress',
            '3' =>'Implemented',
            '4' =>'Rejected',
        ];
        foreach($roadmaps as $key => $value){
            $this->custom_model->insertorupdate('roadmap',['id'=>$key, 'value' => $value],['value'=>$value]);
        }
    }
}
