<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\UsuariosModel;
use App\Models\PermisosModel;
use App\Models\ModulosModel;
use App\Models\SeccionesModel;
use App\Models\UsuarioRolModel;

class Usuarios extends BaseController
{
    public function index()
   {
       $model = new UsuariosModel();
       $resultado = $model->findAll();
       $data['usuarios']=$resultado;
       return view('usuarios', $data);
   }
   public function ver($id)
   {
        $model = new UsuariosModel();
        $resultado = $model->where('id_usuario',$id)->findAll();
        $data['usuario'] = $resultado;
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
       $model = new Model();
       $data = [
           'var' => $this->request->getPost('nombre_del_campo'),
       ];
       if ($model->insert($data)) {
           return redirect()->to('/vista');
       }
   }
   public function editar($id)
   {
       $model = new UsuariosModel();
       $resultado = $model->where('id_usuario',$id)->findAll();
       $data = ['usuario'=>$resultado];
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
   public function eliminar()
   {
       $modelo = new Model();
       $modelo->delete($id);
       if ($modelo->delete($id)) {
           return true;
       }
   }
   public function agregar_rol_usuario()
   {
       $model = new UsuarioRolModel();

       $request = \Config\Services::request();
       $rol = $this->request->getvar('rol');
       $usuario = $this->request->getvar('usuario');

       $data = [
            'id_usuario'=>$usuario,
            'id_rol'=>$rol,
       ];

       if ($model->insert($data)) {
           echo 1;
       }
   }
   public function ver_roles_asignados($id)
   {
       $db = \Config\Database::connect();
       $builder = $db->table('usuario_rol');
       $builder->where('id_usuario',$id);
       $builder->join('roles','roles.role_id = usuario_rol.id_rol');
       $resultado = $builder->get()->getResultArray(); 
       return json_encode($resultado);
   }
}
