<?php

namespace App\Models;

use CodeIgniter\Model;

class UsuariosSecciones extends Model
{
    protected $table            = 'usuarios_secciones';
    protected $primaryKey       = 'id_us';
    protected $allowedFields    = [
        'id_usuario',
        'id_seccion',
    ];

}