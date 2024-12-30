<!--utilización del patrón PRG (POST, Redirect, GET)-->
<?php
date_default_timezone_set('America/Bogota');

require_once(__DIR__ . '/../../../config/routes.php');
require_once(__DIR__ . '/../../../config/config.php');
require_once(__DIR__ . '/../../../logica/Lugar.php');
require_once(__DIR__ . '/../../../logica/Evento.php');
require_once(__DIR__ . '/../../../logica/DetallesEvento.php');
require_once(__DIR__ . '/../../../logica/Factura.php');
require_once(__DIR__ . '/../../../logica/Boleta.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $idEvento = isset($_POST['idEvento']) ? intval($_POST['idEvento']) : 0;
    $idDetalle = isset($_POST['idDetalle']) ? intval($_POST['idDetalle']) : 0;
    $idCliente = isset($_POST['idCliente']) ? intval($_POST['idCliente']) : 0;
    $cantidadEntradas = isset($_POST['cantidad']) ? intval($_POST['cantidad']) : 0;
    $nombres = isset($_POST['nombres']) ? $_POST['nombres'] : [];
    $aforo = isset($_POST['aforo']) ? intval($_POST['aforo']) : 0;

    if (isset($_SESSION['idCliente'])) {
        $idCliente = $_SESSION['idCliente'];
    }

    if (!$idEvento || !$idDetalle || !$idCliente) {
        echo "Datos incompletos para generar una factura.";
        exit;
    }

    $evento = new Evento();
    $eventoData = $evento->consultarIdEvento($idEvento);
    $detallesEvento = new DetallesEvento();
    $detallesData = $detallesEvento->consultarIdDetalles($idDetalle);

    $valorPorEntrada = $detallesData->getCostoEvento();
    $subTotal = $cantidadEntradas * $valorPorEntrada;
    $ivaAgregado = $subTotal * 0.19;
    $total = $subTotal + $ivaAgregado;
    $fechaHoraActual = date('Y-m-d H:i:s');

    $factura = new Factura();
    $factura->insertar("'" . $fechaHoraActual . "'", $subTotal, $total, $idCliente);
    $idFactura = $factura->ultimoId();

    $boleta = new  Boleta();
    foreach ($nombres as $nombre) {
        $boleta->insertar("'" . $nombre . "'", $idFactura, $idDetalle);
    }

    header("Location: /factura?idFactura=$idFactura&idEvento=$idEvento&cantidad=$cantidadEntradas&idDetalle=$idDetalle");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $idFactura = isset($_GET['idFactura']) ? intval($_GET['idFactura']) : 0;
    $idEvento = isset($_GET['idEvento']) ? intval($_GET['idEvento']) : 0;
    $cantidadEntradas = isset($_GET['cantidad']) ? intval($_GET['cantidad']) : 0;
    $idDetalle = isset($_GET['idDetalle']) ? intval($_GET['idDetalle']) : 0;

    $detallesEvento = new DetallesEvento();
    $detallesData = $detallesEvento->consultarIdDetalles($idDetalle);

    $valorPorEntrada = $detallesData->getCostoEvento();
    $subTotal = $cantidadEntradas * $valorPorEntrada;
    $ivaAgregado = $subTotal * 0.19;
    $total = $subTotal + $ivaAgregado;

    if (!$idFactura) {
        echo "No se especificó una factura válida.";
        exit;
    }

    $factura = new Factura($idFactura);
    $factura->consultar();
    $fechaFacturacion = date("d/m/Y H:i:s", strtotime($factura->getFecha()));

    $evento = new Evento();
    $eventoData = $evento->consultarIdEvento($idEvento);
    $idCliente = $factura->getCliente()->getIdCliente();
    $cliente = new Cliente($idCliente);
    $cliente->consultar();
}
?>
<div class="container mt-5">
    <div class="invoice-header">
        <h1>Factura</h1>
        <p>Fecha: <strong id="invoice-date"><?php echo $fechaFacturacion; ?></strong></p>
        <p>Nombre del Comprador: <strong id="buyer-name"><?php echo $cliente->getNombre() . " " . $cliente->getApellido(); ?></strong></p>
    </div>

    <div class="invoice-details">
        <table class="table table-bordered">
            <thead class="table-light">
                <tr>
                    <th>Cod</th>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Precio</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><?php echo $idDetalle ?></td>
                    <td><?php echo $eventoData->getNombreEvento() ?></td>
                    <td><?php echo $cantidadEntradas ?></td>
                    <td>$<?php echo $detallesData->getCostoEvento() ?></td>
                    <td>$<?php echo $subTotal ?></td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3" class="text-right">IVA (19%):</td>
                    <td>$<?php echo $ivaAgregado ?></td>
                </tr>
                <tr class="total">
                    <td colspan="3" class="text-right">Total:</td>
                    <td>$<?php echo $total ?></td>
                </tr>
            </tfoot>
        </table>
    </div>
    <form action="/generarFactura.php" method="POST" target="_blank">
        <input type="hidden" name="idCliente" value="<?php echo $_SESSION['idCliente']; ?>"> 
        <input type="hidden" name="idFactura" value="<?php echo $idFactura; ?>"> 
        <input type="hidden" name="idDetalle" value="<?php echo $idDetalle; ?>">
        <input type="hidden" name="idEvento" value="<?php echo $idEvento; ?>">
        <input type="hidden" name="cantidadEntradas" value="<?php echo $cantidadEntradas; ?>">
        <button type="submit">Factura <?php echo $idCliente . "," . $idFactura ?></button>
    </form>
</div>