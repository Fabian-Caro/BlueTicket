<?php
require_once(__DIR__ . '/../logica/Lugar.php');
require_once(__DIR__ . '/../logica/Evento.php');
require_once(__DIR__ . '/../logica/DetallesEvento.php');
require_once(__DIR__ . '/../logica/Factura.php');
require_once(__DIR__ . '/../logica/Boleta.php');

$idEvento = isset($_GET['idEvento']) ? intval($_GET['idEvento']) : 0;
$idDetalle = isset($_GET['idDetalle']) ? intval($_GET['idDetalle']) : 0;
$cantidadEntradas = isset($_GET['cantidad']) ? intval($_GET['cantidad']) : 0;
$nombres = isset($_GET['nombres']) ? $_GET['nombres'] : [];
$aforo = isset($_GET['aforo']) ? intval($_GET['aforo']) : 0;
// echo "Cantidad de entradas: " . $cantidadEntradas; 
// echo "   aforo  :" . $aforo;
// echo $idEvento;
// echo $idDetalle;

$evento = new Evento();
$eventoData = $evento->consultarIdEvento($idEvento);
if (!$eventoData) {
    echo "Evento no encontrado";
    exit;
}
$detallesEvento = new DetallesEvento();
$detallesData = $detallesEvento->consultarIdDetalles($idDetalle);
$valorPorEntrada = $detallesData->getCostoEvento();
$subTotal = $cantidadEntradas * $valorPorEntrada;
$ivaAgregado = $subTotal*0.19;
$total = $subTotal+$ivaAgregado;

// Obtener fecha actual para la factura
$fechaFactura = date("Y-m-d");
$factura = new Factura();

?>

<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Blue Ticket</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <?php include 'navbar.php';
    $factura -> insertar("'".$fechaFactura."'",$subTotal,$total,$idCliente);
    $idFactura = $factura -> ultimoId();
    //echo "  idFactura : ". $idFactura. "   "; 
    
    $boleta = new  Boleta();
    foreach ($nombres as $nombre) {
        echo "Nombre: " . htmlspecialchars($nombre) . "<br>";
        $boleta -> insertar("'".$nombre."'",$idFactura,$idDetalle);
    }
    ?>

    <div class="container mt-5">
        <div class="invoice-header">
            <h1>Factura</h1>
            <p>Fecha: <strong id="invoice-date"><?php echo $fechaFactura; ?></strong></p>
            <p>Nombre del Comprador: <strong id="buyer-name"><?php echo $cliente->getNombre() . " " . $cliente->getApellido(); ?></strong></p>
        </div>

        <div class="invoice-details">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Cantidad</th>
                        <th>Precio</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><?php echo $eventoData->getNombreEvento() ?></td>
                        <td><?php echo $cantidadEntradas ?></td>
                        <td>$<?php echo $detallesData->getCostoEvento() ?></td>
                        <td>$<?php echo $subTotal ?></td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3" class="text-right">IVA (19%):</td>
                        <td>$<?php echo $ivaAgregado?></td>
                    </tr>
                    <tr class="total">
                        <td colspan="3" class="text-right">Total:</td>
                        <td>$<?php echo $total ?></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    <?php include 'footer.php'; ?>

</body>

</html>