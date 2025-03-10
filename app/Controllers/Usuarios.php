<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\UsuariosModel;
use App\Models\PermisosModel;
use App\Models\ModulosModel;
use App\Models\SeccionesModel;
use App\Models\UsuariosSecciones;
use App\Models\RolesModel;

class Usuarios extends BaseController
{
    public function index()
   {
       $db = \Config\Database::connect();
       
       $builder = $db->table('usuarios');
       $builder->where('tipo',0);
       $builder->join('mbi_roles','mbi_roles.role_id = usuarios.id_rol');
       $resultado = $builder->get()->getResultArray();
       $data['usuarios']=$resultado;
       return view('usuarios', $data);
   }
   public function ver($id)
   {
        $model = new UsuariosModel();
        $resultado = $model->where('id_usuario',$id)->findAll();

        $funcion = new RolesModel();
        $funcion->where('role_id',$resultado[0]['function']);
        $query = $funcion->get()->getResultArray();

        $data['usuario'] = $resultado;
        $data['funcion'] = $query[0]['role_name'];
        
        return view('perfil',$data);
   }
   public function permisos($id)
   {
        $model = new UsuariosModel();
        $resultado = $model->where('id_usuario',$id)->findAll();
        
        $secciones = new SeccionesModel();
        $sec = $secciones->findAll();

        $data['usuario'] = $resultado;
        $data['secciones'] = $sec;

        //return json_encode($data['permisos']);
        return view('permisos',$data);
   }
   public function ver_permisos($id)
   {
        $db = \Config\Database::connect();
        //ver las secciones que tiene asignada el usuario
        $secciones = $db->table('permisos_secciones');
        $secciones->join('secciones','secciones.section_id = permisos_secciones.id_seccion');
        $secciones->where('id_usuario',$id);
        $resultado = $secciones->get()->getResultArray();

        //ver permisos
        /*$builder = $db->table('permisos_secciones');
        $builder->join('secciones','secciones.section_id = permisos_secciones.id_seccion');
        $builder->join('permisos','permisos.permission_id = permisos_secciones.id_permiso');
        $builder->where('id_usuario',$id);
        $res = $builder->get()->getResultArray();*/
        
        return json_encode($resultado);
   }
   public function actualizar_permiso()
   {
      $tipo = $this->request->getvar('tipo');
      $id = $this->request->getvar('id');
      $permiso = $this->request->getvar('permiso');
      if ($tipo == 1) {
          $modelo = new PermisosModel();
          $data=[
            'leer'=>$permiso
          ];
          if ($modelo->update($id,$data)) {
                $number = 1;
                return json_encode($number);
          };
      }elseif ($tipo == 2) {
          $modelo = new PermisosModel();
          $data=[
            'crear'=>$permiso
          ];
          if ($modelo->update($id,$data)) {
                $number = 1;
                return json_encode($number);
          };
      }elseif($tipo == 3){
            $modelo = new PermisosModel();
            $data=[
                'actualizar'=>$permiso
            ];
            if ($modelo->update($id,$data)) {
                $number = 1;
                return json_encode($number);
            };
      }elseif($tipo == 4){
            $modelo = new PermisosModel();
            $data=[
                'eliminar'=>$permiso
            ];
            if ($modelo->update($id,$data)) {
                $number = 1;
                return json_encode($number);
            };
      }
   }
   public function nuevo()
   {
       $nombre = $this->request->getvar('nombre');
       $apellidos = $this->request->getvar('apellidos');
       $correo = $this->request->getvar('correo');
       $hash = password_hash($this->request->getvar('password_confirm'), PASSWORD_DEFAULT);

       $model = new UsuariosModel();
       $data = [
           'nombre' => $nombre,
           'apellidos' => $apellidos,
           'correo' => $correo,
           'password' => $hash,
       ];
       if ($model->insert($data)) {
            echo 1;
       }
   }
   public function editar($id)
   {
        $model = new UsuariosModel();
        $resultado = $model->where('id_usuario',$id)->findAll();

        $funcion_id = $resultado[0]['id_rol'];

        $funcion = new RolesModel();
        $funcion->where('role_id',$funcion_id);
        $query = $funcion->get()->getResultArray();

        if (empty($query[0]['role_name'])) {
            $puesto = "No asignado";
        }else{
            $puesto = $query[0]['role_name'];
        }

        $data = [
            'usuario'=>$resultado,
            'funcion'=>$puesto,
        ];
        return view('editar_usuario',$data);
   }
   public function actualizar()
   {
       
       $modelo = new Model();
       $id = $this->request->getPost('data');
       $data = [
           'nombre'=> $this->request->getPost('nombre'),
           'modelo' => $this->request->getPost('modelo'),
           'precio_prov' => $this->request->getPost('precio_prov'),
           'precio_pub' => $precio,
       ];
       if ($modelo->update($id,$data)) {
           return true;     
       }
   }
   public function eliminar($id)
   {
        $usuarioModel = new UsuariosModel();
        $usuarioModel->where('id_usuario',$id);
        // Verifica si el registro existe
        $usuario = $usuarioModel->findAll();
        if (!$usuario) {
            return $this->response->setJSON(['error' => 'Usuario no encontrado'])->setStatusCode(404);
        }

        // Elimina el registro
        if ($usuarioModel->delete($id)) {
            return $this->response->setJSON(['mensaje' => 'Usuario eliminado exitosamente'])->setStatusCode(200);
        }

        return $this->response->setJSON(['error' => 'No se pudo eliminar el usuario'])->setStatusCode(500);
   }
   public function agregar_seccion_usuario()
   {
       $model = new UsuariosSecciones();

       $request = \Config\Services::request();
       $seccion = $this->request->getvar('seccion');
       $usuario = $this->request->getvar('usuario');

       $data = [
            'id_usuario'=>$usuario,
            'id_seccion'=>$seccion,
       ];

       if ($model->insert($data)) {
           echo 1;
       }
   }
   public function ver_secciones_asignadas($id)
   {
       $db = \Config\Database::connect();
       $builder = $db->table('usuarios_secciones');
       $builder->where('id_usuario',$id);
       $builder->join('secciones','secciones.section_id = usuarios_secciones.id_seccion');
       $resultado = $builder->get()->getResultArray(); 
       return json_encode($resultado);
   }
   public function modificar_perfil()
   {
       
       $id = session('id_usuario');
       $model = new UsuariosModel();
       $model->where('id_usuario', $id);
       $resultado = $model->findAll();

       return json_encode($resultado);
   }
   public function agregar_numero_empleado()
   {
       

       $id = $this->request->getvar('empleado');
       $data['no_empleado'] = $this->request->getvar('numero');
       $model = new UsuariosModel();
       if ($model->update($id,$data)) {
            $return = 1;
            return json_encode($return);
       }
   }
}
