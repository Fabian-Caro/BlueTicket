<?php
require_once(__DIR__ . '/../config/config.php');

if (isset($_GET['cerrarSesion']) && $_GET['cerrarSesion'] === 'true') {
    // Limpia las variables de sesión
    $_SESSION = [];
    // Destruye la sesión
    session_destroy();
    // Redirige al usuario al inicio o login
    header("Location: /");
    exit;
}

require_once(__DIR__ . '/../src/Logic/Evento.php');

$routes = require(__DIR__ . '/../config/routes.php');

$currentPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

if (!array_key_exists($currentPath, $routes)) {
    http_response_code(404);
    include 'views/shared/errors/error404.php';
    echo "Error 404: Página no encontrada.";
    exit;
}

$requiresSession = $routes[$currentPath]['requires_session'] ?? false;

$usuario = null;
if (!empty($_SESSION['idProveedor'])) {
    $usuario = ['rol' => 'proveedor', 'id' => $_SESSION['idProveedor']];
} elseif (!empty($_SESSION['idCliente'])) {
    $usuario = ['rol' => 'cliente', 'id' => $_SESSION['idCliente']];
}

if ($requiresSession && !$usuario) {
    header("Location: /login");
    exit;
}

$allowedRoles = $routes[$currentPath]['allowed_roles'] ?? [];

if ($allowedRoles && (!$usuario || !in_array($usuario['rol'], $allowedRoles))) {
    http_response_code(403);
    include 'views/shared/errors/error403.php';
    echo "403 Forbidden - Acceso no permitido para tu rol.";
    exit;
}

$viewPath = $routes[$currentPath]['view'] ?? null;

if (!$viewPath || !file_exists(__DIR__ . '/../' . $viewPath)) {
    http_response_code(500);
    echo "Error interno: La vista asociada no existe.";
    exit;
}

?>

<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Blue Ticket</title>
    <link rel="icon" type="image/png" href="/assets/images/favicon.ico">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="/assets/css/estilos.css" rel="stylesheet">
</head>

<body>
    <header>
        <?php
        if (!empty($_SESSION['idProveedor'])) {
            include 'views/shared/navbarProveedor.php';
        } else {
            include 'views/shared/navbar.php';
        }
        ?>
    </header>

    <main>
        <?php include __DIR__ . '/../' . $viewPath; ?>
    </main>

    <?php include 'views/shared/footer.php' ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>