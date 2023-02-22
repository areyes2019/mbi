<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\cnnxn_categorie;
use App\Models\cnnxn_Article;
use App\Http\Requests\CategoriesRequest;
use App\Models\cnnxn_config;
class StoreController extends Controller
{
    public function shop()
    {
        //mostramos categorias single
        $single = cnnxn_categorie::where('main',0)->where('is_parent',0)->get();
        $parent = cnnxn_categorie::where('is_parent',1)->get();
        $config = cnnxn_config::all();
        return view('shop',['single'=>$single,'parent'=>$parent, 'hooks'=>$config]);
    }

    public function shop_item($id, $data)
    {
        $article = cnnxn_Article::where('idArticle',$id)->get();
        $article_name = $article[0]->name;
        $categories = cnnxn_categorie::where('idCategorie',$data)->get();
        $categorie_name = $categories[0]->name;
        $slug = $categories[0]->slug;

        return view('store.article',[
            'article_name'=>$article_name,
            'article'=>$article,
            'categorie_name'=>$categorie_name,
            'slug'=>$slug
        ]);
    }

    public function categories($slug)
    {

        //econtramos el id
        $query = cnnxn_categorie::where('slug',$slug)->get();
        $id = $query[0]->idCategorie;
        $title = $query[0]->name;
        //sacamos los artículos
        $items = cnnxn_Article::where('categorie',$id)->paginate(8);

        //sacamos las categorías
        $single = cnnxn_categorie::where('main',0)->where('is_parent',0)->get();
        $parent = cnnxn_categorie::where('is_parent',1)->get();
        return view('store.categories',[
            'title'=>$title,
            'articles'=>$items,
            'single' => $single,
            'parent' => $parent
        ]);    
    }

    public function expert()
    {
        return view('store.expert');
    }
    public function shipping()
    {
        return view ('store/shipping');
    }
    public function purchase()
    {
        return view ('store/purchase');
    }
}
