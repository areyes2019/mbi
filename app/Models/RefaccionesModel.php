<?php 

namespace App\Models;
use CodeIgniter\Model;

class RefaccionesModel extends Model
{
    protected $table = 'mbi_refacciones';
    protected $primaryKey = 'id_refaccion';
    protected $allowedFields = [
        'refaccion',
        'marca',
        'modelo',
        'precio',
        'id_diagnostico'
    ];
}