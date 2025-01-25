<?php
require_once (__DIR__ . '/../../../config/routes.php');
?>
<div class="container mt-4">
    <h1 class="text-center mb-4" style="color: rgb(77, 79, 218);">Explora Nuestros Eventos</h1>
    <div class="row justify-content-center">
        <?php
        $evento = new Evento();
        $eventos = $evento->consultarTodos();
        foreach ($eventos as $index => $temp) {
            if ($index % 4 == 0) {
                if ($index > 0) {
                    echo "</div>"; // Cierra la fila anterior
                }
                echo "<div class='row mb-3 justify-content-center'>"; // Abre una nueva fila
            }
        ?>
            <!-- Card -->
            <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                <div class="card shadow" style="background-color: rgb(77, 79, 218); max-width: 580px; margin: auto;">
                    <a href="/evento?idEvento=<?= $temp->getIdEvento(); ?>" style="text-decoration: none; color: inherit;">
                        <img 
                            src="<?php echo "assets/images/".$temp->getImagen(); ?>"  
                            class="card-img-top" 
                            style="height: 300px; object-fit: cover;" 
                            alt="Imagen del Evento">
                        <div class="card-body">
                            <h5 class="card-title text-white mb-0"><?= $temp->getNombreEvento(); ?></h5>
                            <p class="card-text text-white mb-0">Categoría: <?= $temp->getCategoria()->getNombre(); ?></p>
                            <p class="card-text text-white mb-0">Artista: <?= $temp->getArtista()->getNombre(); ?></p>
                        </div>
                    </a>
                </div>
            </div>
            <!-- End Card -->
        <?php
        }
        if (count($eventos) % 4 != 0) {
            echo "</div>"; // Cierra la última fila si no está completa
        }
        ?>
    </div>
</div>