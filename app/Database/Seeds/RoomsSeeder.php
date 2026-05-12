<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class RoomsSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'room_num' => 'A01',
                'price'    => 800000,
                'facility' => 'AC, Kasur, Lemari',
            ],
            [
                'room_num' => 'A02',
                'price'    => 800000,
                'facility' => 'AC, Kasur, Lemari',
            ],
            [
                'room_num' => 'B01',
                'price'    => 600000,
                'facility' => 'Kasur, Lemari',
            ],
            [
                'room_num' => 'B02',
                'price'    => 600000,
                'facility' => 'Kasur, Lemari',
            ],
            [
                'room_num' => 'C01',
                'price'    => 1000000,
                'facility' => 'AC, Kasur, Lemari, Kamar Mandi Dalam',
            ],
        ];

        $this->db->table('room')->insertBatch($data);
    }
}