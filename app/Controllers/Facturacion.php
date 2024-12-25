<?php

namespace App\Controllers;
use App\Models\CotizacionesModel;
use App\Models\DatosFiscalesModel;
use App\Models\DetalleModel;
use App\Models\EntidadesModel;
use Facturapi\Facturapi;
use CodeIgniter\Controller;

class Facturacion extends Controller
{
	public function index()
	{
		//recibimos los datos del form
		$uso  = $this->request->getvar('metodo_pago');
		$metodo = $this->request->getvar('uso_cfdi');
		$cotizacion = $this->request->getvar('cotizacion');
		$id_entidad = $this->request->getvar('entidad');
		$cliente = $this->request->getvar('cliente');

		//vamos a buscar la entidad
		$entidad = new EntidadesModel();
		$entidad->where('id_entidad',$id_entidad);
		$resultado_entidad = $entidad->findAll();

		//queremos los datos fiscales
		$datos = new DatosFiscalesModel();
		$datos->where('id_cliente',$cliente);
		$resultado_fiscal = $datos->findAll();
		
		//ahora los elementos para la factura
		$cotizacion_model = new DetalleModel();
		$cotizacion_model->where('id_cotizacion', $cotizacion);
		$id_cotizacion = $cotizacion_model->findAll();

		return json_encode($id_cotizacion);

		

		//$facturapi = new Facturapi( "sk_test_O4971mr0DMYnjLKNP76meVGkZQ3xpZqQAyBdeWgbJk" );

		/*$invoice = $facturapi->Invoices->create([
		  "customer" => [
		    "legal_name" => "Alejandro Sabañón",
		    "email" => "email@example.com",
		    "tax_id" => "ABC101010111",
		    "tax_system" => "601",
		    "address" => [
		      "zip" => "38024"
		    ]
		  ],
		  "items" => [
		    [
		      "quantity" => 2,
		      "product" => [
		        "description" => "Ukelele",
		        "product_key" => "60131324", // ClaveProdServ del SAT
		        "price" => 8966.60,
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
		$facturaId = $invoice->id;*/
		/*$factura = $facturapi->Invoices->retrieve('6764e28e1a10c1ecaf087ea4');
		$xml = $facturapi->Invoices->download_xml($factura->id);
		header('Content-Type: application/xml');
		header('Content-Disposition: attachment; filename="factura.xml"');
		echo $xml;*/

	}
}