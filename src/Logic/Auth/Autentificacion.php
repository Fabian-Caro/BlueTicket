<?php
require_once (__DIR__ . '/../Cliente.php');
require_once (__DIR__ . '/../Proveedor.php');

class Autentificacion {
    public static function autentificar ($correo, $clave) {
        $proveedor = new Proveedor(null, null, null, $correo, $clave);

        if ($proveedor -> autenticar()) {

            if ($proveedor -> getEstado() == 0) {
                return "Cuenta sin activar";
            } else if ($proveedor -> getEstado() == 2) {
                return "Cuenta bloqueada";
            }

            return ['rol' => 'proveedor', 'id' => $proveedor -> getIdProveedor()];
        }

        $cliente = new Cliente(null, null, null, $correo, $clave, null);

        if ($cliente -> autenticar()) {

            if ($cliente -> getEstado() == 0) {
                return "Cuenta sin activar";
            } else if ($cliente -> getEstado() == 2) {
                return "Cuenta bloqueada";
            }
            
            return ['rol' => 'cliente', 'id' => $cliente -> getIdCliente()];
        }

        return "Las credenciales no coinciden";
    }
}

?>
