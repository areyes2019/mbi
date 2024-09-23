<?php

namespace App\Models;

use CodeIgniter\Model;

class RolesModel extends Model
{
    protected $table = 'mbi_roles';
    protected $primaryKey = 'role_id';
    protected $allowedFields = [
        'role_name',
    ];
}