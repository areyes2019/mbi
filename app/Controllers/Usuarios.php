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
       $model = new UsuariosModel();
       $model->where('tipo',0);
       $resultado = $model->findAll();
       $data['usuarios']=$resultado;
       return view('usuarios', $data);
   }
   public function ver($id)
   {
        $model = new UsuariosModel();
        $resultado = $model->where('id_usuario',$id)->findAll();

        /*$funcion = new RolesModel();
        $funcion->where('role_id',$resultado[0]['function']);
        $query = $funcion->get()->getResultArray();*/

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

        $funcion_id = $resultado[0]['funcion'];

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
   public function eliminar()
   {
       $modelo = new Model();
       $modelo->delete($id);
       if ($modelo->delete($id)) {
           return true;
       }
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
}
