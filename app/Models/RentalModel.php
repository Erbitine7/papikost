<?php

namespace App\Models;

use CodeIgniter\Model;

class RentalModel extends Model
{
    protected $table            = 'rental';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;




    // Timestamps
    protected $useTimestamps = false;

    // Validation
    protected $validationRules = [
        'room_id'    => 'required|integer',
        'boarder_id' => 'required|integer',
        'status'     => 'required|in_list[active,ended,pending]',
        'start_date' => 'required|valid_date',
    ];

    // ----- Custom Methods -----

    // Ambil semua rental beserta data boarder dan room
    public function getRentalWithDetails()
    {
        return $this->db->table('rental')
            ->select('rental.*, boarder.name as boarder_name, boarder.phone, room.room_num, room.price')
            ->join('boarder', 'boarder.id = rental.boarder_id')
            ->join('room', 'room.id = rental.room_id')
            ->get()
            ->getResultArray();
    }

    // Ambil rental by ID beserta detail
    public function getRentalById($id)
    {
        return $this->db->table('rental')
            ->select('rental.*, boarder.name as boarder_name, boarder.phone, room.room_num, room.price')
            ->join('boarder', 'boarder.id = rental.boarder_id')
            ->join('room', 'room.id = rental.room_id')
            ->where('rental.id', $id)
            ->get()
            ->getRowArray();
    }

    // Ambil rental yang sedang aktif
    public function getActiveRentals()
    {
        return $this->where('status', 'active')->findAll();
    }
}