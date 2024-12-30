<?php
require_once(__DIR__ . '/../logica/Cliente_boleta.php');
require_once(__DIR__ . '/../logica/Cliente.php');

$cliente = new Cliente();
$nombreCliente = $cliente->getNombre();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Datos de Factura</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <header>
        <?php include 'navbar.php'; ?>
    </header>

    <div class="container mt-5">
        <h2 class="text-center">Datos de Factura</h2>
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Nombre del Comprador</th>
                        <th>Nombre del Usuario</th>
                        <th>Nombre del Evento</th>
                        <th>Fecha del Evento</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 0;
                    $c_boleta = new Cliente_boleta();
                    $boletas = $c_boleta->consultarBoletas($idCliente);
                    foreach ($boletas as $temp) {
                        echo "<tr>";
                        echo "<td>" . $temp->getNombreCliente() . "</td>";
                        echo "<td>" . $temp->getNombreUsuario() . "</td>";
                        echo "<td>" . $temp->getNombreEvento() . "</td>";
                        echo "<td>" . $temp->getFecha() . "</td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>