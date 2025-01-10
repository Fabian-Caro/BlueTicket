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

    public function insertar($nombre, $apellido, $correo, $clave) {
        $sentenciaSQL = "INSERT INTO cliente (nombre, apellido, correo, clave) VALUES ('$nombre', '$apellido', '$correo', '$clave')";
        return $sentenciaSQL;
    }

    public function autenticar(){
        return "select idCliente
                from Cliente 
                where correo = '" . $this -> correo . "' and clave = '" . $this -> clave . "'";
    }
    
    public function consultar(){
        $sentenciaSQL = "SELECT idCliente, nombre, apellido, correo
                FROM cliente 
                WHERE idCliente = '" . $this -> idCliente . "'";
        return $sentenciaSQL;

    }

    public function consultarGastoCliente(){
        return "SELECT c.correo, SUM(f.valor_total) as sum
                FROM cliente c LEFT JOIN factura f on c.idCliente = f.idCliente
                GROUP by c.idCliente
                ORDER BY sum DESC;";
    }

    public function consultarBoletas(){
        return "SELECT b.idFactura, c.nombre, c.apellido, b.nombre_usuario, e.nombre, d.fecha, f.idCliente 
                FROM boleta b 
                JOIN factura f ON b.idFactura = f.idFactura 
                JOIN cliente c ON f.idCliente = c.idCliente
                JOIN detalle_evento d ON b.idDetalle = d.idDetalle 
                JOIN evento e ON d.idEvento = e.idEvento
                WHERE f.idCliente = ".$this->idCliente;

    }
}

?>