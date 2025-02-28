<?php

namespace App\Controllers;
use App\Controllers\BaseController;
use CodeIgniter\Controller;

class Ordenes extends Controller
{
    public function index()
    {
        $usuario = session('id_usuario');
        $rol = session('id_rol');

        // Conexión a la base de datos
        $db = \Config\Database::connect();
        $builder = $db->table('mbi_kardex');
        $builder->join('mbi_clientes', 'mbi_clientes.id_cliente = mbi_kardex.id_cliente');
        $builder->join('usuarios', 'usuarios.id_usuario = mbi_kardex.atendido_por'); //esta es imporrtante no la borres
        // Seleccionar las columnas deseadas
        $builder->select('
            mbi_kardex.*, 
            mbi_clientes.*, 
            usuarios.nombre, 
            usuarios.apellidos, 
            usuarios.id_usuario
        ');
        
        //$resultado = $builder->get()->getResultArray();
        //return json_encode($resultado);

        //el vendedor ve lo que el genero pero que ya no esta en su poder
        if ($rol == 1) {
            $builder->where('generado_por', $usuario);
            $builder->where('atendido_por !=', $usuario);
            $resultado = $builder->get()->getResultArray();
        }elseif ($rol==3) { //esto es lo que ve el tecnico
            $builder->where('atendido_por', $usuario); //atendido por el
            $builder->where('estatus', 7); //atendido por el
            $resultado = $builder->get()->getResultArray();
        }elseif ($rol == 2) { //esto es lo que ve el administrador
            $resultado = $builder->get()->getResultArray();
        }


        return view('tabla_general', ['resultado'=>$resultado]);
    }
}
