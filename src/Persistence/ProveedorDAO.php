<?php

class ProveedorDAO
{
    private $idProveedor;
    private $nombre;
    private $apellido;
    private $correo;
    private $clave;
    private $estado;

    public function __construct(
        $idProveedor = 0,
        $nombre = "",
        $apellido = "",
        $correo = "",
        $clave = "",
        $estado = 0,
    ) {
        $this->idProveedor = $idProveedor;
        $this->nombre = $nombre;
        $this->apellido = $apellido;
        $this->correo = $correo;
        $this->clave = $clave;
        $this->estado = $estado;
    }
    public function autenticar()
    {
        return "SELECT idProveedor, estado
                FROM Proveedor 
                WHERE correo = '" . $this->correo . "' AND clave = '" . $this->clave . "'";
    }

    public function activarCuenta($idProveedor)
    {
        $sentenciaSQL = "UPDATE proveedor SET estado = 1 WHERE idProveedor = $idProveedor";

        return $sentenciaSQL;
    }

    public function insertar($nombre, $apellido, $correo, $clave)
    {
        $sentenciaSQL = "INSERT INTO proveedor (nombre, apellido, correo, clave) VALUES ('$nombre', '$apellido', '$correo', '$clave')";
        return $sentenciaSQL;
    }

    public function consultar()
    {
        return "select nombre, apellido, correo, clave, estado
                from Proveedor
                where idProveedor = '" . $this->idProveedor . "'";
    }
    public function consultarEventos()
    {
        return "SELECT idEvento, nombre, idCategoria, idArtista, imagen
                FROM Evento where idProveedor =  '" . $this->idProveedor . "'";
    }
}
