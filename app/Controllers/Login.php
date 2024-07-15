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

		$hash = password_hash($request->getvar('password'), PASSWORD_DEFAULT);
		
		$data = [
			'nombre' => $request->getvar('nombre'),
			'correo' => $request->getvar('correo'),
			'password' => $hash,

		];

		$modelo = new UsuariosModel();
		if ($modelo->insert($data)) {
			echo 1;
		}

	}
	public function validar_entrada(){
		
		//$this->session->set('usuario','Abdias');
		//echo $this->session->get('usuario');
		$usuarios = new UsuariosModel();
        $correo = $this->request->getPost('correo');
        $password = $this->request->getPost('password');
        $usuarios->where('correo', $correo);
        $resultado = $usuarios->findAll();

        if ($resultado && password_verify($password, $resultado[0]['password'])) {
            
            $data = [
            	'id_usuario'=> $resultado[0]['id'],
            	'nombre'=> $resultado[0]['nombre'],
            	'is_logged'=> true
            ];
     		$this->session->set($data);
            return redirect()->to('/inicio');
        }

        return redirect()->back();
	}
	public function actualizar()
	{
		// code...
	}
	public function salir()
	{
		$session = session();
		$session->destroy();
        return redirect()->route('/');
	}
}