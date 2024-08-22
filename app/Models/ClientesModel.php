<?php 

namespace App\Models;
use CodeIgniter\Model;

class ClientesModel extends Model
{
    protected $table = 'mbi_clientes';
    protected $primaryKey = 'id_cliente';
    protected $allowedFields = [
        'titular',
        'responsable',
        'telefono',
        'extencion',
        'movil',
        'direccion',
        'ubicacion',
        'laboratorio',
        'piso',
        'correo',
    ];
}