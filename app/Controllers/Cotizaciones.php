<?php

namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\CotizacionesModel;
use App\Models\ClientesModel;
use App\Models\ArticulosModel;
use App\Models\DetalleModel;
use App\Models\KardexModel;
use App\Models\MensajeModel;
use App\Models\KardexDetalleModel;
use App\Models\KardexDiagnosticoModel;
use App\Models\RefaccionesModel;
use App\Models\DetalleDetalleModel;
use App\Models\UsuariosModel;
use App\Models\EntidadesModel;
use Dompdf\Dompdf;
class Cotizaciones extends BaseController
{
	public function index()
	{
		$entidad = new EntidadesModel();
		$entidades = $entidad->select('id_entidad, razon_social')->findAll();

		$db = \Config\Database::connect();

		$builder = $db->table('mbi_cotizaciones');
		$builder->join('mbi_clientes','mbi_clientes.id_cliente = mbi_cotizaciones.id_cliente');
		$resultado = $builder->get()->getResultArray();
		//$data['cotizaciones'] = $resultado;
		
		$clientes = new ClientesModel();
		$data_cliente = $clientes->findAll();

		$data = [
			'cotizaciones'=>$resultado,
			'clientes'=>$data_cliente,
			'entidades'=>$entidades,
		];

		return view('cotizaciones',$data);
	}
	public function independiente($id)
	{

		// Generar un slug aleatorio
	    $caracteres_permitidos = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
	    $longitud = 12;
	    $slug = substr(str_shuffle($caracteres_permitidos), 0, $longitud);

	    
	    //buscamos a quien genera la cotización
	    $usuario = session('id_usuario');

	    //generamos la cotización

	    $cotizacion = new CotizacionesModel();
	    $data = [
	    	'slug'=>$slug,
	    	'generado_por'=>$usuario

	    ];
	    
	    if ($cotizacion->insert($data)) {
	    	return view('pagina_cotizador_independiente',$data);
	    }



	}
	public function nueva()
	{
		// Obtener el ID del Kardex desde la solicitud
	    $id = $this->request->getVar('id');
		$entidad = $this->request->getvar('entidad'); 

	    // Obtener el registro del cliente usando el ID de Kardex
	    $kardexModel = new KardexModel();
		$clienteData = $kardexModel->select('id_cliente, generado_por')->where('id_kardex', $id)->first();

	    if (!$clienteData) {
	        return json_encode(['hecho' => 0, 'mensaje' => 'Cliente no encontrado']);
	    }

	    $id_cliente = $clienteData['id_cliente'];

	    // Generar un slug aleatorio
	    $caracteres_permitidos = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
	    $longitud = 12;
	    $slug = substr(str_shuffle($caracteres_permitidos), 0, $longitud);

	    // Crear el registro de la cotización
	    $cotizacionesModel = new CotizacionesModel();
	    $data = [
	        'slug' => $slug,
	        'id_cliente' => $id_cliente,
	        'id_kardex' => $id,
	        'estatus' => 9,
	        'atendido_por'=>$clienteData['generado_por'],
	        'aprobado_por'=>session('id_usuario'),
	        'total'=> 0,
	    ];

	    //sacamos la cotizacin
	    // Intentar la inserción y verificar el ID insertado
	    

	    if ($cotizacionesModel->insert($data)){
	    	return json_encode([
	    		'estado'=>1,
	    		'mensaje'=>'Cotización creada con éxito',
	    		'slug'=>$slug,
	    	]);

	    }else{
	    	return json_encode([
	    		'mensaje'=>'Error al crear la cotización',
	    	]);
	    }

	    /*if ($cotizacionesModel->db->affectedRows() > 0) { // Confirma que el registro fue insertado
	        // Actualizar el estatus de Kardex
	        $kardexUpdate = ['estatus' => 8];
	        $kardexModel->update($id, $kardexUpdate);
	        
	        //sacamos el id de la cotizacion

	        $id_cotizacion = new CotizacionesModel();
	        $id_cotizacion->select('id_cotizacion')->where()

	        //agregamos linea de detalle 
	    	$detalle = new DetalleModel();
	    	$data_detalle = [
	    		'cantidad'=> 1,
	    		'partida'=> 1,
	    		'precio_unitario'=> $clienteData['costo_total'],
	    		'total'=>$clienteData['costo_total'],
	    		'id_cotizacion'=> $id
	    	];
	    	$detalle->insert($data_detalle);

	        return json_encode([
	            'hecho' => 1,
	            'slug' => $slug,
	            'id' => $id,
	            'mensaje' => 'Cotización creada exitosamente'
	        ]);

	    } else {
	        return json_encode([
	            'hecho' => 0,
	            'mensaje' => 'Error al crear la cotización'
	        ]);
	    }*/
	}
	public function pagina($slug)
	{
		$db = \Config\Database::connect();
		$cotizacion_id = $this->request->uri->getSegment(2);
		
		
		//encongrar cotizacion
		$cotizacion = $db->table('mbi_cotizaciones');
		$cotizacion->join('mbi_clientes', 'mbi_cotizaciones.id_cliente = mbi_clientes.id_cliente');
		$cotizacion->where('slug',$cotizacion_id);
		$resultado_cotizacion = $cotizacion->get()->getResultArray();

		//return json_encode($total);

		$kardex = new KardexModel();
		$resultado_kardex = $kardex->select('id_kardex')->where('id_kardex',$resultado_cotizacion[0]['id_kardex'])->first();

		//econtrar los diagnosticos

		$detalles = new KardexDetalleModel();
		$detalles->where('id_kardex', $resultado_kardex['id_kardex']);
		$resultado_detalles = $detalles->findAll();

		$diagnostico = new KardexDiagnosticoModel();
		$diagnostico->where('id_detalle_kardex', $resultado_detalles[0]['slug']);
		$resultado_diagnostico = $diagnostico->findAll();



		//encontramos las refacciones

		$refaccion = new RefaccionesModel();
		$refaccion->where('id_diagnostico', $resultado_diagnostico[0]['id_detalle_kardex']);
		$resultado_refaccion = $refaccion->findAll();

		$data = [
			'cotizacion'=>$resultado_cotizacion,
			'diagnostico'=>$resultado_diagnostico,
			'refacciones'=>$resultado_refaccion,
			'slug'=>$resultado_kardex['id_kardex'],
		
		];

		return view('nueva_cotizacion',$data);

		
	}
	public function editar()
	{
		return view('Panel/editar_cotizacion');
	}
	public function agregar()
	{
		$model = new DetalleModel();
		$servicio = $this->request->getvar('servicio');
		$cotizacion = $this->request->getvar('cotizacion');
		$partida = 1;
		$cantidad = 1;

		$data = [
			'cantidad'=>$cantidad,
			'partida'=>$partida,
			'descripcion'=>$servicio,
			'id_cotizacion'=>$cotizacion
		];

		if ($model->insert($data)) {
			echo 1;
		}

	}
	public function modificar_cantidad()
	{
		$db = \Config\Database::connect();
		$request = \Config\Services::Request();
		$id = $request->getvar('id');
		$cant = $request->getvar('cantidad');
		$descuento = $request->getvar('descuento');
		
		//sacamos el precio del articulo
		$linea = new DetalleModel();
		$linea->where('idDetalle',$id);
		$resultado = $linea->findAll();
		$id_articulo = $resultado[0]['id_articulo'];
		$cotizacion = $resultado[0]['id_cotizacion'];
		
		/*$datos =[
			'articulo'=>$id_articulo,
			'cotizacion'=>$cotizacion,
		];

		return json_encode($datos);*/

		$articulo_consulta = new ArticulosModel();
		$articulo_consulta->where('idArticulo',$id_articulo);
		$articulo_consulta_resultado = $articulo_consulta->findAll();

		$nueva_inversion = $articulo_consulta_resultado[0]['precio_prov'] * $cant;
		$nuevo_total = $resultado[0]['p_unitario'] * $cant;
		$datos['cantidad'] = $cant;
		$datos['total'] = $nuevo_total;
		$datos['inversion'] = $nueva_inversion;
		$linea->update($id,$datos);

		//actualizar los totales
		$builder = $db->table('sellopro_detalles');
		$builder->where('id_cotizacion',$cotizacion);
		$builder->selectSum('total');
		$sum = $builder->get()->getResultArray();
		$suma_total = $sum[0]['total'];
		
		$suma_con_desc = $suma_total-($suma_total*$descuento/100);
		$suma_desc = ($suma_total*$descuento/100);
		$total = new CotizacionesModel();
		
		$datos['total'] = $suma_con_desc;
		$datos['descuento'] = $suma_desc;

		$total->update($cotizacion,$datos);


	}
	public function agregar_ind($slug)
	{

		$request = \Config\Services::request();
		// Conectar a la base de datos y cargar los modelos necesarios
		$model = new DetalleModel();
		$totalModel = new CotizacionesModel();
		$db = \Config\Database::connect();

		// Obtener datos JSON de la solicitud
		$requestData = $request->getJSON(true);

		//agregamos el iva
		$precio = $requestData['p_unitario'];
		$precio_con_iva = ($requestData['p_unitario'] ?? 0) * 1.16;
		$iva = $precio_con_iva - $precio;

		$data = [
		    'descripcion' => $requestData['descripcion'] ?? '',
		    'precio_unitario' => $precio,
		    'iva'=>$iva,
		    'id_cotizacion' => $requestData['id_cotizacion'] ?? '',
		    'total' => $precio_con_iva,
		];

		if ($slug != 'independiente') {
			$agregado['agregado']= 1;	
			//atcualizar el diagnostico para que aparezca agregado
			$diagnostico  = new KardexDiagnosticoModel();
			$diagnostico->update($slug,$agregado);
		}


		// Insertar el detalle en la base de datos
		$model->insert($data);


		// Actualizar el total en la tabla de cotizaciones
		$builder = $db->table('mbi_cotizaciones_detalles');
		$suma_total = $builder->where('id_cotizacion', $data['id_cotizacion'])
		                      ->selectSum('total')
		                      ->get()
		                      ->getRow()
		                      ->total;
		
		$totalModel->update($data['id_cotizacion'], ['total' => $suma_total]);

		// Retornar una respuesta JSON
		return $this->response->setJSON(['status' => 'success', 'total' => $suma_total]);

	}
	public function mostrar_detalles($id)
	{
		
		$detalles = new DetalleModel();
		$detalles_data = $detalles->where('id_cotizacion',$id);
		$resultado = $detalles_data->findAll();

		$total = new CotizacionesModel();
		$total->where('id_cotizacion',$id);
		$resultado_total = $total->findAll();
		return json_encode($resultado);

		// Suponiendo que el total que necesitas está en el campo 'total'
		if (!empty($resultado_total)) {
		    $valor_total = $resultado_total[0]['total'];
		    $valor_total_formateado = number_format($valor_total,2);
		    $sin_iva = $valor_total / 1.16; // Quitar el 16% de IVA
		    $sin_iva_formateado = number_format($sin_iva, 2); // Formato a dos decimales
		    $iva = $valor_total - $sin_iva;
		    $iva_formateado = number_format($iva,2);
		    
		} else {
		    echo "No se encontró la cotización con el ID especificado.";
		}

		$suma = [
			'sub_total'=>$sin_iva_formateado,
			'iva'=>$iva_formateado,
			'total'=>$valor_total_formateado
		];

		$data = [
			'detalles'=> $resultado,
			'totales'=>$suma
		];

		
	}
	public function borrar_linea_detalle($id)
	{
		
		//return json_encode($id);	

		$totalModel = new CotizacionesModel();
		$model = new DetalleModel();

		$model->where('id_cotizacion_detalle',$id);
		$resultado = $model->findAll();
		$id_cotizacion = $resultado[0]['id_cotizacion'];

		if ($model->delete($id)) {
			echo 1;

		}
		//actualizar el total en la cotizacion
		$db = \Config\Database::connect();
		// Actualizar el total en la tabla de cotizaciones
		$builder = $db->table('mbi_cotizaciones_detalles');
		$suma_total = $builder->where('id_cotizacion', $id_cotizacion)
		                      ->selectSum('total')
		                      ->get()
		                      ->getRow()
		                      ->total;

		if ($suma_total) {
		    $totalModel->update($id_cotizacion, ['total' => $suma_total]);
		} else {
		    // Manejar el caso donde la suma es cero o no hay resultados
		    $totalModel->update($id_cotizacion, ['total' => 0]);
		}

		//cambiar el 

	}
	public function eliminar($id)
	{
		
		//borramos micro datos

		//borramos detalle

		//borramos la cotizacion

		$model = new CotizacionesModel();
		if ($model->delete($id)) {
			echo 1;
		}

	}
	public function cotizacion_pdf($id)
	{

		//datos del cliente
		$cliente_query = new CotizacionesModel();
		$cliente_query->where('id_cotizacion',$id);
		$resultado_cotizacion = $cliente_query->findAll();

		$cliente = new ClientesModel();
		$cliente->where('id_cliente',$resultado_cotizacion[0]['id_cliente']);
		$resultado = $cliente->findAll();

		$detalles = new DetalleModel();
		$detalles->where('id_cotizacion',$id);
		$resultado_detalles = $detalles->findAll();

		//buscamos al usuario que genero todo
		$usuario = new UsuariosModel();
		$usuario->where('id_usuario',$resultado_cotizacion[0]['atendido_por']);
		$resultado_usuario = $usuario->findAll();

		$total_con_iva = $resultado_cotizacion[0]['total']; // Total con IVA
		$iva_porcentaje = 16; // IVA en porcentaje
		$factor_iva = 1 + ($iva_porcentaje / 100); // Calcula el factor del IVA

		$total_sin_iva = $total_con_iva / $factor_iva; // Total sin IVA
		$iva = $total_con_iva - $total_sin_iva; // Solo IVA

		$importe = number_format($total_sin_iva,2);
		$iva_formateado = number_format($iva,2);
		$total = number_format($total_con_iva,2); //total total

		//mandamos la fecha formateada
		$fechaOriginal = $resultado_cotizacion[0]['created_at'];
		// Mapas para días y meses
		$dias = ['Sunday' => 'domingo', 'Monday' => 'lunes', 'Tuesday' => 'martes', 'Wednesday' => 'miércoles', 'Thursday' => 'jueves', 'Friday' => 'viernes', 'Saturday' => 'sábado'];
		$meses = ['January' => 'enero', 'February' => 'febrero', 'March' => 'marzo', 'April' => 'abril', 'May' => 'mayo', 'June' => 'junio', 'July' => 'julio', 'August' => 'agosto', 'September' => 'septiembre', 'October' => 'octubre', 'November' => 'noviembre', 'December' => 'diciembre'];

		// Convertir la fecha y traducir
		$fecha = new \DateTime($fechaOriginal);
		$dia = $dias[$fecha->format('l')];
		$mes = $meses[$fecha->format('F')];
		// Formatear la fecha
		$fechaFormateada = ucfirst("$dia, " . $fecha->format('d') . " de $mes de " . $fecha->format('Y'));

		$data = [
			'cliente'=>$resultado,
			'id_cotizacion'=>$resultado_cotizacion,
			'detalles'=>$resultado_detalles,
			'sub_total'=>$importe,
			'iva'=>$iva_formateado,
			'total'=>$total,
			'cotizacion'=> $id,
			'usuario'=>$resultado_usuario,
			'fecha'=>$fechaFormateada
		];
		//return view('pdf/cotizacion',$data);
		$doc = new Dompdf();
		$html = view('pdf/cotizacion',$data);
		//return $html;
		$doc->loadHTML($html);
		$doc->setPaper('A4','portrait');
		$doc->render();
		$doc->stream("QT-".$id.".pdf");
	}
	private function actualizar_estatus($id)
	{
		
	}
	public function enviar_pdf($id)
	{

		//datos del cliente
		$cliente_query = new CotizacionesModel();
		$cliente_query->where('id_cotizacion',$id);
		$resultado_cotizacion = $cliente_query->findAll();

		$cliente = new ClientesModel();
		$cliente->where('id_cliente',$resultado_cotizacion[0]['id_cliente']);
		$resultado = $cliente->findAll();

		$detalles = new DetalleModel();
		$detalles->where('id_cotizacion',$id);
		$resultado_detalles = $detalles->findAll();

		//buscamos al usuario que genero todo
		$usuario = new UsuariosModel();
		$usuario->where('id_usuario',$resultado_cotizacion[0]['atendido_por']);
		$resultado_usuario = $usuario->findAll();

		$total_con_iva = $resultado_cotizacion[0]['total']; // Total con IVA
		$iva_porcentaje = 16; // IVA en porcentaje
		$factor_iva = 1 + ($iva_porcentaje / 100); // Calcula el factor del IVA

		$total_sin_iva = $total_con_iva / $factor_iva; // Total sin IVA
		$iva = $total_con_iva - $total_sin_iva; // Solo IVA

		$importe = number_format($total_sin_iva,2);
		$iva_formateado = number_format($iva,2);
		$total = number_format($total_con_iva,2); //total total

		//mandamos la fecha formateada
		$fechaOriginal = $resultado_cotizacion[0]['created_at'];
		// Mapas para días y meses
		$dias = ['Sunday' => 'domingo', 'Monday' => 'lunes', 'Tuesday' => 'martes', 'Wednesday' => 'miércoles', 'Thursday' => 'jueves', 'Friday' => 'viernes', 'Saturday' => 'sábado'];
		$meses = ['January' => 'enero', 'February' => 'febrero', 'March' => 'marzo', 'April' => 'abril', 'May' => 'mayo', 'June' => 'junio', 'July' => 'julio', 'August' => 'agosto', 'September' => 'septiembre', 'October' => 'octubre', 'November' => 'noviembre', 'December' => 'diciembre'];

		// Convertir la fecha y traducir
		$fecha = new \DateTime($fechaOriginal);
		$dia = $dias[$fecha->format('l')];
		$mes = $meses[$fecha->format('F')];
		// Formatear la fecha
		$fechaFormateada = ucfirst("$dia, " . $fecha->format('d') . " de $mes de " . $fecha->format('Y'));

		$data = [
			'cliente'=>$resultado,
			'id_cotizacion'=>$resultado_cotizacion,
			'detalles'=>$resultado_detalles,
			'sub_total'=>$importe,
			'iva'=>$iva_formateado,
			'total'=>$total,
			'cotizacion'=> $id,
			'usuario'=>$resultado_usuario,
			'fecha'=>$fechaFormateada
		];
		//return view('pdf/cotizacion',$data);
		$doc = new Dompdf();
		$html = view('pdf/cotizacion',$data);
		//return $html;
		$doc->loadHTML($html);
		$doc->setPaper('A4','portrait');
		$doc->render();

		// Guardar el PDF en un archivo temporal
        $filePath = WRITEPATH . "uploads/QT-$id.pdf";
        file_put_contents($filePath, $doc->output());

        // Configurar el correo
        $mi_email = env('MY_GLOBAL_VAR');
        $email = \Config\Services::email();
        $email->setFrom($mi_email, 'Grupo MBI');
        $email->setTo($resultado_usuario[0]['correo']); // Cambia por el correo del destinatario
        $email->setSubject("Cotización QT-$id");
        $email->setMailType('html');
        // Definir el contenido HTML del correo
		
		$htmlContent = view('email/enviar_cotizacion');
        $email->setMessage($htmlContent);
        $email->attach($filePath);

        // Enviar el correo
        if ($email->send()) {     	
            $model = new CotizacionesModel();
			$model->where('id_cotizacion',$id);
			$id = $model->findAll();
			$estatus = $id[0]['estatus'];
			$cot = $id[0]['id_cotizacion'];
			$data = [
				'estatus'=> 10
			];
			if ($estatus==9) {
				$model->update($cot,$data); //si el estatus de 9 lo cambiamos a 10
			}else{
				//return "no se puede actualizar";
			}
			echo 1;
        } else {
            echo "Error al enviar el correo: " . $email->printDebugger(['headers']);
        }

        // Eliminar el archivo temporal
        unlink($filePath);

	}
	public function pago()
	{
		//Traemos lo que viene en el input
		$request = \Config\Services::Request();
		$id_cotizacion = $request->getvar('id');
		$monto = $request->getvar('pago');
		

		//verifciamos si hay dinero en el campo pago
		$query = new CotizacionesModel();
		$query->where('idQt',$id_cotizacion);
		$resultado = $query->findAll();
		$hay_pago = $resultado[0]['pago'];

		//return json_encode($monto);

		if ($hay_pago == 0) {
			$data=[
				'pago'=>$monto,
			];
			$query->update($id_cotizacion,$data);
			
		}else{
			$abono = $hay_pago + $monto;
			$data=[
				'pago'=>$abono,
			];
			$query->update($id_cotizacion,$data);
		}

	}
	public function entregado()
	{
		$request = \Config\Services::Request();
		$request->getvar('id');

		//vamos a descontar los valores del inventario
		$query_detalles = new DetalleModel();
		$query_detalles->where('id_cotizacion',$request->getvar('id'));
		$resultado = $query_detalles->findAll();

		return json_encode($resultado);

	}
	public function ver_diagnostico_kardex($id)
	{
		//sacamos el kardex
		$cotizacionModel = new CotizacionesModel();
		$resultado_cotizacion = $cotizacionModel->select('id_kardex')->where('id_cotizacion',$id)->first();
		
		//sacamos el slug del detalle para poder sacar el diagnostico
		$detalle_kardex = new KardexDetalleModel();
		$resultado_kardex = $detalle_kardex->select('slug')->where('id_kardex',$resultado_cotizacion['id_kardex'])->first();

		$id = $resultado_kardex['slug'];
		
		//ahora vamos por el disgnostico
		$diagnostico = new KardexDiagnosticoModel();
		$diagnostico->where('id_detalle_kardex',$id);
		$resultado_diagnostico = $diagnostico->findAll();

		//y las refacciones 

		$refaccion = new RefaccionesModel();
		$refaccion->where('id_diagnostico',$resultado_diagnostico[0]['id_detalle_kardex']);
		$resultado_refaccion = $refaccion->findAll();

		$data = [
			'diagnostico'=>$resultado_diagnostico,
			'refacciones'=>$resultado_refaccion,
		];
		return json_encode($data);

	}
	public function clonar($slug)
	{
		//vamos a buscar la cotizacion con este slug
		$model = new CotizacionesModel();
		$model->where('slug',$slug);
		$resultado = $model->findAll();

	    //Generar un slug aleatorio
	    $caracteres_permitidos = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
	    $longitud = 12;
	    $slug = substr(str_shuffle($caracteres_permitidos), 0, $longitud);

	    

	    // Crear el registro de la cotización
	    $cotizacionesModel = new CotizacionesModel();
	    $data = [
	        'id_cotizacion' => $kardex_id,
	        'slug' => $slug,
	        'id_cliente' => $id_cliente,
	        'id_kardex' => $id,
	        'estatus' => 1,
	        'atendido_por'=>$clienteData['generado_por']
	    ];

	}
	public function facturar()
	{
		
	}
	public function condiciones()
	{
		$model = new CotizacionesModel();

		$id = $this->request->getvar('cotizacion');
		$condiciones = $this->request->getvar('condiciones');
		$entrega = $this->request->getvar('entrega');
		$garantia = $this->request->getvar('garantia');

		$data = [
			'condiciones'=>$condiciones,
			'entrega'=>$entrega,
			'garantia'=>$garantia
		];

		//return json_encode($data);

		if ($model->update($id,$data)) {
			echo 1;
		}

	}
	public function cambiar_moneda()
	{
		$model = new CotizacionesModel();
		$id = $this->request->getvar('cotizacion');
		$moneda = $this->request->getvar('moneda');

		$data['moneda'] = $moneda; 
		if ($model->update($id,$data)) {
			echo 1;
		}
	}
	public function accion()
	{
		$cotizacion = $this->request->getvar('cotizacion');
		$accion = $this->request->getvar('accion');

		$model = new CotizacionesModel();

		if ($accion == 1) {
			$data['estatus'] = 11;
			if ($model->update($cotizacion,$data)) {
				echo 1;
			}	
		}else if($accion==2){
			$data['estatus'] = 12;
			if ($model->update($cotizacion,$data)) {
				echo 1;
			}	
		}
	}
	public function mostrar_entidades()
	{
		$model = new EntidadesModel();
		$resultado = $model->findAll();
		return json_encode($resultado);
	}
	public function agregar_inner()
	{
		$detalleModel = new DetalleDetalleModel();
        // Obtener datos enviados por Axios
        $data = $this->request->getJSON(true); // Decodifica JSON

        $id_detalle = $data['id_detalle']; // Obtenemos el id_diagnostico
        $detalle = $data['detalles'];


        // Validar si se enviaron refacciones
        if (!isset($detalles) || empty($detalles)) {
            echo 1;
        }

        // Guardar cada refacción en la base de datos con el id_diagnostico
        foreach ($detalle as $data_detalle) {
            $detalleModel->insert([
                'id_detalle' => $id_detalle,   // Se añade el id_diagnostico
                'detalles' => $data_detalle['detalles'],
            ]);
        }
        echo 1;
	}
	public function ver_microdados($id)
	{
		//sacamos el detalle
		$model = new DetalleModel();
		$model->where('id_cotizacion',$id);
		$resultado_cotizacion = $model->findAll();

		//sacamos los microdatos
		if ($resultado_cotizacion) {
			$micro = new DetalleDetalleModel();
			$micro->where('id_detalle',$resultado_cotizacion[0]['id_cotizacion_detalle']);
			$resultado = $micro->findAll();
			return json_encode($resultado);
			
		}else{
			return json_encode(0);
		}


	}
	public function eliminar_micro($id)
	{
		$model = new DetalleDetalleModel();
		if ($model->delete($id)) {
			echo 1;
		}
	}
}