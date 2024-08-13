<?php

namespace App\Models;

use CodeIgniter\Model;

class PermisosModel extends Model
{
    protected $table = 'permisos';
    protected $primaryKey = 'id_permiso';
    protected $allowedFields = [
        'permission_name'
    ];
}
