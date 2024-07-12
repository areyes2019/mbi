<?php

namespace App\Controllers\Admin;
use App\Controllers\BaseController;

class Login extends BaseController
{
	public function index()
	{
		return view('Panel/login');
	}
	public function recuperar()
	{
		return view('Panel/recuperar_pass');
	}
	public function crear()
	{
		return view('Panel/crear_cuenta');
	}
	public function insertar()
	{
		// code...
	}
}