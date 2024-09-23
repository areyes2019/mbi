<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\InboxModel;
use App\Models\MensajeModel;
use App\Models\KardexModel;
use App\Models\KardexDetalleModel;
use App\Models\UsuariosModel;

class Inbox extends BaseController
{
    public function index()
    {
        $user = session('id_usuario');

        $usuario = new UsuariosModel();
        $usuario->where('id_usuario !=',$user);
        $usuario_resultado = $usuario->findAll();

        $data = [
            'usuario'=> $usuario_resultado,
        ];

        return view ('inbox',$data);
    }
    public function mostrar_bandeja()
    {
        $usuario = session('id_usuario');
        $usaurio_cero = 0;
        $db = \Config\Database::connect();
        $enviado = 1;
        
        // mostrar lo que yo he enviado
        /*$builder_enviado = $db->table('mbi_mensajes');
        $builder_enviado->select('mbi_kardex.* , mbi_clientes.*, mbi_mensajes.*');
        $builder_enviado->join('mbi_kardex', 'mbi_mensajes.kardex_id = mbi_kardex.id_kardex');
        $builder_enviado->join('mbi_clientes', 'mbi_kardex.id_cliente = mbi_clientes.id_cliente');
        $builder_enviado->where('mbi_mensajes.remitente_id',$usuario);
        $resultado_enviado = $builder_enviado->get()->getResultArray();*/
        
        //mostrar lo que se ha recibido
        $builder_recibido = $db->table('mbi_kardex');
        $builder_recibido->join('mbi_clientes', 'mbi_clientes.id_cliente = mbi_kardex.id_cliente');
        $builder_recibido->where('atendido_por',$usuario);
        $resultado_recibido = $builder_recibido->get()->getResultArray();
        
        $data = [
            'recibido' => $resultado_recibido,
            //'enviado' => $resultado_enviado,
            //'borrador' => $resultado_borrador,
        ];

        return json_encode($data);
    }
    public function vista_previa($id)
    {
        
        $db = \Config\Database::connect();
        
        // mostrar lo que yo he enviado
        $builder_enviado = $db->table('mbi_kardex');
        $builder_enviado->join('mbi_clientes', 'mbi_clientes.id_cliente = mbi_kardex.id_cliente');
        $builder_enviado->where('id_kardex',$id);
        $resultado_enviado = $builder_enviado->get()->getResultArray();

        $data_kardex = $resultado_enviado[0]['id_kardex'];
        
        /*$builder = $db->table('mbi_kardex');
        $builder->join('mbi_clientes','mbi_clientes.id_cliente = mbi_kardex.id_cliente');
        $builder->where('mbi_kardex.id_kardex',$id);
        $resultado = $builder->get()->getResultArray();*/

        $model = new KardexDetalleModel();
        $model->where('id_kardex',$data_kardex);
        $resultado_detalle = $model->findAll();

        $data = [
            'kardex' => $resultado_enviado,
            'kardex_detalle' => $resultado_detalle,
        ];
        return json_encode($data);
    }
    public function primer_kardex()
    {
        
        $db = \Config\Database::connect();
        $usuario  = session('id_usuario');
        
        // mostrar primer kardex
        $builder = $db->table('mbi_kardex');
        $builder->join('mbi_clientes', 'mbi_clientes.id_cliente = mbi_kardex.id_cliente');
        $builder->where('atendido_por',$usuario);
        $builder->orderBy('mbi_kardex.id_kardex', 'ASC')->limit(1);
        $resultado = $builder->get()->getResultArray();

        $detalles = $resultado[0]['id_kardex'];

        $kardex = new KardexDetalleModel();
        $kardex->where('id_kardex',$detalles);
        $resultado_kardex = $kardex->findAll();

        $data = [
            'kardex'=>$resultado,
            'resultado_kardex'=>$resultado_kardex
        ];

        return  json_encode($data);
    }
}
