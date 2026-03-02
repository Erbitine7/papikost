<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class BillingMigration extends Migration
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
        'computer_id' => [
            'type' => 'INT',
            'constraint' => 11,
            'unsigned' => true,
        ],
        'customer_id' => [
    'type' => 'INT',
    'constraint' => 11,
    'unsigned' => true,
    'null' => true,
],

        'start_time' => [
            'type' => 'DATETIME',
        ],
        'end_time' => [
            'type' => 'DATETIME',
            'null' => true,
        ],
        'total_amount' => [
            'type' => 'INT',
            'constraint' => 10,
            'default' => 0,
        ],
        'status' => [
            'type' => 'TINYINT',
            'constraint' => 1,
            'default' => 0,
            // 0=active,1=finished,2=cancelled
        ],
        'operator_id' => [
            'type' => 'INT',
            'constraint' => 11,
            'unsigned' => true,
        ],
    ]);

    $this->forge->addKey('id', true);
    // index foreign keys for faster lookups
    $this->forge->addKey('computer_id');
    $this->forge->addKey('customer_id');
    $this->forge->addKey('operator_id');

    // Foreign keys
    $this->forge->addForeignKey('computer_id', 'computers', 'id');
    $this->forge->addForeignKey('customer_id', 'members', 'id');
    $this->forge->addForeignKey('operator_id', 'operators', 'id');

    $this->forge->createTable('billing_sessions');
}
    public function down()
    {
        $this->forge->dropTable('billing_sessions');      
}
}