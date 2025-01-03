<?php
namespace App\Controllers;

use CodeIgniter\Controller;

class FacturaController extends Controller
{
    public function crearFactura()
    {
        // Cargar el modelo o acceder a la base de datos directamente
        $db = \Config\Database::connect();

        // Datos del cliente y cotización (estos son datos de ejemplo, ajusta según tu caso)
        $id_cotizacion = $this->request->getPost('id_cotizacion'); // Suponiendo que recibes el ID por POST
        $resultado_fiscal = $db->table('clientes')
            ->where('id_cliente', $this->request->getPost('id_cliente'))
            ->get()
            ->getResultArray();

        if (empty($resultado_fiscal)) {
            return json_encode(["error" => "No se encontraron datos fiscales para el cliente."]);
        }

        // Obtener los datos de los artículos relacionados con la cotización
        $articulos = $db->table('articulos')
            ->where('id_cotizacion', $id_cotizacion)
            ->get()
            ->getResultArray();

        if (empty($articulos)) {
            return json_encode(["error" => "No se encontraron artículos para la cotización."]);
        }

        // Construir los items dinámicamente
        $items = [];
        foreach ($articulos as $articulo) {
            $items[] = [
                "quantity" => $articulo['cantidad'],
                "product" => [
                    "description" => $articulo['descripcion'],
                    "product_key" => $articulo['clave_prod'], // ClaveProdServ del SAT
                    "price" => $articulo['precio_unitario'],
                    "taxes" => [
                        [
                            "type" => "IVA",
                            "rate" => 0.16,
                        ]
                    ]
                ]
            ];
        }

        // Crear el array para la factura
        $invoiceData = [
            "customer" => [
                "legal_name" => $resultado_fiscal[0]['nombre'],
                "email" => $resultado_fiscal[0]['correo'],
                "tax_id" => 'ABC101010111', // Ejemplo: agrega el correcto
                "tax_system" => $resultado_fiscal[0]['regimen'],
                "address" => [
                    "zip" => $resultado_fiscal[0]['cp']
                ]
            ],
            "items" => $items, // Aquí van los artículos dinámicos
            "payment_form" => "28" // "Tarjeta de débito"
        ];

        // Instanciar FacturAPI (asegúrate de tener configurada la librería y API key)
        $facturapi = new \FacturAPI\Client('TU_API_KEY');

        try {
            // Crear la factura
            $invoice = $facturapi->Invoices->create($invoiceData);

            // Respuesta de FacturAPI
            return json_encode([
                "success" => true,
                "message" => "Factura creada con éxito.",
                "invoice_id" => $invoice['id'],
            ]);
        } catch (\Exception $e) {
            // Manejo de errores
            return json_encode([
                "success" => false,
                "error" => $e->getMessage()
            ]);
        }
    }
}
