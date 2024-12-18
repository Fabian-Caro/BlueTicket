<?php
require_once(__DIR__ . '/../logica/Carro.php');

echo "pagina carro.php<br>";
$idDetalle = isset($_POST['idDetalle']) ? intval($_POST['idDetalle']) : 0;
$nombres = isset($_POST['nombres']) ? $_POST['nombres'] : [];

echo "idDetalle" . $idDetalle . "<br>";
?>

<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Blue Ticket</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="css/estilos.css" rel="stylesheet">
</head>

<body>

    <?php include 'navbar.php'; ?>

    <?php
    echo "idCliente  " . $idCliente . "<br>";

    $carro = new Carro();

    if ($idDetalle && $nombres) {
        echo "idDetalle  " . $idDetalle . "<br>";
        foreach ($nombres as $nombre) {
            echo $nombre . "<br>";
            $carro->insertar('"' . $nombre . '"', $idCliente, $idDetalle);
        }
    }

    $carros = $carro->consultarTodos($idCliente);

    ?>
    <script>
        function actualizarTotal() {
            let checkboxes = document.querySelectorAll('input[name="items[]"]:checked');
            let total = 0;

            checkboxes.forEach(checkbox => {
                let costo = parseFloat(checkbox.dataset.costo);
                total += costo;
            });

            // Actualizar el total visible
            document.getElementById('total').innerText = `Total: $${total.toFixed(2)}`;

            // Actualizar el valor del input oculto
            document.getElementById('costo_total').value = total.toFixed(2);
        }
    </script>

    <form action="factura.php" method="POST" class="mt-4">
        <div class="container">
            <h3 class="mb-3">Carrito de Compras</h3>
            <?php
            foreach ($carros as $index => $temp) {
                $costo = $temp->getDetallesEvento()->getCostoEvento();
                echo '<div class="form-check mb-3">';
                echo '<input type="checkbox" class="form-check-input" name="items[]" id="item_' . $index . '" value="' . $index . '" data-costo="' . $costo . '" onchange="actualizarTotal()"> ';
                echo '<label class="form-check-label" for="item_' . $index . '">';
                echo $temp->getNombre() . " - " . $temp->getDetallesEvento()->getLugar()->getNombreLugar() .
                    " - " . $temp->getDetallesEvento()->getEvento()->getNombreEvento() .
                    " - " . $temp->getDetallesEvento()->getEvento()->getArtista()->getNombre() .
                    " - $" . $costo;
                echo '</label>';
                echo '</div>';

                // Datos ocultos
                echo $index;
                echo '<input type="hidden" name="data[' . $index . '][idsCarro]" value="' . $temp->getIdCarro() . '">';
                echo '<input type="hidden" name="data[' . $index . '][idDetalle]" value="' . $temp->getDetallesEvento()->getIdDetallesEvento() . '">';
                echo '<input type="hidden" name="data[' . $index . '][nombres]" value="' . $temp->getNombre() . '">';
                echo '<input type="hidden" name="data[' . $index . '][lugares]" value="' . $temp->getDetallesEvento()->getLugar()->getNombreLugar() . '">';
                echo '<input type="hidden" name="data[' . $index . '][eventos]" value="' . $temp->getDetallesEvento()->getEvento()->getNombreEvento() . '">';
                echo '<input type="hidden" name="data[' . $index . '][artistas]" value="' . $temp->getDetallesEvento()->getEvento()->getArtista()->getNombre() . '">';
                echo '<input type="hidden" name="data[' . $index . '][costos]" value="' . $costo . '">';
                echo '<input type="hidden" name="idEvento" value="' . $temp->getDetallesEvento()->getEvento()->getIdEvento() . '">';
                echo '<input type="hidden" name="idCliente" value="' . $idCliente . '">';
            }
            ?>
            <div class="mt-3">
                <p id="total" class="fw-bold">Total: $0.00</p>
            </div>
            <input type="hidden" name="costo_total" id="costo_total" value="0.00">
            <button type="submit" class="btn btn-primary mt-3">Pagar Seleccionados</button>
        </div>
    </form>


    <?php include 'footer.php' ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-4cGFmA9Im4u9OFt8S1rfqESzO5xR7KZGtYt7Lk1AaeoafIYGf1VGzF2dEXKxJwdr" crossorigin="anonymous">
    </script>
</body>

</html>