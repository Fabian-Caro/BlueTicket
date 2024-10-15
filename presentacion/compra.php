<?php
require_once(__DIR__ . '/../logica/Lugar.php');
require_once(__DIR__ . '/../logica/Evento.php');
require_once(__DIR__ . '/../logica/DetallesEvento.php');
$idEvento = isset($_GET['idEvento']) ? intval($_GET['idEvento']) : 0;
$idDetalle = isset($_GET['idDetalle']) ? intval($_GET['idDetalle']) : 0;

echo $idEvento;
echo $idDetalle;

$evento = new Evento();
$eventoData = $evento->consultarIdEvento($idEvento);
$detallesEvento = new DetallesEvento();
$detallesData = $detallesEvento->consultarIdDetalles($idDetalle);
echo $detallesData->getLugar()->getCiudad()->getNombreCiudad();

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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-o0WbElgKgIqQjG1AZGn7wZhzC5TAPdF1pgh4FJvW5tcB3TQF3R7myPau+d3IoDyE" crossorigin="anonymous"></script>
    <link href="estilos.css" rel="stylesheet">
</head>

<body>

    <?php include 'navbar.php' ?>

    <div class="container mt-4">
        <div class="row">
            <div class="col-md-8">
                <ul class="list-unstyled text-center">
                    <?php
                    echo "<li>Capacidad: " . $detallesData->getAforoEvento() . "</li>";
                    echo "<li>Valor por entrada: $" . $detallesData->getCostoEvento() . "</li>";
                    ?>
                </ul>
                <div class="d-flex justify-content-center mt-3">
                    <form action="pago.php" method="GET" class="text-center">
                        <input type="hidden" name="idEvento" value="<?php echo $eventoData->getIdEvento(); ?>">
                        <input type="hidden" name="idDetalle" value="<?php echo $detallesData->getIdDetallesEvento(); ?>">
                        <input type="hidden" name="aforo" value="<?php echo $detallesData->getAforoEvento(); ?>">
                        <div class="d-flex justify-content-center align-items-center mb-3">
                            <span>Cantidad de entradas: </span>
                            <div class="d-flex align-items-center ms-2">
                                <input type="number" name="cantidad" id="contador" class="form-control me-2" value="0" min="1" max="<?php echo $detallesData->getAforoEvento(); ?>" style="width: 80px;" required>
                            </div>
                        </div>
                        <div class="d-flex justify-content-center">
                            <button type="submit" class="btn btn-primary">Continuar</button>
                        </div>
                    </form>

                </div>

                <?php
                // Si hay un error, mostrar el mensaje de advertencia
                if (isset($_GET['error']) && $_GET['error'] == 'sin_entradas') {
                    echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                            No has seleccionado ninguna entrada. Por favor, selecciona al menos una.
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>';
                }
                ?>
            </div>
            <div class="col-md-4">
                <div class="row align-items-center">
                    <div align="center">
                        <img src="imagenes/100.png" alt="Descripción de la imagen" class="img-fluid" style="max-width: 100px; height: auto;">
                    </div>
                    <!-- inicia: Información Evento -->
                    <div align="center" style="padding-top:10px">
                        <div class="grisfondo" style="margin:5px auto 10px auto"><img src="images/spacer.gif" height="1" width="100%" /></div>
                        <div style="margin:10px 0px 0px 0px; padding:0px 0px 10px 0px" class="font14" align="center">
                            <?php
                            echo "<div class='fs-1'>" . $eventoData->getArtista()->getNombre() . "</div>";
                            echo "<div clas='fs-6'> presenta: </div>";
                            echo "<div class='fs-4'>" . $eventoData->getNombreEvento() . " - " . $detallesData->getLugar()->getCiudad()->getNombreCiudad() . "</div>";
                            echo "<div class='fs-6'>" . $detallesData->getLugar()->getNombreLugar() . "</div>";
                            echo "<div class='fs-6'>" . $detallesData->getLugar()->getCiudad()->getNombreCiudad() . "</div>";
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

                                echo "<div class='fs-6'>" . $fechaFormateada . "<br><strong>" . $detallesData->getHoraInicioEvento() . " </strong></div>"; // Muestra la fecha en español
                            } else {
                                echo "Fecha no disponible.";
                            }
                            //echo "<div class='font14'>BOGOTÁ</div>"; // Hay que mostrar la ciudad
                            ?>

                        </div>
                    </div>
                    <!-- termina: Información Evento -->

                </div>
            </div>

            <?php include 'footer.php' ?>

</body>

</html>