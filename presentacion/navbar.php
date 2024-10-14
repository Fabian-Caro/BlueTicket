<?php 
$paginaAnterior = basename($_SERVER['PHP_SELF']);
## echo $paginaAnterior;
session_start();
if($paginaAnterior=="evento.php"){
    $_SESSION["idEvento"] = $idEvento;
}
if(isset($_GET["cerrarSesion"])){
    session_destroy();
    header("Location: index.php");
}
require_once(__DIR__ . '/../logica/Cliente.php');
?>
<head>
<link
	href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
	rel="stylesheet">
<script
	src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
        <a class="navbar-brand" href="index.php">
            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRXu9fXcn2O9M2vE5nCisBfDjiey4LxYsxdXA&s" style="width: 30px; height: 30px;" alt="Logo">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-center" id="navbarSupportedContent">
            <form class="d-flex" role="search">
                <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" disabled>
                <button class="btn btn-outline-success" type="submit" disabled>Search</button>
            </form>
        </div>
        <div class="ml-auto">
        <?php 
            if (!isset($_SESSION["id"])) {
        ?>
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a href="iniciarSesion.php?paginaAnterior=<?php echo urlencode($paginaAnterior); ?>" class="nav-link">Iniciar Sesion</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link disabled" href="#">Registrarse</a>
                </li>
            </ul>
        <?php 
            } else {
                $id = $_SESSION["id"];
                $cliente = new Cliente($id);
                $cliente->consultar();
        ?>
            <ul class="navbar-nav">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle"
                    href="#" role="button" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    <?php echo $cliente->getNombre() . " " . $cliente->getApellido(); ?>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class='dropdown-item' href='index.php?cerrarSesion=true'>Cerrar Sesion</a></li>
                    </ul>
                </li>
            </ul>
        <?php 
            } 
        ?>
        </div>

    </div>
</nav>