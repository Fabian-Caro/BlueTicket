<?php
return [

    '/login' => [
        'view' => '/public/views/auth/login.php',
        'requires_session' => false,
        'allowed_roles' => [],
    ],

    '/registro' => [
        'view' => '/public/views/cliente/registrarCliente.php',
        'requires_session' => false,
        'allowed_roles' => [],
    ],

    '/registroProveedor' => [
        'view' => '/public/views/proveedor/registrarProveedor.php',
        'requires_session' => false,
        'allowed_roles' => [],
    ],

    '/' => [
        'view' => '/public/views/cliente/inicioCliente.php',
        'requires_session' => false,
        'allowed_roles' => [],
    ],

    '/admin' => [
        'view' => '/public/views/proveedor/inicioProveedor.php',
        'requires_session' => true,
        'allowed_roles' => ['proveedor'],
    ],

    '/mantenimientoEvento' => [
        'view' => '/public/views/proveedor/mantenimientoEvento.php',
        'requires_session' => true,
        'allowed_roles' => ['proveedor'],
    ],

    '/crearEvento' => [
        'view' => '/public/views/proveedor/detalleEvento.php',
        'requires_session' => true,
        'allowed_roles' => ['proveedor'],
    ],

    '/editarImagen' => [
        'view' => '/public/views/proveedor/editarImagen.php',
        'requires_session' => true,
        'allowed_roles' => ['proveedor'],
    ],

    '/nuevoEvento' => [
        'view' => '/public/views/proveedor/nuevoEvento.php',
        'requires_session' => true,
        'allowed_roles' => ['proveedor'],
    ],

    '/nuevoArtista' => [
        'view' => '/public/views/proveedor/nuevoArtista.php',
        'requires_session' => true,
        'allowed_roles' => ['proveedor'],
    ],

    '/nuevoLugar' => [
        'view' => '/public/views/proveedor/nuevoLugar.php',
        'requires_session' => true,
        'allowed_roles' => ['proveedor'],
    ],

    '/graficaEventoMasVendido' => [
        'view' => '/public/views/proveedor/graficaEventoMasVendido.php',
        'requires_session' => true,
        'allowed_roles' => ['proveedor'],
    ],

    '/graficaCategoriaEvento' => [
        'view' => '/public/views/proveedor/graficaCategoriaEvento.php',
        'requires_session' => true,
        'allowed_roles' => ['proveedor'],
    ],

    '/graficaGastosClientes' => [
        'view' => '/public/views/proveedor/graficaGastosClientes.php',
        'requires_session' => true,
        'allowed_roles' => ['proveedor'],
    ],

    '/evento' => [
        'view' => '/public/views/cliente/evento.php',
        'requires_session' => false,
        'allowed_roles' => ['cliente', 'proveedor'],
    ],
    
    '/compra' => [
        'view' => '/public/views/cliente/compra.php',
        'requires_session' => false,
        'allowed_roles' => ['cliente', 'proveedor'],
    ],

    '/pago' => [
        'view' => '/public/views/cliente/pago.php',
        'requires_session' => true,
        'allowed_roles' => ['cliente'],
    ],

    '/factura' => [
        'view' => '/public/views/cliente/factura.php',
        'requires_session' => true,
        'allowed_roles' => ['cliente'],
    ],

    '/facturaCarro' => [
        'view' => '/public/views/cliente/facturaCarro.php',
        'requires_session' => true,
        'allowed_roles' => ['cliente'],
    ],

    '/boleteria' => [
        'view' => '/public/views/cliente/boleteria.php',
        'requires_session' => true,
        'allowed_roles' => ['cliente'],
    ],

    '/carro' => [
        'view' => '/public/views/cliente/carro.php',
        'requires_session' => true,
        'allowed_roles' => ['cliente'],
    ],

    '/pdf' => [
        'view' => '/src/Services/facturaPDF.php',
        'requires_session' => true,
        'allowed_roles' => ['cliente'],
    ],

    '/boletaQR' => [
        'view' => '/src/Services/boletaQR.php',
        'requires_session' => true,
        'allowed_roles' => ['cliente'],
    ],
];
?>