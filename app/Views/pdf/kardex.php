<html>
<head>
    <style>
    body {
        font-family: sans-serif;
        font-size: 10pt;
    }

    p {
        margin: 0pt;
    }

    table.items {
        border: 0.1mm solid #e7e7e7;
    }

    td {
        vertical-align: top;
    }

    .items td {
        border-left: 0.1mm solid #e7e7e7;
        border-right: 0.1mm solid #e7e7e7;
    }

    table thead td {
        text-align: center;
        border: 0.1mm solid #e7e7e7;
    }

    .items td.blanktotal {
        background-color: #EEEEEE;
        border: 0.1mm solid #e7e7e7;
        background-color: #FFFFFF;
        border: 0mm none #e7e7e7;
        border-top: 0.1mm solid #e7e7e7;
        border-right: 0.1mm solid #e7e7e7;
    }

    .items td.totals {
        text-align: right;
        border: 0.1mm solid #e7e7e7;
    }

    .items td.cost {
        text-align: "."center;
    }
    </style>
</head>

<body>
    <table width="100%" style="font-family: sans-serif;" cellpadding="10">
        <tr>
            <td width="20%" style="padding: 0px; text-align: left;">
                <?php
                    $path = base_url('public/img/mbi_logo.png');
                    $type = pathinfo($path, PATHINFO_EXTENSION);
                    $data = file_get_contents($path);
                    $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
                ?>
                <img src="<?php echo $base64; ?>" alt="logo" align="center" width="300" height="200">
            </td>
            <td width="40%">&nbsp;</td>
            <td width="40%" style="text-align: left;">
                
            </td>
        </tr>
        <tr>
          <td height="10" style="font-size: 0px; line-height: 10px; height: 10px; padding: 0px;">&nbsp;</td>
        </tr>
    </table>
    <table width="100%" style="font-family: sans-serif;" cellpadding="10">
        <tr>
            <td width="49%" style="border: 0.5mm solid #95a5a6;">
                <p><strong>Metrología Biomédica Integral</strong></p>
                <p>www.grupo-mbi.com.mx</p>
                <p>Cel: 4613581090</p>
                <p>Tel:461 250 7482</p>
                <p>ventas@gmail.com</p>
                <?php foreach ($atendido_por as $atendido): ?>
                <p style="margin-top: 5px;"><strong>Asigando a:</strong> <?php echo $atendido['destinatario_nombre'] ?></p>
                <?php endforeach ?>
            </td>
            <td width="2%">&nbsp;</td>
            <td width="49%" style="border: 0.5mm solid #95a5a6; text-align: left;">
                <?php foreach ($kardex as $key): ?>
                <p><strong>Kardex No: <?php echo $key['id_kardex'] ?> </strong></p>   
                <p><strong>Fecha: <?php echo  $key['created_at'] ?> </strong></p>   
                <p><strong>Generado por: <?php echo  $key['generado_nombre'] ?> </strong></p>
                <p style="margin-top:15px;"><strong>Datos del cliente:</strong></p>   
                <p style="margin-top: 10px; text-transform: uppercase; font-size: 20px;"><?php echo $key['hospital'] ?></p>
                <p><strong>Titular:</strong> <?php echo $key['titular'] ?></p>
                <p><strong>Responsable:</strong> <?php echo $key['responsable'] ?></p>
                <p style="margin-top:10px;"><strong>Día: <?php echo $key['dia'] ?></strong></p>
                <p><strong>Horario asignado: <?php echo $key['hora'] ?></strong></p>
                <?php endforeach ?>
            </td>
        </tr>
    </table>
    <table width="100%" style="font-family: sans-serif; margin-top: 15px;" cellpadding="10">
        <tr>
            <td width="49%" style="border: 0.5mm solid #95a5a6;">
                <p><strong>Reporte del Vendedor</strong></p>
                <?php foreach ($detalle as $detalle_item ): ?>
                <p><strong>Equipo:</strong> <?php echo  $detalle_item['nombre'] ?> </p>
                <p><strong>Marca:</strong> <?php echo  $detalle_item['marca'] ?> </p>
                <p><strong>Modelo:</strong> <?php echo  $detalle_item['modelo'] ?> </p>
                <p style="margin-top: 5px;"><strong>Falla:</strong></p>
                <p><?php echo $detalle_item['falla'] ?></p>
                <?php endforeach; ?>    
            </td>
            <td width="2%">&nbsp;</td>
            <td width="49%" style="border: 0.5mm solid #95a5a6; text-align: left;">
                <p><strong>Diagnóstico Técnico</strong></p>
                <?php if (!empty($diagnostico)): ?>
                    <?php foreach ($diagnostico as $data_diagnostico):?>
                    <p><strong>Diagnóstico: </strong> <?php echo $data_diagnostico['diagnostico'] ?></p>   
                    <p><strong>Reparación: </strong> <?php echo  $data_diagnostico['reparacion'] ?></p>   
                    <p><strong>Tiempo de Entrega: </strong><?php echo  $data_diagnostico['tiempo_entrega'] ?></p>
                    <p><strong>Costo aproximado: </strong><?php echo  $data_diagnostico['precio_estimado'] ?></p>
                    <?php endforeach ?>
                <?php else: ?>
                    <p>No hay datos de diagnóstico disponibles.</p>
                <?php endif; ?>
                <p style="margin-top: 15px; font-size: 20px;"><strong>Refacciones</strong></p>
                <?php if (!empty($refacciones)): ?>
                    <?php foreach ($refacciones as $refaccion): ?>
                    <p><strong>Nombre: </strong><?php echo $refaccion['refaccion'] ?></p>        
                    <p><strong>Marca: </strong><?php echo $refaccion['marca'] ?></p>        
                    <p><strong>Modelo: </strong><?php echo $refaccion['modelo'] ?></p>        
                    <p><strong>Precio: </strong>$<?php echo $refaccion['precio'] ?></p>        
                    <?php endforeach ?>
                <?php else: ?>
                    <p>No hay refacciones</p>
                <?php endif ?>
            </td>
        </tr>
    </table>
    <br>    
</body>
</html>