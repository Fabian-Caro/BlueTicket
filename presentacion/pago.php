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

    <form class="container mt-4">
        <div class="row g-3">
            <div class="col-md-4">
                <input type="text" class="form-control" placeholder="Nombre" required>
            </div>
            <div class="col-md-4">
                <input type="text" class="form-control" placeholder="Apellido" required>
            </div>
            <div class="col-md-4">
                <input type="text" class="form-control" placeholder="Documento" required>
            </div>
        </div>
    </form>
    <form class="container mt-4">
        <div class="row g-3">
            <div class="col-md-4">
                <input type="text" class="form-control" placeholder="Nombre" required>
            </div>
            <div class="col-md-4">
                <input type="text" class="form-control" placeholder="Apellido" required>
            </div>
            <div class="col-md-4">
                <input type="text" class="form-control" placeholder="Documento" required>
            </div>
        </div>
    </form>
    <form class="container mt-4">
        <div class="row g-3">
            <div class="col-md-4">
                <input type="text" class="form-control" placeholder="Nombre" required>
            </div>
            <div class="col-md-4">
                <input type="text" class="form-control" placeholder="Apellido" required>
            </div>
            <div class="col-md-4">
                <input type="text" class="form-control" placeholder="Documento" required>
            </div>
        </div>
    </form>

    <div class="container mt-5 px-5">
        <div class="row">
            <div class="col-md-8">
                <div class="card p-3">
                    <h6 class="text-uppercase">Detalles del pago</h6>
                    <div class="inputbox mt-3"> <input type="text" name="name" class="form-control" placeholder="Nombre del titular" required="required">
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="inputbox mt-3 mr-2">
                                <input type="text" name="name" class="form-control" placeholder="Numero de la tarjeta" required="required">
                                <i class="fa fa-credit-card"></i>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex flex-row">
                                <div class="inputbox mt-3 mr-2">
                                    <input type="text" name="name" class="form-control" placeholder="Expiración" required="required">
                                </div>
                                <div class="inputbox mt-3 mr-2">
                                    <input type="text" name="name" class="form-control" placeholder="CVC" required="required">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-4 mb-4 d-flex justify-content-between">
                    <span>Volver</span>
                    <button class="btn btn-success px-3" onclick="location.href='factura.php'">Pagar</button>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card card-blue p-3 text-black mb-3">
                <img src="https://via.placeholder.com/100" alt="Descripción de la imagen" class="img-fluid" style="max-width: 100px; height: auto;">
                    <span>Evento</span>
                    <div class="d-flex flex-row align-items-end mb-3">
                        <h1 class="mb-0 yellow">$549</h1> <span>.99</span>
                    </div>
                    <span>Enjoy all the features and perk after you complete the payment</span>
                    <a href="#" class="yellow decoration">Know all the features</a>
                    <div class="hightlight">
                        <span>100% Guaranteed support and update for the next 5 years.</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include 'footer.php' ?>

</body>

</html>