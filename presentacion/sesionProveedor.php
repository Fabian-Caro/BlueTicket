
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

    <div class="container mt-4">
        <div class="row justify-content-center">
			<div class="col">
				<div class="card border-primary">
					<div class="card-header text-bg-info">
						<h4>Sesion proveedor</h4>
					</div>
					<div class="card-body">
						<p>Bienvenido proveedor <?php echo $proveedor -> getNombre() . " " . $proveedor -> getApellido() ?></p>
					
					</div>
				</div>
			</div>
            <?php
            $i = 0;
            $eventos = $proveedor->consultarEventos();
            foreach ($eventos as $temp) {
                if ($i % 4 == 0) {
                    echo "<div class='row mb-3 justify-content-center'>";
                }

                $paddingClass = ($i % 4 == 1) ? 'px-2' : 'p-0';

                echo "<div class='col-md-4 mb-4 $paddingClass'>";
                echo "<div class='card' style='width: 100%; background-color: #0033cc;'>";
                echo "<a href='mantenimientoEvento.php?idEvento=" . $temp->getIdEvento() . "' style='text-decoration: none; color: inherit;'>";
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
</body>
</html>