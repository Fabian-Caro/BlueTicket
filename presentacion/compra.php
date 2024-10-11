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
        <div class="row">
            <div class="col-md-8">
                <ul class="list-unstyled text-center">
                    <li>Capacidad: xxxx</li>
                    <li class="d-flex justify-content-center align-items-center">
                        <span>Cantidad de entradas: </span>
                        <div class="d-flex align-items-center">
                            <input type="number" id="contador" value="0" class="form-control me-2" style="width: 80px;" min="0">
                        </div>
                    </li>
                    <li>Valor subtotal: $xxxx.xx</li>
                </ul>
                <div class="d-flex justify-content-center mt-3">
                    <button class="btn btn-primary" onclick="location.href='pago.php'">Pagar</button>
                </div>
            </div>

            <div class="col-md-4">
                <div class="row align-items-center">
                    <div class="col-md-4 mb-4">
                        <img src="https://via.placeholder.com/100" alt="Descripción de la imagen" class="img-fluid" style="max-width: 100px; height: auto;">
                    </div>
                    <div class="col-md-8 mb-4">
                        <h2>Evento</h2>
                        <p>
                        <ul>
                            <li>Nombre evento</li>
                            <li>Lugar, fecha, hora, </li>
                        </ul>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include 'footer.php' ?>

</body>

</html>