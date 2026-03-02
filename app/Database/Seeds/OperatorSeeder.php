<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class OperatorSeeder extends Seeder
{
    public function run()
    {
        $data = [
            'username'  => 'admin',
            'password'  => password_hash('password', PASSWORD_DEFAULT),
            'full_name' => 'Administrator',
            'email'     => 'admin@example.com',
            'role'      => 0, // admin
            'status'    => 0,
        ];

        $this->db->table('operators')->insert($data);
    }
}
