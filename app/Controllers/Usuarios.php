<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\UsuariosModel;
use App\Models\PermisosModel;
use App\Models\ModulosModel;

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
        $resultado = $model->where('id',$id)->findAll();
        $data['usuario'] = $resultado;
        return view('perfil',$data);
   }
   public function permisos($id)
   {
        $model = new UsuariosModel();
        $resultado = $model->where('id',$id)->findAll();
        $data['usuario'] = $resultado;
        
        //return json_encode($data['permisos']);
        return view('permisos',$data);
   }
   public function ver_permisos($id)
   {
       //ver permisos
        $db = \Config\Database::connect();
        $builder = $db->table('mbi_permisos');
        $builder->join('mbi_modulos','mbi_modulos.id_modulo = mbi_permisos.id_modulo');
        $res = $builder->get()->getResultArray();
        
        return json_encode($res);
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
       $model = new Model();
       $resultado = $model->where('id',$id)->findAll();
       $data = ['var'=>$resultado];
       return view('vista',$data);
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
}
