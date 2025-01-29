<?php
require_once(__DIR__ . '/../../../src/Logic/Cliente.php');

if (isset($_POST['registrar'])) {
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $correo = $_POST['correo'];
    $clave = md5($_POST['clave']);

    $cliente = new Cliente(null, $nombre, $apellido, $correo, $clave, null);

    if ($cliente->registrar($nombre, $apellido, $correo, $clave)) {
        $cliente->autenticar();
        activarCuenta($cliente->getIdCliente(), $correo);
        echo "  <div class='alert alert-success' role='alert'>
                Registro completado. Se ha enviado un correo de activación a $correo
                </div>";
        exit();
    } else {
        echo "error al registrar al cliente.";
    }
}

function activarCuenta($idCliente, $correoCliente)
{
    $datosEmpresa = require_once(__DIR__ . '/../../../config/datosEmpresa.php');

    $enlace = "http://localhost:8000/activacion?ic=$idCliente";

    $directorio = __DIR__ . '/../auth/activaciones/';

    $archivo = $directorio . "activarCuentaCliente_$idCliente.txt";

    $mensaje = "De: $datosEmpresa[correo] \n";
    $mensaje .= "Para: $correoCliente \n";
    $mensaje .= "Asunto: Activación de cuenta en BlueTicket \n\n";
    $mensaje .= "¡Hola!\n\n";
    $mensaje .= "Para activar tu cuenta en nuestro sitio, por favor haz clic en el siguiente enlace:\n";
    $mensaje .= "$enlace\n\n";
    $mensaje .= "Si no has solicitado este registro, por favor ignora este mensaje.\n\n";
    $mensaje .= "Gracias,\nEl equipo de BlueTicket.";

    file_put_contents($archivo, $mensaje);
}

?>



<div class="container vh-100 d-flex justify-content-center align-items-center">
    <div class="row w-50">
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

                    <div class="extra-links">
                        <a href="/registroProveedor">Registrarse como proveedor</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>