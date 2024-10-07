<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ActualizarTablaEjemplo extends Migration
{
    
    public function up()
    {
    
        $this->forge->addColumn('mib_prueba', [
            'nuevo_campo1' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => false,
            ],
            'nuevo_campo2' => [
                'type' => 'INT',
                'null' => false,
                'default' => 0,
            ],
        ]);
    }
    public function down()
    {
        $this->forge->dropColumn('nombre_de_la_tabla', ['nuevo_campo1', 'nuevo_campo2']);
    }
}
