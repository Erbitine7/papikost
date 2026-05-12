<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class BoardersSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'email' => 'agus@gmail.com',
                'name'  => 'Agus Prasetyo',
                'phone' => '081234567890',
            ],
            [
                'email' => 'dewi@gmail.com',
                'name'  => 'Dewi Lestari',
                'phone' => '082345678901',
            ],
            [
                'email' => 'fajar@gmail.com',
                'name'  => 'Fajar Nugroho',
                'phone' => '083456789012',
            ],
            [
                'email' => 'maya@gmail.com',
                'name'  => 'Maya Sari',
                'phone' => '084567890123',
            ],
            [
                'email' => 'rizky@gmail.com',
                'name'  => 'Rizky Hidayat',
                'phone' => '085678901234',
            ],
        ];

        $this->db->table('boarder')->insertBatch($data);
    }
}