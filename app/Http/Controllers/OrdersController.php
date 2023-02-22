<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\cnnxn_Order;
use App\Models\Contact;
use App\Models\cnnxn_Article;
use App\Models\cnnxn_order_detail;
use PDF;
class OrdersController extends Controller
{
    public function index()
    {
        return view('orders.index');
    }
    public function orders_page($id)
    {
        
       //aqui enviamos los datos de la cotizacion
        $query = cnnxn_Order::where('slug',$id)->get();
        //buscamos el nombre 
        $supplier_name = Contact::where('idContact',$query[0]->idSupplier)->get();
        return view('orders.page')
                ->with('idOrder', $query[0]->idOrder)
                ->with('slug',$query[0]->slug)
                ->with('supplier_id',$query[0]->idSupplier)
                ->with('supplier_name',$supplier_name[0]->company);

    }
    public function add_quantity_order(Request $request)
    {
        return $request;
    }
    public function store(Request $request)
    {
        $query = new cnnxn_Order;
        $query->slug = $request->slug;
        $query->idSupplier = $request->idSupplier;
        $query->save();
        if ($query) {
            return true;
        }
    }
    public function show_articles($id)
    {
        $query = cnnxn_Article::where('provider',$id)->get();
        return $query;
    }
    public function add_line(Request $request)
    {
        
        $unique = cnnxn_order_detail::where('article',$request->article)
          ->where('idOrder',$request->id_order)
          ->count();
        if ($unique > 0) {
          return 1;
        }else{

            //sacamos el costo 
            $article_query = cnnxn_Article::where('idArticle',$request->article)->get();
            $cost = $article_query[0]->cost;

            //sacamos el total 
            $total = $cost * $request->quantity;

            $insert = new cnnxn_order_detail;
            $insert->quantity = $request->quantity;
            $insert->article = $request->article;
            $insert->unit_price = $cost;
            $insert->total = $total;
            $insert->idOrder = $request->id_order;
            $insert->save();
        }
    }
    public function show_line($id)
    {

        $data = cnnxn_order_detail::where('idOrder',$id)->join('cnnxn_articles','cnnxn_articles.idArticle','=','cnnxn_order_details.article')->get();

        return $data;
    }
    public function order_totals($id)
    {
        $query = cnnxn_order_detail::where('idOrder', $id)->sum('total');
        return $query;
    }
    public function pdf($supplier, $order)
    {

        //obernemos los datos del provedor
        $supplier_data = Contact::where('idContact',$supplier)->get();
        $supplier = trim($supplier_data[0]->company);
        //totales de la orden de compra
        $sub_total = cnnxn_order_detail::where('idOrder',$order)->sum('total');
        $tax = $sub_total /100 *16;
        $total = $sub_total + $tax;

        // detalles de la orden de compra

        $details = cnnxn_order_detail::where('idOrder',$order)->join('cnnxn_articles','cnnxn_articles.idArticle','=', 'cnnxn_order_details.article')->get();
        
        $totals_data=[
            'sub_total'=>$sub_total,
            'tax'=>number_format($tax,2),
            'total'=>number_format($total,2),
            'idOrder'=>$order
        ];

        $data = [
            'supplier'=>$supplier_data,
            'details'=>$details,
            'totals'=>$totals_data,
        ];

        //return view('orders.order_pdf',['supplier'=>$supplier_data, 'totals'=>$totals_data, 'details'=>$details]);
        //return $details;

        $pdf = PDF::loadView('orders.order_pdf',['supplier'=>$supplier_data, 'totals'=>$totals_data, 'details'=>$details]);
        return $pdf->download('QT-'.$supplier.'_'.$order.'.pdf');
    }
    public function orders_show()
    {
        $query = cnnxn_Order::join('cnnxn_contacts','cnnxn_contacts.idContact','=','cnnxn_orders.idSupplier')
            ->select(
                'cnnxn_orders.idOrder',
                'cnnxn_orders.created_at',
                'cnnxn_contacts.company',
                'cnnxn_orders.status',
                'cnnxn_orders.sub_total',
                'cnnxn_orders.link',
                'cnnxn_orders.total',
                'cnnxn_orders.slug',
            )
            ->get();
        return $query;
    }
    public function delete_order_line(Request $request)
    {
        $query = cnnxn_order_detail::where('idDetail', $request->id_line)->delete();
        if ($query) {
            return true;
        }
    }

}