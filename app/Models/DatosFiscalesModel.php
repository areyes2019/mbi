<?php 

namespace App\Models;
use CodeIgniter\Model;

class DatosFiscalesModel extends Model
{
    protected $table = 'mbi_direccion_fiscal';
    protected $primaryKey = 'id_fiscal';
    protected $allowedFields = [
        'nombre',
        'calle',
        'numero_ext',
        'numero_int',
        'colonia',
        'ciudad',
        'estado',
        'cp',
        'regimen',
        'rfc',
        'correo',
        'id_cliente',
    ];
}