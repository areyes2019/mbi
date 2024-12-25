<?php

namespace App\Models;

use CodeIgniter\Model;

class EntidadesModel extends Model
{
    // Nombre de la tabla en la base de datos
    protected $table = 'mbi_entidades';

    // Clave primaria de la tabla
    protected $primaryKey = 'id_entidad';

    // Indica que el campo primaryKey se autoincrementa
    protected $useAutoIncrement = true;

    // Tipo de dato devuelto (array u objeto)
    protected $returnType = 'array';

    // Define qué campos pueden ser manipulados mediante insert/update
    protected $allowedFields = [
        'razon_social',
        'cp',
        'calle',
        'num_int',
        'num_ext',
        'colonia',
        'ciudad',
        'estado',
        'regimen',
        'correo',
        'telefono',
        'rfc'
    ];

    // Si deseas usar las marcas de tiempo (created_at, updated_at)
    // descomenta las siguientes líneas y ajusta a tu tabla:
    // protected $useTimestamps = false;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    
}
