<?php

namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\ClientesModel;
use App\Models\KardexModel;
use App\Models\MensajeModel;

class Admin extends BaseController
{
	public function index()
	{
	    // Obtener el ID y el rol del usuario desde la sesión
	    $id = session('id_usuario');
	    $rol = session('id_rol');
	    // Conectar a la base de datos
	    $db = \Config\Database::connect();
	    $builder = $db->table('mbi_kardex');
	    $builder->join('mbi_clientes', 'mbi_clientes.id_cliente = mbi_kardex.id_cliente');

	    //lo que va a ver el vendedor estatus 1 atedido por él mismo
	    if ($rol == 1) {
	    	$builder->where('estatus',1);
	    	$builder->where('atendido_por',session('id_usuario'));
	    	$builder->orWhere('estatus',3);
	    }elseif($rol == 2) {
	    	$builder->where('estatus',2);
	    	$builder->where('atendido_por',session('id_usuario'));
	    	$builder->orWhere('estatus',7);
	    }elseif($rol == 3) {
	    	$builder->where('estatus',4);
	    	$builder->orWhere('estatus',6);
	    	$builder->where('atendido_por',session('id_usuario')); //lo que van a ver todos los demas
	    }


	    //lo que va a ver el administrado

	    // Obtener todos los clientes
	    $cliente_model = new ClientesModel();
	    $cliente = $cliente_model->findAll();

	    // Obtener los resultados de la consulta
	    $resultado = $builder->get()->getResultArray();

	    // Preparar los datos para la respuesta
	    $data = [
	        'cliente' => $cliente,
	        'kardex_user' => $resultado,
	    ];

	    // Devolver los datos en formato JSON
	    //return json_encode($data);

	    // Si prefieres devolver una vista, descomenta la siguiente línea:
	    return view('panel', $data);
	}
	public function crear_kardex($id)
	{
		echo $id;
	}

	
}