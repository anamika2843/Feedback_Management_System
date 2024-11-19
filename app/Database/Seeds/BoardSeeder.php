<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use Faker\Factory;

class BoardSeeder extends Seeder
{ 
     public function run()
    {
        helper('general');
        for ($i = 0; $i < 50; $i++) { 
            $this->db->table('board')->insert($this->generateBoards());
        }
    }

    private function generateBoards(): array
    {
        $faker = Factory::create();
        $board_name = $faker->name();
        return [
            'name' => $board_name,
            'intro_text' => $faker->paragraph(),
            'board_slug'=>generate_slug($board_name)
        ];
    }
}
