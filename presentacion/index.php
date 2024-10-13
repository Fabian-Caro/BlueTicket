<?php

require_once(__DIR__ . '/../logica/Evento.php');

?>

<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Blue Ticket</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <?php 
    include 'navbar.php';
    ?>
    <div class="container mt-4">
        <div class="justify-content-center">
            <a href="evento.php" class="d-block">
                <img src="https://images3.alphacoders.com/134/1342988.png" alt="Descripción de la imagen" class="img-fluid" style="width: 100%; height: auto; max-height: 200px;">
            </a>
        </div>
    </div>

    <div class="container mt-4">
        <div class="row justify-content-center">
            <?php
            $i = 0;
            $evento = new Evento();
            $eventos = $evento->consultarTodos();
            foreach ($eventos as $temp) {
                if ($i % 4 == 0) {
                    echo "<div class='row mb-3 justify-content-center'>";
                }

                $paddingClass = ($i % 4 == 1) ? 'px-2' : 'p-0';

                echo "<div class='col-md-4 mb-4 $paddingClass'>";
                echo "<div class='card' style='width: 100%; background-color: #0033cc;'>";
                echo "<a href='evento.php?idEvento=" . $temp->getIdEvento() . "' style='text-decoration: none; color: inherit;'>";
                echo "<img src='imagenes/evento_categoria_concierto.jpeg' class='card-img-top' style='height: 300px;'>";
                echo "<div class='card-body'>";
                echo "<h5 class='card-title' style='color: white;'>" . $temp->getNombre() . "</h5>";
                echo "<p class='card-text' style='color: white;'>Categoria: " . $temp->getCategoria()->getNombre() . "</p>";
                echo "<p class='card-text' style='color: white;'>Artista: " . $temp->getArtista()->getNombre() . "</p>";
                echo "</div>";
                echo "</a>";
                echo "</div>";
                echo "</div>";

                if ($i % 4 == 3) {
                    echo "</div>";  // Cierra la fila cada cuatro columnas
                }
                $i++;
            }
            if ($i % 4 != 0) {
                echo "</div>";  // Cierra la fila si no es múltiplo de 4
            }
            ?>
        </div>
    </div>

    <?php include 'footer.php' ?>
</body>

</html>