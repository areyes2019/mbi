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

        //el vendedor ve lo que el genero pero que ya no esta en su poder
        if ($rol == 1) {
            $builder->where('generado_por', $usuario);
            $builder->where('estatus !=', 1);
        }elseif (condition) { //esto es lo que ve el tecnico
            $builder->where('atendido_por', $usuario); //atendido por el
            $builder->where('estatus', 7); //atendido por el
        }

        $resultado = $builder->get()->getResultArray();

        //return json_encode($resultado);
        return view('tabla_general', ['resultado'=>$resultado]);
    }
}
