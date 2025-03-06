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
	const IVA_PORCENTAJE = 16;
	public function index()
	{
		$entidad = new EntidadesModel();
		$entidades = $entidad->findAll();

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
		// Obtener el ID del Kardex desde la solicitud y la entidad
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
	        'entidad'=>$entidad,
	        'total'=> 0,
	    ];

	    
	    $insert = $cotizacionesModel->insert($data);
    	//acutualizar el estaus del kardex
        $kardexUpdate = ['estatus' => 8];
        $update = $kardexModel->update($id, $kardexUpdate);

	    if ($insert == true && $update == true){
	        
	    	return json_encode([
	    		'flag'=>1,
	    		'mensaje'=>'Cotización creada con éxito',
	    		'slug'=>$slug,
	    	]);

	    }else{
	    	return json_encode([
	    		'mensaje'=>'Error al crear la cotización',
	    	]);
	    }

	}
	public function pagina($slug)
	{
	   $empresa = new EntidadesModel();



	    // Validar el slug
	    if (empty($slug)) {
	        throw new \CodeIgniter\Exceptions\PageNotFoundException('Slug no válido');
	    }

	    $db = \Config\Database::connect();

	    // Encontrar cotización
	    $cotizacion = $db->table('mbi_cotizaciones');
	    $cotizacion->join('mbi_clientes', 'mbi_cotizaciones.id_cliente = mbi_clientes.id_cliente');
	    $cotizacion->where('slug', $slug);
	    $resultado_cotizacion = $cotizacion->get()->getResultArray();

	    // Verificar si se encontró la cotización
	    if (empty($resultado_cotizacion)) {
	        throw new \CodeIgniter\Exceptions\PageNotFoundException('Cotización no encontrada');
	    }

	    $kardex = new KardexModel();
	    $resultado_kardex = $kardex->select('id_kardex,slug')->where('id_kardex', $resultado_cotizacion[0]['id_kardex'])->first();

	    // Verificar si se encontró el kardex
	    if (empty($resultado_kardex)) {
	        throw new \CodeIgniter\Exceptions\PageNotFoundException('Kardex no encontrado');
	    }

	    // Encontrar los detalles del kardex
	    $detalles = new KardexDetalleModel();
	    $detalles->where('id_kardex', $resultado_kardex['id_kardex']);
	    $resultado_detalles = $detalles->findAll();

	    // Verificar si se encontraron detalles
	    if (empty($resultado_detalles)) {
	        throw new \CodeIgniter\Exceptions\PageNotFoundException('Detalles no encontrados');
	    }

	    // Encontrar los diagnósticos
	    $diagnostico = new KardexDiagnosticoModel();
	    $diagnostico->where('id_diagnostico', $resultado_detalles[0]['id_detalle']);
	    $resultado_diagnostico = $diagnostico->findAll();	   	

	    // Verificar si se encontraron diagnósticos
	    if (empty($resultado_diagnostico)) {
	        throw new \CodeIgniter\Exceptions\PageNotFoundException('Diagnósticos no encontrados');
	    }
	    // Encontrar las refacciones
	    $refaccion = new RefaccionesModel();
	    $refaccion->where('id_diagnostico', $resultado_diagnostico[0]['id_diagnostico']);
	    $resultado_refaccion = $refaccion->findAll();
	    // Verificar si se encontraron refacciones
	    if (empty($resultado_refaccion)) {
	        throw new \CodeIgniter\Exceptions\PageNotFoundException('Refacciones no encontradas');
	    }
	    $data = [
	        'cotizacion' => $resultado_cotizacion,
	        'diagnostico' => $resultado_diagnostico,
	        'refacciones' => $resultado_refaccion,
	        'slug' => $resultado_kardex['slug'],
	        'id_kardex'=>$resultado_kardex['id_kardex'],
	    ];

	    //return json_encode($data);
	    return view('nueva_cotizacion', $data);
	}
	public function editar_detalle($id)
	{
		if (empty($id)) {
			return $this->response->setJSON(['status'=>'error']);
		}

		$model = new DetalleModel();
		$model->where('id_cotizacion_detalle',$id);
		$resultado = $model->first();

		if (empty($resultado)) {
			return $this->response->setJSON(['status'=>'error']);
		};

		return json_encode($resultado);
	}
	public function actualizar_detalle()
	{
		$detalleModel = new DetalleModel();
        
        // Obtener los datos del formulario
        $partida = $this->request->getvar('partida');
        $cantidad = $this->request->getvar('cantidad');
        $precio = $this->request->getvar('precio_unitario');
        $contenido = $this->request->getvar('contenido');
        $id_detalle = $this->request->getvar('id_detalle');
        $total = $precio * $cantidad;

        $data = [
        	'cantidad'=> $cantidad,
        	'partida'=> $partida,
        	'descripcion'=>$contenido,
        	'precio_unitario'=>$precio,
        	'total'=> $total,
        ];

        // Asegúrate de que $id_detalle no esté vacío y sea un valor válido
		if (!empty($id_detalle)) {
		    $update = $detalleModel->update($id_detalle, $data);
		    if ($update) {
		        return $this->response->setJSON(['flag' => 1]);
		    } else {
		        return $this->response->setJSON(['flag' => 0, 'error' => 'Error al actualizar el registro']);
		    }
		} else {
		    return $this->response->setJSON(['flag' => 0, 'error' => 'ID de detalle no proporcionado']);
		}

        
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
		//Aqui traemos todos los modelos

		$cotizacionModel = new CotizacionesModel();
        $clienteModel = new ClientesModel();
        $detalleModel = new DetalleModel();
        $usuarioModel = new UsuariosModel();
		
		$cotizacion = $cotizacionModel->find($id);
		//Obtenemos la cotizacion
		if (!$cotizacion) { //verificamos que el id venga con datos
 			return "Cotizacion no encontrada";
		}

		//Obtenemos la entida que cotiza
		$entidad = $cotizacionModel->select('entidad')->where('id_cotizacion', $id)->first();
		if (empty($entidad)) {
			return "no hay entidad";
		}

		$emisor = $entidad['entidad'];

		//datos del cliente
		$cliente = $clienteModel->find($cotizacion['id_cliente']);
		
		if (!$cliente) {
			return "no hay cliente";
		}


		//obtenemos los detalles
		$detalleModel->where('id_cotizacion',$id);
		$resultado_detalles = $detalleModel->findAll();
		if (!$resultado_detalles) {
			return "no hay detalles";
		}

		//buscamos al usuario que genero todo
		$resultado_usuario = $usuarioModel->select('nombre, apellidos, correo')->where('id_usuario',$cotizacion['atendido_por'])->first();

		if (!$resultado_usuario) {
			return "no hay usuario";
		}
		

		$total_con_iva = $cotizacion['total']; // Total con IVA
		$iva_porcentaje = 16; // IVA en porcentaje
		$factor_iva = 1 + ($iva_porcentaje / 100); // Calcula el factor del IVA

		$total_sin_iva = $total_con_iva / $factor_iva; // Total sin IVA
		$iva = $total_con_iva - $total_sin_iva; // Solo IVA

		$importe = number_format($total_sin_iva,2);
		$iva_formateado = number_format($iva,2);
		$total = number_format($total_con_iva,2); //total total

        $fechaFormateada = $this->formatearFecha($cotizacion['created_at']);

		$nombre_completo = $resultado_usuario['nombre']." ".$resultado_usuario['apellidos'];

		$data = [
			'cliente'=>$cliente,
			'id_cotizacion'=>$id,
			'detalles'=>$resultado_detalles,
			'sub_total'=>$importe,
			'iva'=>$iva_formateado,
			'total'=>$total,
			'vendedor'=>$nombre_completo,
			'fecha'=>$fechaFormateada
		];
		//return view('pdf/cotizacion',$data);
		$doc = new Dompdf();

		//aqui es donde switcheamos la entidad
		$emisor = $entidad['entidad'];
		if ($emisor == 1) {
			$html = view('pdf/cotizacion',$data);
		}elseif ($emisor == 2) {
			$html = view('pdf/cotizacion_secolab',$data);
		}

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
        $email->setTo($resultado_usuario['correo']); // Cambia por el correo del destinatario
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
    private function formatearFecha($fechaOriginal)
    {
        $dias = [
            'Sunday' => 'domingo', 'Monday' => 'lunes', 'Tuesday' => 'martes',
            'Wednesday' => 'miércoles', 'Thursday' => 'jueves', 'Friday' => 'viernes',
            'Saturday' => 'sábado'
        ];
        $meses = [
            'January' => 'enero', 'February' => 'febrero', 'March' => 'marzo',
            'April' => 'abril', 'May' => 'mayo', 'June' => 'junio', 'July' => 'julio',
            'August' => 'agosto', 'September' => 'septiembre', 'October' => 'octubre',
            'November' => 'noviembre', 'December' => 'diciembre'
        ];

        $fecha = new \DateTime($fechaOriginal);
        $dia = $dias[$fecha->format('l')];
        $mes = $meses[$fecha->format('F')];
        return ucfirst("$dia, " . $fecha->format('d') . " de $mes de " . $fecha->format('Y'));
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

		//sacamos el id del detalle para poder sacar el diagnostico
		$detalle_kardex = new KardexDetalleModel();
		$resultado_kardex = $detalle_kardex->select('id_detalle')->where('id_kardex',$resultado_cotizacion['id_kardex'])->first();

		$id = $resultado_kardex['id_detalle'];
		
		//ahora vamos por el disgnostico
		$diagnostico = new KardexDiagnosticoModel();
		$diagnostico->where('id_diagnostico',$id);
		$resultado_diagnostico = $diagnostico->findAll();

		//y las refacciones 

		$refaccion = new RefaccionesModel();
		$refaccion->where('id_diagnostico',$resultado_diagnostico[0]['id_diagnostico']);
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
		$detalleModel = new DetalleModel();
        
        // Obtener los datos del formulario
        $partida = $this->request->getvar('partida');
        $cantidad = $this->request->getvar('cantidad');
        $precio = $this->request->getvar('precio');
        $contenido = $this->request->getvar('contenido');
        $id = $this->request->getvar('id');
        $total = $precio * $cantidad;

        $data = [
        	'cantidad'=> $cantidad,
        	'partida'=> $partida,
        	'descripcion'=>$contenido,
        	'precio_unitario'=>$precio,
        	'total'=> $total,
        	'id_cotizacion'=>$id
        ];

        $insert = $detalleModel->insert($data);
        if ($insert == true) {
        	return $this->response->setJSON(['flag'=>1]);
        }

        
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
	public function secolab()
	{
		return view('pdf/cotizacion_secolab');
	}
}