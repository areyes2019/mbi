<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>
    <style>
        @page {
           size: 21cm 29.7cm;
           margin-top: 1cm;
           margin-bottom: 0cm;
           border: 1px solid blue;
        }
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
        }
        .invoice-container {
            width: 100%;
            margin:auto;
            background: #fff;
            padding:0px;
        }
        .header-banner {
            background-color: #012a4a; /* Color azul oscuro */
            color: #fff;
            display: flex;
            align-items: center;
            padding: 10px 20px;
        }
        .header-banner .logo {
            flex: 1;
        }
        .header-banner .logo img {
            max-height: 450px;
        }
        .header-banner .company-info {
            flex: 3;
            text-align: right;
            font-size: 14px;
            line-height: 1.5;
        }
        .header {
            margin-bottom: 20px;
            position: relative;
        }
        .header .brand {
            font-size: 24px;
            font-weight: bold;
            line-height: 1.2;
        }
        .header .brand small {
            font-size: 14px;
            color: #888;
        }
        .header .invoice-banner {
            background-color: #ffc107;
            height: 40px;
            width: 100%;
            position: relative;
        }
        .header .invoice-title {
            background-color: #fff;
            padding: 0 15px;
            position: absolute;
            height: 40px;
            line-height: 40px;
            right: 50px;
            color: #333;
            font-size: 28px;
            font-weight: bold;
            text-align: center;
        }
        .details {
            margin-bottom: 20px;
        }
        .details .to {
            font-size: 16px;
            color: #555;
        }
        .details .to strong {
            font-size: 18px;
            color: #000;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .table th, .table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }
        .table th {
            background-color: #f8f8f8;
            font-weight: bold;
            color: #333;
        }
        .table td {
            font-size: 14px;
            color: #555;
        }
        .table .total {
            font-weight: bold;
            color: #000;
        }
        .summary {
            margin-top: 20px;
            width: 25%;
            margin-left: 600px;
        }

        .summary .row {
            display: flex;
            justify-content: space-between; /* Esto separa las dos columnas */
            margin: 5px 0;
        }

        .summary .row p {
            font-size: 16px;
            width: 50%; /* Cada columna ocupa un poco menos de la mitad del espacio */
            text-align: right; /* Alinea el texto a la derecha */
            line-height: 2px;
        }

        .summary .total {
            font-size: 20px;
            font-weight: bold;
            color: #333;
        }

        .footer {
            margin-top: 30px;
            font-size: 14px;
            color: #777;
        }
        .footer p {
            margin: 5px 0;
        }
        .footer .payment-info {
            margin-top: 10px;
            font-size: 14px;
        }
        .footer .payment-info strong {
            color: #000;
        }
    </style>
</head>
<body>
    <div class="invoice-container">
        <!-- Header Banner -->
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
                <td style="color: white;padding: auto;">
                    <p style="text-align:right;">
                    Grupo MBI S.A de C.V<br>
                    Privada Reynosa, #45<br>
                    Col Anzurez<br>
                    Irapuato, Gto
                    </p>
                </td>
            </tr>
        </table>
        <!-- Header -->
        <div class="header">
            <div class="invoice-banner" style="margin-top:15px;">
                <div class="invoice-title">COTIZACIÓN</div>
            </div>
        </div>
        
        <!-- Rest of the content remains the same -->
        <div class="details">
            <div class="to">
                <p style="margin: 5px;"><strong>No: <?php echo $id_cotizacion?></strong></p>
                <p style="margin: 5px; font-size: 13px;"><?php echo $fecha?></p>
                <p style="margin:5px;"><strong><?php echo $vendedor ?></strong><br>Asesor de ventas</p>
            </div>
            <div class="to">
                <p style="margin:5px;"><strong>Cn Att:</strong></p>
                <p style="margin:5px; font-size: 12px;"><?php echo $cliente['responsable'] ?></p>
                <p style="margin:5px; font-size: 12px;">Tel: <?php echo $cliente['telefono'] ?></p>
                <p style="margin:5px; font-size: 12px;"><?php echo $cliente['hospital']; ?></p>
                <p style="margin:5px; font-size: 12px;"><?php echo $cliente['facultad']; ?></p>
            </div>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th>Partida</th>
                    <th>Descripción</th>
                    <th>Importe</th>
                    <th>Cant.</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($detalles as $detalle): ?>
                <tr>
                    <td><?php echo $detalle['partida'] ?></td>
                    <td><?php echo $detalle['descripcion'] ?></td>
                    <td>$<?php echo number_format($detalle['precio_unitario'],2)?></td>
                    <td><?php echo $detalle['cantidad'] ?></td>
                    <td>$<?php echo number_format($detalle['precio_unitario'] * $detalle['cantidad'],2)?></td>
                </tr>
                <?php endforeach ?>
            </tbody>
        </table>
        <div class="summary">
            <div class="row">
                <p><strong>Sub Total:</strong></p>
                <p>$<?php echo $sub_total?></p>
            </div>
            <div class="row">
                <p><strong>IVA (16%):</strong></p>
                <p>$<?php echo $iva ?></p>
            </div>
            <div class="row total">
                <p><strong>Total:</strong></p>
                <p>$<?php echo $total ?></p>
            </div>
        </div>
        <div class="footer">
            <p><strong>Terminos y Condiciones:</strong> Esta cotización se convertirá en pedido cuando cuente con la firma del cliente, y se respetará el precio establecido. Quedando en entendido todos los términos, características y condiciones descritos en esta cotización y/o anexos adjuntos. El tiempo de entrega es a partir de recibir por vía o e-mail su orden de compra o cotización firmada y el anticipo correspondiente. Toda cancelación genera un cargo equivalente al 20% del valor total de esta cotización.</p>
        </div>
        <div class="firma">
            <p>______________________________</p>
            <p><strong><?= $vendedor ?></strong></p>
            <p>Representante de Ventas CDMX</p>
        </div>
    </div>
</body>
</html>
