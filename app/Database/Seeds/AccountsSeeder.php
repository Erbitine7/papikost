<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\Shield\Entities\User;

class AccountsSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'username'  => 'admin',
                'password'  => password_hash('admin123', PASSWORD_DEFAULT),
                'full_name' => 'Admin Utama',
                'email'     => 'admin@kos.com',
                'role'      => 0,
                'status'    => 0,
            ],
            [
                'username'  => 'staff1',
                'password'  => password_hash('staff123', PASSWORD_DEFAULT),
                'full_name' => 'Budi Santoso',
                'email'     => 'staff1@kos.com',
                'role'      => 1,
                'status'    => 0,
            ],
            [
                'username'  => 'staff2',
                'password'  => password_hash('staff123', PASSWORD_DEFAULT),
                'full_name' => 'Siti Rahayu',
                'email'     => 'staff2@kos.com',
                'role'      => 1,
                'status'    => 0,
            ],
            [
                'username'  => 'staff3',
                'password'  => password_hash('staff123', PASSWORD_DEFAULT),
                'full_name' => 'Deni Kurniawan',
                'email'     => 'staff3@kos.com',
                'role'      => 1,
                'status'    => 0,
            ],
            [
                'username'  => 'staff4',
                'password'  => password_hash('staff123', PASSWORD_DEFAULT),
                'full_name' => 'Rina Wulandari',
                'email'     => 'staff4@kos.com',
                'role'      => 1,
                'status'    => 0,
            ],
        ];

        $this->db->table('operators')->insertBatch($data);
    }
}