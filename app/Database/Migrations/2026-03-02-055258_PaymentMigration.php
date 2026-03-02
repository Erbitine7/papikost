<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class PaymentMigration extends Migration
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
        'billing_session_id' => [
            'type' => 'INT',
            'constraint' => 11,
            'unsigned' => true,
        ],
        'payment_method' => [
            'type' => 'TINYINT',
            'constraint' => 1,
            // 0=cash,1=transfer,2=ewallet
        ],
        'amount_paid' => [
            'type' => 'INT',
            'constraint' => 10,
        ],
        'operator_id' => [
            'type' => 'INT',
            'constraint' => 11,
            'unsigned' => true,
        ],
        'created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP',
    ]);

    $this->forge->addKey('id', true);
    $this->forge->addKey('billing_session_id');
    $this->forge->addKey('operator_id');

    // Foreign keys
    $this->forge->addForeignKey(
        'billing_session_id',
        'billing_sessions',
        'id',
        'CASCADE',
        'CASCADE'
    );

    $this->forge->addForeignKey(
        'operator_id',
        'operators',
        'id'
    );

    $this->forge->createTable('payments');
}
 public function down()
{
    $this->forge->dropTable('payments');
}
}