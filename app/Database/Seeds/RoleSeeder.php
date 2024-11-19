<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use Faker\Factory;

class RoleSeeder extends Seeder
{
    
        public function run()
    {
        for ($i = 0; $i < 20; $i++) { 
            $this->db->table('auth_groups')->insert($this->generateRole());
        }
    }

    private function generateRole(): array
    {
        $faker = Factory::create();
        return [
            'name' => $faker->name(),
            'description' => $faker->paragraph()
        ];
    }
   
}
