<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class MemberSeeder extends Seeder
{
    public function run()
    {
        $members = [
            [
                'email' => 'jane.doe@example.com',
                'name'  => 'Jane Doe',
                'phone_number' => '081234567890',
                'status' => 0,
            ],
            [
                'email' => 'john.smith@example.com',
                'name'  => 'John Smith',
                'phone_number' => '082345678901',
                'status' => 0,
            ],
        ];

        foreach ($members as $m) {
            $this->db->table('members')->insert($m);
        }
    }
}
