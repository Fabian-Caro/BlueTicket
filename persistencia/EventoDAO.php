<?php
class EventoDAO{
    private $idEvento;
    private $nombre;
    
    public function __construct($idEvento=0, $nombre=""){
        $this -> idEvento = $idEvento;
        $this -> nombre = $nombre;
    }
    
    public function consultarTodos(){
        return "SELECT idEvento, nombre, idCategoria, idArtista 
                FROM evento";
    }

    public function consultarIdEvento($idEvento) {
        return "SELECT idEvento, nombre, idProveedor, idCategoria, idArtista FROM evento WHERE idEvento = $idEvento";
    }

    public function consultar() {
        return "SELECT nombre FROM evento WHERE idEvento ='" . $this->idEvento . "'";
    }
    
    public function insert($nombre="",$idProveedor=0,$idCategoria=0,$idArtista=0) {
        return "INSERT INTO Evento (nombre,idProveedor,idCategoria,idArtista) 
        VALUES ($nombre, $idProveedor,$idCategoria,$idArtista)";
    }
    
}

?>