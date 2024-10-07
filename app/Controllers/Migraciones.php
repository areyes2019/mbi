<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use Throwable;
class Migraciones extends BaseController
{
    
    public function index()
    {
        return view('bases_datos');
    }

    public function up()
    {
        $migration = \Config\Services::migrations();
        try {
            if ($migration->latest()) {
               return redirect('base');
            }
        } catch (Throwable $e) {
            echo $e;
        }
    }
    public function down()
    {
        // 0 = todas las migraciones, limpia totalmente la base de datos
        // 1,2 etc seleciona el numero de batch que deseas eliminar
        // -1 la ultima migracion

        $migration = \Config\Services::migrations();

        try {
               
            if ($migration->regress(0)) {
               return redirect('base');
            }
            
           } catch (Throwable $e) {
               echo $e;
        }   
    }
    public function batch()
    {
        $request = \Config\Services::request();
        $id = $this->request->getPost('pasos');
        $migration = \Config\Services::migrations();
        try {
            if ($migration->regress($id)) {
                return redirect('base');
            }
               
           } catch (Throwable $e) {
               echo $e;
        }

        // php spark migrate:rollback -b 1  <- este es el numero de migraciones que deseas regresar
    }
}
