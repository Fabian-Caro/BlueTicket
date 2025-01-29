<?php
require_once(__DIR__ . '/../../../src/Logic/Proveedor.php');

if (isset($_POST['registrar'])) {
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $correo = $_POST['correo'];
    $clave = md5($_POST['clave']);

    $proveedor = new Proveedor(null, $nombre, $apellido, $correo, $clave, null);

    if ($proveedor->registrar($nombre, $apellido, $correo, $clave)) {
        $proveedor->autenticar();
        activarCuenta($proveedor->getIdProveedor());
        echo "  <div class='alert alert-success' role='alert'>
                Registro completado. Se ha enviado un correo de activación a $correo
                </div>";
        exit();
    } else {
        echo "error al registrar al proveedor.";
    }
}

function activarCuenta($idProveedor)
{

    $enlace = "http://localhost:8000/activacion?ip=$idProveedor";

    $directorio = __DIR__ . '/../auth/activaciones/';

    $archivo = $directorio . "activarCuentaProveedor_$idProveedor.txt";

    $mensaje = "¡Hola!\n\n";
    $mensaje .= "Para activar tu cuenta y trabajar con nosotros, por favor haz clic en el siguiente enlace:\n";
    $mensaje .= "$enlace\n\n";
    $mensaje .= "Si no has solicitado este registro, por favor ignora este mensaje.\n\n";
    $mensaje .= "Gracias,\nEl equipo de BlueTicket.";

    file_put_contents($archivo, $mensaje);
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
                    <form method="post" action="/registroProveedor">
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
                        <a href="/registro" class="d-block text-center mt-3">Registrarse como cliente</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>