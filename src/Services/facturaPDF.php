<?php
/// Powered by Evilnapsis go to http://evilnapsis.com
require_once (__DIR__ . '/../../libraries/FPDF/fpdf.php');
require_once (__DIR__ . '/../../config/config.php');
$datosEmpresa = require_once (__DIR__ . '/../../config/datosEmpresa.php');
require_once (__DIR__ . '/../Logic/Cliente.php');
require_once (__DIR__ . '/../Logic/Factura.php');
require_once (__DIR__ . '/../Logic/DetallesEvento.php');
require_once (__DIR__ . '/../Logic/Lugar.php');
require_once (__DIR__ . '/../Logic/Evento.php');
require_once (__DIR__ . '/../Logic/DetallesEvento.php');
require_once (__DIR__ . '/../Logic/Boleta.php');

// $idCliente = isset($_POST['idCliente']) ? intval($_POST['idCliente']) : 0;
// $idFactura = isset($_POST['idFactura']) ? intval($_POST['idFactura']) : 0;

if (isset($_POST['idCliente']) && isset($_POST['idFactura'])) {
    $idCliente = $_POST['idCliente'];
    $idFactura = $_POST['idFactura'];
    $idDetalle = $_POST['idDetalle'];
    $idEvento = $_POST['idEvento'];
    $cantidadEntradas = $_POST['cantidadEntradas'];
    $cliente = new Cliente($idCliente);
    $cliente -> consultar();
    $factura = new Factura($idFactura);
    $factura -> consultar();
    $fechaFactura = date("d/m/Y H:i:s", strtotime($factura -> getFecha()));
    $detalleEvento = new DetallesEvento($idDetalle);
    $detalleEvento -> consultarDetallesEvento($idDetalle);
    $detallesData = $detalleEvento->consultarIdDetalles($idDetalle);
    $evento = new Evento($idEvento);
    $evento -> consultar();


    $pdf = new FPDF($orientation = 'P', $unit = 'mm');
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 20);
    $textypos = 5;
    $pdf->setY(12);
    $pdf->setX(10);
    // Agregamos los datos de la empresa
    $pdf->Cell(5, $textypos, $datosEmpresa['nombre']);
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->setY(30);
    $pdf->setX(10);
    $pdf->Cell(5, $textypos, "DE:");
    $pdf->SetFont('Arial', '', 10);
    $pdf->setY(35);
    $pdf->setX(10);
    $pdf->Cell(5, $textypos, $datosEmpresa['nombre']);
    $pdf->setY(40);
    $pdf->setX(10);
    $pdf->Cell(5, $textypos, $datosEmpresa['direccion']);
    $pdf->setY(45);
    $pdf->setX(10);
    $pdf->Cell(5, $textypos, $datosEmpresa['telefono']);
    $pdf->setY(50);
    $pdf->setX(10);
    $pdf->Cell(5, $textypos, $datosEmpresa['correo']);

    // Agregamos los datos del cliente
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->setY(30);
    $pdf->setX(75);
    $pdf->Cell(5, $textypos, "PARA:");
    $pdf->SetFont('Arial', '', 10);
    $pdf->setY(35);
    $pdf->setX(75);
    $pdf->Cell(5, $textypos, $cliente -> getNombre() . ' ' . $cliente -> getApellido());
    $pdf->setY(40);
    $pdf->setX(75);
    //$pdf->Cell(5, $textypos, "Direccion del cliente");
    //$pdf->setY(45);
    //$pdf->setX(75);
    //$pdf->Cell(5, $textypos, "Telefono del cliente");
    //$pdf->setY(50);
    //$pdf->setX(75);
    $pdf->Cell(5, $textypos, $cliente -> getCorreo());

    // Agregamos los datos del cliente
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->setY(30);
    $pdf->setX(135);
    $pdf->Cell(5, $textypos, "FACTURA #" . $idFactura);
    $pdf->SetFont('Arial', '', 10);
    $pdf->setY(35);
    $pdf->setX(135);
    $pdf->Cell(5, $textypos, "Fecha y hora: " . $fechaFactura);
    $pdf->setY(40);
    $pdf->setX(135);
    $pdf->Cell(5, $textypos, "Vencimiento: " . $fechaFactura);
    $pdf->setY(45);
    $pdf->setX(135);
    $pdf->Cell(5, $textypos, "");
    $pdf->setY(50);
    $pdf->setX(135);
    $pdf->Cell(5, $textypos, "");

    /// Apartir de aqui empezamos con la tabla de productos
    $pdf->setY(60);
    $pdf->setX(135);
    $pdf->Ln();
    /////////////////////////////
    //// Array de Cabecera
    $header = array("Cod.", "Descripcion", "Cant.", "Precio", "Subtotal");
    //// Arrar de Productos
    $products = array(
        //idEvento, NombreEvento, factura mal hecha, agregar cantidad, precioEvento, valor_total
        array($detalleEvento -> getIdDetallesEvento(), $evento->getNombreEvento(), $cantidadEntradas, $detallesData->getCostoEvento(), 0),
    );
    // Column widths
    $w = array(20, 95, 20, 25, 25);
    // Header
    for ($i = 0; $i < count($header); $i++)
        $pdf->Cell($w[$i], 7, $header[$i], 1, 0, 'C');
    $pdf->Ln();
    // Data
    $total = 0;
    foreach ($products as $row) {
        $pdf->Cell($w[0], 6, $row[0], 1);
        $pdf->Cell($w[1], 6, $row[1], 1);
        $pdf->Cell($w[2], 6, number_format($row[2]), '1', 0, 'R');
        $pdf->Cell($w[3], 6, "$ " . number_format($row[3], 2, ".", ","), '1', 0, 'R');
        $pdf->Cell($w[4], 6, "$ " . number_format($row[3] * $row[2], 2, ".", ","), '1', 0, 'R');

        $pdf->Ln();
        $total += $row[3] * $row[2];
    }
    /////////////////////////////
    //// Apartir de aqui esta la tabla con los subtotales y totales
    $yposdinamic = 60 + (count($products) * 10);

    $pdf->setY($yposdinamic);
    $pdf->setX(235);
    $pdf->Ln();
    /////////////////////////////
    $header = array("", "");
    $ivaAgregado = $total * 0.19;
    $data2 = array(
        array("Subtotal", $total),
        array("Descuento", 0),      
        array("Impuesto", $ivaAgregado),
        array("Total", $total+$ivaAgregado),
    );
    // Column widths
    $w2 = array(40, 40);
    // Header

    $pdf->Ln();
    // Data
    foreach ($data2 as $row) {
        $pdf->setX(115);
        $pdf->Cell($w2[0], 6, $row[0], 1);
        $pdf->Cell($w2[1], 6, "$ " . number_format($row[1], 2, ".", ","), '1', 0, 'R');

        $pdf->Ln();
    }
    /////////////////////////////

    $yposdinamic += (count($data2) * 10);
    $pdf->SetFont('Arial', 'B', 10);

    $pdf->setY($yposdinamic);
    $pdf->setX(10);
    $pdf->Cell(5, $textypos, "TERMINOS Y CONDICIONES");
    $pdf->SetFont('Arial', '', 10);

    $pdf->setY($yposdinamic + 10);
    $pdf->setX(10);
    $pdf->Cell(5, $textypos, "El cliente se compromete a pagar la factura.");
    $pdf->setY($yposdinamic + 20);
    $pdf->setX(10);
    //$pdf->Cell(5, $textypos, "Powered by Evilnapsis");


    $pdf->output();
} else {
    // Redirigir si no se recibieron los datos correctamente
    header("Location: /views/shared/errors/error404.php");
    exit;
}
