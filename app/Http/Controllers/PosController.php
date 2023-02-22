<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\cnnxn_Stock;
use App\Models\cnnxn_Article;
use App\Models\cnnxn_;
use App\Models\cnnxn_customer_order;


class PosController extends Controller
{
    public function index()
    {
        return view('pos.index');
    }
    public function show()
    {
        $query = cnnxn_Article::where('re_order','>',0)->get();
        return $query;
    }
    public function add_sale($id)
    {
        return view('pos.sale')->with('slug',$id);;
    }
    public function add_slug(Request $request)
    {
        $query = new cnnxn_customer_order;

        $query->slug = $request->slug;
        $query->name = "general";
        $query->save();
    }
    public function order_data($slug)
    {
        $query = cnnxn_customer_order::where('slug',$slug)->get();
        $day = strtotime($query[0]->created_at);
        $date = date('d-m-Y',$day);
        $data = [
            'data'=>$query,
            'date' =>$date

        ];
        return $data;
    }
}
