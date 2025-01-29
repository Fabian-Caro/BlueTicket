<!--utilización del patrón PRG (POST, Redirect, GET)-->
<?php
date_default_timezone_set('America/Bogota');

require_once(__DIR__ . '/../../../config/routes.php');
require_once(__DIR__ . '/../../../config/config.php');
require_once(__DIR__ . '/../../../src/Logic/Lugar.php');
require_once(__DIR__ . '/../../../src/Logic/Evento.php');
require_once(__DIR__ . '/../../../src/Logic/DetallesEvento.php');
require_once(__DIR__ . '/../../../src/Logic/Carro.php');
require_once(__DIR__ . '/../../../src/Logic/Factura.php');
require_once(__DIR__ . '/../../../src/Logic/Boleta.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (isset($_POST['items']) && isset($_POST['data'])) {

        $idEvento = $_POST['idEvento'];
        $evento = new Evento();
        $eventoData = $evento->consultarIdEvento($idEvento);
        // Los índices de los elementos seleccionados en el formulario
        $seleccionados = $_POST['items']; // Ejemplo: [0, 2, 3]

        // Todos los datos ocultos enviados en el formulario
        $datos = $_POST['data'];

        $valor_subtotal = isset($_POST['costo_total']) ? floatval($_POST['costo_total']) : 0;
        $ivaAgregado = $valor_subtotal * 0.19;
        $valor_total = $valor_subtotal + $ivaAgregado;

        $fechaHoraActual = date('Y-m-d H:i:s');
        $factura = new Factura();
        $factura->insertar("'" . $fechaHoraActual . "'", $valor_subtotal, $valor_total, $idCliente);
        $idFactura = $factura->ultimoId();
        $boleta = new  Boleta();
        $carro = new Carro();
        // Iterar sobre los elementos seleccionados
        $eventosAgrupados = [];
        $idEventos = [];
        $idDetalles = [];
        foreach ($seleccionados as $indice) {
            // Obtener los datos del elemento seleccionado usando su índice
            $elementos = $datos[$indice];
            //print_r($elementos);

            if (isset($elementos['idEventos'])) {
                // Agregar el valor de 'idEventos' al arreglo
                $idEventos[] = $elementos['idEventos'];
            }

            if (isset($elementos['idDetalles'])) {
                // Agregar el valor de 'idDetalles' al arreglo
                $idDetalles[] = $elementos['idDetalles'];
            }

            $evento = $elementos['eventos'];
            $costo = $elementos['costos'];

            if (!isset($eventosAgrupados[$evento])) {
                $eventosAgrupados[$evento] = [
                    'cantidad' => 0,
                    'subtotal' => 0,
                    'costo_unitario' => $costo
                ];
            }

            $eventosAgrupados[$evento]['cantidad']++;
            $eventosAgrupados[$evento]['subtotal'] += $costo;

            // Acceder a cada campo enviado
            $idCarro = $elementos['idsCarro'];
            $idDetalles = $elementos['idsDetalles'];
            $nombre = $elementos['nombres'];
            $lugar = $elementos['lugares'];
            $artista = $elementos['artistas'];

            $boleta->insertar("'" . $nombre . "'", $idFactura, $idDetalles);
            $carro->eliminar($idCarro);
        }

        if (!empty($idEventos)) {
            // Ahora podemos usar implode para convertir el arreglo en una cadena separada por comas
            $idEventosStr = implode(',', $idEventos);
            if (!empty($idDetalles)) {
                // Ahora podemos usar implode para convertir el arreglo en una cadena separada por comas
                $idDetallesStr = implode(',', $idDetalles);

                // Redirigir con la lista de idDetalles en la URL
                header("Location: /factura?idFactura=$idFactura&idEvento=$idEventos&cantidad=0&idDetalle=$idDetallesStr&carro");
            } else {
                // Si no hay detalles seleccionados, muestra un mensaje de error
                echo "No se han seleccionado detalles.";
            }

            // Redirigir con la lista de idEventos en la URL
            header("Location: /factura?idFactura=$idFactura&idEvento=$idEventosStr&cantidad=0&idDetalle=$idDetalles&carro");
        } else {
            // Si no hay eventos seleccionados, muestra un mensaje de error
            echo "No se han seleccionado eventos.";
        }
    } else {

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

        header("Location: /factura?idFactura=$idFactura&idEvento=$idEvento&cantidad=$cantidadEntradas&idDetalle=$idDetalle&unico");
    }

    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $idFactura = isset($_GET['idFactura']) ? intval($_GET['idFactura']) : 0;
    $idEvento = isset($_GET['idEvento']) ? intval($_GET['idEvento']) : 0;
    //echo $idEvento;
    $cantidadEntradas = isset($_GET['cantidad']) ? intval($_GET['cantidad']) : 0;
    $idDetalle = isset($_GET['idDetalle']) ? intval($_GET['idDetalle']) : 0;

    if (!$idFactura) {
        echo "No se especificó una factura válida.";
        exit;
    }

    $factura = new Factura($idFactura);
    $factura->consultar();
    $fechaFacturacion = date("d/m/Y H:i:s", strtotime($factura->getFecha()));
    $valorSubTotal = $factura->getValorSubtotal();
    $valorTotal = $factura->getValorTotal();

    $idCliente = $factura->getCliente()->getIdCliente();
    $cliente = new Cliente($idCliente);
    $cliente->consultar();

    if ($cantidadEntradas > 0 && $idDetalle > 0) {

        $detallesEvento = new DetallesEvento();
        $detallesData = $detallesEvento->consultarIdDetalles($idDetalle);

        $valorPorEntrada = $detallesData->getCostoEvento();
        $subTotal = $cantidadEntradas * $valorPorEntrada;
        $ivaAgregado = $subTotal * 0.19;
        $total = $subTotal + $ivaAgregado;

        $evento = new Evento();
        $eventoData = $evento->consultarIdEvento($idEvento);
    } else {
        echo $idEvento;
        $boleta = new  Boleta();
        $itemsFactura = $boleta->consultarPorFactura($idFactura);
        $eventosAgrupados = [];

        foreach ($itemsFactura as $item) {
            echo $idEvento;
            //print_r($item);
            $evento = $item['idDetalle'];
            $costo = $item['costoUnitario'];

            if (!isset($eventosAgrupados[$evento])) {
                $eventosAgrupados[$evento] = [
                    'nombre' => $item['nombreEvento'],
                    'cantidad' => 0,
                    'subtotal' => 0,
                    'costo_unitario' => $costo
                ];
            }

            $eventosAgrupados[$evento]['cantidad']++;
            $eventosAgrupados[$evento]['subtotal'] += $costo;
        }

        $valor_subtotal = isset($_GET['costo_total']) ? floatval($_GET['costo_total']) : 0;
        $ivaAgregado = $valor_subtotal * 0.19;
        $valor_total = $valor_subtotal + $ivaAgregado;
    }
}


?>
<style>
    body {
        background-color: #F8F9FA;
        font-family: 'Poppins', sans-serif;
    }

    .container {
        max-width: 900px;
        margin: 40px auto;
        padding: 30px;
        background: #ffffff;
        border-radius: 12px;
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
    }

    .invoice-header {
        text-align: center;
        margin-bottom: 30px;
        color: #007BFF;
    }

    .invoice-header h1 {
        font-weight: bold;
        font-size: 36px;
    }

    .invoice-header p {
        font-size: 18px;
    }

    .invoice-details table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 30px;
    }

    .invoice-details th,
    .invoice-details td {
        padding: 12px;
        text-align: center;
    }

    .invoice-details thead {
        background-color: #f2f2f2;
    }

    .invoice-details tbody tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    .invoice-details tfoot td {
        font-weight: bold;
    }

    .total {
        background-color: #f8f9fa;
    }

    .invoice-details .text-right {
        text-align: right;
    }

    form {
        text-align: center;
        margin-top: 30px;
    }

    form button {
        background-color: #007BFF;
        color: white;
        padding: 12px 24px;
        font-size: 16px;
        border: none;
        border-radius: 6px;
        transition: background 0.3s ease;
    }

    form button:hover {
        background-color: #0056B3;
    }
</style>
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
        <input type="hidden" name="tipoFactura" value="individual">
        <button type="submit">Generar Factura</button>
    </form>
</div>