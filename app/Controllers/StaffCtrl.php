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
        $data = [
            'page'=>'Computer'
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

    public function rental(): string
    {
        $data = [
            'page'=>'Rental'
        ];
        return view('rental', $data);
    }
}
