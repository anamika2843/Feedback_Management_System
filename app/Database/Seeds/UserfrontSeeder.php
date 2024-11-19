<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use Faker\Factory;


class UserfrontSeeder extends Seeder
{
   public function run()
    {
        for ($i = 0; $i < 10; $i++) { 
            $this->db->table('users_front')->insert($this->generateBoards());
        }
    }

    private function generateBoards(): array
    {
        $faker = Factory::create();
        return [
            'name' => $faker->name(),
            'email' => $faker->email()
        ];
    }
}
