<?php

namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\ClientesModel;
use App\Models\KardexModel;

class Admin extends BaseController
{
	public function index()
	{
		$db = \Config\Database::connect();
		
		$builder = $db->table('mbi_kardex');
		$builder->join('mbi_clientes','mbi_clientes.id_cliente = mbi_kardex.id_cliente');
		$builder->join('usuarios','usuarios.id_usuario = mbi_kardex.enviado_a');
		$kardex_data = $builder->get()->getResultArray();

		$model = new ClientesModel();
		$resultado = $model->findAll();
		$data = [
			'cliente' => $resultado,
			'kardex' => $kardex_data
		];
		return view('panel',$data);
	}
	public function crear_kardex($id)
	{
		echo $id;
	}
}