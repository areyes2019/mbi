<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\UsuariosModel;

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
   public function permisos()
   {
       return view('permisos');
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
