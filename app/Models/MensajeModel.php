<?php

namespace App\Models;

use CodeIgniter\Model;

class MensajeModel extends Model
{
    protected $table            = 'mbi_mensajes';
    protected $primaryKey       = 'id_mensaje';
    protected $returnType       = 'array';
    protected $useTimestamps = true;
    protected $allowedFields    = [
        'remitente_id',
        'remitente_nombre',
        'destinatario_id',
        'destinatario_nombre',
        'kardex_id',
        'leido',
        'asunto',
    ];



}
