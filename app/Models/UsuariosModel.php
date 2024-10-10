<?php

namespace App\Models;

use CodeIgniter\Model;

class UsuariosModel extends Model
{
    protected $table            = 'usuarios';
    protected $primaryKey       = 'id_usuario';
    protected $allowedFields    = [
        'nombre',
        'apellidos',
        'no_empleado',
        'correo',
        'mobil',
        'zona',
        'nicho',
        'password',
        'tipo',
        'id_rol',
        'verificado',
        'creado_en',
        'deleted_at'
    ];
   
}
