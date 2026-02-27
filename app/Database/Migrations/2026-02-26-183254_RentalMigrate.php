<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class RentalMigrate extends Migration
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
            'room_id' => [
                'type'     => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'boarder_id' => [
                'type'     => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'status' => [
                'type'       => 'ENUM',
                'constraint' => ['active', 'ended', 'pending'],
                'default'    => 'pending',
            ],
            'start_date' => [
                'type' => 'DATE',
            ],
            'end_date' => [
                'type' => 'DATE',
                'null' => true,
            ],
        ]);

        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('room_id', 'room', 'id', 'CASCADE', 'RESTRICT');
        $this->forge->addForeignKey('boarder_id', 'boarder', 'id', 'CASCADE', 'RESTRICT');
        $this->forge->createTable('rental');
    }

    public function down()
    {
        $this->forge->dropTable('rental');
    }
}
