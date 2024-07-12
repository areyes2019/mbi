<?php

namespace App\Controllers\Admin;
use App\Controllers\BaseController;
use App\Models\CotizacionesModel;
use App\Models\ClientesModel;
use App\Models\ArticulosModel;
use App\Models\DetalleModel;
use Dompdf\Dompdf;
class Cotizaciones extends BaseController
{
	public function index()
	{
		$db = \Config\Database::connect();

		$builder = $db->table('sellopro_cotizaciones');
		$builder->join('sellopro_clientes','sellopro_clientes.idCliente = sellopro_cotizaciones.cliente');
		$resultado = $builder->get()->getResultArray();

		//return view('Panel/cotizaciones');
		$cliente = new ClientesModel();
		$data['cotizaciones'] = $resultado;
		$data['clientes']  = $cliente->findAll();
		return view('Panel/cotizaciones', $data);
	}
	public function nueva($id)
	{
		//vamops a guardar un slgu y un cliente

		$caracteres_permitidos = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
   		$longitud = 12;
   		$slug = substr(str_shuffle($caracteres_permitidos), 0, $longitud);

   		$hoy = date("Y-m-d");
   		$caduca = date("Y-m-d",strtotime($hoy."+ 30 days"));
   		$nuevo_registro = new CotizacionesModel();
   		$data=[
   			'slug'=>$slug,
   			'cliente'=>$id,
   			'fecha'=>$hoy,
   			'caduca'=>$caduca
   		];
   		$nuevo_registro->insert($data);
   		return redirect()->to(base_url('pagina_cotizador/'.$slug));
		
	}
	public function pagina($slug)
	{
		//vamos a buscar la cotizacion

		$cliente = new CotizacionesModel();
		$cliente->where('slug',$slug);
		$resultado = $cliente->findAll();

		$id = $resultado[0]['slug'];
		$cotizacion = $resultado[0]['idQt'];

		//buscamos los ariticulos
		$articulos = new ArticulosModel();
		
		$db = \Config\Database::connect();
		$builder = $db->table('sellopro_cotizaciones');
		$builder->where('slug',$id);
		$builder->join('sellopro_clientes','sellopro_clientes.idCliente = sellopro_cotizaciones.cliente');
		$query['cliente'] = $builder->get()->getResultArray();
		$query['id_cotizacion']= $cotizacion;
		$query['articulo'] = $articulos->findAll();

		return view('Panel/nueva_cotizacion', $query);
		
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
		$model = new DetalleModel();
		$request = \Config\Services::Request();
		$db = \Config\Database::connect();

		$data['descripcion'] = $request->getvar('descripcion');
		$data['id_articulo'] = 0;
		$data['cantidad'] = $request->getvar('cantidad');
		$data['p_unitario'] = $request->getvar('p_unitario');
		$data['id_cotizacion'] = $request->getvar('id_cotizacion');
		$data['total'] = $request->getvar('p_unitario') * $request->getvar('cantidad');

		//return json_encode($data);
		$model->insert($data);

		//actualizamos el total
		$builder = $db->table('sellopro_detalles');
		$builder->where('id_cotizacion',$request->getvar('id_cotizacion'));
		$builder->selectSum('total');
		$sum = $builder->get()->getResultArray();
		$suma_total = $sum[0]['total'];
		$total = new CotizacionesModel();
		$datos=[
			'total'=>$suma_total,
		];
		$total->update($request->getvar('id_cotizacion'),$datos);

	}
	public function mostrar_detalles($id)
	{
		//encontrar el articulo completo
		$db = \Config\Database::connect();
		$builder = $db->table('sellopro_detalles');
		$builder->where('id_cotizacion',$id);
		$builder->join('sellopro_articulos','sellopro_articulos.idArticulo = sellopro_detalles.id_articulo');
		$resultado = $builder->get()->getResultArray();

		//Mostrar articulos independientes
		$query = new DetalleModel();
		$query->where('id_cotizacion',$id);
		$query->where('id_articulo',0);
		$independiente = $query->findAll();
		
		//mostrar totales
		$total = new CotizacionesModel();
		$total->where('idQt',$id);
		$suma_total = $total->findAll();
		$porcenteje = 16;
		$monto = $suma_total[0]['total'];
		$abono = $suma_total[0]['pago'];
		$iva = $monto*($porcenteje/100);
		$pago_total = $monto + $iva;
		$debe = 0;
		if ($suma_total[0]['pago'] < 0) {
			$debe = 1;
		}else if($suma_total[0]['pago'] > $suma_total[0]['total']){
			$debe = 2;
		}

		$saldo = $pago_total - $suma_total[0]['pago'];

		//mostramos el beneficio
		$beneficio = new DetalleModel();
		$beneficio->where('id_cotizacion',$id);
		$beneficio->selectSum('inversion');
		$beneficio->selectSum('total');
		$inversion = $beneficio->findAll();

		$gasto = $inversion[0]['inversion'];
		$cobro = $inversion[0]['total'];
		$utilidad = $cobro - $gasto;
		
		$data=[
			'independiente'=>$independiente,
			'articulo'=>$resultado,
			'sub_total'=> number_format($monto,2),
			'descuento'=> number_format($suma_total[0]['descuento'],2),
			'iva'=> number_format($iva,2),
			'total'=>number_format($pago_total,2),
			'abono'=>number_format($suma_total[0]['pago'],2),
			'saldo'=>number_format($saldo,2),
			'debe'=>$debe,
			'sugerido'=>number_format($pago_total / 2,2),
			'utilidad'=>number_format($utilidad,2)
		];

		return json_encode($data);
		
	}
	public function borrar_linea($id)
	{
		$db = \Config\Database::connect();
		$modelo = new DetalleModel();

		//sacamos el numero de cotizacion
		$modelo->where('idDetalle',$id);
		$ver_modelo = $modelo->findAll();

		$numero = $ver_modelo[0]['id_cotizacion'];

		$modelo->delete($id);

		//actualizamos el total
		$builder = $db->table('sellopro_detalles');
		$builder->where('id_cotizacion',$numero);
		$builder->selectSum('total');
		$sum = $builder->get()->getResultArray();

		$suma_total = $sum[0]['total'];
		$total = new CotizacionesModel();
		$datos=[
			'total'=>$suma_total,
		];
		$total->update($numero,$datos);

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