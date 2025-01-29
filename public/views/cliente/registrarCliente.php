<?php
require_once(__DIR__ . '/../../../src/Logic/Cliente.php');

if (isset($_POST['registrar'])) {
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $correo = $_POST['correo'];
    $clave = md5($_POST['clave']);

    $cliente = new Cliente(null, $nombre, $apellido, $correo, $clave);

    if ($cliente->registrar($nombre, $apellido, $correo, $clave)) {
        echo $correo;
        echo $clave;
        $cliente -> autenticar();
        //$_SESSION['idCliente'] = $cliente->getIdCliente();
        activarCuenta($cliente->getIdCliente(), $correo);
        echo "  <div class='alert alert-success' role='alert'>
                Registro completado
                </div>";
        echo "idCliente: " . $cliente->getIdCliente();

        //header("Location: ../index.php");
        exit();
    } else {
        echo "error al registrar al cliente.";
    }
}

function activarCuenta($idCliente, $correo)
{
    echo $idCliente;

    $enlace = "http://localhost:8000/activacion?ic=$idCliente";
    
    $directorio = __DIR__ . '/../auth/activaciones/';

    $archivo = $directorio . "activarCuenta_$idCliente.txt";

    if (file_put_contents($archivo, "Enlace de activacion: $enlace")) {
        echo "Archivo de activación creado: activacion_$idCliente.txt";
    } else {
        echo "Error al crear archivo de activación";
    }
   
}

?>


<div class="container vh-100 d-flex justify-content-center align-items-center">
    <div class="row">
        <div class="col-md-12">
            <div class="card border-primary">
                <div class="card-header bg-primary text-white">
                    <h4>Registro</h4>
                </div>
                <div class="card-body">
                    <form method="post" action="/registro">
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
                        <button type="submit" name="registrar" class="btn btn-primary w-100">Registrarse</button>
                    </form>
                    <a href="/registroProveedor" class="d-block text-center mt-3">Registrarse como proveedor</a>
                </div>
            </div>
        </div>
    </div>
</div>