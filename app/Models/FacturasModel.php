<?php 

namespace App\Models;
use CodeIgniter\Model;

class FacturasModel extends Model
{
    protected $table = 'mbi_factura';
    protected $primaryKey = 'id_folio';
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';  // Campo para created_at
    protected $updatedField  = 'updated_at';
    protected $allowedFields = [
        'serie_emisor',
        'id_cliente',
        'id_cotizacion',
        'estatus',
        'entidad'
    ];

}