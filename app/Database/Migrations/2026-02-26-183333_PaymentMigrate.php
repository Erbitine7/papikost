<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class PaymentMigrate extends Migration
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
            'rental_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'months' => [
                'type'       => 'INT',
                'constraint' => 11,
            ],
            'amount' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
            ],
            'date' => [
                'type' => 'DATE',
            ],
            'status' => [
                'type'       => 'ENUM',
                'constraint' => ['pending', 'paid', 'late'],
                'default'    => 'pending',
            ],
        ]);

        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('rental_id', 'rental', 'id', 'CASCADE', 'RESTRICT');
        $this->forge->createTable('payment');
    }

    public function down()
    {
        $this->forge->dropTable('payment');
    }
}
