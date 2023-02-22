<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\cnnxn_Accounting;
use App\Models\cnnxn_quotation_detail;
use App\Models\cnnxn_expense;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");

        $fecha = $meses[date('n')-1];
        $month = date("m");
        $year = date('Y');
        $total_query = cnnxn_Accounting::whereMonth('created_at',$month)->sum('amount');
        $profit_query = cnnxn_Accounting::whereMonth('created_at',$month)->sum('profit');
        $quantity = cnnxn_quotation_detail::whereMonth('created_at',$month)->sum('quantity');
        $spent_query = cnnxn_expense::whereMonth('created_at',$month)->sum('amount');

        $total  = number_format($total_query,2);
        $profit = number_format($profit_query,2);
        $spent  = number_format($spent_query,2);
        $net = number_format($profit_query - $spent_query,2);
        

        return view('home')
            ->with('sales',$total)
            ->with('profit',$profit)
            ->with('sold',$quantity)
            ->with('month',$fecha)
            ->with('spent',$spent)
            ->with('net',$net)
            ->with('year',$year);
    }
}
