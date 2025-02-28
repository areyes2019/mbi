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
        $builder->select('mbi_kardex.*, mbi_clientes.*, usuarios.id_usuario, usuarios.nombre, usuarios.apellidos');
        $builder->join('mbi_clientes', 'mbi_clientes.id_cliente = mbi_kardex.id_cliente');
        $builder->join('usuarios', 'usuarios.id_usuario = mbi_kardex.atendido_por');

        if ($rol == 1 || $rol == 3) {
            $builder->where('generado_por', $usuario);
        }

        $resultado = $builder->get()->getResultArray();

        return view('tabla_general', ['resultado'=>$resultado]);
    }
}
