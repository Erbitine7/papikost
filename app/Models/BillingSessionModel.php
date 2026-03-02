<?php

namespace App\Models;

use CodeIgniter\Model;

class BillingSessionModel extends Model
{
    protected $table            = 'billing_sessions';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $protectFields    = true;

    protected $allowedFields = [
        'computer_id',
        'customer_id',
        'start_time',
        'end_time',
        'total_amount',
        'status',
        'operator_id'
    ];

    protected $useTimestamps = false;
}
