<?php
require_once(__DIR__ . '/../logica/Lugar.php');
require_once(__DIR__ . '/../logica/Evento.php');
require_once(__DIR__ . '/../logica/DetallesEvento.php');
require_once(__DIR__ . '/../logica/Ciudad.php');

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
    <title><?php echo $eventoData->getNombreEvento(); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link href="css/estilos.css" rel="stylesheet">
</head>

<body>
    <?php include 'navProveedor.php'; ?>

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
                    echo "<h2>" . $eventoData->getNombreEvento() . "</h2>";
                    echo "<p>";
                    echo    "<ul>";
                    echo            "<li>" . $eventoData->getArtista()->getNombre() . "</li>";
                    echo            "<li>"  . $detalle->getLugar()->getNombreLugar() . "</li>";
                    echo            "<li>"  . $detalle->getLugar()->getCiudad()->getNombreCiudad() . "</li>";
                    echo            "<li>"  . $detalle->getFechaEvento() . "</li>";
                    echo            "<li>"  . $detalle->getHoraInicioEvento() . "</li>";
                    echo    "</ul>";
                    echo "</p>";
                    ?>
                </div>
            </div>
        <?php
        }
        ?>
        <div class="row">
            <div class="col-md-12 text-center">
                <button class='btn btn-primary' onclick="location.href='detalleEvento.php?idEvento=<?php echo $idEvento; ?>'">Crear Detalle Evento</button>
            </div>
        </div>
    </div>

</body>

</html>