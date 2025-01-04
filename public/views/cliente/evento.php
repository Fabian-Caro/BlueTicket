<?php
require_once (__DIR__ . '/../../../config/routes.php');
require_once(__DIR__ . '/../../../src/Logic/Lugar.php');
require_once(__DIR__ . '/../../../src/Logic/Ciudad.php');
require_once(__DIR__ . '/../../../src/Logic/Evento.php');
require_once(__DIR__ . '/../../../src/Logic/DetallesEvento.php');

$idEvento = isset($_GET['idEvento']) ? intval($_GET['idEvento']) : 0;

$evento = new Evento();
$eventoData = $evento->consultarIdEvento($idEvento);
$detallesEvento = new DetallesEvento();
$detallesData = $detallesEvento->consultarDetallesEvento($idEvento);

if (!$eventoData) {
    echo "Evento no encontrado";
    exit;
}

?>

<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $eventoData->getArtista()->getNombre(); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="css/estilos.css" rel="stylesheet">
</head>

<body>

    <div class="container event-container">
        <?php foreach ($detallesData as $detalle) { ?>
            <div class="row align-items-center mb-4">
                <div class="col-md-4 text-center">
                    <h1 class="event-header"><?php echo $eventoData->getArtista()->getNombre(); ?></h1>
                    <img src="/assets/images/100.png" alt="Descripción de la imagen" class="img-fluid event-image">
                </div>
                <div class="col-md-8">
                    <h2 class="event-header"><?php echo $detalle->getLugar()->getNombreLugar(); ?></h2>
                    <p class="event-details">
                        <?php echo "<div class='fs-6'>" . $eventoData->getNombreEvento() . " - " . $detalle->getLugar()->getCiudad()->getNombreCiudad() . "</div>"; ?>

                        <?php
                        $fecha = $detalle->getFechaEvento();
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
                        ?>

                    <div class="fs-6"><?php echo $detalle->getHoraInicioEvento(); ?></div>
                    </p>
                    <button class="event-btn" onclick="location.href='/compra?idEvento=<?php echo $eventoData->getIdEvento(); ?>&idDetalle=<?php echo $detalle->getIdDetallesEvento(); ?>'">Ver evento</button>
                </div>
            </div>
        <?php } ?>
    </div>
</body>

</html>