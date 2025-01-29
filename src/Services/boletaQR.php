<?php
require_once(__DIR__ . '/../../libraries/PHPQRCODE/qrlib.php');

function generarQR($contenido) {
    $path = (__DIR__ . "/../../public/assets/images");
    if (!file_exists($path)) {
        mkdir($path, 0777, true); // Crear el directorio si no existe
    }
    $qrcode = $path . DIRECTORY_SEPARATOR . "qr.png";

    // Generar el QR
    QRcode::png($contenido, $qrcode);

    // Retornar la ruta del archivo QR generado
    return $qrcode;
}
?>
