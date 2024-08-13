<?php

namespace App\Models;

use CodeIgniter\Model;

class RolesSecciones extends Model
{
    protected $table = 'roles_secciones';
    protected $primaryKey = 'id_roles_secciones';
    protected $allowedFields = [
        'id_rol',
        'id_seccion',
    ];
}