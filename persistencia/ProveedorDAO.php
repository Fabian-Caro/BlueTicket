<?php

class ProveedorDAO{
    private $idProveedor;
    private $nombre;
    private $apellido;
    private $correo;
    private $clave;

    public function __construct($idProveedor=0, $nombre="", $apellido="", $correo="", $clave=""){
        $this -> idProveedor = $idProveedor;
        $this -> nombre = $nombre;
        $this -> apellido = $apellido;
        $this -> correo = $correo;
        $this -> clave = $clave;
    }
    public function autenticar(){
        return "select idProveedor
                from Proveedor 
                where correo = '" . $this -> correo . "' and clave = '" . $this -> clave . "'";
    }
    
    public function consultar(){
        return "select nombre, apellido, correo
                from Proveedor
                where idProveedor = '" . $this -> idProveedor . "'";
    }
    public function consultarEventos(){
        return "SELECT idEvento, nombre, idCategoria, idArtista 
                FROM Evento where idProveedor =  '". $this -> idProveedor . "'";
    }
}
?>