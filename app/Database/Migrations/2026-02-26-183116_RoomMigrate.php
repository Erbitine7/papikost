<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class RoomMigrate extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'room_num' => [
                'type'       => 'VARCHAR',
                'constraint' => 10,
                'unique'     => true,
            ],
            'price' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
            ],
            'facility' => [
                'type' => 'TEXT',
                'null' => true,
            ],
        ]);

        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('room');
    }

    public function down()
    {
        $this->forge->dropTable('room');
    }
}
