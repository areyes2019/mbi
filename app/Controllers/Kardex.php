<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\ClientesModel;
use App\Models\KardexModel;
use App\Models\KardexDetalleModel;
use App\Models\HorariosModel;
use App\Models\UsuariosModel;
class Kardex extends BaseController
{
    public function index($slug)
    {
        //datos del kardex
        $kardex = new KardexModel();
        $kardex->where('slug',$slug);
        $kardex_data = $kardex->findAll();

        $id_cliente = $kardex_data[0]['id_cliente'];
        $id_vendedor = $kardex_data[0]['id_vendedor'];
        
        //datos de cliente
        $cliente = new ClientesModel();
        $cliente->where('id_cliente',$id_cliente);
        $cliente_data = $cliente->findAll();
        //kardex/BGHE

        //datos de horarios
        $hora = new HorariosModel();
        $hora->where('id_cliente', $id_cliente);
        $hora_data = $hora->findAll();

        //datos del vendedor
        $vendedor = new UsuariosModel();
        $vendedor->where('id_usuario', $id_vendedor);
        $vendedor_data = $vendedor->findAll();

        $data = [
            'kardex' => $kardex_data,
            'horario' => $hora_data,
            'vendedor' => $vendedor_data,
            'cliente' =>$cliente_data
        ];

        return view('kardex',$data);
    }
    public function crear_kardex()
    {
        
        $tipo = $this->request->getvar('tipo');
        $cliente = $this->request->getvar('cliente');

        $caracteres_permitidos = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $longitud = 5;
        //vamos a abrir un reporte con numero de cliente y slug
        $nuevo = new KardexModel();
        $slug = substr(str_shuffle($caracteres_permitidos), 0, $longitud);
        $data=[
            'slug'=> $slug,
            'id_cliente'=> $cliente,
            'id_vendedor'=>session('id_usuario'),
            'tipo'=>$tipo
        ];
        if ($nuevo->insert($data)) {
            $dato = [
                'exito'=> 1,
                'slug' => $slug
            ];
            return json_encode($dato);
        };
    }
    public function detalle_kardex()
    {
        $model = new KardexDetalleModel();
        $data = [
            'nombre' => $this->request->getvar('nombre'),
            'marca' => $this->request->getvar('marca'),
            'modelo' => $this->request->getvar('modelo'),
            'serie' => $this->request->getvar('serie'),
            'inventario' => $this->request->getvar('inventario'),
            'falla' => $this->request->getvar('falla'),
            'id_kardex' => $this->request->getvar('kardex'),
        ];

        //return json_encode($data);
        if ($model->insert($data)) {
            echo 1;
        }   
    }
    function mostrar_kardex($id)
    {
        $model = new KardexDetalleModel();
        $model->where('id_kardex', $id);
        $resultado = $model->findAll();
        return json_encode($resultado);
    }
}
