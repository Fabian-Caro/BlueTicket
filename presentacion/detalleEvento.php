<?php
require_once(__DIR__ . '/../logica/Lugar.php');
require_once(__DIR__ . '/../logica/DetallesEvento.php');
require_once(__DIR__ . '/../logica/Zona.php');
$idEvento = isset($_GET['idEvento']) ? intval($_GET['idEvento']) : 0;
?>

<html>

<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link href="css/estilos.css" rel="stylesheet">
</head>

<body>

    <header>
    <?php include 'navProveedor.php';?>
    </header>
    
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
        <form action="detalleEvento.php?idEvento=<?php echo $idEvento; ?>" method="POST">
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
                <?php
                $i = 0;
                $zona = new Zona();
                $zonas = $zona->consultarZonas();
                foreach ($zonas as $temp) {
                    echo "<span>" . $temp->getNombreZona() . "</span><br>";
                }
                ?>
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
</body>

</html>