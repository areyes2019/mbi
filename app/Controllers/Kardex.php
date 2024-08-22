<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Kardex extends BaseController
{
    public function index()
    {
        return view('kardex');
    }
    public function kardex_reporte()
    {
        return view('kardex_reporte');
    }
}
