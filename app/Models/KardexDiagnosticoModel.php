<?php

namespace App\Models;

use CodeIgniter\Model;

class KardexDiagnosticoModel extends Model
{
    protected $table            = 'mbi_kardex_diagnostico';
    protected $primaryKey       = 'id_diagnostico';
    protected $allowedFields    = [
        'id_diagnostico',
        'diagnostico',
        'reparacion',
        'tiempo_entrega',
        'precio_estimado',
        'agregado',
        'id_kardex'
    ];

}
