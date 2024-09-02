<?php

namespace App\Controllers;
use App\Models\Model;

use CodeIgniter\Controller;

class Ejemplo extends Controller
{
	public function index()
	{
		
	}

	public function insertar()
		{
			$model = new Model();
			$data = ->request->getJSON();
			$insertar = [
				'campo'=> $data->nombre,
				'campo'=> $data->nombre,
				'campo'=> $data->nombre,
				'campo'=> $data->nombre,
			];
			if ($model->insert($data)) {
				echo 1;
			}
		}
		public function editar_ajax()
		{
			$model = new Model();
			$data = $this->request->getJSON();
			$id = $data->id_algo;
			$insertar = [
				'campo'=>\->algo,
				'campo'=>\->algo,
				'campo'=>\->algo,
			];
	
			if ($model->update($id,$data)) {
				echo 1;
			}
		}
		public function editar()
		{
			$model = new Model();
			$model->where('id_algo',);
			$resultado = $model->findAll();
			$data=[
				'datos' => $resultado
			];
	
			return view('view_name',$data);
		}
		public function actualizar()
		{
			$model = new Model();
			$data = ->request->getPost();
			$insertar = [
				'campo'=>$data->algo,
				'campo'=>$data->algo,
				'campo'=>$data->algo,
			];
	
			if ($model->update($id,$data)) {
				return redirect()->to('url');
			}
		}
		public function eliminar()
		{
			$model = new Model();
			$model->delete($id);
			return redirect()->to('ruta');
		}
		public function eliminar_ajax()
		{
			$model = new Model();
			if ($model->delete($id)) {
				echo 1;
			}
		}
	public function con_archivo()
	{
		\$model = new Model();
		\$data = \$this->request->getvar();
		\$archivo = \$this->request->getFile('foto');
		if (\$archivo && !\$archivo->hasMoved()) {
			\$ruta = ROOTPATH . 'public/carpeta';
			\$nuevo_nombre = \$archivo->getRandomName();
			\$archivo->move(\$ruta,\$nuevo_nombre);


			\$data = [
				'campo'=>\$data['algo'],
				'campo'=>\$data['algo'],
				'img'=>'public/equipos/'.\$nuevo_nombre,
				'id_cliente'=>\$data['id_cliente'],
			];

			if (\$model->insert(\$data)) {
				echo 1;
			}

		}else{
			echo "no hay archivo";
		}
	}
}
