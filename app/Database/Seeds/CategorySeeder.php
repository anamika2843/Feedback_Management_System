<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use Faker\Factory;

class CategorySeeder extends Seeder
{
    public function run()
    {
        for ($i = 0; $i < 10; $i++) { 
            $this->db->table('category')->insert($this->generateCategory());
        }
    }

    private function generateCategory(): array
    {
        $faker = Factory::create();
        return [
            'title' => $faker->name(),
            'description' => $faker->paragraph()
        ];
    }
}
