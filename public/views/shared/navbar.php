<?php
require_once(__DIR__ . '/../../../config/config.php');
require_once (__DIR__ . '/../../../config/routes.php');
require_once (__DIR__ .'/../../../src/Logic/Cliente.php');

basename($_SERVER['PHP_SELF']);
//echo basename($_SERVER['PHP_SELF']);

$paginaAnterior = $_SERVER['REQUEST_URI'];
$paginaAnteriorCodificada = urlencode($paginaAnterior);

//echo $paginaAnteriorCodificada;
//echo "iniciarSesion.php?paginaAnterior=" . $paginaAnteriorCodificada;

if (basename(parse_url($paginaAnterior, PHP_URL_PATH)) === 'iniciarSesion.php') {

    $paginaAnterior = '/'; // Cambiar a una página base para evitar bucles

}

if ($paginaAnterior == "evento.php") {

    $_SESSION["idEvento"] = $idEvento;
} else if ($paginaAnterior == 'compra.php') {

    $_SESSION["idEvento"] = $idEvento;
    $_SESSION["idDetalle"] = $idDetalle;
} else if ($paginaAnterior == 'pago.php') {

    $_SESSION["idEvento"] = $idEvento;
    $_SESSION["idDetalle"] = $idDetalle;
    $_SESSION["cantidad"] = isset($_GET['cantidad']) ? intval($_GET['cantidad']) : 0; // Definir cantidad
    $_SESSION["aforo"] = isset($_GET['aforo']) ? intval($_GET['aforo']) : 0;

    if (!isset($_SESSION["idCliente"])) {

        header("Location: iniciarSesion.php?paginaAnterior=" . $paginaAnterior);
    }
}


if (isset($_GET["cerrarSesion"])) {

    session_destroy();

    header("Location: /");
}

?>

<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
        <a class="navbar-brand" href="/">
            <img src="/assets/images/logo.webp" style="width: 30px; height: 30px;" alt="Logo">
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
            // ?paginaAnterior=<?php echo urlencode($paginaAnterior);
            if (!isset($_SESSION["idCliente"])) {
            ?>
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="/login">Iniciar Sesión</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/registro">Registrarse</a>
                    </li>
                </ul>
            <?php
            } else {
                $idCliente = $_SESSION["idCliente"];
                $cliente = new Cliente($idCliente);
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
                            <li><a class='dropdown-item' href='/boleteria'>Historial</a></li>
                            <li><a class='dropdown-item' href='/carro'>Carro</a></li>
                            <li><a class='dropdown-item' href='/../?cerrarSesion=true'>Cerrar Sesion</a></li>
                        </ul>
                    </li>
                </ul>
            <?php
            }
            ?>
        </div>
    </div>
</nav>