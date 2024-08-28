<?php 

namespace App\Models;
use CodeIgniter\Model;

class RegimenFiscalModel extends Model
{
    protected $table = 'mbi_regimenes_fiscales';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'codigo',
        'nombre',
    ];
}