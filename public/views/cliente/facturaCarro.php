<?php
require_once(__DIR__ . '/../../../src/Logic/Lugar.php');
require_once(__DIR__ . '/../../../src/Logic/Evento.php');
require_once(__DIR__ . '/../../../src/Logic/DetallesEvento.php');
require_once(__DIR__ . '/../../../src/Logic/Factura.php');
require_once(__DIR__ . '/../../../src/Logic/Boleta.php');
require_once(__DIR__ . '/../../../src/Logic/Carro.php');


$idEvento = $_POST['idEvento'];
$evento = new Evento();
$eventoData = $evento->consultarIdEvento($idEvento);

if (isset($_POST['items']) && isset($_POST['data'])) {
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
    foreach ($seleccionados as $indice) {
        // Obtener los datos del elemento seleccionado usando su índice
        $elementos = $datos[$indice];
        $evento = $elementos['eventos'];
        $costo = $elementos['costos'];
        $idDetalles = $elementos['idsDetalles'];

        if (!isset($eventosAgrupados[$evento])) {
            $eventosAgrupados[$evento] = [
                'cantidad' => 0,
                'subtotal' => 0,
                'costo_unitario' => $costo,
                'idDetalles' => [],
            ];
        }

        $eventosAgrupados[$evento]['cantidad']++;
        $eventosAgrupados[$evento]['subtotal'] += $costo;
        $eventosAgrupados[$evento]['idsDetalles'][] = $idDetalles;

        // Acceder a cada campo enviado
        $idCarro = $elementos['idsCarro'];
        $idDetalles = $elementos['idsDetalles'];
        $nombre = $elementos['nombres'];
        $lugar = $elementos['lugares'];
        $artista = $elementos['artistas'];

        $boleta->insertar("'" . $nombre . "'", $idFactura, $idDetalles);
        $carro->eliminar($idCarro);
    }
} else {
    // Si no se seleccionaron elementos o no llegaron datos
    echo "No se seleccionaron elementos para pagar.";
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
            <thead class="table-light">
                <tr>
                    <th>COD.</th>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Precio</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($eventosAgrupados as $evento => $detalles): ?>
                    <tr>
                        <td><?php echo implode(', ', $detalles['idsDetalles']); ?></td>
                        <td><?php echo $evento; ?></td>
                        <td><?php echo $detalles['cantidad']; ?></td>
                        <td>$<?php echo number_format($detalles['costo_unitario'], 2); ?></td>
                        <td>$<?php echo number_format($detalles['subtotal'], 2); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3" class="text-right">IVA (19%):</td>
                    <td>$<?php echo $ivaAgregado ?></td>
                </tr>
                <tr class="total">
                    <td colspan="3" class="text-right">Total:</td>
                    <td>$<?php echo $valor_total ?></td>
                </tr>
            </tfoot>
        </table>
    </div>
    <form action="/generarFactura.php" method="POST" target="_blank">
        <input type="hidden" name="idCliente" value="<?php echo $_SESSION['idCliente']; ?>">
        <input type="hidden" name="idFactura" value="<?php echo $idFactura; ?>">
        <?php foreach ($eventosAgrupados as $evento => $detalles): ?>
            <input type="hidden" name="eventos[<?php echo $evento; ?>][idsDetalles]" value="<?php echo implode(', ', $detalles['idsDetalles']); ?>">
            <input type="hidden" name="eventos[<?php echo $evento; ?>][nombre]" value="<?php echo $evento; ?>">
            <input type="hidden" name="eventos[<?php echo $evento; ?>][cantidad]" value="<?php echo $detalles['cantidad']; ?>">
            <input type="hidden" name="eventos[<?php echo $evento; ?>][costo_unitario]" value="<?php echo $detalles['costo_unitario']; ?>">
            <input type="hidden" name="eventos[<?php echo $evento; ?>][subtotal]" value="<?php echo $detalles['subtotal']; ?>">
        <?php endforeach; ?>
        <input type="hidden" name="valor_subtotal" value="<?php echo $valor_subtotal; ?>">
        <input type="hidden" name="ivaAgregado" value="<?php echo $ivaAgregado; ?>">
        <input type="hidden" name="valor_total" value="<?php echo $valor_total; ?>">
        <input type="hidden" name="tipoFactura" value="carrito">
        <button type="submit">Factura <?php echo $idCliente . "," . $idFactura ?></button>
    </form>
</div>