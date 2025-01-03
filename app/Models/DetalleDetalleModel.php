<?php 

namespace App\Models;
use CodeIgniter\Model;

class DetalleDetalleModel extends Model
{
    protected $table = 'mbi_lista_detalle';
    protected $primaryKey = 'id_lista';
    protected $allowedFields = [
        'detalles',
        'id_detalle',
    ];
}