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
		$builder->select('mbi_kardex.*, mbi_clientes.*, usuarios.nombre, usuarios.apellidos');
		$builder->join('mbi_clientes', 'mbi_clientes.id_cliente = mbi_kardex.id_cliente');
		$builder->join('usuarios', 'usuarios.id_usuario = mbi_kardex.atendido_por'); // Ajusta el campo según tu relación

	    //lo que va a ver el vendedor estatus 1 atedido por él mismo
	    if ($rol == 1) { // Vendedor
		    $builder->groupStart()
		            ->where('estatus', 1)
		            ->where('atendido_por', session('id_usuario'))
		            ->groupEnd()
		            ->orWhere('estatus', 3);
		} elseif ($rol == 2) { // Otro rol
		    $builder->groupStart()
		            ->where('estatus', 2)
		            ->where('atendido_por', session('id_usuario'))
		            ->groupEnd()
		            ->orWhere('estatus', 7)
		            ->orWhere('estatus', 5);
		} elseif ($rol == 3) { // Otro rol
		    $builder->groupStart()
		            ->where('estatus', 4)
		            ->orWhere('estatus', 6)
		            ->groupEnd()
		            ->where('atendido_por', session('id_usuario'));
		}

	    //lo que va a ver el administrado

	    // Obtener todos los clientes
	    $cliente_model = new ClientesModel();
	    $cliente = $cliente_model->findAll();

	    // Obtener los resultados de la consulta
		$query = $builder->get();
		$result = $query->getResultArray();

	    // Preparar los datos para la respuesta
	    $data = [
	        'cliente' => $cliente,
	        'kardex_user' => $result,
	    ];

	    // Devolver los datos en formato JSON

	    // Si prefieres devolver una vista, descomenta la siguiente línea:
	    return view('panel', $data);
	    //return json_encode($data);
	}
	public function crear_kardex($id)
	{
		echo $id;
	}

	
}