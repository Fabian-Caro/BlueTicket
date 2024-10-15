<?php
require_once(__DIR__ . '/../logica/Ciudad.php');
require_once(__DIR__ . '/../logica/DetallesEvento.php');
?>

<html>

<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link href="css/estilos.css" rel="stylesheet">
</head>

<body>
    <?php include 'navProveedor.php';
    if (isset($_POST["submit"])) {
        $nombreLugar = "'" . $_POST['nombreLugar'] . "'";
        $direccionLugar = "'" . $_POST['direccionLugar'] . "'";
        $idCiudad = "'" . $_POST['idCiudad'] . "'";

        $lugar = new Lugar();
        $lugar->insertar($nombreLugar, $direccionLugar, $idCiudad);
    }
    ?>

    <div class="container form-container">
        <h2>Agregar Nuevo Lugar</h2>
        <form action="nuevoLugar.php" method="POST">
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre del Lugar</label>
                <input type="text" class="form-control" id="nombreLugar" name="nombreLugar" required>
                <label for="nombre" class="form-label">Dirección del Lugar</label>
                <input type="text" class="form-control" id="direccionLugar" name="direccionLugar" required>
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
            <button type="submit" name="submit" class="submit-btn btn btn-primary">Agregar Ciudad</button>
        </form>
    </div>
</body>

</html>