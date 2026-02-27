<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class StaffCtrl extends BaseController
{
    public function index(): string
    {
        return view('dashboard');
    }

    public function login(): string
    {
        return view('login');
    }
}
