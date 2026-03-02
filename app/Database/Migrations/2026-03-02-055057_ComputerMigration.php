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
            'auto_increment' => true,
        ],
        'pc_category' => [
            'type' => 'VARCHAR',
            'constraint' => 50,
        ],
        'spec' => [
            'type' => 'TEXT',
            'null' => true,
        ],
        'tariff' => [
            'type' => 'INT',
            'constraint' => 10,
            'default' => 5000,
        ],
        'status' => [
            'type' => 'TINYINT',
            'constraint' => 1,
            'default' => 0, 
            // 0=available,1=in_use,2=maintenance
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
