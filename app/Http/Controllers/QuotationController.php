<?php

namespace App\Http\Controllers;

use App\Models\cnnxn_quotation;
use App\Models\cnnxn_Article;
use App\Models\Contact;
use App\Models\cnnxn_quotation_detail;
use App\Models\cnnxn_Accounting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use PDF;
class QuotationController extends Controller
{
  public function index()
  {
  	return view('quotations.index');
  }
  public function show()
  {
    $posts = cnnxn_quotation::join('cnnxn_contacts', 'cnnxn_contacts.idContact', '=', 'cnnxn_quotations.idCustomer')->get();
    return $posts;
  } 
  public function store(Request $request)
   {

      if ($request->invoice==true) {
        //con iva
        $tax = 1;
        $query = new cnnxn_quotation;
        $query->slug = $request->slug;
        $query->idCustomer = $request->idCustomer;
        $query->with_tax = $tax;
        $query->save();
        if ($query) {
           return true;
        }
      }else{
        //sin iva
        $tax = 0;
        $query = new cnnxn_quotation;
        $query->slug = $request->slug;
        $query->idCustomer = $request->idCustomer;
        $query->with_tax = $tax;
        $query->save(); 
        if ($query) {
           return true;
        }
      }
     
   }
   
    public function page($id){
       
        //aqui enviamos los datos de la cotizacion
        $query = cnnxn_quotation::where('slug',$id)->get();
        foreach ($query as $data) {
            $id = $data->idQt;
            $slug = $data->slug;
            $customer = $data->idCustomer;
        }
            return view('quotations.page')
                    ->with('id', $id)
                    ->with('slug',$slug)
                    ->with('customer',$customer);

    }

    public function show_articles()
    {
        $query = cnnxn_Article::all();
        return $query;
       
    }

    public function show_quotation($id)
    {
        $query = cnnxn_quotation::where('slug',$id)->get();
        return $query;
    }
    public function show_customer($id)
    {
      $query = Contact::where('type',1)->where('idContact',$id)->get();
      return $query;
    }
    public function change_status(Request $request, $id)
    {
       $query = cnnxn_quotation::where('slug',$id)->update([
          'status'=>$request->status
       ]);
       if ($query) {
         return true;
       }
    }
    public function add_line(Request $request)
    {
      

        //vemos si hay iva o no 
        $query_tax = cnnxn_quotation::where('idQt',$request->idQt)->get();
        $has_tax = $query_tax[0]->with_tax;

        //luego vemos si ya esta agregado
        $unique = cnnxn_quotation_detail::where('article',$request->article)
          ->where('idQuotation',$request->idQt)
          ->count();
        if ($unique > 0) {
          return 1;
        }else{
          if ($has_tax == 1) {
            //con iva

            $query = cnnxn_Article::where('idArticle',$request->article)->get(); //sacamos el artículo
            $price = $query[0]->price;
            $with_tax = $price / 1.16;
            $add = new cnnxn_quotation_detail;
            $add->quantity = $request->quantity;
            $add->cost = $query[0]->cost;
            $add->rubber = $query[0]->rubber;
            $add->total_cost = $query[0]->cost * $request->quantity;
            $add->total_rubber = $query[0]->rubber * $request->quantity;
            $add->article = $request->article;
            $add->unit_price = $with_tax;
            $add->total = $with_tax * $request->quantity;
            $add->idQuotation = $request->idQt;
            $add->save();
            
            //actualizamos la tabla de cotización

            $sub_total = cnnxn_quotation_detail::where('idQuotation',$request->idQt)->sum('total'); //sacamos el sub-total
            $tax = $sub_total * 0.16; //sacamos el iva;
            $total = $tax + $sub_total;
    
            cnnxn_quotation::where('idQt',$request->idQt)->update([
                'amount'=>$sub_total,
            ]);

          }else{
            //sin iva
            $query = cnnxn_Article::where('idArticle',$request->article)->get();
            $price = $query[0]->price;
            $add = new cnnxn_quotation_detail;
            $add->quantity = $request->quantity;
            $add->cost = $query[0]->cost;
            $add->rubber = $query[0]->rubber;
            $add->total_cost = $query[0]->cost * $request->quantity;
            $add->total_rubber = $query[0]->rubber * $request->quantity;
            $add->article = $request->article;
            $add->unit_price = $price;
            $add->total = $price * $request->quantity;
            $add->idQuotation = $request->idQt;
            $add->save();
            $query_sum = cnnxn_quotation_detail::where('idQuotation',$request->idQt)->sum('total'); //sacamos el sub-total

            //actualizamos la tabla de cotización

            $total = cnnxn_quotation_detail::where('idQuotation',$request->idQt)->sum('total'); //sacamos el sub-total
            $tax = 0;

            $query = cnnxn_quotation::where('idQt',$request->idQt)->update([
                'amount'=>$total,
            ]);

          }


        }
     


    }
    public function show_lines($id)
    {
        $data = cnnxn_quotation_detail::where('idQuotation',$id)->join('cnnxn_articles','cnnxn_articles.idArticle','=','cnnxn_quotation_details.article')->get();

        return $data;
    }

    public function show_totals($id)
    {      
      $query = cnnxn_quotation::where('idQt',$id)->get();
      //sacamos el tota 
      $amount = $query[0]->amount;
      //sacamos el descuento
      $discount = $amount /100 * $query[0]->discount;
      //aplicamos el descuento
      $new_price = $amount - $discount;

      //verificamos si hay iva
      if ($query[0]->with_tax == 1) {
        //aplicamos el iva
        $tax = $new_price /100 * 16;
        $with_tax = $new_price + $tax;
        $advance = $with_tax / 2;
      }else{
        $tax = 0;
        $with_tax = $new_price;
        $advance = $with_tax / 2;
      }
      $balance = $with_tax - $query[0]->payment;
      $data = [
        'amount'=>    number_format($amount,2),
        'percent'=>   number_format($query[0]->discount,2),
        'discount'=>  number_format($discount,2), 
        'tax'=>       number_format($tax,2),
        'payment'=>   number_format($query[0]->payment,2),
        'balance'=>   number_format($balance,2),
        'total'=>     number_format($with_tax,2),
        'advance' =>  number_format($advance,2)
      ];

      return $data;

    }
    public function add_quantity(Request $request, $line)
    {
      $unit_price_query = cnnxn_quotation_detail::where('id',$line)->get();
      $unit_price = $unit_price_query[0]->unit_price;
      $new_price = $unit_price * $request ->quantity;

      $article = cnnxn_Article::where('idArticle',$unit_price_query[0]->article)->get();
      
      $query = cnnxn_quotation_detail::where('id',$line)->update([
        'quantity'=>$request->quantity,
        'total'=>$new_price,
        'total_cost'=> $article[0]->cost * $request->quantity,
        'total_rubber'=> $article[0]->rubber * $request->quantity
      ]);

      //hay que sacar el total

      $total = cnnxn_quotation_detail::where('idQuotation',$request->id)->sum('total');

      cnnxn_quotation::where('idQt',$request->id)->update([
          'amount'=>$total,
      ]);
      


    }
    public function delete_line(Request $request)
    {
      
      //borramos la linea
      $query = cnnxn_quotation_detail::where('id',$request->id_line)->delete();      

      //sacamos el total nuevamente
      $total = cnnxn_quotation_detail::where('idQuotation',$request->id_qt)->sum('total');

      if ($total >0) {
      
      //actualizamos todos los campos
      $update_total = cnnxn_quotation::where('idQt', $request->id_qt)->update([
        'amount'=>$total,
      ]);
      
      }else if ($total==0) {
          $update_total = cnnxn_quotation::where('idQt', $request->id_qt)->update([
          'amount'=> 0,
          'discount'=>0
        ]);
      }

    }
    public function tax_free(Request $request)
    {
      
      $id = $request->id;
      $tax = $request->tax;
      $query = cnnxn_quotation::where('idQt',$id)->update([
        'with_tax'=> $request->tax,
      ]);

      if ($tax == 0) {
        $query_price = cnnxn_quotation_detail::where('idQuotation',$id)->get();
        foreach ($query_price as $key) {
            $price = cnnxn_Article::where('idArticle',$key->article)->get();
            $number = cnnxn_Article::where('idArticle',$key->article)->count();
            
            foreach ($price as $key_price) {
              for ($i=0; $i <$number ; $i++) { 
                cnnxn_quotation_detail::where('id',$id[$i])->update([
                  'unit_price'=> $key_price->price[$i]
                ]);
              }
            }
        }
      }else{
        
      }
    

    }
    public function add_discount(Request $request)
    {
      $query = cnnxn_quotation::where('slug',$request->slug)->get();
      $count = $query[0]->amount;
      if ($count == 0) {
          return 0;
      }else{

        $query = cnnxn_quotation::where('slug',$request->slug)->update([
            //aqui actualizamos el porcentaje de descuento
            'discount'=> $request->discount
        ]);
        return 1;
      }  
      

    }
    public function delete_discount(Request $request)
    {
      
      $delete = cnnxn_quotation::where('slug', $request->slug)->update([
          'discount'=>0
      ]);

      
    }
    public function get_pdf($id, $id_qt,$try)
    {
        //este es el cliente
        $customer =  $id;
        //estos son los datos de la cotización
        $quotation = $id_qt;

        //aqui obtenemos todos los datos del cliente
        $customer_query     = Contact::where('idContact',$customer)->get();
        
        //aqui todos los datos de la cotización
        $quotation_query    = cnnxn_quotation::where('idQt', $quotation)->get();          
        //aqui los detalles de la cotización
        $detail_query = cnnxn_quotation_detail::where('idQuotation',$quotation)
                        ->join('cnnxn_articles','cnnxn_articles.idArticle','=','cnnxn_quotation_details.article')
                        ->get();
        
        
        //este es el gran total
        $quotation_total = cnnxn_quotation_detail::where('idQuotation', $quotation)->sum('total');
        
        //aplicamos el descuento

        $discount = $quotation_total /100 * $quotation_query[0]->discount;
        
        $with_discount = $quotation_total - $discount;

        //aplicamos el iva
        if ($quotation_query[0]->with_tax==1) {
          $tax = $with_discount /100 * 16;
        }else{
          $tax = 0;
        }
        //mostramos el total
        $total = $with_discount + $tax;

        
        
        $data = [

            'sub_total'     =>number_format($quotation_total,2), //aparece en el resumen
            'discount'      =>number_format($discount,2), //descuento en dinero
            'percent'       =>number_format($quotation_query[0]->discount,0), //cantidad en porcentaje
            'tax'           =>number_format($tax,2),  //impustesto
            'total'         =>number_format($total,2), // gran total
        ];
        
        $mega_pack=[
            'quotation' => $quotation_query,
            'customer'  => $customer_query,
            'detail'    => $detail_query,
            'totals'    => $data
        ];
        
        //return view('quotations.pdf')->with($mega_pack);

        $file_name = str_replace(' ','_',$customer_query[0]->company_name);
        $pdf = PDF::loadView('quotations.pdf',$mega_pack);
        if ($try == "down") {
            return $pdf->download('QT-'.$id_qt.'-'.$file_name.'.pdf');
        }elseif ($try = "send") {
            $file=$pdf->output();
            $file_id = 'QT-'.$id_qt.'-'.$file_name.'.pdf';
            $mailable = new SendQuotation($file, $file_id);
            Mail::to($customer_query[0]->email)->send($mailable);
        }
        
    }
    public function destroy($id)
    {
      //eliminamos los detalles
      $details = cnnxn_quotation_detail::where('idQuotation',$id)->delete(); 

      // luego eliminamos la cotizacion
      $quotation = cnnxn_quotation::where('idQt',$id)->delete();

      return 1;
      
    }
    public function add_payment(Request $request)
    {
        //traemos el total
        $total_query = cnnxn_quotation::where('slug',$request->slug)->get();
        $total = $total_query[0]->amount;
        if ($request->payment > $total) {
          return 0;
        }else{
          $query = cnnxn_quotation::where('slug',$request->slug)->update([
            'payment'=> $request->payment,
            'status' => 2
          ]);
          return 1;
        }

    }
    public function total_payment(Request $request)
    {

        $coma = ",";
        $amount =  str_replace($coma,"", $request->amount);
        //registrar el momnto total en cotizacion
        $query = cnnxn_quotation::where('idQt',$request->id)->update([
            'payment'=>$amount,
            'status'=> 3
        ]);

        //Extraemos el monto total

        //Estraemo el gasto de produccion
        $cost = cnnxn_quotation_detail::where('idQuotation',$request->id)->sum('total_cost');
        $rubber = cnnxn_quotation_detail::where('idQuotation',$request->id)->sum('total_rubber');
        
        if ($request->type==1) {
          // si se fabrico local
          $percent = $cost / 100 * 10;
          $big_total = $cost + $percent;
        }elseif($request->type==2){
          //si se fabricó foraneo
          $big_total = $cost + $rubber;
        }elseif ($request->type==3) {
          // si solo se vendio la maquina
          $big_total = $cost;
        }
        //Sacamos la utilidad
        $profit =  $amount - $big_total;

        //vamos a registrar en contabilidad
        $insert = new cnnxn_Accounting;

        $insert->quotation        = $request->id;
        $insert->amount           = $amount;
        $insert->production_cost  = $big_total;
        $insert->profit           = $profit;
        $insert->save();


    }

}
