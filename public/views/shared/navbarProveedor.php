<?php
if (!isset($_SESSION["idProveedor"])) {
	header("Location: index.php");
}
$idProveedor = $_SESSION["idProveedor"];
require_once(__DIR__ . '/../../../src/Logic/Proveedor.php');

$proveedor = new Proveedor($idProveedor);
$proveedor->consultar();
?>

<nav class="navbar navbar-expand-lg bg-body-tertiary">
	<div class="container">
		<a class="navbar-brand" href="/admin"><img src="/assets/images/logo.webp" width="50" /></a>
		<div class="collapse navbar-collapse" id="navbarNavDropdown">
			<ul class="navbar-nav me-auto">
				<li class="nav-item dropdown"><a class="nav-link dropdown-toggle"
						href="#" role="button" data-bs-toggle="dropdown"
						aria-expanded="false">Evento</a>
					<ul class="dropdown-menu">
						<li><a class='dropdown-item' href='/nuevoEvento'>Nuevo Evento</a></li>
						<li><a class='dropdown-item' href='/nuevoArtista'>Nuevo Artista</a></li>
						<li><a class='dropdown-item' href='/nuevoLugar'>Nuevo Lugar</a></li>
					</ul>
				</li>
				<li class="nav-item dropdown"><a class="nav-link dropdown-toggle"
						href="#" role="button" data-bs-toggle="dropdown"
						aria-expanded="false">Graficas</a>
					<ul class="dropdown-menu">
						<li><a class='dropdown-item' href='/graficaEventoMasVendido'>Eventos mas vendidos</a></li>
						<li><a class='dropdown-item' href='/graficaCategoriaEvento'>Categoria por eventos</a></li>
						<li><a class='dropdown-item' href='/graficaGastosClientes'>Gastos por clientes</a></li>
					</ul>
				</li>
			</ul>
			<ul class="navbar-nav">
				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
						<?php echo $proveedor->getNombre() . " " . $proveedor->getApellido() ?></a>
					<ul class="dropdown-menu">
						<li><a class='dropdown-item' href='/../?cerrarSesion=true'>Cerrar Sesion</a></li>
					</ul>
				</li>
			</ul>
		</div>
	</div>
</nav>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>