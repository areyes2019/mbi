<?php

namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\ClientesModel;

class Clientes extends BaseController
{
	public function index()
	{
		$model = new ClientesModel();
		$data['clientes'] = $model->findAll();
		return view('clientes', $data);
	}
	public function agregar()
	{
		return view('nuevo_cliente');
	}
	public function nuevo()
	{
		$request = \Config\Services::request();
		$model = new ClientesModel();
		$data = [
		    'titular' => $this->request->getvar('titular'),
		    'responsable' => $this->request->getvar('responsable'),
		    'telefono' => $this->request->getvar('telefono'),
		    'extencion' => $this->request->getvar('extencion'),
		    'movil' => $this->request->getvar('movil'),
		    'correo' => $this->request->getvar('correo'),
		    'direccion' => $this->request->getvar('direccion'),
		    'ubicacion' => $this->request->getvar('ubicacion'),
		    'laboratorio' => $this->request->getvar('laboratorio'),
		    'piso' => $this->request->getvar('piso'),
		];
		if ($model->insert($data)) {
			echo 1;	
		}
		
		//return json_encode($data); //redirect()->to('/clientes');
	}
	public function editar($id)
	{
		$model = new ClientesModel();
		$resultado = $model->where('id_cliente',$id)->findAll();
		$nombre = $resultado[0]['titular'];
		$id = $resultado[0]['id_cliente'];
		$data = ['id_cliente'=>$id,'nombre'=>$nombre];
		return view('editar_cliente', $data);
	}
	public function mostrar_cliente($id){
		$model = new ClientesModel();
		$model->where('id_cliente',$id);
		$resultado = $model->findAll();

		return json_encode($resultado);
	}
	public function actualizar()
	{
		
		$modelo = new ClientesModel();
		$request = \Config\Services::request();
		$datos = $this->request->getvar()[0];
		$id = $datos->id_cliente;
		$data = [
			'correo' => $datos->correo,
			'direccion'=> $datos->direccion,
			'extencion' => $datos->extencion,
			'laboratorio' => $datos->laboratorio,
			'movil' => $datos->movil,
			'piso' =>$datos->piso,
			'responsable' =>$datos->responsable,
			'telefono' =>$datos->telefono,
			'titular' =>$datos->titular,
			'ubicacion' =>$datos->ubicacion,
		];
		if ($modelo->update($id,$data)) {
			echo 1;
		}
		
	}
	public function eliminar($id)
	{
		$modelo = new ClientesModel();
		$modelo->delete($id);
		return redirect()->to('/clientes');

	}
}