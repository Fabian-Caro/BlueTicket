<?php
require_once(__DIR__ . '/../../../src/Logic/Lugar.php');
require_once(__DIR__ . '/../../../src/Logic/DetallesEvento.php');

$idEvento = isset($_GET['idEvento']) ? intval($_GET['idEvento']) : 0;

if (isset($_POST["submit"])) {
    $fecha = "'" . $_POST['fecha'] . "'";
    $horaInicio = "'" . $_POST['horaInicio'] . "'";
    $horaFinal = "'" . $_POST['horaFinal'] . "'";
    $costo = $_POST["costo"];
    $aforo = $_POST["aforo"];
    $idLugar = $_POST["idLugar"];

    $detallesEvento = new DetallesEvento();
    $detallesEvento->insertar($fecha, $horaInicio, $horaFinal, $costo, $aforo, $idLugar, $idEvento);
}
?>

<div class="container form-container">
    <h2>Detalles del Evento</h2>
    <form action="/crearEvento?idEvento=<?php echo $idEvento; ?>" method="POST">
        <div class="mb-3">
            <label for="fecha" class="form-label">Fecha del Evento</label>
            <input type="date" class="form-control" id="fecha" name="fecha" required>
        </div>

        <div class="mb-3">
            <label for="horaInicio" class="form-label">Hora de Inicio</label>
            <input type="time" class="form-control" id="horaInicio" name="horaInicio" required>
        </div>

        <div class="mb-3">
            <label for="horaFinal" class="form-label">Hora de Finalización</label>
            <input type="time" class="form-control" id="horaFinal" name="horaFinal" required>
        </div>

        <div class="mb-3">
            <label for="costo" class="form-label">Costo</label>
            <input type="number" class="form-control" id="costo" name="costo" required>
        </div>

        <div class="mb-3">
            <label for="aforo" class="form-label">Aforo</label>
            <input type="number" class="form-control" id="aforo" name="aforo" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Lugar</label><br>
            <?php
            $lugar = new Lugar();
            $lugares = $lugar->consultarTodos();
            foreach ($lugares as $lugarActual) {
                echo '<div class="form-check">';
                echo '<input class="form-check-input" type="radio" name="idLugar" value="' . $lugarActual->getIdLugar() . '" required>';
                echo '<label class="form-check-label">' . $lugarActual->getNombreLugar() . '</label>';
                echo '</div>';
            }
            ?>
        </div>

        <button type="submit" name="submit" class="submit-btn btn btn-primary">Crear Detalles del Evento</button>
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>