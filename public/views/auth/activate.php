<?php
require_once (__DIR__ . '/../../../src/Logic/Cliente.php');
require_once (__DIR__ . '/../../../src/Logic/Proveedor.php');

if (isset($_GET['ic'])) {
    $idCliente = $_GET['ic'];

    $cliente = new Cliente();
    if ($cliente->activarCuenta($idCliente)) {
        echo "  <div class='alert alert-success' role='alert'>
                Cuenta activada
                </div>";
    } else {
        echo "  <div class='alert alert-danger' role='alert'>
                Algo malo a ocurrido
                </div>";
    }
    
} else if (isset($_GET['ip'])) {
    $idProveedor = $_GET['ip'];

    $proveedor = new Proveedor();
    if ($proveedor->activarCuenta($idProveedor)) {
        echo "  <div class='alert alert-success' role='alert'>
                Cuenta activada
                </div>";
    } else {
        echo "  <div class='alert alert-danger' role='alert'>
                Algo malo a ocurrido
                </div>";
    }
} else {
    echo "  <div class='alert alert-danger' role='alert'>
            Algo malo a ocurrido
            </div>";
}
?>