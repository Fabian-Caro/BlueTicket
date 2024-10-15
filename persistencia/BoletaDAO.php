<?php
class BoletaDAO{
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
    
    public function insert($nombre_usuario="",$idFactura=0,$idDetalle=0) {
        return "INSERT into Boleta (nombre_usuario,idFactura,idDetalle)
                VALUES ($nombre_usuario,$idFactura,$idDetalle);";
    }
    
}

?>