<?php
class FacturaDAO{
    private $idBoleta;
    private $nombre;
    private $factura;
    private $detalleEvento;
    
    public function __construct($idBoleta = 0, $nombre = "", $factura=null,$detalleEvento=null) {
        $this->idBoleta = $idBoleta;
        $this->nombre = $nombre;
        $this->factura = $factura;
        $this->detalleEvento = $detalleEvento;
    }
    
    public function ultimoId(){
        return "SELECT MAX(idBoleta) FROM Boleta ";
    }
    
    // public function insert($fecha="",$valor_subtotal=0,$valor_total=0,$idCliente=0) {
    //     return "INSERT into Factura (fecha,valor_subtotal,valor_total,idCliente)
    //             VALUES ($fecha,$valor_subtotal,$valor_total,$idCliente);";
    // }
    
}

?>