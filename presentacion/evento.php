<?php
require_once(__DIR__ . '/../logica/Lugar.php');
require_once(__DIR__ . '/../logica/Ciudad.php');
require_once(__DIR__ . '/../logica/Evento.php');
require_once(__DIR__ . '/../logica/DetallesEvento.php');
$idEvento = isset($_GET['idEvento']) ? intval($_GET['idEvento']) : 0;

$evento = new Evento();
$eventoData = $evento->consultarIdEvento($idEvento);
$detallesEvento = new DetallesEvento();
$detallesData = $detallesEvento->consultarDetallesEvento($idEvento);
echo $idEvento;

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
    <link href="estilos.css" rel="stylesheet">
</head>

<body>
    <?php
    include 'navbar.php'
    ?>

    <div class="container mt-4">
        <?php
        foreach ($detallesData as $detalle) {
        ?>
            <div class="row align-items-center mb-4">
                <div class="col-md-4">
                    <img src="imagenes/100.png" alt="Descripción de la imagen" class="img-fluid" style="max-width: 100px; height: auto;">
                </div>
                <div class="col-md-8">
                    <?php
                    echo "<h1>" . $detalle->getIdDetallesEvento() . "</h1>";
                    echo "<h2>" . $eventoData->getArtista()->getNombre() . "</h2>";
                    echo "<p>";
                    echo    "<ul>";
                    echo            "<li>" . $eventoData->getArtista()->getNombre() . "</li>";
                    echo            "<li>"  . $detalle->getLugar()->getNombreLugar() . "</li>";
                    echo            "<li>"  . $detalle->getLugar()->getCiudad()->getNombreCiudad() . "</li>";
                    echo            "<li>"  . $detalle->getFechaEvento() . "</li>";
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
                    echo            "<li>"  . $detalle->getHoraInicioEvento() . "</li>";
                    echo    "</ul>";
                    echo "</p>";
                    echo "<button class='btn btn-primary' onclick=\"location.href='compra.php?idEvento=" . $eventoData->getIdEvento() . "&idDetalle=" . $detalle->getIdDetallesEvento() . "'\">Ver evento</button>";
                    ?>
                </div>
            </div>
        <?php
        }
        ?>

        <?php include 'footer.php' ?>

</body>

</html>