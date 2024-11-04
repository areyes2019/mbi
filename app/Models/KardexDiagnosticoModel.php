<?php

namespace App\Models;

use CodeIgniter\Model;

class KardexDiagnosticoModel extends Model
{
    protected $table            = 'mbi_kardex_diagnostico';
    protected $primaryKey       = 'id_detalle_kardex';
    protected $allowedFields    = [

        'id_detalle_kardex',
        'diagnostico',
        'reparacion',
        'tiempo_entrega',
        'precio_estimado',
    ];

}
