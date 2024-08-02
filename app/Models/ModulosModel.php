<?php

namespace App\Models;

use CodeIgniter\Model;

class ModulosModel extends Model
{
    protected $table = 'mbi_modulos';
    protected $primaryKey = 'id_modulo';
    protected $allowedFields = [
        'nombre',
    ];
}
