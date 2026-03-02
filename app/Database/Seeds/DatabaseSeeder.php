<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call('App\\Database\\Seeds\\OperatorSeeder');
        $this->call('App\\Database\\Seeds\\MemberSeeder');
        $this->call('App\\Database\\Seeds\\ComputerSeeder');
    }
}
