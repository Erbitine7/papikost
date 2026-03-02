<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ComputerSeeder extends Seeder
{
    public function run()
    {
        $computers = [
            [
                'pc_category' => 'Gaming',
                'spec' => 'i7, 16GB RAM, GTX 1660',
                'tariff' => 10000,
                'status' => 0,
            ],
            [
                'pc_category' => 'Standard',
                'spec' => 'i5, 8GB RAM, Integrated',
                'tariff' => 5000,
                'status' => 0,
            ],
        ];

        foreach ($computers as $c) {
            $this->db->table('computers')->insert($c);
        }
    }
}
