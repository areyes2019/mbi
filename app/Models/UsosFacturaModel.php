<?php 

namespace App\Models;
use CodeIgniter\Model;

class UsosFacturaModel extends Model
{
    protected $table = 'mib_usos_factura';
    protected $primaryKey = 'clave';
    protected $allowedFields = [
        'descripcion',
        
    ];
}