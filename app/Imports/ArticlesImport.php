<?php

namespace App\Imports;
use App\Models\cnnxn_Article;
use Illuminate\Support\Collection;
//use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
//use Maatwebsite\Excel\Concerns\WithValidation;
use Illuminate\Support\Facades\Validator;

class ArticlesImport implements ToCollection, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function collection(Collection $rows)
    {
        
        Validator::make($rows->toArray(),[
            '*.name'=>'required', 
            '*.model'=> '',
            '*.lines'=> 'numeric',
            '*.size'=> 'max:12',
            '*.stock'=>'numeric',
            '*.visible'=> 'numeric',
            '*.cost'=> 'required|numeric|regex:/^[\d]{0,11}(\.[\d]{1,2})?$/',
            '*.dealer'=> '',
            '*.price'=>'numeric|regex:/^[\d]{0,11}(\.[\d]{1,2})?$/',
            '*.discount'=> '',
            '*.provider'=> 'required',
            '*.re_order'=> '',
            '*.family'=>'required',
            '*.img_url'=>'',
            '*.short_desc'=>'' ,
            '*.long_desc'=> '',
            '*.categorie'=> 'required',
            '*.cataloge'=>'required', 
            
        ])->validate();
        
        foreach ($rows as $row) {
            cnnxn_Article::create([
                'name'      =>$row['name'],
                'model'     =>$row['model'],
                'lines'     =>$row['lines'],
                'size'      =>$row['size'],
                'stock'     =>$row['stock'],
                'cost'      =>$row['cost'],
                'dealer'    =>$row['dealer'],
                'price'     =>$row['price'],
                'discount'  =>$row['discount'],
                'type'      =>$row['type'],
                'provider'  =>$row['provider'],
                're_order'  =>$row['re_order'],
                'visible'   =>$row['visible'],
                'family'    =>$row['family'],
                'img_url'    =>$row['img_url'],
                'short_desc'=>$row['short_desc'],
                'long_desc' =>$row['long_desc'],
                'categorie'=>$row['categorie'],
                'cataloge'=>$row['cataloge'],
            ]);
        };
       
    }
    
    
}
