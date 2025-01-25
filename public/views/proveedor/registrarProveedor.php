<?php
require_once(__DIR__ . '/../../../src/Logic/Proveedor.php');

if (isset($_POST['registrar'])) {
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $correo = $_POST['correo'];
    $clave = md5($_POST['clave']);

    $proveedor = new Proveedor(null, $nombre, $apellido, $correo, $clave);

    if ($proveedor->registrar($nombre, $apellido, $correo, $clave)) {
        session_start();
        $_SESSION['idProveedor'] = $proveedor->getIdProveedor();
        echo "  <div class='alert alert-success' role='alert'>
                Registro completado
                </div>";

        header("Location: /");
        exit();
    } else {
        echo "error al registrar al proveedor.";
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