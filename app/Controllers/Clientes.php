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
		    'empresa' => $this->request->getvar('empresa'),
		    'contacto' => $this->request->getvar('contacto'),
		    'calle' => $this->request->getvar('calle'),
		    'numero_ext' => $this->request->getvar('ext'),
		    'numero_int' => $this->request->getvar('int'),
		    'colonia' => $this->request->getvar('colonia'),
		    'ciudad' => $this->request->getvar('ciudad'),
		    'estado' => $this->request->getvar('estado'),
		    'ubicacion' => $this->request->getvar('ubicacion'),
		    'telefono' => $this->request->getvar('fijo'),
		    'movil' => $this->request->getvar('movil'),
		    'correo' => $this->request->getvar('correo'),
		];
		if ($model->insert($data)) {
			echo true;	
		}
		//return redirect()->to('/clientes');
	}
	public function editar($id)
	{

		$model = new ClientesModel();
		$resultado = $model->where('idCliente',$id)->findAll();
		$nombre = $resultado[0]['nombre'];
		$data = ['clientes'=>$resultado,'nombre'=>$nombre];
		return view('Panel/editar_cliente',$data);

	}
	public function actualizar()
	{
		

		$modelo = new ClientesModel();
		$id = $this->request->getPost('idcliente');
		$data = [
			'nombre'=> $this->request->getPost('nombre'),
			'correo' => $this->request->getPost('correo'),
			'direccion' => $this->request->getPost('direccion'),
			'telefono' => $this->request->getPost('telefono'),
			'ciudad' => $this->request->getPost('ciudad'),
			'estado' => $this->request->getPost('estado'),
			'cp' =>$this->request->getPost('cp'),
			'descuento' =>$this->request->getPost('descuento'),
		];
		$modelo->update($id,$data);
		return redirect()->to('/clientes');
	}
	public function eliminar($id)
	{
		$modelo = new ClientesModel();
		$modelo->delete($id);
		return redirect()->to('/clientes');

	}
}