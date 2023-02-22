<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\cnnxn_Article;
use App\Models\cnnxn_Cataloge;
use App\Models\Contact;
use App\Models\cnnxn_Family;
use App\Models\cnnxn_config;
use App\Http\Requests\ArticleRequest;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ArticlesImport;
class ArticlesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $query = cnnxn_config::all();
        $percent=  $query[0]->percent;
        return view('articles.index')->with('percent',$percent);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        if ($request->visible==true) {
            $visible = 1;
        }else{
            $visible = 0;
        }

        if ($request->stock==true) {
            $stock = 1;
        }else{
            $stock = 0;
        }
        
        $data = [
            'name'=> $request->name,
            'model'=> $request->model,
            'lines'=> $request->lines,
            'size'=> $request->size,
            'stock'=> $stock,
            'visible'=> $visible,
            'cost'=> $request->cost,
            'dealer'=> $request->dealer,
            'price'=> $request->price,
            'discount'=> $request->discount,
            'provider'=> $request->provider,
            're_order'=> $request->re_order,
            'family'=> $request->family,
            'short_desc'=> $request->short,
            'long_desc'=> $request->long,
            'categorie'=> $request->categorie,
            'cataloge'=> $request->cataloge,
        ];


        $validated = Validator::make($data,[
            'name'=>'required', 
            'model'=> '',
            'lines'=> '',
            'size'=> 'max:12',
            'stock'=>'',
            'visible'=> '',
            'cost'=> 'required|numeric|regex:/^[\d]{0,11}(\.[\d]{1,2})?$/',
            'dealer'=> '',
            'price'=>'numeric|regex:/^[\d]{0,11}(\.[\d]{1,2})?$/',
            'provider'=> 'required',
            'family'=>'required',
            'short_desc'=>'' ,
            'long_desc'=> '',
            'categorie'=>'',
            'cataloge'=>'required',
        ],[
            'name.required'     =>'Se requiere un nombre de artículo',
            'size.max'          =>'Máximo 2 caractéres',
            'shtock.numeric'    =>'Solo se aceptan numeros',
            'cost.required'     =>'Se requiere agregar un costo',
            'cost.numeric'      =>'Solo números',
            'dealer.numeric'    =>'Solo numeros',
            'provider.required' =>'Es necesario agregar un proveedor',
            'family.required'   =>'Es necesario agregar una familia',
            'cataloge.required' =>'Se requiere un catálogo'
        ])->validate();

        $query = cnnxn_Article::create($validated);
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function excel(Request $request)
    {
        $file=$request->file;   
        $query = Excel::import(new ArticlesImport, $file);
        if ($query) {
            return true;
        }
    }
    public function show($id)
    {
        $query = cnnxn_Article::where('idArticle',$id)->get();
        return $query;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        //el valor original de la goma

        $rubber_query = cnnxn_Article::where('idArticle',$id)->get();
        $ruber_cost = $rubber_query[0]->rubber;

        if ($ruber_cost == $request->rubber) {
           $query = cnnxn_Article::where('idArticle',$id)->update([
            'name'      => $request->name,
            'model'     => $request->model,
            'lines'     => $request->lines,
            'size'      => $request->size,
            'stock'     => $request->stock,
            'cost'      => $request->cost,
            'rubber'    => $request->rubber,
            'dealer'    => $request->dealer,
            'price'     => $request->price,
            'discount'  => $request->discount,
            'provider'  => $request->provider,
            're_order'  => $request->re_order,
            'visible'   => $request->visible,
            'family'    => $request->family,
            'short_desc'=> $request->short_desc,
            'long_desc' => $request->short_desc,
            'img_url'   => $request->img_url,
            'categorie' => $request->categorie,
            'cataloge'  => $request->cataloge,

            ]); 
        }else{

            $query_benefit = cnnxn_config::all();
            $percent = $query_benefit[0]->percent; //margen de utlidad en dinero

            $mechanic = $request->cost; //costo del mecanismo
            $rubber = $request->rubber; //cosoto de la goma
            $total = $mechanic + $rubber; //sumamos mecanismo mas goma
            $profit = $total + $percent; // sumamos el beneficio
            $price = round($profit);
            
            $query = cnnxn_Article::where('idArticle',$id)->update([
                'name'      => $request->name,
                'model'     => $request->model,
                'lines'     => $request->lines,
                'size'      => $request->size,
                'stock'     => $request->stock,
                'cost'      => $request->cost,
                'rubber'    => $request->rubber,
                'dealer'    => $request->dealer,
                'price'     => $price,
                'discount'  => $request->discount,
                'provider'  => $request->provider,
                're_order'  => $request->re_order,
                'visible'   => $request->visible,
                'family'    => $request->family,
                'short_desc'=> $request->short_desc,
                'long_desc' => $request->short_desc,
                'img_url'   => $request->img_url,
                'categorie' => $request->categorie,
                'cataloge'  => $request->cataloge,

            ]);
        }

        
        if ($query) {
            return true;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $query = cnnxn_Article::where('idArticle',$id)->delete();
        return $query;
    }
    public function cataloges()
    {
        return view('articles.cataloges');
    }
    public function add_cataloge(Request $request)
    {

        /*$validated = $request->validate([
            'cataloge_name'=>'required',
            'discount'=>'numeric',
            'idProvider'=>'required',
        ],[
            'cataloge_name.required' => 'El nombre del catalogo  es obligatorio',
            'discount.numeric' => 'El descuento solo debe llevar valores numéricos',
            'supplier.required' => 'Es obligatorio agregar un proveedor',
        ]
        );*/

        $query = cnnxn_Cataloge::create($request->all());
        if ($query) {
            return true;
        }

    }
    public function show_cataloges()
    {
        $query = Contact::join('cnnxn_cataloges','cnnxn_cataloges.idProvider', "=", 'cnnxn_contacts.idContact')->get();
        /*$query = cnnxn_Cataloge::join('cnnxn_contacts', 'cnnxn_cataloges.idProvider','=','cnnxn_contacts.idContact')->get();*/
        return $query;
    }
    public function delete_cataloge($id)
    {
        //elimina los articulos de catalogo
        $delete_items = cnnxn_Article::where('cataloge',$id)->count();
        if ($delete_items>0) {
            $delete_articles = cnnxn_Article::where('cataloge',$id)->delete();
            $delete_cataloge = cnnxn_Cataloge::where('idCataloge',$id)->delete();
        }else{
            $delete_only_cataloge = cnnxn_Cataloge::where('idCataloge',$id)->delete();
        }

        return true;

        //elimina los datos del catalogo
    }
    public function add_family(Request $request)
    {
        $validated = $request->validate([
            'family_name'=>'required'
        ],[
            'family_name.required'=>'El campo Nombre no puede ir vacío',
        ]);
        cnnxn_Family::create($validated);
        return true;
    }
    public function get_family()
    {
        $query = cnnxn_Family::all();
        return $query;
    }

    public function list()
    {
        $query = cnnxn_Article::join('cnnxn_family','cnnxn_family.idFamily','=','cnnxn_articles.family')->get();
        return $query;
    }
    public function get_cataloge($id)
    {
        $query = cnnxn_Cataloge::where('idProvider',$id)->get();
        return $query;
    }
    public function sum_value()
    {
        $value = 10;
        cnnxn_Article::query()->increment('price', $value);

    }
    public function img(Request $request)
    {

        //obtenemos la imagen 
        /*$request()->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);*/

        if ($files = $request->file('image')) {
            

            $name = $files->getClientOriginalName();
            $files->storeAs('public/cataloge',$name);

            $insert = cnnxn_Article::where('idArticle',$request->id_article)->update([
                'img_url'=> $name
            ]);


            if ($insert) {
                return true;
            }
        }

    }

    

}
