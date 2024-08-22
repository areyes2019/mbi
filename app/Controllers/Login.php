<?php 

namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\UsuariosModel;
use App\Models\UsuarioRolModel;

class Login extends BaseController{
	

	public function index()
	{
		return view('auth/login');
	}
	public function crear()
	{
		return view('auth/crear_cuenta');
	}
	public function recuperar()
	{
		return view('auth/recuperar_cuenta');
	}
	public function insertar()
	{
		$request = \Config\Services::request();
		
		$hash = password_hash($request->getvar('password'), PASSWORD_DEFAULT);
		
		$data = [
			'nombre' => $request->getvar('nombre'),
			'apellidos' => $request->getvar('apellidos'),
			'correo' => $request->getvar('correo'),
			'password' => $hash,

		];

		//return json_encode($data);	

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
        $id = $resultado[0]['id_usuario'];
        
        //sacamos las secciones
        
        $rol = new UsuarioRolModel();
        $rol->where('id_usuario',$id);
        $query = $rol->get()->getResultArray();

        if ($resultado && password_verify($password, $resultado[0]['password'])) {            
            $data = [
            	'id_usuario'=> $resultado[0]['id_usuario'],
            	'nombre'=> $resultado[0]['nombre'],
            	'tipo'=>$resultado[0]['tipo'],
            	'funcion'=>$resultado[0]['funcion'],
            	'is_logged'=> true,
            	'role' => $query
            ];

            //return json_encode($data);
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