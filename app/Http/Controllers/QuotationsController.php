<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class QuotationsController extends Controller
{
    public function index()
    {
        return view('quotations.index');
    }
}
