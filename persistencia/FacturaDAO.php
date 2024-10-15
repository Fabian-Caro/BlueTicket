<?php
class FacturaDAO{
    private $idFactura;
    private $fecha;
    private $valorSubtotal;
    private $valorTotal;
    private $cliente;
    
    public function __construct($idFactura = 0, $fecha = "", $valorSubtotal=0, $valorTotal=0,$cliente=null) {
        $this->idFactura = $idFactura;
        $this->fecha = $fecha;
        $this->valorSubtotal = $valorSubtotal;
        $this->valorTotal = $valorTotal;
        $this->cliente = $cliente;
    }
    
    public function ultimoId(){
        return "SELECT MAX(idFactura) FROM Factura ";
    }
    
    public function insert($fecha="",$valor_subtotal=0,$valor_total=0,$idCliente=0) {
        return "INSERT into Factura (fecha,valor_subtotal,valor_total,idCliente)
                VALUES ($fecha,$valor_subtotal,$valor_total,$idCliente);";
    }
    
}

?>