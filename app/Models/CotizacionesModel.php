<?php 

namespace App\Models;
use CodeIgniter\Model;

class CotizacionesModel extends Model
{
    protected $table = 'mbi_cotizaciones';
    protected $primaryKey = 'id_cotizacion';
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';  // Campo para created_at
    protected $updatedField  = 'updated_at';
    protected $allowedFields = [
        'slug',
        'id_cliente',
        'estatus',
        'validez',
        'id_kardex',
        'total',
        'id_cotizacion',
        'atendido_por'
    ];

}