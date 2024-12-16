<?php
require_once(__DIR__ . '/../logica/Lugar.php');
require_once(__DIR__ . '/../logica/Evento.php');
require_once(__DIR__ . '/../logica/DetallesEvento.php');
$idEvento = isset($_GET['idEvento']) ? intval($_GET['idEvento']) : 0;
$idDetalle = isset($_GET['idDetalle']) ? intval($_GET['idDetalle']) : 0;

$evento = new Evento();
$eventoData = $evento->consultarIdEvento($idEvento);
$detallesEvento = new DetallesEvento();
$detallesData = $detallesEvento->consultarIdDetalles($idDetalle);

if (!$eventoData) {
    echo "Evento no encontrado";
    exit;
}
?>

<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $eventoData->getNombreEvento(); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="css/estilos.css" rel="stylesheet">
</head>

<body>

    <?php include 'navbar.php'; ?>

    <div class="container mt-4">
        <div class="row">
            <!-- Información del evento -->
            <div class="col-lg-8 col-md-7">
                <h2 class="text-center"><?php echo $eventoData->getNombreEvento(); ?></h2>
                <ul class="list-unstyled text-center">
                    <li><strong>Capacidad:</strong> <?php echo $detallesData->getAforoEvento(); ?></li>
                    <li><strong>Valor por entrada:</strong> $<?php echo $detallesData->getCostoEvento(); ?></li>
                </ul>

                <div class="d-flex justify-content-center mt-3">
                    <form action="pago.php" method="GET">
                        <input type="hidden" name="idEvento" value="<?php echo $eventoData->getIdEvento(); ?>">
                        <input type="hidden" name="idDetalle" value="<?php echo $detallesData->getIdDetallesEvento(); ?>">
                        <input type="hidden" name="aforo" value="<?php echo $detallesData->getAforoEvento(); ?>">
                        <div class="d-flex justify-content-center align-items-center mb-3">
                            <label for="contador" class="me-2">Cantidad de entradas:</label>
                            <input type="number" name="cantidad" id="contador" class="form-control" value="" min="1" max="<?php echo $detallesData->getAforoEvento(); ?>" style="width: 100px;" required>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">Continuar</button>
                        </div>
                    </form>
                </div>

                <?php
                // Mostrar alerta en caso de error
                if (isset($_GET['error']) && $_GET['error'] == 'sin_entradas') {
                    echo '<div class="alert alert-warning mt-3" role="alert">
                            No has seleccionado ninguna entrada. Por favor, selecciona al menos una.
                          </div>';
                }
                ?>
            </div>

            <!-- Detalles del evento -->
            <div class="col-lg-4 col-md-5 text-center">
                <img src="imagenes/100.png" alt="Imagen del evento" class="img-fluid mb-3" style="max-width: 100px;">
                
                <h4 class="text-primary"><?php echo $eventoData->getArtista()->getNombre(); ?></h4>
                <p class="text-muted">Presenta:</p>
                <h5><?php echo $eventoData->getNombreEvento(); ?></h5>
                <p><?php echo $detallesData->getLugar()->getNombreLugar() . " - " . $detallesData->getLugar()->getCiudad()->getNombreCiudad(); ?></p>

                <?php
                $fecha = $detallesData->getFechaEvento();
                if ($fecha) {
                    $date = new DateTime($fecha);
                    $dias = ['domingo', 'lunes', 'martes', 'miércoles', 'jueves', 'viernes', 'sábado'];
                    $meses = ['enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre'];

                    $diaNombre = $dias[$date->format('w')];
                    $dia = $date->format('d');
                    $mesNombre = $meses[$date->format('n') - 1];
                    $anio = $date->format('Y');

                    $fechaFormateada = "{$diaNombre}, {$dia} de {$mesNombre} de {$anio}";
                    echo "<p><strong>Fecha:</strong> {$fechaFormateada}</p>";
                    echo "<p><strong>Hora:</strong> {$detallesData->getHoraInicioEvento()}</p>";
                } else {
                    echo "<p>Fecha no disponible.</p>";
                }
                ?>
            </div>
        </div>
    </div>

    <?php include 'footer.php'; ?>

</body>

</html>
