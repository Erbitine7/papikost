<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ComputerSeeder extends Seeder
{
    public function run()
    {
        $computers = [
            [
                
                'tariff' => 10000,
                'status' => 0,
            ],
            [
                
                'tariff' => 5000,
                'status' => 0,
            ],
        ];

        foreach ($computers as $c) {
            $this->db->table('computers')->insert($c);
        }
    }
}
