<?php

namespace App\Models;

use CodeIgniter\Model;

class ConfigModel extends Model
{
    protected $table            = 'mbi_config';
    protected $primaryKey       = 'id_config';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'nombre',
        'rfc',
        'correo',
        'telefono',
    ];

}
