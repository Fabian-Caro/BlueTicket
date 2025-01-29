<?php
require '../src/Services/boletaQR.php';
require '../libraries/fpdf/fpdf.php';

// Recibir datos del formulario
$nombreCliente = $_POST['nombreCliente'] ?? '';
$nombreUsuario = $_POST['nombreUsuario'] ?? '';
$nombreEvento = $_POST['nombreEvento'] ?? '';
$fecha = $_POST['fecha'] ?? '';

// Contenido para el QR
$contenidoQR = "Usuario: $nombreUsuario\nEvento: $nombreEvento\nFecha: $fecha";

// Generar el QR y obtener su ruta
$qrcode = generarQR($contenidoQR);

// Crear un PDF de tamaño personalizado
$anchoPDF = 70; // Ancho del PDF en mm
$altoPDF = 140;  // Alto del PDF en mm
$pdf = new FPDF('P', 'mm', 'letter'); // 'P' para orientación vertical
$pdf->AddPage();

// Agregar un logotipo o encabezado
$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(0, 10, 'Evento QR', 0, 1, 'C');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(0, 5, "Tu entrada digital", 0, 1, 'C');
$pdf->Ln(5);

// Añadir el QR al centro del PDF
if (file_exists($qrcode)) {
    $margenX = ($pdf->GetPageWidth() - 32.5) / 2; // Centrar el QR horizontalmente
    $margenY = $pdf->GetY();
    $pdf->Image($qrcode, $margenX, $margenY, 32.5, 32.5); // Tamaño del QR en mm
    $pdf->Ln(30); // Espacio después del QR
} else {
    $pdf->Cell(0, 10, 'Error: no se pudo generar el código QR.', 0, 1);
}

// Mostrar un mensaje breve
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(0, 10, 'Escanea este codigo para mas detalles.', 0, 1, 'C');
$pdf->Ln(5);

// Mostrar información clave
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 10, "Cliente: $nombreCliente", 0, 1);
$pdf->Cell(0, 10, "Evento: $nombreEvento", 0, 1);
$pdf->Cell(0, 10, "Fecha: $fecha", 0, 0);
$pdf->Ln(10);

// Agregar un pie de página
$pdf->SetFont('Arial', 'I', 8);
$pdf->Cell(0, 10, 'Gracias por tu compra', 0, 1, 'C');

// Generar el PDF en el navegador
$pdf->Output('I', 'boleta.pdf'); // 'I' para inline (mostrar en el navegador), 'D' para descargar directamente
?>
