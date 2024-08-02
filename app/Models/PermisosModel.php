<?php

namespace App\Models;

use CodeIgniter\Model;

class PermisosModel extends Model
{
    protected $table = 'mbi_permisos';
    protected $primaryKey = 'id_permiso';
    protected $allowedFields = [
        'leer',
        'crear',
        'actualizar',
        'eliminar',
    ];
}
