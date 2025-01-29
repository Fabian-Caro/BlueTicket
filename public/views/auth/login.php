<?php
require_once(__DIR__ . '/../../../config/config.php');
require_once(__DIR__ . '/../../../config/routes.php');
require_once(__DIR__ . '/../../../src/Logic/Auth/Autentificacion.php');

$paginaAnterior = isset($_GET['paginaAnterior']) ? $_GET['paginaAnterior'] : '/';

if ($paginaAnterior == "evento.php") {
	$paginaAnterior .= "?idEvento=" . urlencode($_SESSION["idEvento"]);
} else if ($paginaAnterior == 'compra.php') {
	$paginaAnterior .= "?idEvento=" . urlencode($_SESSION["idEvento"]) . "&idDetalle=" . urlencode($_SESSION["idDetalle"]);
} else if ($paginaAnterior == 'pago.php') {
	$paginaAnterior .= "?idEvento=" . urlencode($_SESSION["idEvento"]) . "&idDetalle=" . urlencode($_SESSION["idDetalle"]) . "&cantidad=" . urlencode($_SESSION["cantidad"]) . "&aforo=" . urlencode($_SESSION["aforo"]);
}

$error = false;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	$correo = filter_var($_POST['correo'], FILTER_SANITIZE_EMAIL);
	$clave = md5($_POST['clave']);

	$resultado = Autentificacion::autentificar($correo, $clave);

	if (is_array($resultado)) {

		if ($resultado['rol'] === 'proveedor') {

			$_SESSION['idProveedor'] = $resultado['id'];
			header("Location: /admin");
		} elseif ($resultado['rol'] === 'cliente') {

			$_SESSION['idCliente'] = $resultado['id'];
			header("Location: $paginaAnterior");
		}
		exit;
	} else {

		$error = $resultado;
	}
}

?>
<style>
	body {
		background-color: #F8F9FA;
		/* Fondo gris claro */
		font-family: 'Poppins', sans-serif;
	}

	.card {
		border-radius: 12px;
		box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
	}

	.card-header {
		border-top-left-radius: 12px;
		border-top-right-radius: 12px;
		text-align: center;
		font-weight: bold;
	}

	.btn-primary {
		background-color: #007BFF;
		border: none;
		font-weight: bold;
	}

	.btn-primary:hover {
		background-color: #0056B3;
	}

	.extra-links {
		text-align: center;
		margin-top: 15px;
	}

	.extra-links a {
		color: #007BFF;
		text-decoration: none;
		font-size: 14px;
	}

	.extra-links a:hover {
		text-decoration: underline;
	}
</style>
<div class="container d-flex justify-content-center align-items-center" style="height: 100vh;">
    <div class="card w-50 border-primary">
        <div class="card-header bg-primary text-white">
            <h4>Iniciar Sesión</h4>
        </div>
        <div class="card-body">
            <form method="post" action="/login">
                <div class="mb-3">
                    <label for="correo" class="form-label">Correo</label>
                    <input type="email" name="correo" class="form-control" placeholder="Ingresa tu correo" required>
                </div>
                <div class="mb-3">
                    <label for="clave" class="form-label">Clave</label>
                    <input type="password" name="clave" class="form-control" placeholder="Ingresa tu clave" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Iniciar Sesión</button>
            </form>

            <?php if (isset($error) && $error): ?>
                <div class="alert alert-danger mt-3">
                    <?php echo $error; ?>
                </div>
            <?php endif; ?>

            <div class="extra-links">
                <a href="#">¿Olvidaste tu clave?</a> |  
                <a href="/registro">Crear cuenta</a>
            </div>
        </div>
    </div>
</div>