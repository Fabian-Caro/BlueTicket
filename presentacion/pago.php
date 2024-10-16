<?php
require_once(__DIR__ . '/../logica/Lugar.php');
require_once(__DIR__ . '/../logica/Evento.php');
require_once(__DIR__ . '/../logica/DetallesEvento.php');
$idEvento = isset($_GET['idEvento']) ? intval($_GET['idEvento']) : 0;
$idDetalle = isset($_GET['idDetalle']) ? intval($_GET['idDetalle']) : 0;
$aforo = isset($_GET['aforo']) ? intval($_GET['aforo']) : 0;
$cantidadEntradas = isset($_GET['cantidad']) ? intval($_GET['cantidad']) : 0;

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
    if ($cantidadEntradas <= 0) {
        // Obtener los parámetros actuales de la URL, excluyendo 'cantidad'
        $params = $_GET;
        unset($params['cantidad']); // Elimina 'cantidad' de los parámetros

        // Redirigir de nuevo a la página anterior manteniendo los otros parámetros
        header("Location: compra.php?" . http_build_query($params) . "&error=sin_entradas");
        exit();
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
    <link href="css/estilos.css" rel="stylesheet">
</head>

<body>

    <?php include 'navbar.php'; ?>

    <div class="container mt-4">
        <div class="text-center">
            <h1 class="fs-1"><?php echo $eventoData->getArtista()->getNombre() . ": " . $eventoData->getNombreEvento(); ?></h1>
            <p class="fs-6 text-muted"><?php echo $detallesData->getLugar()->getCiudad()->getNombreCiudad(); ?></p>
        </div>

        <?php
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

            echo "<div class='text-center fs-6'>" . $fechaFormateada . "</div>"; // Muestra la fecha en español
        } else {
            echo "<div class='text-center'>Fecha no disponible.</div>";
        }
        echo "<div class='text-center fs-6'>" . $detallesData->getLugar()->getNombreLugar() . "</div>";
        echo "<div class='text-center fs-6'>" . $detallesData->getLugar()->getCiudad()->getNombreCiudad() . "</div>";
        ?>
    </div>

    <div class="container mt-5">
        <div class="row">
            <!-- Columna para el formulario de detalles de las entradas -->
            <div class="col-md-6"> <!-- Cambié a col-md-6 -->
                <div class="d-flex justify-content-center mt-3">
                    <form action="factura.php" method="GET" class="container">
                        <h4 class="text-center mb-4">Detalles de las Entradas</h4>
                        <?php
                        for ($i = 1; $i <= $cantidadEntradas; $i++) {
                            echo '
                        <div class="row g-3 mb-3">
                            <div class="col-md-8 offset-md-2">
                                <div class="input-group">
                                    <span class="input-group-text">Nombre ' . $i . '</span>
                                    <input type="text" class="form-control" name="nombres[]" placeholder="Nombre" required>
                                </div>
                            </div>
                        </div>';
                        }
                        ?>
                        <!-- Campos ocultos para datos adicionales -->
                        <input type="hidden" name="idEvento" value="<?php echo $eventoData->getIdEvento(); ?>">
                        <input type="hidden" name="idDetalle" value="<?php echo $detallesData->getIdDetallesEvento(); ?>">
                        <input type="hidden" name="cantidad" value="<?php echo $cantidadEntradas; ?>">
                        <input type="hidden" name="aforo" value="<?php echo $aforo; ?>">
                        <!-- Botón para pagar -->
                        <div class="row mt-4">
                            <div class="col-md-8 offset-md-2">
                                <button type="submit" class="btn btn-primary btn-lg w-100">Pagar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Columna para la tarjeta de información del evento -->
            <div class="col-md-6"> <!-- Cambié a col-md-6 -->
                <div class="card card-blue p-3 text-black mb-3 text-center">
                    <div class="d-flex justify-content-center">
                        <img src="imagenes/100.png" alt="Descripción de la imagen" class="img-fluid mb-2" style="max-width: 100px;">
                    </div>
                    <h2 class="fs-5"><?php echo $eventoData->getNombreEvento() . " - " . $detallesData->getLugar()->getCiudad()->getNombreCiudad(); ?></h2>
                    <h4 class='yellow mb-0'><?php echo number_format($costoTotal, 2); ?></h4>
                    <?php
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

                        echo "<div class='text-center fs-6'>" . $fechaFormateada . "</div>"; // Muestra la fecha en español
                    } else {
                        echo "<div class='text-center'>Fecha no disponible.</div>";
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>

    <?php include 'footer.php' ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-4cGFmA9Im4u9OFt8S1rfqESzO5xR7KZGtYt7Lk1AaeoafIYGf1VGzF2dEXKxJwdr" crossorigin="anonymous"></script>
</body>

</html>