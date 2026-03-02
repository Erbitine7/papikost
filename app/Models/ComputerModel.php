<?php

namespace App\Models;

use CodeIgniter\Model;

class ComputerModel extends Model
{
    protected $table            = 'computers';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $protectFields    = true;

    protected $allowedFields = [
        'pc_code',
        'pc_category',
        'spec',
        'tariff',
        'status'
    ];

    protected $useTimestamps = false;
}
