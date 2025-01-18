<?php
require_once(__DIR__ . '/../../../src/Logic/Ciudad.php');
require_once(__DIR__ . '/../../../src/Logic/DetallesEvento.php');
?>

<?php
if (isset($_POST["submit"])) {
    $nombreLugar = "'" . $_POST['nombreLugar'] . "'";
    $direccionLugar = "'" . $_POST['direccionLugar'] . "'";
    $capacidadMaximaLugar = "'" . $_POST['capacidadLugar'] . "'";
    $idCiudad = "'" . $_POST['idCiudad'] . "'";

    $lugar = new Lugar();
    $lugar->insertar($nombreLugar, $direccionLugar, $capacidadMaximaLugar, $idCiudad);
}
?>

<div class="container form-container">
    <h2>Agregar Nuevo Lugar</h2>
    <form action="/nuevoLugar" method="POST">
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre del Lugar</label>
            <input type="text" class="form-control" id="nombreLugar" name="nombreLugar" required>
            <label for="nombre" class="form-label">Dirección del Lugar</label>
            <input type="text" class="form-control" id="direccionLugar" name="direccionLugar" required>
            <label for="nombre" class="form-label">Capacidad máxima</label>
            <input type="number" class="form-control" id="capacidadLugar" name="capacidadLugar" min="1" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Ciudad</label><br>
            <?php
            $ciudad = new Ciudad();
            $ciudades = $ciudad->consultarTodos();
            foreach ($ciudades as $temp) {
                echo '<div class="form-check">';
                echo '<input class="form-check-input" type="radio" name="idCiudad" value="' . $temp->getIdCiudad() . '" required>';
                echo '<label class="form-check-label">' . $temp->getNombreCiudad() . '</label>';
                echo '</div>';
            }
            ?>
        </div>
        <button type="submit" name="submit" class="submit-btn btn btn-primary">Agregar lugar</button>
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>