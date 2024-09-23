<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\RolesModel;
use App\Models\SeccionesModel;
use App\Models\PermisosModel;
use App\Models\RolesSecciones;
use App\Models\SeccionesPermisosModel;
use App\Models\UsuariosModel;
use App\Models\UsuariosSecciones;
use Exception;

class Roles extends BaseController
{
    public function index()
    {
        return view('roles');
    }
    public function agregar()
    {
        $model = new RolesModel();
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
        if ($modelo->delete($id)) {
            echo 1;
        }
        

    }
    public function editar_permiso()
    {
        $id_seccion = $this->request->getvar('seccion');
        $permiso = $this->request->getvar('permiso');
        $valor = $this->request->getvar('valor');
        $valor_final = json_encode($valor);

        $model = new UsuariosSecciones();
        
        if ($permiso == 1) {
            $data['solo_ver'] = $valor_final;
            if ($model->update($id_seccion,$data)) {
                echo 1;
            }
        }elseif ($permiso == 2) {
            $data['puede_crear'] = $valor_final;
            if ($model->update($id_seccion,$data)) {
                echo 1;
            }
        }
        elseif ($permiso == 3) {
            $data['puede_modificar'] = $valor_final;
            if ($model->update($id_seccion,$data)) {
                echo 1;
            }
        }
        elseif ($permiso == 4) {
            $data['puede_eliminar'] = $valor_final;
            if ($model->update($id_seccion,$data)) {
                echo 1;
            }
        }
        

    

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
    public function asignar_funcion()
    {
        $model = new UsuariosModel();
        $request = \Config\Services::request();
        $id = $this->request->getvar('usuario');
        $data = [
            'id_rol'=>$this->request->getvar('funcion'),
        ];

        if ($model->update($id,$data)) {
            echo 1;
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
    public function quitar_seccion_usuario($id)
    {
        $model = new  UsuariosSecciones();
        if ($model->delete($id)) {
            echo 1;
        }
    }
   
}
