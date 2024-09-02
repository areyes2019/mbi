<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\ClientesModel;
use App\Models\KardexModel;
class Kardex extends BaseController
{
    public function index($id)
    {
        $caracteres_permitidos = '123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $longitud = 5;
        //vamos a abrir un reporte con numero de cliente y slug
        $nuevo = new KardexModel();
        $slug = substr(str_shuffle($caracteres_permitidos), 0, $longitud);
        $data=[
            'slug'=> $slug,
            'id_cliente'=> $id,
        ];
        $nuevo->insert($data);
        //ahora vamos a mostrar el cliente en la vista
        $cliente = new ClientesModel();
        $cliente->where('id_cliente',$id);
        $resultado = $cliente->findAll();

        //finalmente mostramos el id del kardex
        $nuevo->where('slug',$slug);
        $datos = $nuevo->findAll();

        $data = [
            'cliente'=>$resultado,
            'id_kardex'=>$datos,
        ];
        return view('kardex',$data);
    }
    public function kardex_reporte()
    {
        return view('kardex_reporte');
    }
}
