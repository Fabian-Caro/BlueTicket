<?php

if ( isset ( $_POST['tipoFactura'] ) ) {
    $tipoFactura = $_POST['tipoFactura'];

    if ( $tipoFactura === 'individual' ) {
        include '../src/Services/facturaPDF.php';
    } else if ( $tipoFactura === 'carrito') {
        include '../src/Services/facturaCarroPDF.php';
    } else {
        echo 'Tipo de factura no válido';
        exit;
    }
} else {
    echo 'No se ha especificado el tipo de factura';
    exit;
}

?>