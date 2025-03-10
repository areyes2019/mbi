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
        'atendido_por',
        'aceptado',
        'rechazado',
        'rechazo_razon',
        'atendido_rol',
        'tipo',
        'tipo_txt',
        'leido',
        'dia',
        'hora',
        'horario',
        'terminado',
        'terminado_fecha',
        'fecha_leido',
        'fecha_enviado',
        'enviado',
        'costo_total'
    ];
    
}