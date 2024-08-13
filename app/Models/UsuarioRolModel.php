<?php

namespace App\Models;

use CodeIgniter\Model;

class UsuarioRolModel extends Model
{
    protected $table = 'usuario_rol';
    protected $primaryKey = 'id_ur';
    protected $allowedFields = [
        'id_usuario',
        'id_rol',
    ];
}