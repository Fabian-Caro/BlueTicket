<?php
require_once(__DIR__ . '/../logica/Evento.php');
require_once(__DIR__ . '/../logica/Artista.php');
require_once(__DIR__ . '/../logica/Categoria.php');
?>

<html>
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link href="css/estilos.css" rel="stylesheet">
</head>
<body>
    <?php include 'navProveedor.php'; 
    if(isset($_POST["submit"])){
        $nombre = "'" . $_POST['nombre'] . "'";
        $idCategoria = $_POST['idCategoria'];
        $idArtista = $_POST['idArtista'];
        $idProveedor = $_SESSION["idProveedor"];

        $evento = new Evento();
        $evento->insertar($nombre, $idProveedor, $idCategoria, $idArtista);
    }
    ?>

    <div class="container form-container">
        <h2>Crear Nuevo Evento</h2>
        <form action="newEvento.php" method="POST">
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre del Evento</label>
                <input type="text" class="form-control" id="nombre" name="nombre" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Categoría</label><br>
                <?php
                    $categoria = new Categoria();
                    $categorias = $categoria->consultarTodos();
                    foreach ($categorias as $categoriaActual) {
                        echo '<div class="form-check">';
                        echo '<input class="form-check-input" type="radio" name="idCategoria" value="' . $categoriaActual->getIdCategoria() . '" required>';
                        echo '<label class="form-check-label">' . $categoriaActual->getNombre() . '</label>';
                        echo '</div>';
                    }
                ?>
            </div>

            <div class="mb-3">
                <label class="form-label">Artista</label><br>
                <?php
                    $artista = new Artista();
                    $artistas = $artista->consultarTodos();
                    foreach ($artistas as $temp) {
                        echo '<div class="form-check">';
                        echo '<input class="form-check-input" type="radio" name="idArtista" value="' . $temp->getIdArtista() . '" required>';
                        echo '<label class="form-check-label">' . $temp->getNombre() . '</label>';
                        echo '</div>';
                    }
                ?>
            </div>

            <button type="submit" name="submit" class="submit-btn btn btn-primary">Crear Evento</button>
        </form>
    </div>
</body>
</html>
