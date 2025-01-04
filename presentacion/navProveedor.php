<?php
session_start();
if (!isset($_SESSION["idProveedor"])) {
	header("Location: index.php");
}
$idProveedor = $_SESSION["idProveedor"];
require_once(__DIR__ . '/../logica/Proveedor.php');
$proveedor = new Proveedor($idProveedor);
$proveedor->consultar();
?>

<nav class="navbar navbar-expand-lg bg-body-tertiary">
	<div class="container">
		<a class="navbar-brand" href="sesionProveedor.php"><img src="imagenes/logo.webp" width="50" /></a>
		<button class="navbar-toggler" type="button"
			data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown"
			aria-controls="navbarNavDropdown" aria-expanded="false"
			aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse" id="navbarNavDropdown">
			<ul class="navbar-nav me-auto">
				<li class="nav-item dropdown"><a class="nav-link dropdown-toggle"
						href="#" role="button" data-bs-toggle="dropdown"
						aria-expanded="false">Evento</a>
					<ul class="dropdown-menu">
						<li><a class='dropdown-item' href='newEvento.php'>Nuevo Evento</a></li>
						<li><a class='dropdown-item' href='newArtista.php'>Nuevo Artista</a></li>
						<li><a class='dropdown-item' href='nuevoLugar.php'>Nuevo Lugar</a></li>
					</ul>
				</li>
			</ul>
			<ul class="navbar-nav">
				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
						<?php echo $proveedor->getNombre() . " " . $proveedor->getApellido() ?></a>
					<ul class="dropdown-menu">
						<li><a class='dropdown-item' href='index.php?cerrarSesion=true'>Cerrar Sesion</a></li>
					</ul>
				</li>
			</ul>
		</div>
	</div>
</nav>