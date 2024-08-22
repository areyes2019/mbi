<?php

namespace App\Models;

use CodeIgniter\Model;

class SeccionesPermisosModel extends Model
{
    protected $table = 'secciones_permisos';
    protected $primaryKey = 'id_permiso_seccion';
    protected $allowedFields = [
        'id_seccion',
        'id_permiso',
    ];
}
