<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Blue Ticket</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <?php include 'navbar.php' ?>

    <div class="container mt-4">
        <ul class="list-unstyled text-center">
            <li>capacidad: xxxx</li>
            <li class="d-flex justify-content-center align-items-center">
            <span>Cantidad de entradas: </span>
            <div class="d-flex align-items-center">
                <input type="number" id="contador" value="0" class="form-control me-2" style="width: 80px;" readonly>
                <button class="btn btn-danger" onclick="disminuir()">-</button>
                <button class="btn btn-success ms-2" onclick="aumentar()">+</button>
            </div>
        </li>
            <li>Valor subtotal: $xxxx.xx</li>
        </ul>
    </div>

    <div class="container mt-4">
        <!-- Primera Vista -->
        <div id="vista1">
            <h2>Selecciona una opción</h2>
            <button class="btn btn-primary" onclick="irAVista2()">Opción 1</button>
            <button class="btn btn-secondary" onclick="irAVista2()">Opción 2</button>
        </div>

        <!-- Segunda Vista -->
        <div id="vista2" style="display: none;">
            <h2>Vista 2</h2>
            <p>Contenido adicional para la opción seleccionada.</p>
            <button class="btn btn-secondary" onclick="volverAVista1()">Volver</button>
        </div>
    </div>

    <?php include 'footer.php' ?>
</body>

</html>