<?php
require_once(__DIR__ . '/../../../src/Logic/Carro.php');

echo "pagina carro.php<br>";
$idDetalle = isset($_POST['idDetalle']) ? intval($_POST['idDetalle']) : 0;
$nombres = isset($_POST['nombres']) ? $_POST['nombres'] : [];

echo "idDetalle" . $idDetalle . "<br>";

echo "idCliente" . $idCliente . "<br>";
$carro = new Carro();

if (isset($_POST['items']) && isset($_POST['data'])) {
    // Los índices de los elementos seleccionados en el formulario
    $seleccionados = $_POST['items']; // Ejemplo: [0, 2, 3]

    // Todos los datos ocultos enviados en el formulario
    $datos = $_POST['data'];

    // Iterar sobre los elementos seleccionados
    foreach ($seleccionados as $indice) {
        // Obtener los datos del elemento seleccionado usando su índice
        $elementos = $datos[$indice];

        // Acceder a cada campo enviado
        $idCarro = $elementos['idsCarro'];

        $carro->eliminar($idCarro);
    }
}

if ($idDetalle && $nombres) {
    echo "idDetalle  " . $idDetalle . "<br>";
    foreach ($nombres as $nombre) {
        echo $nombre . "<br>";
        $carro->insertar('"' . $nombre . '"', $idCliente, $idDetalle);
    }
}

$carros = $carro->consultarTodos($idCliente);
?>

<form id="formulario" action="/facturaCarro" method="POST" class="mt-4">
    <div class="container">
        <h3 class="mb-3">Carrito de Compras</h3>
        <?php
        foreach ($carros as $index => $temp) {
            $costo = $temp->getDetallesEvento()->getCostoEvento();
            echo '<div class="form-check mb-3">';
            echo '<input type="checkbox" class="form-check-input" name="items[]" id="item_' . $index . '" value="' . $index . '" data-costo="' . $costo . '" onchange="actualizarBoton()"> ';
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
        <button type="submit" id="btnPagar" class="btn btn-primary mt-3" disabled>Pagar Seleccionados</button>
        <button type="submit" id="btnCancelar" class="btn btn-primary mt-3" disabled onclick="cambiarDireccion('/carro')">Cancelar Seleccionados</button>
    </div>
</form>

<script>
    function cambiarDireccion(url) {
        const form = document.getElementById('formulario');
        form.action = url; // Cambiamos el atributo action
        form.submit(); // Enviamos el formulario
    }

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

    function actualizarBoton() {
        let total = 0;
        let haySeleccionados = false;
        const checkboxes = document.querySelectorAll('.form-check-input');
        const totalDisplay = document.getElementById('total');
        const costoTotalInput = document.getElementById('costo_total');
        const btnPagar = document.getElementById('btnPagar');
        const btnCancelar = document.getElementById('btnCancelar');

        checkboxes.forEach(checkbox => {
            if (checkbox.checked) {
                total += parseFloat(checkbox.dataset.costo);
                haySeleccionados = true; // Al menos un checkbox está seleccionado
            }
        });

        totalDisplay.textContent = `Total: $${total.toFixed(2)}`;
        costoTotalInput.value = total.toFixed(2);

        // Habilitar o deshabilitar botones según el estado de los checkboxes
        btnPagar.disabled = total === 0;
        btnCancelar.disabled = !haySeleccionados; // Se habilita si hay al menos un seleccionado
    }
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-4cGFmA9Im4u9OFt8S1rfqESzO5xR7KZGtYt7Lk1AaeoafIYGf1VGzF2dEXKxJwdr" crossorigin="anonymous"> </script>