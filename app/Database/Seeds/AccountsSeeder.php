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
                'email'    => 'admin@kos.com',
                'name'     => 'Admin Utama',
                'password' => password_hash('admin123', PASSWORD_DEFAULT),
                'role'     => 'admin',
            ],
            [
                'email'    => 'staff1@kos.com',
                'name'     => 'Budi Santoso',
                'password' => password_hash('staff123', PASSWORD_DEFAULT),
                'role'     => 'staff',
            ],
            [
                'email'    => 'staff2@kos.com',
                'name'     => 'Siti Rahayu',
                'password' => password_hash('staff123', PASSWORD_DEFAULT),
                'role'     => 'staff',
            ],
            [
                'email'    => 'staff3@kos.com',
                'name'     => 'Deni Kurniawan',
                'password' => password_hash('staff123', PASSWORD_DEFAULT),
                'role'     => 'staff',
            ],
            [
                'email'    => 'staff4@kos.com',
                'name'     => 'Rina Wulandari',
                'password' => password_hash('staff123', PASSWORD_DEFAULT),
                'role'     => 'staff',
            ],
        ];

        $this->db->table('account')->insertBatch($data);
    }
}