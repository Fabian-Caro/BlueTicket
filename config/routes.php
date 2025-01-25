<?php
return [

    '/login' => [
        'view' => '/public/views/auth/login.php',
        'requires_session' => false,
    ],

    '/registro' => [
        'view' => '/public/views/cliente/registrarCliente.php',
        'requires_session' => false,
    ],

    '/registroProveedor' => [
        'view' => '/public/views/proveedor/registrarProveedor.php',
        'requires_session' => false,
    ],

    '/' => [
        'view' => '/public/views/cliente/inicioCliente.php',
        'requires_session' => false,
    ],

    '/admin' => [
        'view' => '/public/views/proveedor/inicioProveedor.php',
        'requires_session' => true,
    ],

    '/mantenimientoEvento' => [
        'view' => '/public/views/proveedor/mantenimientoEvento.php',
        'requires_session' => true,
    ],

    '/crearEvento' => [
        'view' => '/public/views/proveedor/detalleEvento.php',
        'requires_session' => true,
    ],

    '/editarImagen' => [
        'view' => '/public/views/proveedor/editarImagen.php',
        'requires_session' => true,
    ],

    '/nuevoEvento' => [
        'view' => '/public/views/proveedor/nuevoEvento.php',
        'requires_session' => true,
    ],

    '/nuevoArtista' => [
        'view' => '/public/views/proveedor/nuevoArtista.php',
        'requires_session' => true,
    ],

    '/nuevoLugar' => [
        'view' => '/public/views/proveedor/nuevoLugar.php',
        'requires_session' => true,
    ],

    '/graficaEventoMasVendido' => [
        'view' => '/public/views/proveedor/graficaEventoMasVendido.php',
        'requires_session' => true,
    ],

    '/graficaCategoriaEvento' => [
        'view' => '/public/views/proveedor/graficaCategoriaEvento.php',
        'requires_session' => true,
    ],

    '/graficaGastosClientes' => [
        'view' => '/public/views/proveedor/graficaGastosClientes.php',
        'requires_session' => true,
    ],

    '/evento' => [
        'view' => '/public/views/cliente/evento.php',
        'requires_session' => false,
    ],
    
    '/compra' => [
        'view' => '/public/views/cliente/compra.php',
        'requires_session' => false,
    ],

    '/pago' => [
        'view' => '/public/views/cliente/pago.php',
        'requires_session' => true,
    ],

    '/factura' => [
        'view' => '/public/views/cliente/factura.php',
        'requires_session' => true,
    ],

    '/facturaCarro' => [
        'view' => '/public/views/cliente/facturaCarro.php',
        'requires_session' => true,
    ],

    '/boleteria' => [
        'view' => '/public/views/cliente/boleteria.php',
        'requires_session' => true,
    ],

    '/carro' => [
        'view' => '/public/views/cliente/carro.php',
        'requires_session' => true,
    ],

    '/pdf' => [
        'view' => '/src/Services/facturaPDF.php',
        'requires_session' => true,
    ],
];
?>