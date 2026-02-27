<?php

namespace App\Models;

use CodeIgniter\Model;

class RoomModel extends Model
{
    protected $useAutoIncrement = true;
 
    protected $useTimestamps    = false;

    protected $table = 'rooms';
    protected $primaryKey = 'id';
    protected $allowedFields = ['room_num', 'price', 'facility'];
}
