//vamos a descargar la factura en pdf
		//return view('pdf/cotizacion',$data);
		$doc = new Dompdf();
		$html = view('pdf/factura',$invoice);
		//return $html;
		$doc->loadHTML($html);
		$doc->setPaper('A4','portrait');
		$doc->render();

		// Guardar el PDF en un archivo temporal
        $filePath = WRITEPATH . "uploads/QT-$id.pdf";
        file_put_contents($filePath, $doc->output());
		// vamos a descargar la factura en xml

		//vamos a registrar la factura en la tabla facturas

		// vamos a registrar la cotizacion como facturada



Claro, te muestro cómo agregar múltiples productos a una factura usando un foreach en CodeIgniter 4:
// Suponiendo que tienes un array de productos
$productos = [/* ... tus productos ... */];

// Inicializa el array de items
$items = [];

// Itera sobre los productos
foreach ($productos as $producto) {
    $items[] = [
        "quantity" => $producto->cantidad,
        "product" => [
            "description" => $producto->descripcion,
            "product_key" => $producto->clave_producto,
            "price" => $producto->precio
        ]
    ];
}

// Crea la factura con los items
$invoice = $facturapi->Invoices->create([
    "customer" => [
        "legal_name" => "Dunder Mifflin",
        "email" => "email@example.com",
        "tax_id" => "ABC101010111",
        "tax_system" => "601",
        "address" => [
            "zip" => "85900"
        ]
    ],
    "items" => $items,
    "payment_form" => "28" // Tarjeta de crédito
]);