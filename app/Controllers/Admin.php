<?php

namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\ClientesModel;

class Admin extends BaseController
{
	public function index()
	{
		$model = new ClientesModel();
		$resultado = $model->findAll();
		$data = [
			'cliente' => $resultado
		];
		return view('panel',$data);
	}
}