<?php
class ArtistaDAO{
    private $idArtista;
    private $nombre;
    
    public function __construct($idArtista=0, $nombre=""){
        $this -> idArtista = $idArtista;
        $this -> nombre = $nombre;
    }
    
    public function consultarTodos(){
        return "select idArtista, nombre
                from Artista
                order by nombre asc";
    }
    
    public function consultar(){
        return "select nombre 
                from Artista
                where idArtista = '" . $this -> idArtista . "'";
    }

    public function insert($nombre="") {
        return "INSERT INTO artista (nombre) 
        VALUES ($nombre)";
    }
}

?>