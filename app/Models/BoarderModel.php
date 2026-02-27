<?php

namespace App\Models;

use CodeIgniter\Model;

class BoarderModel extends Model
{
       protected $useAutoIncrement = true;
   
    protected $useTimestamps    = false;

    protected $table = 'boarders';
    protected $primaryKey = 'id';
    protected $allowedFields = ['name', 'email', 'phone', 'name'];
}
