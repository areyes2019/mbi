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
    <br>
    <br>
    <table class="items" width="100%" style="font-size: 14px; border-collapse: collapse;"  cellpadding="8">
        <thead>
            <tr>
                <td width="50%" style="text-align: left; border: 1px solid #95a5a6;"><strong>Descripción</strong></td>
                <td width="20%" style="text-align: left;border: 1px solid #95a5a6"><strong>Modelo</strong></td>
                <td width="6%" style="text-align: center;border: 1px solid #95a5a6"><strong>Cant.</strong></td>
                <td width="12%" style="text-align: left;border: 1px solid #95a5a6"><strong>P/U</strong></td>
                <td width="12%" style="text-align: left;border: 1px solid #95a5a6"><strong>TOTAL</strong></td>
            </tr>
        </thead>
        <tbody>
            <!-- ITEMS HERE -->
            <?php //foreach ($detalles as $linea): ?>
            <tr>
                    <td style="padding: 9px 7px; line-height: 20px; border: 1px solid #95a5a6; "><?php echo 'Modelo' //$linea['nombre'] ?></td>
                    <td style="padding: 9px 7px; line-height: 20px; border: 1px solid #95a5a6; "><?php echo 'Modelo' //$linea['modelo'] ?></td>
                    <td style="padding: 9px 7px; line-height: 20px; border: 1px solid #95a5a6; text-align: center;"><?php echo 'formato'//$linea['cantidad'] ?></td>
                    <td style="padding: 9px 7px; line-height: 20px; border: 1px solid #95a5a6; ">$<?php echo 'saludos' //number_format($linea['p_unitario'],2)  ?></td>
                    <td style="padding: 9px 7px; line-height: 20px; border: 1px solid #95a5a6; ">$<?php echo 'saludos' //number_format($linea['total'],2) ?></td>
            </tr>
            <?php //endforeach ?>
            <?php //foreach ($detalles_ind as $linea_i): ?>
            <tr>
                    <td style="padding: 9px 7px; line-height: 20px; border: 1px solid #95a5a6; "><?php echo 'Ajuste de motor'//$linea_i['descripcion'] ?></td>
                    <td style="padding: 9px 7px; line-height: 20px; border: 1px solid #95a5a6; ">ND</td>
                    <td style="padding: 9px 7px; line-height: 20px; border: 1px solid #95a5a6; text-align: center;"><?php echo '5'//$linea_i['cantidad'] ?></td>
                    <td style="padding: 9px 7px; line-height: 20px; border: 1px solid #95a5a6; ">$<?php echo '$253.00'//number_format($linea_i['p_unitario'],2)  ?></td>
                    <td style="padding: 9px 7px; line-height: 20px; border: 1px solid #95a5a6; ">$<?php echo '$562.22'//number_format($linea_i['total'],2) ?></td>
            </tr>
            <?php //endforeach ?>
        </tbody>
    </table>
    <br>
    <table width="100%" style="font-family: sans-serif; font-size: 14px;" >
        <tr>
            <td>
                <table width="70%" align="left" style="font-family: sans-serif; font-size: 14px;" >
                    <tr>
                        <td style="padding: 0px; line-height: 20px;">&nbsp;</td>
                    </tr>
                </table>
                <table width="30%" align="right" style="font-family: sans-serif; font-size: 14px; border-collapse: collapse;" >
                    <tr>
                        <td style="border: 1px solid #95a5a6; padding: 10px 8px; line-height: 20px;"><strong>Sub-Total</strong></td>
                        <td style="border: 1px solid #95a5a6; padding: 10px 8px; line-height: 20px;">$<?php echo  '$2530.00'// number_format($sub_total,2)  ?></td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid #95a5a6; padding: 10px 8px; line-height: 20px;"><strong>Dcto</strong></td>
                        <td style="border: 1px solid #95a5a6; padding: 10px 8px; line-height: 20px;"><?php echo  '$2530.00'// number_format($descuento,2); ?></td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid #95a5a6; padding: 10px 8px; line-height: 20px;"><strong>IVA</strong></td>
                        <td style="border: 1px solid #95a5a6; padding: 10px 8px; line-height: 20px;">$<?php echo  '$2530.00'// number_format($iva,2); ?></td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid #95a5a6; padding: 10px 8px; line-height: 20px;"><strong>Total</strong></td>
                        <td style="border: 1px solid #95a5a6; padding: 10px 8px; line-height: 20px;">$<?php echo  '$2530.00'// number_format($total,2)?></td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <br>
    
</body>
</html>