<?php

namespace App\Controllers;
use App\Models\CotizacionesModel;
use App\Models\DatosFiscalesModel;
use App\Models\RegimenFiscalModel;
use App\Models\UsosFacturaModel;
use App\Models\DetalleModel;
use App\Models\EntidadesModel;
use App\Models\FacturasModel;
use App\Models\ClientesModel;
use Facturapi\Facturapi;
use CodeIgniter\Controller;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Dompdf\Dompdf;
use Dompdf\Options;

class Facturacion extends Controller
{
	public function index()
	{
		$factura = new FacturasModel();
		$cot = new CotizacionesModel();
		//recibimos los datos del form
		$uso  = $this->request->getvar('metodo_pago');
		$metodo = $this->request->getvar('uso_cfdi');
		$cotizacion = $this->request->getvar('cotizacion');
		$id_entidad = $this->request->getvar('entidad');
		$clave_prod = $this->request->getvar('clave_prod');
		$cliente = $this->request->getvar('cliente');
		//return json_encode($clave_prod);


		//vamos a buscar la entidad
		$entidad = new EntidadesModel();
		$entidad->where('id_entidad',$id_entidad);
		$resultado_entidad = $entidad->findAll();

		//queremos los datos fiscales
		$datos = new DatosFiscalesModel();
		$datos->where('id_cliente',$cliente);
		$resultado_fiscal = $datos->findAll();
		

		//para el total de la cotizacion
		$total= new CotizacionesModel();
		$total->where('id_cotizacion',$cotizacion);
		$resultado_total = $total->findAll();

		//ahora los elementos para la factura
		$cotizacion_model = new DetalleModel();
		$cotizacion_model->where('id_cotizacion', $cotizacion);
		$id_cotizacion = $cotizacion_model->findAll();

		$facturapi = new Facturapi($resultado_entidad[0]['secret_key']);
		//return json_encode($resultado_entidad[0]['secret_key']);

		$invoice = $facturapi->Invoices->create([
		  "customer" => [
		    "legal_name" => $resultado_fiscal[0]['nombre'],
		    "email" => $resultado_fiscal[0]['correo'],
		    "tax_id" => 'ABC101010111',
		    "tax_system" => $resultado_fiscal[0]['regimen'],
		    "address" => [
		      "zip" => $resultado_fiscal[0]['cp']
		    ]
		  ],
		  "items" => [
		    [
		      "quantity" => $id_cotizacion[0]['cantidad'],
		      "product" => [
		        "description" => $id_cotizacion[0]['descripcion'],
		        "product_key" => $clave_prod, // ClaveProdServ del SAT
		        "price" => $id_cotizacion[0]['total'],
		        "taxes" => [
		          [
		            "type" => "IVA",
		            "rate" => 0.16,
		          ]
		        ]
		      ]
		    ],
		  ],
		  "payment_form" => "28" // "Tarjeta de débito"
		]);

		//ahora vamos a recuperar la factura
		$invoiceId = $invoice->id;
		//$invoice = $facturapi->Invoices->retrieve($invoiceId);
		
		//vamos a guardar la factura en un tabla 
		$data = [
			'id_cotizacion'=> $cotizacion,
			'serie_emisor'=> $invoiceId,
			'id_cliente'=>$resultado_fiscal[0]['id_cliente'],
			//1 = pendiente
			//2 = pagada
			//3 = cancelada
		];

		//cambiamos el estatus de la cotización
		$actualizar_estatus = [
			'estatus'=> 13,
		];
		if ($factura->insert($data) && $cot->update($cotizacion,$actualizar_estatus)) {
			echo 1;
		}

		
		

	}
	public function lista()
	{
		$db = \Config\Database::connect();

		$builder = $db->table('mbi_factura');
		$builder->select('mbi_factura.*, mbi_clientes.*, mbi_entidades.id_entidad');
		$builder->join('mbi_clientes','mbi_clientes.id_cliente = mbi_factura.id_cliente');
		$builder->join('mbi_entidades', 'mbi_entidades.id_entidad = mbi_factura.entidad');
		$resultado = $builder->get()->getResultArray();

		$data['factura'] = $resultado;
		return view('facturas',$data);
	}
	public function descargar($id) // se encarga de descargar en pdf
	{
		
		$doc = new Dompdf();
		$options = new Options();
        $options->set('defaultFont', 'DejaVu Sans'); 
		$factura = new FacturasModel();
		$factura->where('id_folio',$id);
		$resultado = $factura->findAll();
		$entidad = $resultado[0]['entidad'];
		$folio_externo = $resultado[0]['serie_emisor'];

		$api = new EntidadesModel();
		$api->where('id_entidad',$entidad);
		$resultado_api = $api->findAll();
		$key = $resultado_api[0]['secret_key'];
		
		$facturapi = new Facturapi($key);
		$invoice_in = $facturapi->Invoices->retrieve($folio_externo);
		$invoice = json_decode(json_encode($invoice_in), true);



		//consulta regimen fiscal
		$regimen = new RegimenFiscalModel();
		$regimen->where('codigo',$invoice['customer']['tax_system']);
		$resultado_regimen = $regimen->findAll();
		$reg = $resultado_regimen[0]['nombre'];

		//consutal de uso de factura
		$uso = new UsosFacturaModel();
		$uso->where('clave',$invoice['use']);
		$resultado_uso = $uso->findAll();
		$usoCFDI = $resultado_uso[0]['descripcion'];

		$subtotal = 0;
    	$iva = 0;

		$qr = $invoice_in->verification_url;
    	//obtener el codigo qr
	    $qrCode    = new QrCode($qr);
	    $qrCode->setSize(150);

	    $writer   = new PngWriter();
	    $result   = $writer->write($qrCode);
	    // Convertimos la imagen a Data URI para incrustarla en HTML
	    $qrDataUri = $result->getDataUri();
		// Calcular subtotal e IVA
	    foreach ($invoice['items'] as $item) {
	        $quantity = $item['quantity'];
	        $price = $item['product']['price'];
	        $taxRate = $item['product']['taxes'][0]['rate'] ?? 0;

	        // Sumar al subtotal
	        $subtotal += $price * $quantity;

	        // Calcular IVA para este item
	        $iva += ($price * $quantity) * $taxRate;
	    }

		$html = view('pdf/factura',[
			'invoice' => $invoice,
			'id'=>$id, 
			'regimen'=>$reg,
			'uso'=>$usoCFDI,
			'sub_total'=>$subtotal,
			'iva'=>$iva,
			'qrImage'=>$qrDataUri,
		]);

		//return $html;
		$doc->loadHTML($html);
		$doc->setPaper('letter','portrait');
		$doc->render();
		$doc->stream("FCT-".$id.".pdf");

	}
}