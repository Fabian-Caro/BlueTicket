<?php
require_once(__DIR__ . '/../../../src/Logic/Artista.php');
?>

<?php
if (isset($_POST["submit"])) {
    $nombre = "'" . $_POST['nombre'] . "'";

    $artista = new Artista();
    $artista->insertar($nombre);
}
?>

<div class="container form-container">
    <h2>Agregar Nuevo Artista o Responsable</h2>
    <form action="/nuevoArtista" method="POST">
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre del Artista o Responsable</label>
            <input type="text" class="form-control" id="nombre" name="nombre" required>
        </div>
        <button type="submit" name="submit" class="submit-btn btn btn-primary">Agregar Artista o Responsable</button>
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>