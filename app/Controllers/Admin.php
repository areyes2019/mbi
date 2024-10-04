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

		$cliente_model = new ClientesModel();
		$cliente = $cliente_model->findAll();
		
		$db = \Config\Database::connect();
		//Consulta para admin

		$builder_admin = $db->table('mbi_kardex');
		$builder_admin->join('mbi_clientes', 'mbi_clientes.id_cliente = mbi_kardex.id_cliente');
		$builder_admin->join('mbi_mensajes', 'mbi_mensajes.kardex_id = mbi_kardex.slug');
		$resultado_admin = $builder_admin->get()->getResultArray();

		if ($resultado_admin) {
			$estatus_texto = asignar_estatus($resultado_admin[0]['estatus']);
		}else{
			$estatus_texto = "";
		}


		
		$builder = $db->table('mbi_kardex');
		$builder->join('mbi_clientes','mbi_clientes.id_cliente = mbi_kardex.id_cliente');
		$builder->join('mbi_mensajes', 'mbi_mensajes.kardex_id = mbi_kardex.slug', 'left');
		$builder->where('destinatario_id',$id);
		$builder->orWhere('remitente_id',$id);
		$builder->orWhere('generado_por',$id);
		$resultado = $builder->get()->getResultArray();

		$data = [
			'kardex_admin' => $resultado_admin,
			'cliente' => $cliente,
			'kardex_user' => $resultado,
			'estatus'=>$estatus_texto
		];
        return view('panel',$data);
    }
	public function crear_kardex($id)
	{
		echo $id;
	}

	
}