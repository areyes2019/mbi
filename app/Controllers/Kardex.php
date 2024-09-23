<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\ClientesModel;
use App\Models\KardexModel;
use App\Models\KardexDetalleModel;
use App\Models\HorariosModel;
use App\Models\UsuariosModel;
use App\Models\MensajeModel;
use App\Models\InboxModel;
class Kardex extends BaseController
{
    public function index($slug)
    {

        //vamos a ver el estatus del kardex

        $estatus = new KardexModel();
        $estatus->where('slug',$slug);
        $resultado_estatus = $estatus->findAll();

        $db = \Config\Database::connect();
        
        $builder = $db->table('mbi_kardex');
        $builder->join('mbi_clientes',',mbi_clientes.id_cliente = mbi_kardex.id_cliente');
        $builder->where('slug',$slug);
        $resultado = $builder->get()->getResultArray();

        $id_cliente = $resultado[0]['id_cliente'];

        //datos de horarios
        $hora = new HorariosModel();
        $hora->where('id_cliente', $id_cliente);
        $hora_data = $hora->findAll();

    
        //enviamos el detalle del kardex
        $detalle_kardex = new KardexDetalleModel();
        $detalle_kardex->where('id_kardex',$resultado[0]['id_kardex']);
        $detalle = $detalle_kardex->findAll();
        $resultado_detalle = $detalle_kardex->countAllResults();

        //datos de usuarios que no estan logeados 
        $usuario = new UsuariosModel();
        $usuario->where('id_usuario !=',session('id_usuario'));
        $usuario_data = $usuario->findAll(); 

        $data = [
            'kardex' => $resultado,
            'horario' => $hora_data,
            'detalle' => $detalle,
            'usuarios' => $usuario_data,
            'hay_detalle'=>$resultado_detalle,
        ];

        return view('kardex',$data);
    }
    public function crear_kardex()
    {
        
        $tipo = $this->request->getvar('tipo');
        $cliente = $this->request->getvar('cliente');


        $tipo_txt = "";

        if ($tipo == 1) {
            $tipo_txt = "Diagnóstico";
        }elseif($tipo == 2){
            $tipo_txt = "Refaciones";
        }elseif($tipo == 3){
            $tipo_txt = "Mtto.Prev";
        }elseif ($tipo == 4) {
            $tipo_txt = "Garantía";
        }
        
        

        //vamos a obtener el nombre del remitente
        $nombre = new UsuariosModel();
        $nombre->where('id_usuario',session('id_usuario'));
        $resultado_nombre = $nombre->findAll();
        $nombre_completo = $resultado_nombre[0]['nombre']." ".$resultado_nombre[0]['apellidos'];


        $caracteres_permitidos = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $longitud = 5;
        //vamos a abrir un reporte con numero de cliente y slug
        $nuevo = new KardexModel();
        $slug = substr(str_shuffle($caracteres_permitidos), 0, $longitud);
        $data=[
            'slug'=> $slug,
            'id_cliente'=> $cliente,
            'generado_por'=>session('id_usuario'),
            'generado_nombre'=>$nombre_completo,
            'tipo'=>$tipo,
            'tipo_txt'=>$tipo_txt,
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
    public function mostrar_kardex($id)
    {
        $model = new KardexDetalleModel();
        $model->where('id_kardex', $id);
        $resultado = $model->findAll();
        return json_encode($resultado);
    }
    public function enviar_kardex()
    {
        
        //estos son los datos que vienen del formulario
        $kardex_id = $this->request->getvar('kardex');
        $destinatario = $this->request->getvar('destinatario');
        $asunto = $this->request->getvar('asunto');

        
        //econtrar al destinatario
        $receptor = new UsuariosModel();
        $receptor->where('id_usuario',$destinatario);
        $recibe = $receptor->findAll();
        $nombre_completo = $recibe[0]['nombre']." ".$recibe[0]['apellidos'];

        //ahora tenemos que encontrar que estatus le damos al kardex
        //si el estatus es 1 y el atendido_por es null, el estatus debe ser 2

        $kardex = new KardexModel();
        $kardex->where('id_kardex',$kardex_id);
        $kardex_resultado = $kardex->findAll();


        if ($kardex_resultado[0]['estatus'] == 1 && !$kardex_resultado[0]['atendido_por']) {
            $estatus = 2;
        }
        elseif ($kardex_resultado[0]['estatus'] == 2 && $kardex_resultado[0]['aceptado'] == 0 ) {
            $estatus = 3;
        }




        //metemos el id mensaje a inbox

        //$fecha = date('Y-m-d H:i:s');
        $data = [
            'atendido_por'=> $destinatario,
            'atendido_nombre'=>$nombre_completo,
            'comentarios'=>$asunto,
            'estatus'=>$estatus

        ];

        $kardex_update = new KardexModel();

        if ($kardex_update->update($kardex_id,$data)) {
            echo 1;
        }

        //return json_encode($data);
    }
    public function borrar_linea($id)
    {
        $model = new KardexDetalleModel();
        $model->where('id_kardex',$id);
        $resultado = $model->findAll();
        $id_detalle = $resultado[0]['id_detalle']; 
        if ($model->delete($id_detalle)) {
            echo 1;
        }

    }
    //esta funcion lanza el kardez al modal para verlo en vista rápida
    public function ver_kardex($id)
    {

        $db = \Config\Database::connect();
        
        $builder = $db->table('mbi_kardex');
        $builder->join('mbi_clientes','mbi_clientes.id_cliente = mbi_kardex.id_cliente');
        $builder->where('id_kardex',$id);
        $resultado = $builder->get()->getResultArray();
        $id_kardex = $resultado[0]['id_kardex'];
        //buscamos los detalles del kardex

        $detalles = new KardexDetalleModel();
        $detalles->where('id_kardex', $id_kardex);
        $resultado_detalles = $detalles->findAll();


        $data=[
            'kardex'=>   $resultado,
            'detalles'=> $resultado_detalles
        ];
        return json_encode($data);
    }
    //esta funcion muestra el cardex en la barra lateral
    public function ver_kardex_lateral($id)
    {
        

        $db = \Config\Database::connect();
        
        $builder = $db->table('mbi_kardex');
        $builder->join('mbi_clientes','mbi_clientes.id_cliente = mbi_kardex.id_cliente');
        $builder->where('mbi_kardex.id_kardex',$id);
        $resultado = $builder->get()->getResultArray();

        $model = new KardexDetalleModel();
        $model->where('id_kardex',$id);
        $resultado_detalle = $model->findAll();

        $data = [
            'kardex' => $resultado,
            'kardex_detalle' => $resultado_detalle,
        ];
        return json_encode($data);
    }
    public function ver_primer_kardex()
    {
        $db = \Config\Database::connect();
        
        $builder = $db->table('mbi_kardex')
        ->join('mbi_clientes','mbi_clientes.id_cliente = mbi_kardex.id_cliente')
        ->orderBy('id_kardex','DESC')
        ->limit(1);
        $query = $builder->get();

        $detalle = new KardexDetalleModel();
        $detalle->where('id_kardex', $resultado['id_kardex']);
        $resultado_detalle = $detalle->findAll();

        $data = [
            'primer_kardex' => $query,
            'primer_detalle' => $resultado_detalle,
        ];
        return json_encode($data);

    }
    public function kardex_accion()
    {

        $kardex = $this->request->getvar('kardex');
        $accion = $this->request->getvar('accion');
        
        $model = new KardexModel();
        $model->where('id_kardex', $kardex);
        $resultado = $model->findAll();


        if ($accion == 1 ) { //aceptar
            if (!$resultado[0]['rechazado'] && $resultado[0]['estatus'] == 3) {
                $hoy  = date('Y:m:d');
                $data['aceptado'] = $hoy;
                $data['estatus'] = "4";
                if ($model->update($kardex,$data)) {
                    echo 1;
                }
            }
        }elseif($accion == 2){
            if (!$resultado[0]['rechazado'] && $resultado[0]['estatus'] == 3) {
                $hoy  = date('Y:m:d');
                $data['rechazado'] = $hoy;
                $data['estatus'] = "5";
                if ($model->update($kardex,$data)) {
                    echo 1;
                }
            }
        }


    }
    
}
