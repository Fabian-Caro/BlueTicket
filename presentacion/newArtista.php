<?php
require_once(__DIR__ . '/../logica/Artista.php');
?>

<html>

<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link href="css/estilos.css" rel="stylesheet">
</head>

<body>
    <header>
        <?php include 'navProveedor.php'; ?>
    </header>
    <?php
    if (isset($_POST["submit"])) {
        $nombre = "'" . $_POST['nombre'] . "'";

        $artista = new Artista();
        $artista->insertar($nombre);
    }
    ?>

    <div class="container form-container">
        <h2>Agregar Nuevo Artista</h2>
        <form action="newArtista.php" method="POST">
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre del Artista</label>
                <input type="text" class="form-control" id="nombre" name="nombre" required>
            </div>
            <button type="submit" name="submit" class="submit-btn btn btn-primary">Agregar Artista</button>
        </form>
    </div>
</body>

</html>