<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cotización de Servicio</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        .container { width: 90%; margin: 0 auto; }
        .header { display: flex; justify-content: space-between; align-items: center; background-color: #800080; color: white; padding: 10px; }
        .header h2 { margin: 0; }
        .logo { width: 250px; height: auto; }
        .info { display: flex; justify-content: space-between; margin-top: 10px; }
        .vendedor, .cotizacion { width: 45%; }
        .box { background-color: #800080; color: white; padding: 10px; margin-top: 10px; font-weight: bold; text-align: center; }
        .content-box { border: 1px solid #800080; padding: 10px; margin-bottom: 10px; }
        .table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        .table, .table th, .table td { border: 1px solid black; }
        .table th { background-color: #800080; color: white; padding: 8px; text-align: center; }
        .table td { padding: 8px; text-align: center; }
        .observaciones { margin-top: 10px; font-size: 10px; background-color: #f2f2f2; padding: 10px; }
        .firma { margin-top: 20px; text-align: center; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>COTIZACIÓN DE SERVICIO</h2>
            <?php
                $path = base_url('public/img/logo_ecolab.png');
                $type = pathinfo($path, PATHINFO_EXTENSION);
                $data = file_get_contents($path);
                $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
            ?>
            <img src="<?php echo $base64;?>" alt="logo" class="logo">
        </div>
        
        <div class="info">
            <div class="vendedor">
                <p><strong>Vendedor:</strong><?php echo $vendedor?></p>
                <p><strong>Email:</strong> ventas_secolab@hotmail.com</p>
                <p><strong>Teléfono:</strong>556 633 666</p>
            </div>
            <div class="cotizacion">
                <p><strong>Fecha:</strong> <?php echo $fecha?></p>
                <p><strong>No. Cotización:</strong><?php echo $id_cotizacion ?></p>
            </div>
        </div>
        
        <div class="box">TÉRMINOS Y CONDICIONES</div>
        <div class="content-box">
            <p><strong>Vigencia:</strong> 15 días</p>
            <p><strong>Moneda:</strong> Nacional (Pesos)</p>
            <p><strong>Garantía:</strong> 3 meses</p>
        </div>
        
        <div class="box">DATOS DEL CLIENTE</div>
        <div class="content-box">
            <p><strong>Cliente:</strong><?php echo $cliente['hospital']; ?></p>
            <p><strong>Dirigido a:</strong><?php echo $cliente['facultad'] ?></p>
            <p><strong>Dirigido a:</strong><?php echo $cliente['responsable'] ?></p>
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
        
        <p><strong>Subtotal:</strong> $<?php echo $sub_total?></p>
        <p><strong>IVA:</strong> $<?php echo $iva ?></p>
        <p><strong>Total:</strong> $<?php echo $total ?></p>
        
        <div class="observaciones">
            <p><strong>Observaciones:</strong></p>
            <p>La presente cotización se convertirá en pedido cuando tenga la firma y leyenda del cliente.</p>
            <p>Toda cancelación genera una penalización del 25% del valor total de la cotización.</p>
        </div>
        
        <div class="firma">
            <p>______________________________</p>
            <p><strong>Aneel Ramírez</strong></p>
            <p>Representante de Ventas CDMX</p>
        </div>
    </div>
</body>
</html>
