<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use Faker\Factory;

class FeedbackSeeder extends Seeder
{
    public function __construct()
    {      
        $this->custom_model = Model('App\Models\Custom_model');
    }

     public function run()
    {
        for ($i = 0; $i < 10; $i++) { 
            $this->custom_model->insertRow('feedbacks',$this->generateBoards());
        }
    }

    private function generateBoards(): array
    {
        $faker = Factory::create();
        $category= $this->custom_model->getRandomRecord('category');
        $board= $this->custom_model->getRandomRecord('board');
        $user_id= $this->custom_model->getRandomRecord('users_front');
        return [
            'user_id' => $user_id->id,
            'user_name' => $faker->name(),
            'user_email' => $faker->email(),
            'feedback_description' => $faker->paragraph(),
            'status' => '0',
            'category' => $category->id,
            'approval_status' => '0',
            'upvotes' => '0',
            'board_id' => $board->id,
        ];
    }
}
