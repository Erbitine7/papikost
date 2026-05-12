<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DbSeeder extends Seeder
{
public function run()
{
    $this->call('AccountsSeeder');
    $this->call('BoardersSeeder');
    $this->call('RoomsSeeder');
}
}
