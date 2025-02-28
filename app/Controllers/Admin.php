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
		$id= session('id_usuario');
		$rol = session('id_rol');
		$db = \Config\Database::connect();
		$builder = $db->table('mbi_kardex');
		$builder->join('mbi_clientes','mbi_clientes.id_cliente = mbi_kardex.id_cliente');
		$builder->join('usuarios', 'usuarios.id_usuario = mbi_kardex.atendido_por');
		//esta consulta es para lo que esta en poder de el vendedor en proceso 1
		if ($rol == 1) {
			$builder->where('generado_por',$id);
			$builder->where('atendido_por',$id);
			$builder->where('estatus',1);
		}

		//esta consulta es para lo que esta en poder del administrador en proceso 2 o proceso 7
		if ($rol == 2) {
			$builder->where('atendido_por',$id);
			$builder->where('estatus',2);
			$builder->orWhere('estatus',7);

		}

		//esta es para el tecnico en proceso 4 o 6
		if ($rol == 3) {
			$builder->where('atendido_por',$id);
			$builder->where('estatus',4);
			$builder->orWhere('estatus',6);
		}
		
		$cliente_model = new ClientesModel();
		$cliente = $cliente_model->findAll();

		$resultado = $builder->get()->getResultArray();
		$data = [
			'cliente' => $cliente,
			'kardex_user' => $resultado,
		];
        return view('panel',$data);
    }
	public function crear_kardex($id)
	{
		echo $id;
	}

	
}