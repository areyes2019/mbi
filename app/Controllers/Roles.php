<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\RolesModel;
use App\Models\SeccionesModel;
use App\Models\PermisosModel;
use App\Models\RolesSecciones;
use App\Models\SeccionesPermisosModel;
use App\Models\UsuarioRolModel;
use Exception;

class Roles extends BaseController
{
    public function index()
    {
        return view('roles');
    }
    public function agregar()
    {
        $request = \Config\Services::request();
        $model = new RolesModel();
        $id = $this->request->getvar('nombre');
        $data=[
            'role_name'=> $this->request->getvar('nombre'),
        ];
        if ($model->insert($data)) {
            echo 1;
        }

    }
    public function mostrar()
    {   
        $model = new RolesModel();
        $resultado = $model->findAll();
        return json_encode($resultado);
    }
    public function eliminar_rol($id)
    {
        $modelo = new RolesModel();
        $modelo->delete($id);

    }
    public function editar_rol($id)
    {
        
    }
    public function add_seccion()
    {
        $model = new RolesSecciones();
        $request = \Config\Services::request();
        $data = [
            'id_seccion'=>$this->request->getvar('seccion'),
            'id_rol'=>$this->request->getvar('rol'),
        ];

        if ($model->insert($data)) {
            echo 1;
        }
        
    }
    public function rol_seccion($id)
    {    
      
        $model = new RolesModel();
        $model->where('role_id',$id);
        $resultado = $model->get()->getResultArray();

        $db = \Config\Database::connect();
        $builder = $db->table('roles_secciones');
        $builder->where('id_rol',$id);
        $builder->join('secciones', 'secciones.section_id = roles_secciones.id_seccion');
        $data_end = $builder->get()->getResultArray();

        $data = [
            'nombre'=>$resultado,
            'lista'=>$data_end
        ];
        return view('secciones.php',$data);
    }
    public function ver_secciones()
    {
        $model = new SeccionesModel();
        $resultado = $model->findAll();
        return json_encode($resultado);
    }
    public function ver_permisos()
    {
        $model = new PermisosModel();
        $resultado = $model->findAll();
        return json_encode($resultado);
    }
    public function agregar_permiso()
    {
        $model = new SeccionesPermisosModel();
        $request = \Config\Services::request();
        $data = [
            'id_rol_seccion'=>$this->request->getvar('rol_seccion'),
            'id_permiso'    =>$this->request->getvar('permiso'),
        ];

        //return json_encode($data);
        try {
            $model->insert($data);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
    public function mostrar_permiso_seccion($id)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('secciones_permisos');
        $builder->where('id_rol_seccion',$id);
        $builder->join('permisos','permisos.permission_id = secciones_permisos.id_permiso');
        $resultado = $builder->get()->getResultArray();
        return json_encode($resultado);      
    }
    public function borrar_permiso($id)
    {
        $modelo = new SeccionesPermisosModel();
        if ($modelo->delete($id)) {
            echo 1;
        }
        
    }
    public function eliminar_seccion_rol($id)
    {
        $modelo = new RolesSecciones();
        if ($modelo->delete($id)) {
            echo 1;
        }
    }
    public function quitar_rol_usuario($id)
    {
        $model = new  UsuarioRolModel();
        if ($model->delete($id)) {
            echo 1;
        }
    }
}
