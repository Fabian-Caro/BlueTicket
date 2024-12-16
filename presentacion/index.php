<?php

require_once(__DIR__ . '/../logica/Evento.php');

?>

<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Blue Ticket</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="css/estilos.css" rel="stylesheet">
</head>

<body>

    <?php include 'navbar.php'; ?>

    <div class="container mt-4">
        <div class="row justify-content-center">
            <?php
            $i = 0;
            $evento = new Evento();
            $eventos = $evento->consultarTodos();
            foreach ($eventos as $temp) {
                if ($i % 4 == 0) {
                    if ($i > 0) {
                        echo "</div>"; // Cierra la fila anterior
                    }
                    echo "<div class='row mb-3 justify-content-center'>"; // Abre una nueva fila
                }

                echo "<div class='col-md-3 mb-4'>"; // Siempre usa col-md-3 para 4 columnas por fila
                echo "<div class='card' style='width: 100%; background-color: #0033cc;'>";
                echo "<a href='evento.php?idEvento=" . $temp->getIdEvento() . "' style='text-decoration: none; color: inherit;'>";
                echo "<img src='imagenes/evento_categoria_concierto.jpeg' class='card-img-top' style='height: 300px;'>";
                echo "<div class='card-body'>";
                echo "<h5 class='card-title' style='color: white;'>" . $temp->getNombreEvento() . "</h5>";
                echo "<p class='card-text' style='color: white;'>Categoria: " . $temp->getCategoria()->getNombre() . "</p>";
                echo "<p class='card-text' style='color: white;'>Artista: " . $temp->getArtista()->getNombre() . "</p>";
                echo "</div>";
                echo "</a>";
                echo "</div>";
                echo "</div>";

                $i++;
            }
            if ($i % 4 != 0) {
                echo "</div>"; // Cierra la última fila si no está completa
            }
            ?>

        </div>
    </div>

    <?php include 'footer.php' ?>
</body>

</html>