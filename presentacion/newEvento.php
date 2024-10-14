<?php
require_once(__DIR__ . '/../logica/Evento.php');
require_once(__DIR__ . '/../logica/Artista.php');
require_once(__DIR__ . '/../logica/Categoria.php');

if(isset($_POST["submit"])){
    $nombre = "'" . $_POST['nombre'] . "'";
    $idCategoria = $_POST['idCategoria'];
    $idArtista = $_POST['idArtista'];
    $idProveedor = $_SESSION["idProveedor"];

    $evento = new Evento();
    $evento -> insertar($nombre,$idProveedor,$idCategoria,$idArtista);
}
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
    <?php include 'navProveedor.php';?>

<form action="newEvento.php" method="POST">
    <label for="nombre">Nombre del Producto:</label>
    <input type="text" value="nombre" name="nombre" required><br><br>

    <label for="idCategoria">Categoría:</label><br>
    <?php
        $categoria = new Categoria();
        $categorias = $categoria->consultarTodos();
        foreach ($categorias as $categoriaActual) {
            echo '<input type="radio" value="' . $categoriaActual->getIdCategoria() . '" name="idCategoria" required> ' . $categoriaActual->getNombre() . '<br>';
        }
    ?>

    <label for="idArtista">Artista:</label><br>
    <?php
        $artista = new Artista();
        $artistas = $artista->consultarTodos();
        foreach ($artistas as $temp) {
            echo '<input type="radio" value="' . $temp->getIdArtista() . '" name="idArtista" required> ' . $temp->getNombre() . '<br>';
        }
    ?>
    <button type="submit" name="submit">submit</button>
</form>

</body>

</html>
