<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class OperatorMigration extends Migration
{
   public function up()
{
    $this->forge->addField([
        'id' => [
            'type' => 'INT',
            'constraint' => 11,
            'auto_increment' => true,
        ],
        'username' => [
            'type' => 'VARCHAR',
            'constraint' => 50,
            'unique' => true,
        ],
        'password' => [
            'type' => 'VARCHAR',
            'constraint' => 255,
        ],
        'full_name' => [
            'type' => 'VARCHAR',
            'constraint' => 100,
        ],
        'email' => [
            'type' => 'VARCHAR',
            'constraint' => 100,
            'null' => true,
        ],
        'role' => [
            'type' => 'TINYINT',
            'constraint' => 1,
            'default' => 1, // 0=admin,1=operator
        ],
        'status' => [
            'type' => 'TINYINT',
            'constraint' => 1,
            'default' => 0, // 0=active,1=inactive
        ],
        'created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP',
    ]);

    $this->forge->addKey('id', true);
    $this->forge->createTable('operators');
}
    public function down()
    {
        $this->forge->dropTable('operators');
    }
}
