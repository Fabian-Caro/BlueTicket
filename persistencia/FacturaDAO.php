<?php
class FacturaDAO
{
    private $idFactura;
    private $fecha;
    private $valorSubtotal;
    private $valorTotal;
    private $cliente;

    public function __construct($idFactura = 0, $fecha = "", $valorSubtotal = 0, $valorTotal = 0, $cliente = null)
    {
        $this->idFactura = $idFactura;
        $this->fecha = $fecha;
        $this->valorSubtotal = $valorSubtotal;
        $this->valorTotal = $valorTotal;
        $this->cliente = $cliente;
    }

    public function consultarTodos() {
        return "SELECT 
                    idFactura, fecha, valor_subtotal, valor_total, idCliente
                FROM 
                    factura";
    }

    public function ultimoId()
    {
        return "SELECT MAX(idFactura) FROM Factura ";
    }

    public function consultar() {
        $sentenciaSQL = "SELECT idFactura, fecha, valor_subtotal, valor_total, idCliente 
                         FROM factura 
                         WHERE idFactura ='" . $this->idFactura . "'";

        return $sentenciaSQL;
    }

    public function insert($fechaHoraActual = "", $valor_subtotal = 0, $valor_total = 0, $idCliente = 0) {
        $sentenciaSQL = "INSERT into Factura (fecha,valor_subtotal,valor_total,idCliente)
                VALUES ($fechaHoraActual,$valor_subtotal,$valor_total,$idCliente);";
        return $sentenciaSQL;
    }
}
