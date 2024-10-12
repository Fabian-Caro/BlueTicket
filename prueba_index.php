<?php
require ("logica/Evento.php");
require_once("./logica/Evento.php");

?>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Blue Ticket</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
	<?php 
    $paginaAnterior = basename(isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'prueba_index.php');
    include 'navbar.php' 
    ?>
	<div class="container">
		<div class="row mb-3">
			<div class="col">
				<div class="card border-primary">

					<div class="card-body">
    					<?php
                        $i = 0;
                        $evento = new Evento();
                        $eventos = $evento->consultarTodos();
                        foreach ($eventos as $temp) {
                            if ($i % 4 == 0) {
                                echo "<div class='row mb-3'>";
                            }
                            echo "<div class='col-lg-3 col-md-4 col-sm-6' >";
                            echo "<div class='card text-bg-light'>";
                            echo "<div class='card-body'>";
                            echo "<div class='text-center'><img src='https://icons.iconarchive.com/icons/custom-icon-design/mono-general-1/256/faq-icon.png' width='70%' /></div>";
                            echo "<a href='evento.php'>" . $temp->getNombre() . "</a><br>";
                            echo "Categoria: " . $temp->getCategoria()->getNombre() . "<br>";
							echo "Categoria: " . $temp->getArtista()->getNombre() . "<br>";
                            echo "</div>";
                            echo "</div>";
                            echo "</div>";
                
                            if ($i % 4 == 3) {
                                echo "</div>";
                            }
                            $i ++;
                        }
                        if ($i % 4 != 0) {
                            echo "</div>";
                        }
                        ?>
					</div>
				</div>
			</div>
		</div>
	<?php include 'footer.php' ?>
</body>
</html>