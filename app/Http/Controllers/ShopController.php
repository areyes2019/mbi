<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\cnnxn_categorie;
use App\Http\Requests\CategoriesRequest;

class ShopController extends Controller
{
    public function categories()
    {
        return view('categories.index');
    }

    public function get_categories()
    {
        //papas 
        $parents = cnnxn_categorie::where('main',0)->get();
        $child = cnnxn_categorie::where('main','!=',0)->get();
        return $result = [$parents,$child];
    }
    public function add_categorie(Request $request)
    {
        $url = str_replace(" ", "_", $request->name);
        $to_lower = strtolower($url);
        //$request->slug = $to_lower;
        if ($request->main > 0) {
            //buscamos si la categoria ya es padre
            $parent = cnnxn_categorie::where('idCategorie',$request->main)->get();
            $result = $parent[0]->is_parent;
            if ($result==0) {
                cnnxn_categorie::where('idCategorie',$request->main)->update([
                    'is_parent'=>'1',
                ]);
            }
        }
        $data=[
            'name'=> $request->name,
            'main'=> $request->main,
            'slug'=> $to_lower,
        ];

        $validated = Validator::make($data,[
            'name'=>[
                'required',
                'unique:cnnxn_categories,name',
            ],
            'main'=>'required',
            'slug'=>'required',
        ],[
            'name.unique' => 'Este nombre ya esta registrado',
            'name.required'=>'El nombre de la categoria es requerido',
            'main.required'=>'El nombre de la sub-categoria es requerido',
        ])->validate();
        $query = cnnxn_categorie::create($validated);

    }
    public function delete_categorie($id)
    {
        $query = cnnxn_categorie::where('idCategorie',$id)->delete();
        $child_delete = cnnxn_categorie::where('main',$id)->delete();
        return true;
        
    }
    public function update_categorie(Request $request,$id)
    {

        $validated = $request->validate([
            'name'=>'unique:cnnxn_categories,name',
            'slug'=>'required'
        ],[
            'name.unique'=>'Este nombre ya esta asignado',
            'slug.required'=>'El campo es requerido'
        ]);

        $query = cnnxn_categorie::where('idCategorie',$id)->update($validated);
        if ($query) {
            return true;
        }
    }
    public function update_child(Request $request, $id)
    {
        if ($request->main == 0) {
            $validated = $request->validate([
                'name'=>'unique:cnnxn_categories,name',
                'slug'=>'required',
                'is_parent'=>'required'
            ],[
                'name.unique'=>'Este nombre ya esta asignado',
                'slug.required'=>'El campo es requerido',
                'is_parent.required'=>'El campo es requerido'
            ]);
        }else{

            $validated = $request->validate([
                'name'=>'required',
                'slug'=>'required',
                'main'=>'required',
                'is_parent'=>'required'
            ],[
                'name.required'=>'El nombre es requerido',
                'slug.required'=>'El campo es requerido',
                'main.required'=>'El campo es requerido',
                'is_parent.required'=>'El campo es requerido'
            ]);
        }
        

        $query = cnnxn_categorie::where('idCategorie',$id)->update($validated);
        if ($query) {
            return true;
        }
    }
    public function categories_list()
    {
        $qr_child = cnnxn_categorie::where('main','!=',0)->get();
        
        /*foreach ($qr_child as $data) {
            $id = $data->main;
            $qr_parents = cnnxn_categorie::where('idCategorie',$id)->get();
            $qr[]=$qr_parents;
        };*/

        foreach ($qr_child as $key ) {
            $id_child = $key->main;
            $qr_single = cnnxn_categorie::where('main',0)->get();
            $sng[]=$qr_single;
        }

        /*$data=[
            'single' => $qr_single,
            'parents'=> $qr_parents
        ];*/

        return $sng;
    }
    public function is_parent()
    {
        $single = cnnxn_categorie::where('is_parent',0)
                ->where('main',0)
                ->get();
        $is_parent = cnnxn_categorie::where('is_parent',1)->get();
        $is_child = cnnxn_categorie::where('main','!=',0)->get();
        $data = [
            'single'=>$single,
            'parent'=>$is_parent,
            'child'=>$is_child
        ];
        return $data;
    }
}
