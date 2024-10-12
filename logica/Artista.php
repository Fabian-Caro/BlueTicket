<?php
require_once ("./persistencia/Conexion.php");
require ("./persistencia/ArtistaDAO.php");

class Artista{
    private $idArtista;
    private $nombre;

    public function getIdArtista() {
        return $this->idArtista;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function setIdArtista($idArtista){
        $this->idArtista = $idArtista;
    }

    public function setNombre($nombre){
        $this->nombre = $nombre;
    }

    public function __construct($idArtista=0, $nombre=""){
        $this -> idArtista = $idArtista;
        $this -> nombre = $nombre;
    }
    
    public function consultarTodos(){
        $artistas = array();
        $conexion = new Conexion();
        $conexion -> abrirConexion();
        $artistaDAO = new ArtistaDAO();
        $conexion -> ejecutarConsulta($artistaDAO -> consultarTodos());
        while($registro = $conexion -> siguienteRegistro()){
            $artista = new Artista($registro[0], $registro[1]);
            array_push($artistas, $artista);
        }
        $conexion -> cerrarConexion();
        return $artistas;        
    }
    
    public function consultar(){
        $conexion = new Conexion();
        $conexion -> abrirConexion();
        $artistaDAO = new ArtistaDAO($this -> idArtista);
        $conexion -> ejecutarConsulta($artistaDAO -> consultar());
        $registro = $conexion -> siguienteRegistro();
        $this -> nombre = $registro[0];
        $conexion -> cerrarConexion();
    }    
}

?>