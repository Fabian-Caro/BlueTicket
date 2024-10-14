<?php
require_once(__DIR__ . '/../logica/Lugar.php');
require_once(__DIR__ . '/../logica/Evento.php');
require_once(__DIR__ . '/../logica/DetallesEvento.php');
$idEvento = isset($_GET['idEvento']) ? intval($_GET['idEvento']) : 0;
$idDetalle = isset($_GET['idDetalle']) ? intval($_GET['idDetalle']) : 0;
$cantidadEntradas = isset($_GET['cantidad']) ? intval($_GET['cantidad']) : 0;
echo $cantidadEntradas;

echo $idEvento;
echo $idDetalle;

$evento = new Evento();
$eventoData = $evento->consultarIdEvento($idEvento);
$detallesEvento = new DetallesEvento();
$detallesData = $detallesEvento->consultarIdDetalles($idDetalle);
$valorPorEntrada = $detallesData->getCostoEvento();
$costoTotal = $cantidadEntradas * $valorPorEntrada;

if (!$eventoData) {
    echo "Evento no encontrado";
    exit;
}

// Verificar si se ha enviado la cantidad de entradas
if (isset($_GET['cantidad'])) {
    $cantidadEntradas = intval($_GET['cantidad']);

    // Verificar si la cantidad es mayor a 0
    if ($cantidadEntradas > 0) {
        // Continuar con el proceso de pago o lo que necesites
        echo "Cantidad de entradas seleccionada: " . $cantidadEntradas;
        // Aquí iría la lógica para el pago
    } else {
        // Obtener los parámetros actuales de la URL, excluyendo 'cantidad'
        $params = $_GET;
        unset($params['cantidad']); // Elimina 'cantidad' de los parámetros

        // Redirigir de nuevo a la página anterior manteniendo los otros parámetros
        header("Location: compra.php?" . http_build_query($params) . "&error=sin_entradas");
        exit(); // Siempre es importante usar exit después de header
    }
} else {
    // En caso de que no haya una cantidad de entradas enviada
    header("Location: compra.php?" . http_build_query($_GET)); // Mantiene otros parámetros
    exit();
}

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

    <?php include 'navbar.php' ?>

    <div class="container mt-4">
        <?php
        echo "<div class='fs-1'>"
            . $eventoData->getArtista()->getNombre() . ": "
            . $eventoData->getNombreEvento() . " - " . $detallesData->getLugar()->getCiudad()->getNombreCiudad()
            . "</div>";
        $fecha = $detallesData->getFechaEvento();

        if ($fecha) {
            $date = new DateTime($fecha);
            $dias = ['domingo', 'lunes', 'martes', 'miércoles', 'jueves', 'viernes', 'sábado'];
            $meses = ['enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre'];

            $diaNombre = $dias[$date->format('w')]; // Día de la semana
            $dia = $date->format('d'); // Día del mes
            $mesNombre = $meses[$date->format('n') - 1]; // Nombre del mes
            $anio = $date->format('Y'); // Año

            $fechaFormateada = "{$diaNombre}, {$dia} de {$mesNombre} de {$anio}";

            echo "<div class='fs-6'>" . $fechaFormateada . "</div>"; // Muestra la fecha en español
        } else {
            echo "Fecha no disponible.";
        }
        echo "<div class='fs-6'>" . $detallesData->getLugar()->getNombreLugar() . "</div>";
        echo "<div class='fs-6'>" . $detallesData->getLugar()->getCiudad()->getNombreCiudad() . "</div>";
        ?>
    </div>

    <?php
    echo '<form class="container mt-4">';

    for ($i = 1; $i <= $cantidadEntradas; $i++) {
        echo '
        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <input type="text" class="form-control" name="nombre_' . $i . '" placeholder="Nombre" required>
            </div>
            <div class="col-md-4">
                <input type="text" class="form-control" name="apellido_' . $i . '" placeholder="Apellido" required>
            </div>
            <div class="col-md-4">
                <input type="text" class="form-control" name="documento_' . $i . '" placeholder="Documento" required>
            </div>
        </div>';
    }

    echo '</form>';
    ?>
    <div class="container mt-5 px-5">
        <div class="row">
            <div class="col-md-8">
                <div class="card p-3">
                    <h6 class="text-uppercase">Detalles del pago</h6>
                    <div class="inputbox mt-3"> <input type="text" name="name" class="form-control" placeholder="Nombre del titular" required="required" disabled>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="inputbox mt-3 mr-2">
                                <input type="text" name="name" class="form-control" placeholder="Numero de la tarjeta" required="required" disabled>
                                <i class="fa fa-credit-card"></i>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex flex-row">
                                <div class="inputbox mt-3 mr-2">
                                    <input type="text" name="name" class="form-control" placeholder="Expiración" required="required" disabled>
                                </div>
                                <div class="inputbox mt-3 mr-2">
                                    <input type="text" name="name" class="form-control" placeholder="CVC" required="required" disabled>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                ?>
                <div class="d-flex justify-content-center mt-3">
                    <form action="factura.php" method="GET">
                        <input type="hidden" name="idEvento" value="<?php echo $eventoData->getIdEvento(); ?>">
                        <input type="hidden" name="idDetalle" value="<?php echo $detallesData->getIdDetallesEvento(); ?>">
                        <!-- Aquí asignamos el valor de $cantidadEntradas al input hidden -->
                        <input type="hidden" name="cantidad" id="cantidad" value="<?php echo $cantidadEntradas; ?>">
                        <button type="submit" class="btn btn-primary">Pagar</button>
                    </form>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card card-blue p-3 text-black mb-3 text-center">
                    <div class="d-flex justify-content-center"> <!-- Div para centrar la imagen -->
                        <img src="imagenes/100.png" alt="Descripción de la imagen" class="img-fluid" style="max-width: 100px; height: auto;">
                    </div>
                    <h2><?php echo "<div class='fs-5'>" . $eventoData->getNombreEvento() . " - " . $detallesData->getLugar()->getCiudad()->getNombreCiudad() . "</div>"; ?></h2>

                    <div class="d-flex flex-row justify-content-center align-items-end mb-3">
                        <h4 class='mb-0 yellow'><?php echo number_format($costoTotal, 2); ?></h4>
                    </div>
                    <?php
                    echo "<div class='fs-6'>" . $detallesData->getLugar()->getNombreLugar() . "</div>";
                    $fecha = $detallesData->getFechaEvento();

                    if ($fecha) {
                        $date = new DateTime($fecha);
                        $dias = ['domingo', 'lunes', 'martes', 'miércoles', 'jueves', 'viernes', 'sábado'];
                        $meses = ['enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre'];

                        $diaNombre = $dias[$date->format('w')]; // Día de la semana
                        $dia = $date->format('d'); // Día del mes
                        $mesNombre = $meses[$date->format('n') - 1]; // Nombre del mes
                        $anio = $date->format('Y'); // Año

                        $fechaFormateada = "{$diaNombre}, {$dia} de {$mesNombre} de {$anio}";

                        echo "<div class='fs-6'>" . $fechaFormateada . "</div>"; // Muestra la fecha en español
                    } else {
                        echo "Fecha no disponible.";
                    }
                    echo "<div class='font14'>" . $detallesData->getLugar()->getCiudad()->getNombreCiudad() . "</div>"; // Hay que mostrar la ciudad
                    ?>
                </div>
            </div>
        </div>
    </div>

    <?php include 'footer.php' ?>

</body>

</html>