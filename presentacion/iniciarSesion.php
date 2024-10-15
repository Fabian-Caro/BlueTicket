<?php
session_start();

require_once(__DIR__ . '/../logica/Cliente.php');
require_once(__DIR__ . '/../logica/Proveedor.php');

$error = false;
$paginaAnterior = isset($_GET['paginaAnterior']) ? $_GET['paginaAnterior'] : 'index.php';
echo $paginaAnterior;

if ($paginaAnterior == "evento.php") {
	$paginaAnterior .= "?idEvento=" . urlencode($_SESSION["idEvento"]);
} else if ($paginaAnterior == 'compra.php') {
	$paginaAnterior .= "?idEvento=" . urlencode($_SESSION["idEvento"]) . "&idDetalle=" . urlencode($_SESSION["idDetalle"]);
} else if ($paginaAnterior == 'pago.php') {
	$paginaAnterior .= "?idEvento=" . urlencode($_SESSION["idEvento"]) . "&idDetalle=" . urlencode($_SESSION["idDetalle"]) . "&cantidad=" . urlencode($_SESSION["cantidad"]) . "&aforo=" . urlencode($_SESSION["aforo"]);
}
if (isset($_POST["autenticar"])) {
	if ($paginaAnterior != 'sesionProveedor.php') {
		$cliente = new Cliente(null, null, null, $_POST["correo"], $_POST["clave"]);
		if ($cliente->autenticar()) {
			$_SESSION["idCliente"] = $cliente->getIdCliente();
			header("Location: $paginaAnterior");
		} else {
			$error = true;
		}
	} else {
		$proveedor = new Proveedor(null, null, null, $_POST["correo"], $_POST["clave"]);
		if ($proveedor->autenticar()) {
			$_SESSION["idProveedor"] = $proveedor->getIdProveedor();
			header("Location: $paginaAnterior");
		} else {
			$error = true;
		}
	}
}
?>
<html>

<head>
	<link
		href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
		rel="stylesheet">
	<script
		src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
	<link href="css/estilos.css" rel="stylesheet">
</head>

<body>
	<div class="container">
		<div class="row mt-5">
			<div class="col-4"></div>
			<div class="col-4">
				<div class="card border-primary">
					<div class="card-header text-bg-info">
						<h4>Iniciar Sesion</h4>
					</div>
					<div class="card-body">
						<?php $paginaAnterior = isset($_GET['paginaAnterior']) ? $_GET['paginaAnterior'] : 'index.php';
						?>
						<form method="post" action="iniciarSesion.php?paginaAnterior=<?php echo urlencode($paginaAnterior); ?>">
							<div class="mb-3">
								<input type="email" name="correo" class="form-control" placeholder="Correo">
							</div>
							<div class="mb-3">
								<input type="password" name="clave" class="form-control" placeholder="Clave">
							</div>
							<button type="submit" name="autenticar" class="btn btn-primary">Iniciar Sesion</button>
							<?php if ($error) { ?>
								<div class="alert alert-danger mt-3" role="alert">
									Error de correo o clave
								</div>
							<?php } ?>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>

</html>