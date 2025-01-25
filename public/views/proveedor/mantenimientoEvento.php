<?php
require_once(__DIR__ . '/../../../src/Logic/Lugar.php');
require_once(__DIR__ . '/../../../src/Logic/Evento.php');
require_once(__DIR__ . '/../../../src/Logic/DetallesEvento.php');
require_once(__DIR__ . '/../../../src/Logic/Ciudad.php');

$idEvento = isset($_GET['idEvento']) ? intval($_GET['idEvento']) : 0;

$evento = new Evento($idEvento);
$evento -> consultar();
$eventoData = $evento->consultarIdEvento($idEvento);
$detallesEvento = new DetallesEvento();
$detallesData = $detallesEvento->consultarDetallesEvento($idEvento);

if (!$eventoData) {
    echo "Evento no encontrado";
    exit;
}

?>

<div class="container mt-4">
    <?php
    foreach ($detallesData as $detalle) {
    ?>
        <div class="row align-items-center mb-4">
            <div class="col-md-4">
            <img 
            src="<?php echo "assets/images/".$evento->getImagen(); ?>" 
            alt="Descripción de la imagen" 
            class="img-fluid" 
            style="max-width: 100px; height: auto;">
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
            <button class='btn btn-primary' onclick="location.href='/crearEvento?idEvento=<?php echo $idEvento; ?>'">Crear Detalle Evento</button>
            <button class='btn btn-primary' onclick="location.href='/editarImagen?idEvento=<?php echo $idEvento; ?>'">Editar Imagen</button>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>