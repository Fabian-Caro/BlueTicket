<div class="container mt-4">
    <div class="session-header mb-4">
        <h4>Bienvenido, proveedor <?php echo $proveedor->getNombre() . " " . $proveedor->getApellido(); ?></h4>
    </div>

    <div class="row justify-content-center">
        <?php
        $eventos = $proveedor->consultarEventos();
        if (!$eventos) {
            echo "<p class='text-center text-muted'>No hay eventos disponibles.</p>";
        } else {
            foreach ($eventos as $i => $temp) {
                if ($i % 4 == 0 && $i != 0) {
                    echo "</div>";  // Cierra la fila cada cuatro columnas
                }

                if ($i % 4 == 0) {
                    echo "<div class='row mb-3 justify-content-center'>";
                }

                $paddingClass = ($i % 4 == 1) ? 'px-2' : 'p-0';

                echo "<div class='col-md-4 mb-4 $paddingClass'>";
                echo "<div class='card' style='width: 100%; background-color: #0033cc;'>";
                echo "<a href='/mantenimientoEvento?idEvento=" . $temp->getIdEvento() . "' style='text-decoration: none; color: inherit;'>";
                echo "<img src='assets/images/" . $temp->getImagen() . "'class='card-img-top' style='height: 300px;'>";
                echo "<div class='card-body'>";
                echo "<h5 class='card-title' style='color: white;'>" . $temp->getNombreEvento() . "</h5>";
                echo "<p class='card-text' style='color: white;'>Categoria: " . $temp->getCategoria()->getNombre() . "</p>";
                echo "<p class='card-text' style='color: white;'>Artista: " . $temp->getArtista()->getNombre() . "</p>";
                echo "</div>";
                echo "</a>";
                echo "</div>";
                echo "</div>";

                if ($i % 4 == 3) {
                    echo "</div>";  // Cierra la fila cada cuatro columnas
                }
            }
            if ($i % 4 != 0) {
                echo "</div>";  // Cierra la fila si no es múltiplo de 4
            }
        }
        ?>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>