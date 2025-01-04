<?php
require_once(__DIR__ . '/../../../config/routes.php');
require_once(__DIR__ . '/../../../config/config.php');
require_once(__DIR__ . '/../../../src/Logic/Lugar.php');
require_once(__DIR__ . '/../../../src/Logic/Evento.php');
require_once(__DIR__ . '/../../../src/Logic/DetallesEvento.php');

$idEvento = isset($_GET['idEvento']) ? intval($_GET['idEvento']) : 0;
$idDetalle = isset($_GET['idDetalle']) ? intval($_GET['idDetalle']) : 0;
$aforo = isset($_GET['aforo']) ? intval($_GET['aforo']) : 0;
$cantidadEntradas = isset($_GET['cantidad']) ? intval($_GET['cantidad']) : 0;

$evento = new Evento();
$eventoData = $evento->consultarIdEvento($idEvento);
$detallesEvento = new DetallesEvento();
$detallesData = $detallesEvento->consultarIdDetalles($idDetalle);
$valorPorEntrada = $detallesData->getCostoEvento();
$costoTotal = $cantidadEntradas * $valorPorEntrada;

if (!$eventoData) {
    echo "Evento no encontrado";
    exit;
}

// Verificar si se ha enviado la cantidad de entradas
if (isset($_GET['cantidad'])) {
    $cantidadEntradas = intval($_GET['cantidad']);

    // Verificar si la cantidad es mayor a 0
    if ($cantidadEntradas <= 0) {
        // Obtener los parámetros actuales de la URL, excluyendo 'cantidad'
        $params = $_GET;
        unset($params['cantidad']); // Elimina 'cantidad' de los parámetros

        // Redirigir de nuevo a la página anterior manteniendo los otros parámetros
        header("Location: compra.php?" . http_build_query($params) . "&error=sin_entradas");
        exit();
    }
} else {
    // En caso de que no haya una cantidad de entradas enviada
    header("Location: compra.php?" . http_build_query($_GET)); // Mantiene otros parámetros
    exit();
}
?>
<div id="successMessage" class="alert alert-success mt-3" style="display:none;">
    Producto agregado al carrito con éxito.
</div>

<div class="container mt-4">
    <div class="text-center">
        <h1 class="fs-1">
            <?php echo $eventoData->getArtista()->getNombre() . ": " . $eventoData->getNombreEvento(); ?></h1>
        <p class="fs-6 text-muted"><?php echo $detallesData->getLugar()->getNombreLugar(); ?></p>
    </div>

    <?php
    $fecha = $detallesData->getFechaEvento();
    if ($fecha) {
        $date = new DateTime($fecha);
        $dias = ['domingo', 'lunes', 'martes', 'miércoles', 'jueves', 'viernes', 'sábado'];
        $meses = ['enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre'];

        $diaNombre = $dias[$date->format('w')]; // Día de la semana
        $dia = $date->format('d'); // Día del mes
        $mesNombre = $meses[$date->format('n') - 1]; // Nombre del mes
        $anio = $date->format('Y'); // Año

        $fechaFormateada = "{$diaNombre}, {$dia} de {$mesNombre} de {$anio}";

        echo "<div class='text-center fs-6'>" . $fechaFormateada . "</div>"; // Muestra la fecha en español
    } else {
        echo "<div class='text-center'>Fecha no disponible.</div>";
    }
    echo "<div class='text-center fs-6'>" . $detallesData->getLugar()->getNombreLugar() . "</div>";
    echo "<div class='text-center fs-6'>" . $detallesData->getLugar()->getCiudad()->getNombreCiudad() . "</div>";
    ?>
</div>

<div class="container mt-5">
    <div class="row">
        <!-- Columna para el formulario de detalles de las entradas -->
        <div class="col-md-6">
            <!-- Cambié a col-md-6 -->
            <div class="d-flex justify-content-center mt-3">

                <form id="formulario" action="/factura" method="POST">
                    <h4 class="text-center mb-4">Detalles de las Entradas</h4>
                    <?php
                    for ($i = 1; $i <= $cantidadEntradas; $i++) {
                        echo    '<div class="row g-3 mb-3">
                                    <div class="col-md-8 offset-md-2">
                                        <div class="input-group">
                                            <span class="input-group-text">Nombre ' . $i . '</span>
                                            <input type="text" class="form-control" name="nombres[]" placeholder="Nombre" required>
                                        </div>
                                    </div>
                                </div>';
                    }
                    ?>
                    <!-- Campos ocultos para datos adicionales -->
                    <input type="hidden" name="idEvento" value="<?php echo $eventoData->getIdEvento(); ?>">
                    <input type="hidden" name="idDetalle" value="<?php echo $detallesData->getIdDetallesEvento(); ?>">
                    <input type="hidden" name="cantidad" value="<?php echo $cantidadEntradas; ?>">
                    <!-- <input type="hidden" name="aforo" value="<?php echo $aforo; ?>"> -->

                    <!-- Botones -->
                    <div class="row mt-4">
                        <!-- Botón para pagar -->
                        <div class="col-md-8 offset-md-2">
                            <button type="button" class="btn btn-primary btn-lg w-100" onclick="cambiarDireccion('/factura')">
                                Pagar
                            </button>
                        </div>
                        <!-- funcionalidad ajax -->
                        <button type="button" class="btn btn-secondary btn-lg w-100" id="addToCartButton">
                            Agregar al Carrito
                        </button>
                        <!-- Botón para Carro -->
                        <div class="col-md-8 offset-md-2">
                            <button type="submit" class="btn btn-secondary btn-lg w-100" onclick="cambiarDireccion('/carro')">
                                Carro
                            </button>
                        </div>
                    </div>
                </form>

                <script>
                    function cambiarDireccion(url) {
                        const form = document.getElementById('formulario');
                        form.action = url; // Cambiamos el atributo action
                        form.submit(); // Enviamos el formulario
                    }

                    document.getElementById("addToCartButton").addEventListener("click", function() {
                        const cantidadEntradas = <?php echo $cantidadEntradas; ?>;
                        const idEvento = <?php echo $eventoData->getIdEvento(); ?>;
                        const idDetalle = <?php echo $detallesData->getIdDetallesEvento(); ?>;

                        // Hacemos la petición AJAX para agregar al carrito
                        const xhr = new XMLHttpRequest();
                        xhr.open("POST", "/carro", true);
                        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

                        // Pasamos los parámetros necesarios (se puede mejorar si es necesario)
                        xhr.send(`idEvento=${idEvento}&idDetalle=${idDetalle}&cantidad=${cantidadEntradas}`);
                        console.log(`idEvento=${idEvento}&idDetalle=${idDetalle}&cantidad=${cantidadEntradas}`);

                        // Al recibir la respuesta, mostramos el mensaje de éxito
                        xhr.onload = function() {
                            if (xhr.status === 200) {
                                // Muestra el mensaje de éxito
                                console.log(xhr.responseText);
                                document.getElementById("successMessage").style.display = "block";

                                // Ocultar el mensaje después de 3 segundos (opcional)
                                setTimeout(function() {
                                    document.getElementById("successMessage").style.display = "none";
                                }, 3000);
                            } else {
                                console.error("Error al agregar al carrito");
                            }
                        };
                    });
                </script>
            </div>
        </div>

        <!-- Columna para la tarjeta de información del evento -->
        <div class="col-md-6">
            <!-- Cambié a col-md-6 -->
            <div class="card card-white p-3 text-black mb-3 text-center">
                <div class="d-flex justify-content-center">
                    <img src="/assets/images/100.png" alt="Descripción de la imagen" class="img-fluid mb-2"
                        style="max-width: 100px;">
                </div>
                <h2 class="fs-5">
                    <?php echo $eventoData->getNombreEvento() . " - " . $detallesData->getLugar()->getNombreLugar(); ?>
                </h2>
                <h4 class='yellow mb-0'><?php echo number_format($costoTotal, 2); ?></h4>
                <?php
                $fecha = $detallesData->getFechaEvento();
                if ($fecha) {
                    $date = new DateTime($fecha);
                    $dias = ['domingo', 'lunes', 'martes', 'miércoles', 'jueves', 'viernes', 'sábado'];
                    $meses = ['enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre'];

                    $diaNombre = $dias[$date->format('w')]; // Día de la semana
                    $dia = $date->format('d'); // Día del mes
                    $mesNombre = $meses[$date->format('n') - 1]; // Nombre del mes
                    $anio = $date->format('Y'); // Año

                    $fechaFormateada = "{$diaNombre}, {$dia} de {$mesNombre} de {$anio}";

                    echo "<div class='text-center fs-6'>" . $fechaFormateada . "</div>"; // Muestra la fecha en español
                } else {
                    echo "<div class='text-center'>Fecha no disponible.</div>";
                }
                ?>
            </div>
        </div>
    </div>
</div>