<?php

namespace App\Models;

use CodeIgniter\Model;

class SeccionesModel extends Model
{
    protected $table = 'secciones';
    protected $primaryKey = 'section_id';
    protected $allowedFields = [
        'section_name',
    ];
}
