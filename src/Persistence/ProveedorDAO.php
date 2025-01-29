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
        return "select idProveedor, estado
                from Proveedor 
                where correo = '" . $this -> correo . "' and clave = '" . $this -> clave . "'";
    }

    public function insertar($nombre, $apellido, $correo, $clave) {
        $sentenciaSQL = "INSERT INTO proveedor (nombre, apellido, correo, clave) VALUES ('$nombre', '$apellido', '$correo', '$clave')";
        return $sentenciaSQL;
    }
    
    public function consultar(){
        return "select nombre, apellido, correo, clave, estado
                from Proveedor
                where idProveedor = '" . $this -> idProveedor . "'";
    }
    public function consultarEventos(){
        return "SELECT idEvento, nombre, idCategoria, idArtista, imagen
                FROM Evento where idProveedor =  '". $this -> idProveedor . "'";
    }
}
?>