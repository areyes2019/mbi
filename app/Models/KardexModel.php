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
        'id_vendedor',
        'id_tecnico',
        'tipo',
        'fecha',
        'horario',
        'observaciones_tecnico',
        'observaciones_reporte'
    ];
}