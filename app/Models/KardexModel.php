<?php 

namespace App\Models;
use CodeIgniter\Model;

class KardexModel extends Model
{
    protected $table = 'mbi_kardex';
    protected $primaryKey = 'id_kardex';
    protected $useTimestamps = true;
    protected $allowedFields = [
        'slug',
        'estatus',
        'id_cliente',
        'generado_por',
        'generado_nombre',
        'aceptado',
        'rechazado',
        'atendido_por',
        'atendido_nombre',
        'atendido_rol',
        'tipo',
        'tipo_txt',
        'leido',
        'horario',
        'asunto',
        'fecha_leido',
        'fecha_enviado',
        'enviado',
    ];
}