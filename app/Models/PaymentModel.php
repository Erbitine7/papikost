<?php

namespace App\Models;

use CodeIgniter\Model;

class PaymentModel extends Model
{
    protected $table            = 'payment';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $useSoftDeletes   = false;

    // Timestamps
    protected $useTimestamps = false;

    // Validation
    protected $validationRules = [
        'rental_id' => 'required|integer',
        'months'    => 'required|integer',
        'amount'    => 'required|numeric',
        'date'      => 'required|valid_date',
        'status'    => 'required|in_list[pending,paid,late]',
    ];

    // ----- Custom Methods -----

    // Ambil semua payment beserta detail rental, boarder, dan room
    public function getPaymentWithDetails()
    {
        return $this->db->table('payment')
            ->select('payment.*, rental.start_date, rental.status as rental_status, boarder.name as boarder_name, room.room_num')
            ->join('rental', 'rental.id = payment.rental_id')
            ->join('boarder', 'boarder.id = rental.boarder_id')
            ->join('room', 'room.id = rental.room_id')
            ->get()
            ->getResultArray();
    }

    // Ambil payment berdasarkan rental_id
    public function getPaymentByRental($rentalId)
    {
        return $this->where('rental_id', $rentalId)->findAll();
    }

    // Ambil payment berdasarkan status
    public function getPaymentByStatus($status)
    {
        return $this->where('status', $status)->findAll();
    }

    // Hitung total amount yang sudah dibayar per rental
    public function getTotalPaidByRental($rentalId)
    {
        return $this->db->table('payment')
            ->selectSum('amount')
            ->where('rental_id', $rentalId)
            ->where('status', 'paid')
            ->get()
            ->getRowArray();
    }
}