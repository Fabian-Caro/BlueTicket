<?php
return [
    '/' => [
        'view' => '/public/views/cliente/inicioCliente.php',
        'requires_session' => false,
    ],

    '/login' => [
        'view' => '/public/views/auth/login.php',
        'requires_session' => false,
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

    '/pdf' => [
        'view' => '/src/Services/facturaPDF.php',
        'requires_session' => true,
    ],
];
?>