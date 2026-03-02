<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ComputerModel;

class ComputerController extends BaseController
{
    protected $computerModel;

    public function __construct()
    {
        $this->computerModel = new ComputerModel();
    }

    // Display all computers
    public function index()
    {
        $data['computers'] = $this->computerModel->findAll();

        return view('computers/index', $data);
    }

    // Show detail of a single computer
    public function show($id)
    {
        $computer = $this->computerModel->find($id);

        if (!$computer) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Computer not found');
        }

        $data['computer'] = $computer;

        return view('computers/show', $data);
    }
}


$last = $this->computerModel->orderBy('id', 'DESC')->first();

$nextNumber = $last ? $last['id'] + 1 : 1;

$pcCode = 'pc_' . str_pad($nextNumber, 2, '0', STR_PAD_LEFT);

$this->computerModel->insert([
    'pc_code' => $pcCode,
    'pc_category' => $this->request->getPost('pc_category'),
    'tariff' => $this->request->getPost('tariff'),
    'status' => 0
]);
