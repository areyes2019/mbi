<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nuevo Kardex Asignado</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f7f7;
            color: #333;
            padding: 20px;
        }
        .email-container {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 20px;
            max-width: 600px;
            margin: 0 auto;
        }
        .header {
            text-align: center;
            background-color: #3498db;
            color: #fff;
            padding: 10px;
            border-radius: 6px;
        }
        .message {
            padding: 20px;
            font-size: 16px;
            line-height: 1.6;
        }
        .footer {
            text-align: center;
            font-size: 12px;
            color: #aaa;
            padding-top: 10px;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <h1>Información relacionada con el kardex # <?= $kardex?></h1>
        </div>
        <div class="message">
            <p>Hola,</p>
            <p><?= $mensaje ?></p>
        </div>
        <div class="footer">
            <p>Este correo fue enviado automáticamente por el Sistema Kardex.</p>
        </div>
    </div>
</body>
</html>