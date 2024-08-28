<?php 

namespace App\Models;
use CodeIgniter\Model;

class HorariosModel extends Model
{
    protected $table = 'mbi_horarios_atencion';
    protected $primaryKey = 'id_horario';
    protected $allowedFields = [
        'dia',
        'hora_inicio',
        'hora_fin',
        'id_cliente'
    ];
}