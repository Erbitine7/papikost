<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class GuestCtrl extends BaseController
{
    public function index(): string
    {
        return view('guesthome');
    }
}
