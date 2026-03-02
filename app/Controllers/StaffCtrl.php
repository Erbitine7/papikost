<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class StaffCtrl extends BaseController
{
    public function index(): string
    {
        $data = [
            'page'=>'Dashboard'
        ];
        return view('dashboard', $data);
    }

    public function login(): string
    {
        $data = [
            'page'=>'Login'
        ];
        return view('login', $data);
    }

    public function computer(): string
    {
        
        $computerModel = new \App\Models\ComputerModel();
        $computers    = $computerModel->findAll();

        $data = [
            'page'      => 'Computer',
            'computers' => $computers,
        ];

        return view('computer', $data);
    }

    public function addcomputer(): string
    {
        $data = [
            'page'=>'Computer'
        ];
        return view('addcomputer', $data);
    }

    public function editcomputer(): string
    {
        $data = [
            'page'=>'Computer'
        ];
        return view('editcomputer', $data);
    }

    public function detailcomputer(): string
    {
        $data = [
            'page'=>'Computer'
        ];
        return view('detailcomputer', $data);
    }

    public function rental(): string
    {
        $data = [
            'page'=>'Rental'
        ];
        return view('rental', $data);
    }

    public function addrental(): string
    {
        $data = [
            'page'=>'Rental'
        ];
        return view('addrental', $data);
    }
    public function member(): string
    {
        $data = [
            'page'=>'Member'
        ];
        return view('member', $data);
    }

    public function addmember(): string
    {
        $data = [
            'page'=>'Member'
        ];
        return view('addmember', $data);
    }

    public function editmember(): string
    {
        $data = [
            'page'=>'Member'
        ];
        return view('editmember', $data);
    }

    public function staff(): string
    {
        $data = [
            'page'=>'Staff'
        ];
        return view('staff', $data);
    }

    public function addstaff(): string
    {
        $data = [
            'page'=>'Staff'
        ];
        return view('addstaff', $data);
    }

    public function editstaff(): string
    {
        $data = [
            'page'=>'Staff'
        ];
        return view('editstaff', $data);
    }

    public function payment(): string
    {
        $data = [
            'page'=>'Payment'
        ];
        return view('payment', $data);
    }

}
