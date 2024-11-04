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

	public function validar_entrada(){
		
        
        $correo = $this->request->getPost('correo');
        $password = $this->request->getPost('password');

        $db = \Config\Database::connect();
        
        $builder = $db->table('usuarios');
        $builder->where('correo',$correo);
        $builder->join('mbi_roles','mbi_roles.role_id = usuarios.id_rol');
        $resultado = $builder->get()->getResultArray();

        
        //return json_encode($resultado);

        if ($resultado && password_verify($password, $resultado[0]['password'])) {            
            $data = [
            	'id_usuario'=> $resultado[0]['id_usuario'],
            	'nombre'=> $resultado[0]['nombre'],
            	'tipo'=>$resultado[0]['tipo'],
            	'id_rol'=>$resultado[0]['id_rol'],
            	'is_logged'=> true,
            ];
     		$this->session->set($data);
    		return redirect()->to('/');
        }else{
        	return redirect()->back()->with('alert','El usuario o la contraseña no coinciden, verifica nuevamente');
        }

	}
	public function entrada()
	{
		// code...
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