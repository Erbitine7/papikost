<?php

namespace App\Models;

use CodeIgniter\Model;

class Acccounts extends Model
{
    protected $useAutoIncrement = true;
  
    protected $useTimestamps    = false;    

    protected $table = 'accounts';
    protected $primaryKey = 'id';
    protected $allowedFields = ['username', 'email', 'name', 'password', 'role'];
}
