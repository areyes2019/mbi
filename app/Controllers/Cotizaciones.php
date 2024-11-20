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
use App\Models\UsuariosModel;
use Dompdf\Dompdf;
class Cotizaciones extends BaseController
{
	public function index()
	{
		$db = \Config\Database::connect();

		$builder = $db->table('mbi_cotizaciones');
		$builder->join('mbi_clientes','mbi_clientes.id_cliente = mbi_cotizaciones.id_cliente');
		$resultado = $builder->get()->getResultArray();
		$data['cotizaciones'] = $resultado;
		return view('cotizaciones',$data);
	}
	public function nueva()
	{
		// Obtener el ID del Kardex desde la solicitud
	    $id = $this->request->getVar('id');

	    // Obtener el registro del cliente usando el ID de Kardex
	    $kardexModel = new KardexModel();
	    $clienteData = $kardexModel->where('id_kardex', $id)->first();

	    if (!$clienteData) {
	        return json_encode(['hecho' => 0, 'mensaje' => 'Cliente no encontrado']);
	    }


	    $id_cliente = $clienteData['id_cliente'];
	    $kardex_id = $id;

	    // Generar un slug aleatorio
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

	    // Intentar la inserción y verificar el ID insertado
	    $cotizacionesModel->insert($data);
	    if ($cotizacionesModel->db->affectedRows() > 0) { // Confirma que el registro fue insertado
	        // Actualizar el estatus de Kardex
	        $kardexUpdate = ['estatus' => 8];
	        $kardexModel->update($id, $kardexUpdate);

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
	    }
	}
	public function pagina($slug)
	{
		$db = \Config\Database::connect();
		$cotizacion_id = $this->request->uri->getSegment(3);
		$id = $cotizacion_id;

		
		//encongrar cotizacoin
		$cotizacion = $db->table('mbi_cotizaciones');
		$cotizacion->join('mbi_clientes', 'mbi_cotizaciones.id_cliente = mbi_clientes.id_cliente');
		$cotizacion->where('id_cotizacion',$id);
		$resultado_cotizacion = $cotizacion->get()->getResultArray();


		$kardex = new KardexModel();
		$kardex->where('id_kardex',$resultado_cotizacion[0]['id_kardex']);
		$resultado_kardex = $kardex->findAll();
		$kardex_slug = $resultado_kardex[0]['slug'];

		//econtrar los diagnosticos

		$detalles = new KardexDetalleModel();
		$detalles->where('id_kardex', $resultado_cotizacion[0]['id_kardex']);
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
			'slug'=>$kardex_slug,
		];

		return view('nueva_cotizacion',$data);

		
	}
	public function editar()
	{
		return view('Panel/editar_cotizacion');
	}
	public function agregar()
	{
		$db = \Config\Database::connect();
		$query = new ArticulosModel();
		$model = new DetalleModel();

		$request = \Config\Services::Request();
		$articulo = $request->getvar('id_articulo');
		$cantidad = $request->getvar('cantidad');
		$cotizacion = $request->getvar('id_cotizacion');
		$descuento = $request->getvar('descuento');
		//verificamos si el producto ya esta agregado
		$doble = $db->table('sellopro_detalles');
		$doble->where('id_cotizacion',$cotizacion);
		$doble->where('id_articulo',$articulo);
		$es_duplicado = $doble->countAllResults();

		//return json_encode($es_duplicado);
		
		if ($es_duplicado > 0) {
			//esta duplicado
			return "1";
		}else{

			//sacar el precio
			$query->where('idArticulo',$articulo);
			$resultado = $query->findAll();

			$precio = $resultado[0]['precio_pub'];
			$total = $precio * $cantidad;
			$inversion = $resultado[0]['precio_prov'] * $cantidad;
			
			$data = [
			    'id_articulo' => $request->getvar('id_articulo'),
			    'cantidad' => $request->getvar('cantidad'),
			    'p_unitario'=>$precio,
			    'total'=>$total,
			    'id_cotizacion'=>$cotizacion,
			    'inversion'=>$inversion
			];

			$model->insert($data);

			//actualizamos el total
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

		return json_encode($data);
		
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
		$db = \Config\Database::connect();

		$modelo = new CotizacionesModel();
		$modelo->delete($id);

		$builder = $db->table('sellopro_detalles');
		$builder->where('id_cotizacion',$id);
		$builder->delete();

		return redirect()->to('/cotizaciones');

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
        // Definir el contenido HTML del correo
		
		$htmlContent = view('email/enviar_cotizacion');
        $email->setMessage($htmlContent);
        $email->attach($filePath);

        // Enviar el correo
        if ($email->send()) {
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
	public function ver_diagnostico_kardex($data)
	{
		//primero sacamos el detalle del kardex
		$detalle_kardex = new KardexDetalleModel();
		$detalle_kardex->where('id_kardex', $data);
		$resultado_kardex = $detalle_kardex->findAll();

		$id = $resultado_kardex[0]['slug'];
		
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
}