<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\cnnxn_config;
use App\Models\cnnxn_Article;

class ConfigController extends Controller
{
    public function index()
    {
        $query = cnnxn_config::all();
        return view('config.index',compact('query'));
    }
    public function main_img(Request $request)
    {
         if ($files = $request->file('hook')) {
            
            $name = $files->getClientOriginalName();
            $files->storeAs('public/multiporpouse',$name);

            if ($request->id == 1) {
                $insert = cnnxn_config::where('id',1)->update([
                    'img01'=> $name
                ]);
            }elseif($request->id ==2){
                $insert = cnnxn_config::where('id',1)->update([
                    'img02'=> $name
                ]);
            }elseif ($request->id ==3) {
                $insert = cnnxn_config::where('id',1)->update([
                    'img03'=> $name
                ]);
            }


            if ($insert) {
                return redirect('config');   
            }
        }
    }
    public function profit(Request $request)
    {
        $insert = cnnxn_config::where('id',1)->update([
                'percent'=> $request->profit
        ]);
        if ($insert) {
            return redirect('config');
        }
    }
    public function profit_global(Request $request)
    {
        $increment = cnnxn_Article::whereNotNull('price')->increment('price',$request->increment);
        $current_profit = cnnxn_config::where('id',1)->get();
        $change = $current_profit[0]->percent + $request->increment; 
        $query = cnnxn_config::where('id',1)->update(['percent'=> $change]);
        return redirect('config');
    }

}
