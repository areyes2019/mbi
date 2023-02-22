<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CrudController extends Controller
{
    public function index()
    {
        return view('view')
    }
    public function show()
    {
        $query = model::all();
        return $query;
    }
    public function show_single($id)
    {
        $query = model::where('id',$id)
        return $query;
    }
    public function save(Request $request)
    {
        $data = [
            'field01' => $request->field01,
            'field02' => $request->field02
        ]

        $validated = Validator::make($data,[
            'field01'=>'rule'
            'field02'=>'rule'
        ],[
            'field01.rule'=> 'Bla bla bla',
            'field02.rule'=> 'Bla bla bla',
        ])->validate();

        $query = model::create($validated);
    }
    public function update(Request $request, $id)
    {
        $query = cnnxn_categorie::where('idCategorie',$id)->update([
            'field01'=> $request->field01,
            'field02'=> $request->field02,
        ]);
    }
    public function delete($id)
    {
        $query = model::where('id',$id)->delete();
        return $query;
    }
    
}
