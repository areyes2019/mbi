<?php

namespace App\Models;

use CodeIgniter\Model;

class InboxModel extends Model
{
    protected $table            = 'mbi_inbox';
    protected $primaryKey       = 'id_inbox';
    protected $useTimestamps = true;
    protected $allowedFields    = [
        'mensaje_id',
        'destinatario_id',
        'destinatario_nombre',
        'leido',
        'fecha_lectura',
        'kardex_id'
    ];

}
