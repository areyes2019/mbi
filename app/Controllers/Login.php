<?php 

namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\UsuariosModel;

class Login extends BaseController{
	
	public function index()
	{
		return view('Auth/login');
	}
	public function crear()
	{
		return view('Auth/crear_cuenta');
	}
	public function recuperar()
	{
		return view('Auth/recuperar_cuenta');
	}
	public function insertar()
	{
		$request = \Config\Services::Request();

		$data = [
			'nombre' => $request->getvar('nombre'),
			'correo' => $request->getvar('correo'),
			'password' => $request->getvar('password'),

		];

		$modelo = new UsuariosModel();
		if ($modelo->insert($data)) {
			echo 1;
		}

	}
	public function actualizar()
	{
		// code...
	}
}