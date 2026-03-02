<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class MemberMigration extends Migration
{
    public function up()
{
    $this->forge->addField([
        'id' => [
            'type' => 'INT',
            'constraint' => 11,
            'unsigned' => true,
            'auto_increment' => true,
        ],
        'email' => [
            'type' => 'VARCHAR',
            'constraint' => 100,
            'null' => true,
        ],
        'name' => [
            'type' => 'VARCHAR',
            'constraint' => 100,
        ],
        'phone_number' => [
            'type' => 'VARCHAR',
            'constraint' => 20,
        ],
        'status' => [
            'type' => 'TINYINT',
            'constraint' => 1,
            'default' => 0, // 0=active,1=inactive,2=banned
        ],
        'created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP',
        'updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
    ]);

    $this->forge->addKey('id', true);
    $this->forge->createTable('members');
}
    public function down()
    {
        $this->forge->dropTable('members');
    }
}
