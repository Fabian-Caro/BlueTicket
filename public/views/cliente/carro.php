<?php
require_once(__DIR__ . '/../../../src/Logic/Carro.php');

// Este es un ejemplo básico de cómo manejar la solicitud para agregar al carrito
// if ($_SERVER['REQUEST_METHOD'] === 'POST') {

//     $idEvento = intval($_POST['idEvento']);
//     $idDetalle = intval($_POST['idDetalle']);
//     $cantidad = intval($_POST['cantidad']);
//     $nombres = intval($_POST['nombres']) ? $_POST['nombres'] : [];

//     // Lógica para agregar al carrito (esto debe integrarse con tu sistema de carrito)
//     // Ejemplo de guardar el producto en la sesión:
//     $_SESSION['carrito'][] = [
//         'idEvento' => $idEvento,
//         'idDetalle' => $idDetalle,
//         'cantidad' => $cantidad,
//         'nombres' => $nombres,
//     ];

//     $carro = new Carro();

//     if ($_SESSION['carrito']) {
//         echo "idDetalle  " . $idDetalle . "<br>";
//         echo var_dump($nombres) . "<br>";
//         foreach ($nombres as $nombre) {
//             echo $nombre . "<br>";
//             $carro->insertar('"' . $nombre . '"', $idCliente, $idDetalle);
//             echo "Producto agregado al carrito";
//         }
//     }

//     // Responder con éxito
    
// }

echo "pagina carro.php<br>";
$idDetalle = isset($_POST['idDetalle']) ? intval($_POST['idDetalle']) : 0;
$nombres = isset($_POST['nombres']) ? $_POST['nombres'] : [];

echo "idDetalle" . $idDetalle . "<br>";

echo "idCliente" . $idCliente . "<br>";

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

<form action="/facturaCarro" method="POST" class="mt-4">
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
            echo '<input type="hidden" name="data[' . $index . '][idsCarro]" value="' . $temp->getIdCarro() . '">';
            echo '<input type="hidden" name="data[' . $index . '][idsDetalles]" value="' . $temp->getDetallesEvento()->getIdDetallesEvento() . '">';
            echo "ID Detalles: " . $temp->getDetallesEvento()->getIdDetallesEvento() . "<br>";
            echo '<input type="hidden" name="data[' . $index . '][nombres]" value="' . $temp->getNombre() . '">';
            echo '<input type="hidden" name="data[' . $index . '][lugares]" value="' . $temp->getDetallesEvento()->getLugar()->getNombreLugar() . '">';
            echo '<input type="hidden" name="data[' . $index . '][eventos]" value="' . $temp->getDetallesEvento()->getEvento()->getNombreEvento() . '">';
            echo '<input type="hidden" name="data[' . $index . '][artistas]" value="' . $temp->getDetallesEvento()->getEvento()->getArtista()->getNombre() . '">';
            echo '<input type="hidden" name="data[' . $index . '][costos]" value="' . $costo . '">';
            echo '<input type="hidden" name="data[' . $index . '][idEventos]" value="' . $temp->getDetallesEvento()->getEvento()->getIdEvento() . '">';
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-4cGFmA9Im4u9OFt8S1rfqESzO5xR7KZGtYt7Lk1AaeoafIYGf1VGzF2dEXKxJwdr" crossorigin="anonymous"> </script>