<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ComputerMigration extends Migration
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
        'tariff' => [
            'type' => 'INT',
            'constraint' => 10,
            'default' => 5000,
        ],
        'spec' => [
            'type' => 'TEXT',
            'default' => 'Standard',
        ],
        'status' => [
            'type' => 'TINYINT',
            'constraint' => 1,
            'default' => 0, 
            
        ],
        'created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP',
        'updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
    ]);

    $this->forge->addKey('id', true);
    $this->forge->createTable('computers');
}
    public function down()
    {
        $this->forge->dropTable('computers');
    }
}
