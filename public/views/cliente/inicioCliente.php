<?php
require_once(__DIR__ . '/../../../config/routes.php');
?>
<style>
    body {
        background-color: #F8F9FA;
        font-family: 'Poppins', sans-serif;
    }

    h1 {
        color: #007BFF;
        font-weight: bold;
    }

    .card {
        border-radius: 12px;
        transition: transform 0.2s, box-shadow 0.2s;
        overflow: hidden;
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
    }

    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0px 6px 12px rgba(0, 0, 0, 0.15);
    }

    .card img {
        height: 250px;
        object-fit: cover;
        border-top-left-radius: 12px;
        border-top-right-radius: 12px;
    }

    .card-body {
        background-color: #ffffff;
        padding: 15px;
    }

    .card-title {
        font-size: 1.2rem;
        font-weight: bold;
        color: #007BFF;
    }

    .card-text {
        font-size: 0.9rem;
        color: #6C757D;
    }

    .event-link {
        text-decoration: none;
    }
</style>
<div class="container mt-4">
    <h1 class="text-center mb-4">Explora Nuestros Eventos</h1>
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
            <!-- Tarjeta del Evento -->
            <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                <div class="card">
                    <a href="/evento?idEvento=<?= $temp->getIdEvento(); ?>" class="event-link">
                        <img 
                            src="<?php echo "assets/images/".$temp->getImagen(); ?>"  
                            class="card-img-top" 
                            alt="Imagen del Evento">
                        <div class="card-body">
                            <h5 class="card-title"><?= $temp->getNombreEvento(); ?></h5>
                            <p class="card-text">Categoría: <?= $temp->getCategoria()->getNombre(); ?></p>
                            <p class="card-text">Artista: <?= $temp->getArtista()->getNombre(); ?></p>
                        </div>
                    </a>
                </div>
            </div>
            <!-- Fin de Tarjeta -->
        <?php
        }
        if (count($eventos) % 4 != 0) {
            echo "</div>"; // Cierra la última fila si no está completa
        }
        ?>
    </div>
</div>