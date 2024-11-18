<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cotización 026/M/24</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 90%;
            margin: auto;
            padding: 20px;
        }
        .header, .footer {
            text-align: center;
            margin-bottom: 20px;
        }
        .header img {
            width: 150px;
        }
        .client-info, .conditions {
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #333;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f4f4f4;
        }
        .totals {
            text-align: right;
        }
        .totals th, .totals td {
            border: none;
            padding: 5px 8px;
        }
        .observations, .footer p {
            font-size: 12px;
            color: #555;
        }
        .signature {
            margin-top: 50px;
            text-align: center;
        }
        .signature-line {
            margin-top: 40px;
            border-top: 1px solid #000;
            width: 60%;
            margin-left: auto;
            margin-right: auto;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>COTIZACIÓN: <?php echo $cotizacion ?>  /M/24</h1>
            <p><strong>Contacto:</strong> Monserrat Cano</p>
            <p><strong>E-mail:</strong> admonbajio@grupo-mbi.com.mx</p>
        </div>

        <div class="client-info">
            <?php foreach ($cliente as $clientes): ?>
            <p><strong>At'n a: </strong><?php echo $clientes['responsable'] ?></p>
            <p><strong>Institución:</strong> <?php echo $clientes['hospital']; ?></p>
            <p><strong>Campus:</strong> <?php echo $clientes['facultad']; ?></p>
            <?php endforeach ?>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Partida</th>
                    <th>Cantidad</th>
                    <th>Descripción</th>
                    <th>Precio Unitario</th>
                    <th>Importe</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($detalles as $detalle): ?>
                <tr>
                    <td><?php echo $detalle['partida'] ?></td>
                    <td><?php echo $detalle['cantidad'] ?></td>
                    <td><?php echo $detalle['descripcion'] ?></td>
                    <td>$<?php echo number_format($detalle['precio_unitario'],2)?></td>
                    <td>$<?php echo number_format($detalle['precio_unitario'] * $detalle['cantidad'],2)?></td>
                </tr>
                <?php endforeach ?>
            </tbody>
        </table>

        <div class="totals">
            <table>
                <tr>
                    <th>Importe:</th>
                    <td>$<?php echo $sub_total ?></td>
                </tr>
                <tr>
                    <th>IVA (16%):</th>
                    <td>$<?php echo $iva ?></td>
                </tr>
                <tr>
                    <th>Total:</th>
                    <td><strong>$<?php echo $total ?></strong></td>
                </tr>
            </table>
        </div>

        <div class="conditions">
            <h3>Condiciones Comerciales</h3>
            <p style="margin: 0px;"><strong>Validez de la cotización:</strong> 15 días</p>
            <p style="margin: 0px;"><strong>Forma de pago:</strong> Crédito UNAM</p>
            <p style="margin: 0px;"><strong>Tipo de moneda:</strong> Moneda nacional</p>
            <p style="margin: 0px;"><strong>Tiempo de entrega:</strong> 10 - 20 días hábiles</p>
        </div>

        <div class="observations">
            <p>Esta cotización se convertirá en pedido cuando cuente con la firma del cliente, y se respetará el precio establecido. 
            Quedando en entendido todos los términos, características y condiciones descritos en esta cotización y/o anexos adjuntos.</p>
            <p>El tiempo de entrega es a partir de recibir por vía o e-mail su orden de compra o cotización firmada y el anticipo correspondiente.</p>
            <p>Toda cancelación genera un cargo equivalente al 20% del valor total de esta cotización.</p>
        </div>
        <div class="signature">
            <p>Atentamente,</p>
            <div class="signature-line"></div>
        </div>
        <div class="footer">
            <?php foreach ($usuario as $vendedor): ?>
            <p><strong><?php echo $vendedor['nombre']." ".$vendedor['apellidos'] ?></strong><br>Asesor de ventas</p>
            <p><?php echo $vendedor['mobil'] ?><br><?php echo $fecha ?></p>
            <?php endforeach ?>
        </div>
    </div>
</body>
</html>
