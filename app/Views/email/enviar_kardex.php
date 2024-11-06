<!DOCTYPE html>
<html>
<head>
    <style>
        /* Puedes agregar estilos en línea o aquí */
        .email-container {
            font-family: Arial, sans-serif;
            color: #333;
        }
        .button {
            display: inline-block;
            padding: 10px 20px;
            color: #fff;
            background-color: #007bff;
            text-decoration: none;
            border-radius: 5px;
        }
        .footer {
            margin-top: 20px;
            font-size: 12px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <h2>Orden de Revisión</h2>
        <p>Hola,</p>
        <p><?php echo $mensaje ?></p>
        <p>Ve a tu panel de contro para revisar esta orden</p>
        <div class="footer">
            <p>&copy; <?= date('Y') ?> Grupo MBI. Todos los derechos reservados.</p>
        </div>
    </div>
</body>
</html>