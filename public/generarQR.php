<?php
include '../src/Services/boletaQR.php';

// Recibir datos del formulario
$nombreCliente = $_POST['nombreCliente'] ?? '';
$nombreUsuario = $_POST['nombreUsuario'] ?? '';
$nombreEvento = $_POST['nombreEvento'] ?? '';
$fecha = $_POST['fecha'] ?? '';

// Contenido para el QR
$contenidoQR = "Cliente: $nombreCliente\nUsuario: $nombreUsuario\nEvento: $nombreEvento\nFecha: $fecha";

// Generar el QR
$qrcode = generarQR($contenidoQR);

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QR Code Generado</title>
    <style>
        .qr-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
    </style>
</head>
<body>
    <div class="qr-container">
        <?php
        if (file_exists($qrcode)) {
            echo "<img src='/assets/images/qr.png' alt='QR Code' />";
        } else {
            echo "Error: no se pudo generar el QR.";
        }
        ?>
    </div>
</body>
</html>
