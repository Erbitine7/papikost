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
            'auto_increment' => true,
        ],
        'billing_session_id' => [
            'type' => 'INT',
            'constraint' => 11,
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
        ],
        'created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP',
    ]);

    $this->forge->addKey('id', true);

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