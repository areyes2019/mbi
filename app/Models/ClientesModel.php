<?php 

namespace App\Models;
use CodeIgniter\Model;

class ClientesModel extends Model
{
    protected $table = 'mbi_clientes';
    protected $primaryKey = 'id_cliente';
    protected $allowedFields = [
        'empresa',
        'contacto',
        'calle',
        'numero_ext',
        'numero_int',
        'colonia',
        'ciudad',
        'estado',
        'ubicacion',
        'telefono',
        'movil',
        'correo'
    ];
}