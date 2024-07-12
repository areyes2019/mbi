<?php 

namespace App\Controllers;
use App\Controllers\BaseController;

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
	public function insetar()
	{
		$request = \Config\Services::Request;

		$data = [
			'nombre' => $request->getvar('nombre'),
			'correo' => $request->getvar('correo'),
			'password' => $request->getvar('password_confirmada'),

		];

		return json_encode($data);
	}
	public function actualizar()
	{
		// code...
	}
}