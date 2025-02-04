<?php 

namespace App\Models;
use CodeIgniter\Model;

class DetalleModel extends Model
{
    protected $table = 'mbi_cotizaciones_detalles';
    protected $primaryKey = 'id_cotizacion_detalle';
    protected $allowedFields = [
        'cantidad',
        'partida',
        'precio_unitario',
        'clave',
        'descripcion',
        'iva',
        'total',
        'id_cotizacion',
        'diagnostico',
    ];
}