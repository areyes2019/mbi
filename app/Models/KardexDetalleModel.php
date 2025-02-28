<?php

namespace App\Models;

use CodeIgniter\Model;

class KardexDetalleModel extends Model
{
    protected $table            = 'mbi_kardex_detalle';
    protected $primaryKey       = 'id_detalle';
    protected $allowedFields    = [
        'nombre',
        'marca',
        'modelo',
        'serie',
        'inventario',
        'falla',
        'id_kardex',
    ];

    
}
