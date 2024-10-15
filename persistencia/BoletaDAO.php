<?php
class BoletaDAO
{
    private $idBoleta;
    private $nombre;
    private $factura;
    private $detalleEvento;

    public function __construct($idBoleta = 0, $nombre = "", $factura = null, $detalleEvento = null)
    {
        $this->idBoleta = $idBoleta;
        $this->nombre = $nombre;
        $this->factura = $factura;
        $this->detalleEvento = $detalleEvento;
    }

    public function consultarTodos()
    {
        return "SELECT idBoleta, nombre_usuario, idFactura, idDetalle FROM boleta";
    }

    public function consultarBoletasPorCliente()
    {
        return "SELECT b.idFactura, c.nombre, c.apellido, b.nombre_usuario, e.nombre, d.fecha, f.idCliente 
FROM boleta b 
JOIN factura f ON b.idFactura = f.idFactura 
JOIN cliente c ON f.idCliente = c.idCliente
JOIN detalle_evento d ON b.idDetalle = d.idDetalle 
JOIN evento e ON d.idEvento = e.idEvento
where f.idCliente=1";
    }

    public function ultimoId()
    {
        return "SELECT MAX(idBoleta) FROM Boleta ";
    }

    public function insert($nombre_usuario = "", $idFactura = 0, $idDetalle = 0)
    {
        return "INSERT into Boleta (nombre_usuario,idFactura,idDetalle)
                VALUES ($nombre_usuario,$idFactura,$idDetalle);";
    }
}
