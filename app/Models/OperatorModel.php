<?php

namespace App\Models;

use CodeIgniter\Model;

class OperatorModel extends Model
{
    protected $table            = 'operators';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $protectFields    = true;

    protected $allowedFields = [
        'username',
        'password',
        'full_name',
        'email',
        'role',
        'status'
    ];

    protected $useTimestamps = true;
}
