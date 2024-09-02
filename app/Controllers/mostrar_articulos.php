<?php

namespace App\Controllers\Admin;
use App\Controllers\BaseController;
use App\Models\ArticulosModel;
use App\Models\ProveedoresModel;
use App\Models\PedidosModel;
use App\Models\DetallePedidosModel;
use Dompdf\Dompdf;
class Compras extends BaseController
{
	public function index()
	{

		$db = \Config\Database::connect();

		$builder = $db->table('sellopro_pedidos');
		$builder->join('sellopro_proveedores','sellopro_proveedores.id_proveedor = sellopro_pedidos.proveedor');
		$resultado = $builder->get()->getResultArray();

		//return view('Panel/cotizaciones');
		$proveedor = new ProveedoresModel();
		$data['pedidos'] = $resultado;
		$data['proveedor']  = $proveedor->findAll();
		return view('Panel/pedidos', $data);
	}
	public function nueva($id)
	{
		//vamops a guardar un slgu y un cliente


		$caracteres_permitidos = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
   		$longitud = 12;
   		$slug = substr(str_shuffle($caracteres_permitidos), 0, $longitud);

   		$hoy = date("Y-m-d");
   		$caduca = date("Y-m-d",strtotime($hoy."+ 30 days"));
   		$nuevo_registro = new PedidosModel();
   		$data=[
   			'slug'=>$slug,
   			'proveedor'=>$id,
   			'fecha'=>$hoy,
   			'caduca'=>$caduca
   		];
   		$nuevo_registro->insert($data);
   		return redirect()->to(base_url('pagina_orden/'.$slug));
		
	}
	public function pagina($slug)
	{
		//vamos a buscar la cotizacion

		$proveedor = new PedidosModel();
		$proveedor->where('slug',$slug);
		$resultado = $proveedor->findAll();

		$id = $resultado[0]['slug'];
		$pedido = $resultado[0]['pedidos_id'];

		//buscamos los ariticulos
		$articulos = new ArticulosModel();
		
		$db = \Config\Database::connect();
		$builder = $db->table('sellopro_pedidos');
		$builder->where('slug',$id);
		$builder->join('sellopro_proveedores','sellopro_proveedores.id_proveedor = sellopro_pedidos.proveedor');
		$query['proveedor'] = $builder->get()->getResultArray();
		$query['pedidos_id']= $pedido;
		$query['articulo'] = $articulos->findAll();

		return view('Panel/nueva_compra', $query);
		
	}
	public function editar()
	{
		return view('Panel/editar_pedido');
	}
	public function agregar()
	{
		$db = \Config\Database::connect();
		$query = new ArticulosModel();
		$model = new DetallePedidosModel();

		$request = \Config\Services::Request();
		$articulo = $request->getvar('id_articulo');
		$cantidad = $request->getvar('cantidad');
		$cotizacion = $request->getvar('pedidos_id');
		$descuento = $request->getvar('descuento');
		//verificamos si el producto ya esta agregado
		$doble = $db->table('sellopro_detalles_pedido');
		$doble->where('pedidos_id',$cotizacion);
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
			$builder = $db->table('sellopro_detalles_pedido');
			$builder->where('pedidos_id',$cotizacion);
			$builder->selectSum('total');
			$sum = $builder->get()->getResultArray();
			$suma_total = $sum[0]['total'];
			
			$suma_con_desc = $suma_total-($suma_total*$descuento/100);
			$suma_desc = ($suma_total*$descuento/100);
			$total = new PedidosModel();
			
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
		$linea = new DetallePedidosModel();
		$linea->where('pedido_detalle_id',$id);
		$resultado = $linea->findAll();
		$id_articulo = $resultado[0]['id_articulo'];
		$cotizacion = $resultado[0]['pedidos_id'];
		
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
		$builder = $db->table('sellopro_detalles_pedido');
		$builder->where('pedidos_id',$cotizacion);
		$builder->selectSum('total');
		$sum = $builder->get()->getResultArray();
		$suma_total = $sum[0]['total'];
		
		$suma_con_desc = $suma_total-($suma_total*$descuento/100);
		$suma_desc = ($suma_total*$descuento/100);
		$total = new PedidosModel();
		
		$datos['total'] = $suma_con_desc;
		$datos['descuento'] = $suma_desc;

		$total->update($cotizacion,$datos);


	}
	
	public function mostrar_detalles($id)
	{
		//encontrar el articulo completo
		$db = \Config\Database::connect();
		$builder = $db->table('sellopro_detalles_pedido');
		$builder->where('pedidos_id',$id);
		$builder->join('sellopro_articulos','sellopro_articulos.idArticulo = sellopro_detalles_pedido.id_articulo');
		$resultado = $builder->get()->getResultArray();
		
		//mostrar totales
		$total = new PedidosModel();
		$total->where('pedidos_id',$id);
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
		$beneficio = new DetallePedidosModel();
		$beneficio->where('pedidos_id',$id);
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
		$modelo = new DetallePedidosModel();

		//sacamos el numero de cotizacion
		$modelo->where('pedido_detalle_id',$id);
		$ver_modelo = $modelo->findAll();

		$numero = $ver_modelo[0]['pedidos_id'];

		$modelo->delete($id);

		//actualizamos el total
		$builder = $db->table('sellopro_detalles_pedido');
		$builder->where('pedidos_id',$numero);
		$builder->selectSum('total');
		$sum = $builder->get()->getResultArray();

		$suma_total = $sum[0]['total'];
		$total = new PedidosModel();
		$datos=[
			'total'=>$suma_total,
		];
		$total->update($numero,$datos);

	}
	public function eliminar($id)
	{
		$db = \Config\Database::connect();

		$modelo = new PedidosModel();
		$modelo->delete($id);

		$builder = $db->table('sellopro_detalles_pedido');
		$builder->where('pedidos_id',$id);
		$builder->delete();

		return redirect()->to('/pedidos');

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
}