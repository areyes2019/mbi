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
	        'estatus' => 1
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
	public function agregar_ind()
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
		$totalModel = new CotizacionesModel();

		$model = new DetalleModel();
		if ($model->delete($id)) {
			echo 1;
			//actualizar el total en la cotizacion
			$request = \Config\Services::request();
			$db = \Config\Database::connect();
			// Actualizar el total en la tabla de cotizaciones
			$builder = $db->table('mbi_cotizaciones_detalles');
			$suma_total = $builder->where('id_cotizacion', $id)
			                      ->selectSum('total')
			                      ->get()
			                      ->getRow();
			
			$totalModel->update($id, ['total' => $suma_total]);
			}

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
		$db = \Config\Database::connect();

		//datos del cliente
		$cliente_query = new CotizacionesModel();
		$cliente_query->where('idQt',$id);
		$resultado_cotizacion = $cliente_query->findAll();

		$cliente = new ClientesModel();
		$cliente->where('idCliente',$resultado_cotizacion[0]['cliente']);
		$resultado = $cliente->findAll();

		//mostrar los articulos
		$builder = $db->table('sellopro_detalles');
		$builder->where('id_cotizacion',$id);
		$builder->join('sellopro_articulos','sellopro_articulos.idArticulo = sellopro_detalles.id_articulo');
		$resultado_lineas = $builder->get()->getResultArray();

		//mostrar independientes
		//Mostrar articulos independientes
		$query = new DetalleModel();
		$query->where('id_cotizacion',$id);
		$query->where('id_articulo',0);
		$independiente = $query->findAll();

		//sacamos los totales 

		//actualizamos el total
		$sum = $db->table('sellopro_detalles');
		$sum->where('id_cotizacion',$id);
		$sum->selectSum('total');
		$result = $sum->get()->getResultArray();
		$total_sum = $result[0]['total'];
		$porcenteje = 16;
		$iva = $total_sum*($porcenteje/100);
		$total = $total_sum + $iva;	
			

		$data = [
			'cliente'=>$resultado,
			'id_cotizacion'=>$resultado_cotizacion,
			'detalles'=>$resultado_lineas,
			'detalles_ind'=>$independiente,
			'sub_total'=>$total_sum,
			'descuento'=>$resultado_cotizacion[0]['descuento'],
			'iva'=>$iva,
			'total'=>$total,
		];
		//return view('Panel/PDF',$data);
		$doc = new Dompdf();
		$html = view('Panel/PDF',$data);
		//return $html;
		$doc->loadHTML($html);
		$doc->setPaper('A4','portrait');
		$doc->render();
		$doc->stream("QT-".$id.".pdf");
	}
	public function enviar_pdf($id)
	{
		$db = \Config\Database::connect();

		//datos del cliente
		$cliente_query = new CotizacionesModel();
		$cliente_query->where('idQt',$id);
		$resultado_cotizacion = $cliente_query->findAll();
		$cliente = new ClientesModel();
		$cliente->where('idCliente',$resultado_cotizacion[0]['cliente']);
		$resultado = $cliente->findAll();

		//mostrar los articulos
		$builder = $db->table('sellopro_detalles');
		$builder->where('id_cotizacion',$id);
		$builder->join('sellopro_articulos','sellopro_articulos.idArticulo = sellopro_detalles.id_articulo');
		$resultado_lineas = $builder->get()->getResultArray();

		//sacamos los totales 

		//actualizamos el total
		$sum = $db->table('sellopro_detalles');
		$sum->where('id_cotizacion',$id);
		$sum->selectSum('total');
		$result = $sum->get()->getResultArray();
		$total_sum = $result[0]['total'];
		$porcenteje = 16;
		$iva = $total_sum*($porcenteje/100);
		$total = $total_sum + $iva;	
			

		$data = [
			'cliente'=>$resultado,
			'id_cotizacion'=>$resultado_cotizacion,
			'detalles'=>$resultado_lineas,
			'sub_total'=>$total_sum,
			'descuento'=>$resultado_cotizacion[0]['descuento'],
			'iva'=>$iva,
			'total'=>$total,
		];
		//return view('Panel/PDF',$data);
		$doc = new Dompdf();
		$html = view('Panel/PDF',$data);
		//return $html;
		$doc->loadHTML($html);
		$doc->setPaper('A4','portrait');
		$doc->render();
		$salida = $doc->output();
		$nombre = "QT-".$id.".pdf";
		$email = \Config\Services::email();
		$email->setFrom('ventas@sellopronto.com.mx','Sello Pronto');
		$email->setTo('reyesabdias@gmail.com');
		$email->setSubject('Cusrsos');
		$email->setMessage('Este es un mensaje de prueba');
		$email->attach('img/40.png');
		$email->send();
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
}