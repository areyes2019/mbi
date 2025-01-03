<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Factura</title>
    <style>
        @page {
            margin: 5mm; /* Márgenes de 2 centímetros en todos los lados */
        }
        body {
            font-family: sans-serif;
            font-size: 10pt;
        }
        .container {
            width: 100%;
            max-width: 800px;
            margin: 0 auto;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .logo {
            max-width: 200px;
            margin: 0 auto;
            display: block;
        }
        .address {
            text-align: center;
            margin-bottom: 20px;
        }
        .info {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .info th, .info td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        .info th {
            background-color: #f2f2f2;
        }
        .items {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .items th, .items td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        .items th {
            background-color: #f2f2f2;
            text-align: center;
        }
        .totals {
            width: 50%;
            text-align: right;
            margin-bottom: 20px;
        }
        .totals table {
            margin-left: auto;
            border-collapse: collapse;
        }
        .totals th, .totals td {
            padding: 5px 10px;
            text-align: right;
        }
        .footer {
            text-align: center;
            font-size: 8pt;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }
        .totals-container {
            display: flex; /* Usamos flexbox para alinear el QR y los totales */
            align-items: flex-start; /* Alinea los elementos arriba */
            margin-bottom: 20px;
        }
        .qr-code {
            width: 50px; /* Ancho del QR */
            margin-right: 20px; /* Espacio entre el QR y los totales */
        }
        .qr-code img {
            max-width: 70%; /* Asegura que la imagen del QR no se desborde */
            height: auto;
        }
        .totals {
            flex-grow: 1; /* Permite que los totales ocupen el espacio restante */
            text-align: right;
        }
        .cfdi-info {
            font-size: 12pt;
            margin-top: 10px;
            word-wrap: break-word; /* Permite que las líneas largas se rompan */
        }
        .linea{
            margin: 0 0 5px;
            width: 100%; /* o max-width:300px; */
            overflow-wrap: break-word;
            word-wrap: break-word;
            word-break: break-all;
            white-space: normal;
        }
    </style>
</head>
<body>
    <div class="container">
        <table style="width: 100%; background-color: #012a4a;">
            <tr>
                <td style="padding: 15px; align-items: center; display: flex;">
                     <?php
                        $path = base_url('public/img/logo.png');
                        $type = pathinfo($path, PATHINFO_EXTENSION);
                        $data = file_get_contents($path);
                        $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
                    ?>
                    <img src="<?php echo $base64;?>" alt="logo" width="90">
                    <p style="color: white; margin-left: 5px;">Mantenimiento médico de confianza, salud garantizada</p>        
                </td>
                <td style="color: white; padding: 15px;">
                    <p style="text-align:right;">
                        Grupo MBI S.A de C.V<br>
                        Privada Reynosa, #45<br>
                        Col Anzurez<br>
                        Irapuato, Gto
                    </p>
                </td>
            </tr>
        </table>

        <table class="info" style="margin-top: 15px;">
            <tr>
                <td style="vertical-align: top;">
                    <p style="margin: 3px;"><strong>Factura No:</strong> <?php echo $id ?></p>
                    <p style="margin: 3px;"><strong>Fecha:</strong> <?php echo $invoice['created_at'] ?></p>
                    <p style="margin: 3px;"><strong>Folio de Emisión:</strong></p>
                    <p style="margin: 3px;"><?php echo $invoice['id'] ?></p>
                </td>
                <td style="vertical-align: top;">
                    <p style="margin: 3px;"><strong>Razon Social:</strong> <?php echo $invoice['customer']['legal_name']?></p>
                    <p style="margin: 3px;"><strong>RFC:</strong> <?php echo $invoice['customer']['tax_id'] ?></p>
                    <p style="margin: 3px;"><strong>Regimen Fiscal:</strong></p>
                    <p style="margin: 3px;"><?php echo $invoice['customer']['tax_system']?> - <?php echo $regimen?></p>
                    <p style="margin: 3px;"><strong>Domicilio:</strong> <?php echo $invoice['customer']['address']['zip']?></p>
                    <p style="margin: 3px;"><strong>Uso CFDI:</strong> <?php echo $invoice['use']?> - <?php echo $uso ?></p>
                </td>
                <td style="vertical-align: top;">
                    <p style="margin: 3px;"><strong>Folio fiscal:</strong> <span style="font-size: 9px;"><?php echo $invoice['uuid']?></span></p>
                    <p style="margin: 3px;"><strong>Tipo CFDI:</strong> Ingreso</p>
                    <p style="margin: 3px;"><strong>Version:</strong>5</p>
                    <p style="margin: 3px;"><strong>Lugar de emisión:</strong><?php echo $invoice['address']['city'].", ".$invoice['address']['state']?></p>
                    <p style="margin: 3px;"><strong>Fecha cert:</strong> <?php echo $invoice['stamp']['date']?></p>
                    <p style="margin: 3px;"><strong>Serie SSD:</strong> <?php echo $invoice['stamp']['sat_cert_number']?></p>
                </td>
            </tr>
        </table>
        <table class="items">
            <tr>
                <th>Unidad</th>
                <th>C. Prod</th>
                <th>Cant</th>
                <th>Descripción</th>
                <th>Precio Unitario</th>
                <th>Total</th>
            </tr>
            <tr>
                <?php foreach ($invoice['items'] as $item): ?>
                <td style="text-align: center;"><?= $item['product']['unit_key']." / ".$item['product']['unit_name'] ?></td>
                <td style="text-align: center;"><?= $item['product']['product_key'] ?></td>
                <td style="text-align: center;"><?= $item['quantity'] ?></td>
                <td style="text-align: center;"><?= $item['product']['description'] ?></td>
                <td style="text-align: center;">$<?= $item['product']['price'] ?></td>
                <td style="text-align: center;">$<?= $item['product']['price'] * $item['quantity'] ?></td>
                <?php endforeach ?>
            </tr>
        </table>
        <table style="width: 100%; border-collapse: collapse;">
            <tr>
                <td style="vertical-align: top;">
                    <img style="max-width: 80%; height: auto;"
                         src="<?= esc($qrImage) ?>"
                         alt="QR Factura" />
                </td>
                <!-- Celda para los totales -->
                <td style="vertical-align: top;">
                    <!-- Aquí flotamos la tabla anidada a la derecha -->
                    <table style="float: right; border-collapse: collapse; margin-bottom: 10px;">
                        <tr>
                            <th style="text-align: left; padding: 5px;">Subtotal:</th>
                            <td style="text-align: right; padding: 5px;">
                                $<?= number_format($sub_total,2) ?>
                            </td>
                        </tr>
                        <tr>
                            <th style="text-align: left; padding: 5px;">IVA (16%):</th>
                            <td style="text-align: right; padding: 5px;">
                                $<?= number_format($iva,2) ?>
                            </td>
                        </tr>
                        <tr>
                            <th style="text-align: left; padding: 5px;">Total:</th>
                            <td style="text-align: right; padding: 5px;">
                                $<?= number_format($invoice['total'],2) ?>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
                                 
        <div>
            <p class="linea">
                <strong>Sello digital del CFDI:</strong><br>
                <?= $invoice['stamp']['signature']; ?>
            </p>
            <p class="linea">
                <strong>Sello del SAT:</strong><br>
                <?= $invoice['stamp']['sat_signature']; ?>
            </p>
            <p class="linea">
                <strong>Cadena original del complemento de certificación digital del SAT:</strong><br>
                <?= $invoice['stamp']['complement_string']; ?>
            </p>
            <p class="linea">
                <strong>Serie del CSD del SAT:</strong><br>
                <?= $invoice['stamp']['sat_cert_number']; ?>
            </p>
        </div>
        <div class="footer">
            Este documento es una representación impresa de un CFDI.
        </div>
    </div>
</body>
</html>