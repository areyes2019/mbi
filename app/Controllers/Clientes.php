<?php

namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\ClientesModel;
use App\Models\DatosFiscalesModel;
use App\Models\RegimenFiscalModel;
use App\Models\HorariosModel;

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
		$model = new DatosFiscalesModel();
		$resultado = $model->where('id_cliente',$id)->countAllResults();

		if ($resultado > 0) {
			$datos_fiscales = 1;
		}else{
			$datos_fiscales = 0;
		}
		
		$modelo = new ClientesModel();
		$resultado = $modelo->where('id_cliente',$id)->findAll();
		$nombre = $resultado[0]['titular'];
		$id = $resultado[0]['id_cliente'];

		//pasar la lista de regimenes fiscales

		$fiscal = new RegimenFiscalModel();
		$resultado = $fiscal->findAll();

		$data = [
			'id_cliente'=>$id,
			'nombre'=>$nombre,
			'si_hay_datos'=>$datos_fiscales,
			'regimenes'=>$resultado
		];
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
		
		$request = \Config\Services::request();
		$modelo = new ClientesModel();
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
	public function agregar_datos_fiscales()
	{
		$model = new DatosFiscalesModel();
		$request = \Config\Services::request();
			
		$empresa 	= 	$this->request->getvar('nombre');
		$calle 		=	$this->request->getvar('calle');
		$ext 		=	$this->request->getvar('numero_ext');
		$int 		=	$this->request->getvar('numero_int');
		$colonia  	=	$this->request->getvar('colonia');
		$estado 	=	$this->request->getvar('estado');
		$cp 		=	$this->request->getvar('cp');
		$regimen 	=	$this->request->getvar('regimen');
		$ciudad 	=	$this->request->getvar('ciudad');
		$rfc 		=	$this->request->getvar('rfc');
		$correo =		$this->request->getvar('correo');
		$cliente =		$this->request->getvar('cliente');

		$data = [
			'nombre' 		=> $empresa ,
			'calle' 		=> $calle,
			'numero_ext' 	=> $ext,
			'numero_int' 	=> $int,
			'colonia' 		=> $colonia,
			'ciudad' 		=> $ciudad,
			'estado' 		=> $estado,
			'cp' 			=> $cp,
			'regimen' 		=> $regimen,
			'rfc' 			=> $rfc,
			'correo' 		=> $correo,
			'id_cliente' 	=> $cliente,
		];



		if ($model->insert($data)) {
			echo 1;
		}

	}
	public function mostrar_datos_fiscales($id)
	{
		$model = new DatosFiscalesModel();
		$model->where('id_cliente', $id);
		$resultado = $model->findAll();
		return json_encode($resultado);
	}
	public function actualizar_datos_fiscales()
	{
		$query = new DatosFiscalesModel();
		
		$datos = $this->request->getJSON();

		if ($datos) {

			$data = [
				'nombre' => $datos->nombre ?? '',
		        'calle' => $datos->calle ?? '',
		        'numero_ext' => $datos->numero_ext ?? '',
		        'numero_int' => $datos->numero_int ?? '',
		        'colonia' => $datos->colonia ?? '',
		        'ciudad' => $datos->ciudad ?? '',
		        'estado' => $datos->estado ?? '',
		        'cp' => $datos->cp ?? '',
		        'regimen' => $datos->regimen ?? '',
		        'rfc' => $datos->rfc ?? '',
		        'correo' => $datos->correo ?? ''
		    	];
		    $id = $datos->id_fiscal ?? null;
		    if ($id) {
		    	if ($query->update($id,$data)) {
		    		echo 1;
		    	}else{
		    		echo 0;
		    	}
		    }else{
		    	echo "id de cliente no valido";
		    }
		}else{
			echo "Datos no validos";
		}



	}
	public function agregar_horario()
	{
		//$request = \Config\Services::request();

		$horariosModel = new HorariosModel();
		$data = $this->request->getJSON();

		//return json_encode($data->cliente);
		
		if ($data && isset($data->horarios)) {
			$horarios = $data->horarios;
			//preparamos un array para insertar
			$data_a_insertar = [];

			foreach ($horarios as $horario) {
				$id_cliente = $data->cliente;
				$data_a_insertar[] = [
					'dia' => $horario->dia,
					'hora_inicio' => $horario->horaInicio,
					'hora_fin' => $horario->horaFin,
					'id_cliente'=> $id_cliente
				];
			}
			if ($horariosModel->insertBatch($data_a_insertar)) {
				echo 1;
			}else{
				echo 0;
			}
		}

	}
	public function ver_horarios($id)
	{
		$cuenta = new HorariosModel();
		$cuenta->where('id_cliente',$id);
		$total = $cuenta->countAllResults();
		

		$model = new HorariosModel();
		$model->where('id_cliente', $id);
		$resultado = $model->findAll(); 
		
		$data = [
			'query'=>$resultado,
			'cuenta'=>$total,
		];
		return json_encode($data);
	}
	public function eliminar_horario($id)
	{
		$model = new HorariosModel();
		if ($model->delete($id)) {
			echo 1;
		}
	}
	public function actualizar_hora()
	{
		$model = new HorariosModel();
		$data = $this->request->getJSON();

		$id = $data->id_horario;

		$datos = [
			'dia' => $data->dia,
			'hora_inicio' => $data->hora_inicio,
			'hora_fin' => $data->hora_fin,
		];

		if ($model->update($id,$datos)) {
			echo 1;
		}

	}
}