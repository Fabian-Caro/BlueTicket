<?php

class ClienteDAO{
    private $idCliente;
    private $nombre;
    private $apellido;
    private $correo;
    private $clave;

    public function __construct($idCliente=0, $nombre="", $apellido="", $correo="", $clave=""){
        $this -> idCliente = $idCliente;
        $this -> nombre = $nombre;
        $this -> apellido = $apellido;
        $this -> correo = $correo;
        $this -> clave = $clave;
    }
    public function autenticar(){
        return "select idCliente
                from Cliente 
                where correo = '" . $this -> correo . "' and clave = '" . $this -> clave . "'";
    }
    
    public function consultar(){
        return "select nombre, apellido, correo
                from Cliente
                where idCliente = '" . $this -> idCliente . "'";
    }
}

?>