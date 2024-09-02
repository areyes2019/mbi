<?php namespace App\Models;

use CodeIgniter\Model;

class EquiposClienteModel extends Model
{
    protected $table      = 'mbi_equipos_cliente';
    protected $primaryKey = 'id_equipo';

    protected $allowedFields = ['equipo', 'marca', 'modelo', 'inventario', 'no_serie', 'img', 'id_cliente'];

}