<?php 

require_once(__DIR__ . '/../logica/Lugar.php');
require_once(__DIR__ . '/../logica/DetallesEvento.php');
$idEvento = isset($_GET['idEvento']) ? intval($_GET['idEvento']) : 0;
echo "idEvento: ". $idEvento;
?>

<html>
<head>
<link
	href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
	rel="stylesheet">
<script
	src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <?php include 'navProveedor.php';
    if(isset($_POST["submit"])){
        $fecha = "'" . $_POST['fecha'] . "'";
        $horaInicio = "'" . $_POST['horaInicio'] . "'";
        $horaFinal = "'" . $_POST['horaFinal'] . "'";
        $costo = $_POST["costo"];
        $aforo = $_POST["aforo"];
        $idLugar = $_POST["idLugar"];
    
        $detallesEvento = new DetallesEvento();
        $detallesEvento -> insertar($fecha,$horaInicio,$horaFinal,$costo,$aforo,$idLugar,$idEvento);
    }
    ?>

    <form action="detalleEvento.php?idEvento=<?php echo isset($_GET['idEvento']) ? intval($_GET['idEvento']) : 0; ?>" method="POST">
        <label for="fecha">fecha: </label>
        <input type="text" value="" name="fecha" required><br><br>

        <label for="horaInicio">horaInicio: </label>
        <input type="text" value="" name="horaInicio" required><br><br>

        <label for="horaFinal">horaFinal: </label>
        <input type="text" value="" name="horaFinal" required><br><br>

        <label for="costo">costo:</label>
        <input type="text" value="" name="costo" required><br><br>

        <label for="aforo">aforo:</label>
        <input type="text" value="" name="aforo" required><br><br>
        
        <label for="idLugar">Lugar:</label><br>
        <?php
            $lugar = new Lugar();
            $lugares = $lugar->consultarTodos();
            foreach ($lugares as $lugarActual) {
                echo '<input type="radio" value="' . $lugarActual->getIdLugar() . '" name="idLugar" required> ' . $lugarActual->getNombreLugar() . '<br>';
            }
        ?>
        <button type="submit" name="submit">submit</button>
    </form>

</body>

</html>
