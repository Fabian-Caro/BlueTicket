<?php
require_once('../../logica/Cliente.php');

if (isset($_POST['registrar'])) {
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $correo = $_POST['correo'];
    $clave = md5($_POST['clave']);

    $cliente = new Cliente(null, $nombre, $apellido, $correo, $clave);

    if ($cliente->registrar($nombre, $apellido, $correo, $clave)) {
        session_start();
        $_SESSION['idCliente'] = $cliente->getIdCliente();
        echo "  <div class='alert alert-success' role='alert'>
                Registro completado
                </div>";
      
        header("Location: ../index.php");
        exit();
    } else {
        echo "error al registrar al cliente.";
    }
}

?>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Blue Ticket</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="css/estilos.css" rel="stylesheet">
</head>

<body>

    <?php include '../navbar.php'; ?>

    <div class="container vh-100 d-flex justify-content-center align-items-center">
        <div class="row">
            <div class="col-md-12">
                <div class="card border-primary">
                    <div class="card-header text-bg-info text-center">
                        <h4>Registro</h4>
                    </div>
                    <div class="card-body">
                        <form method="post" action="registrarCliente.php">
                            <div class="mb-3">
                                <input type="text" name="nombre" class="form-control" placeholder="Nombre" required>
                            </div>
                            <div class="mb-3">
                                <input type="text" name="apellido" class="form-control" placeholder="Apellido" required>
                            </div>
                            <div class="mb-3">
                                <input type="email" name="correo" class="form-control" placeholder="Correo" required>
                            </div>
                            <div class="mb-3">
                                <input type="password" name="clave" class="form-control" placeholder="Clave" required>
                            </div>
                            <button type="submit" name="registrar" class="btn btn-info w-100">Registrarse</button>
                        </form>
                        <a href="/proveedor/registrarProveedor.php" class="d-block text-center mt-3">Registrarse como proveedor</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include '../footer.php' ?>
</body>

</html>