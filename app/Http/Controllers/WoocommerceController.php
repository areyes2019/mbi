<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\woocommerce;
use Automattic\WooCommerce\Client;


class WoocommerceController extends Controller
{
    public function __construct(){
        $woocommerce = new Client(
          'http://worpress.test/',
          'ck_f37524e277f50a21b221ac92dabf3bf7e14b6d27',
          'cs_00a658aa2b5927b355ddf6de0f8f098d56d86f6d',
          [
            'version' => 'wc/v3',
          ]
        );
    }
    public function index()
    {
        return view('woocommerce/index');
    }
    public function get_list()
    {
        return woocommerce::all();
    }
    public function add(Request $request)
    {
        $validated = $request->validate([
            'name'=>'required',
            'url'=>'required',
            'slug'=>'required',
            'public_key'=>'required',
            'private_key'=>'required',
        ],[
            'name.required'=>"El nombre de la tienda es requerido",
            'url.required'=>"Es importante la ruta de tu tienda",
            'public_key.required'=>"Debes guardar una lave pública",
            'private_key.required'=>"Debes guardar una llave privada",
            'slug.required'=>'El formulario no se ha enviado correctamente'
        ]
        );
        
        woocommerce::create($validated);
        if ($validated) {
            return 1;
        }else{
            return 0;
        }
        

    }
    public function store($id,$slug)
    {
        $query = woocommerce::where('slug',$slug)->get();
        return view('woocommerce.woocommerce_main',compact('query'));
    }
    public function woo_articles($id)
    {
        
        return view('woocommerce.woo_articles')->with('id',$id);

    }
    public function woo_articles_list($id)
    {
        $query = woocommerce::where('idStore',$id)->get();
        $url     =  $query[0]->url;
        $public =  $query[0]->public_key;
        $private  =  $query[0]->private_key;
        
        $woocommerce = new Client(
          $url,
          $public,
          $private,
          [
            'posts_per_page'=>50,
            'wp_api' => true,
            'version' => 'wc/v3',
          ]
        );

        //desplegamos los productos

        $woo_query = $woocommerce->get('products');
        return $woo_query;
    }
    public function store_id($id)
    {
        $query = woocommerce::where('idStore',$id)->get();
        return $query[0]->name;
    }
    public function woo_article($id)
    {
        return view('woocommerce.article_view')->with('article',$id);
    }
    public function woo_get_article($id,$store)
    {
        $query = woocommerce::where('idStore',$store)->get();
        $url     =  $query[0]->url;
        $public =  $query[0]->public_key;
        $private  =  $query[0]->private_key;
        $woocommerce = new Client(
          $url,
          $public,
          $private,
          [
            
            'wp_api' => true,
            'version' => 'wc/v3',
          ]
        );
        //desplegamos los productos
        $woo_query = $woocommerce->get('products/'.$id);
        return $woo_query;
    }
}
