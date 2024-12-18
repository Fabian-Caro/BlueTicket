<?php
require_once(__DIR__ . '/../config/config.php');
require_once(__DIR__ . '/../logica/Autentificacion.php');

$paginaAnterior = isset($_GET['paginaAnterior']) ? $_GET['paginaAnterior'] : 'index.php';

$error = false;
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$correo = filter_var($_POST['correo'], FILTER_SANITIZE_EMAIL);
	$clave = md5($_POST['clave']);

	$resultado = Autentificacion::autentificar($correo, $clave);

	if ($resultado) {

		if ($resultado['rol'] === 'proveedor') {
			$_SESSION['idProveedor'] = $resultado['id'];
			header("Location: sesionProveedor.php");
		} elseif ($resultado['rol'] === 'cliente') {
			$_SESSION['idCliente'] = $resultado['id'];
			header("Location: $paginaAnterior");
		}
		exit;
	} else {
		$error = "Error de correo o clave";
	}
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Iniciar Sesión</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
	<link href="css/estilos.css" rel="stylesheet">
</head>

<body>
	<header>
		<?php include 'navbar.php' ?>
	</header>

	<?php
	if ($paginaAnterior == "evento.php") {
		$paginaAnterior .= "?idEvento=" . urlencode($_SESSION["idEvento"]);
	} else if ($paginaAnterior == 'compra.php') {
		$paginaAnterior .= "?idEvento=" . urlencode($_SESSION["idEvento"]) . "&idDetalle=" . urlencode($_SESSION["idDetalle"]);
	} else if ($paginaAnterior == 'pago.php') {
		$paginaAnterior .= "?idEvento=" . urlencode($_SESSION["idEvento"]) . "&idDetalle=" . urlencode($_SESSION["idDetalle"]) . "&cantidad=" . urlencode($_SESSION["cantidad"]) . "&aforo=" . urlencode($_SESSION["aforo"]);
	}
	?>

	<div class="container d-flex justify-content-center align-items-center" style="height: 100vh;">
		<div class="card w-50 border-primary">
			<div class="card-header bg-primary text-white">
				<h4>Iniciar Sesión</h4>
			</div>
			<div class="card-body">
				<form method="post" action="iniciarSesion.php?paginaAnterior=<?php echo urlencode($paginaAnterior); ?>">
					<div class="mb-3">
						<label for="correo" class="form-label">Correo</label>
						<input type="email" name="correo" class="form-control" placeholder="Correo" required>
					</div>
					<div class="mb-3">
						<label for="clave" class="form-label">Clave</label>
						<input type="password" name="clave" class="form-control" placeholder="Clave" required>
					</div>
					<button type="submit" class="btn btn-primary w-100">Iniciar Sesión</button>
				</form>
				<?php if ($error): ?>
					<div class="alert alert-danger mt-3">
						<?php echo $error; ?>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</div>
	<footer>
		<?php include 'footer.php' ?>
	</footer>
</body>

</html>