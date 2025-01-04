<?php
require_once (__DIR__ . '/../Database/Conexion.php');
require(__DIR__ . '/../Persistence/LugarDAO.php');
require_once(__DIR__ . '/Ciudad.php');

class Lugar {
    private $idLugar;
    private $nombreLugar;
    private $direccionLugar;
    private $capacidadMaximaLugar;
    private $ciudad;

    public function getIdLugar() {
        return $this->idLugar;
    }

    public function setIdLugar($idLugar) {
        $this->idLugar = $idLugar;
    }

    public function getNombreLugar() {
        return $this->nombreLugar;
    }

    public function setNombreLugar($nombreLugar) {
        $this->nombreLugar = $nombreLugar;
    }

    public function getDireccionLugar() {
        return $this->direccionLugar;
    }

    public function setDireccionLugar($direccionLugar) {
        $this->direccionLugar = $direccionLugar;
    }

    public function getCapacidadMaximaLugar () {
        return $this -> capacidadMaximaLugar;
    }

    public function setCapacidadMaximaLugar ($capacidadMaximaLugar) {
        $this -> capacidadMaximaLugar = $capacidadMaximaLugar;
    }

    public function getCiudad() {
        return $this->ciudad;
    }

    public function setCiudad($ciudad) {
        $this->ciudad = $ciudad;
    }

    public function __construct($idLugar = 0, $nombreLugar = "", $direccionLugar = "", $capacidadMaximaLugar = "", $ciudad = null) {
        $this->idLugar = $idLugar;
        $this->nombreLugar = $nombreLugar;
        $this->direccionLugar = $direccionLugar;
        $this -> capacidadMaximaLugar = $capacidadMaximaLugar;
        $this->ciudad = $ciudad;
    }

    public function consultarTodos() {
        $ciudades = array();
        $lugares = array();

        $conexion = new Conexion();
        $conexion->abrirConexion();
        $lugarDAO = new LugarDAO();
        $conexion->ejecutarConsulta($lugarDAO->consultarTodos());

        while($registro = $conexion->siguienteRegistro()) {
            $ciudad = null;
            if(array_key_exists($registro[3], $ciudades)){
                $ciudad = $ciudades[$registro[3]];
            }
            else {
                $ciudad = new Ciudad($registro[3]);
                $ciudad->consultar();
                $ciudades[$registro[3]] = $ciudad;
            }
            
            $lugar = new Lugar($registro[0], $registro[1], $registro[2], $ciudad);
            array_push($lugares, $lugar);
        }

        $conexion->cerrarConexion();
        return $lugares;
    }

    public function consultar(){
        $conexion = new Conexion();
        $conexion -> abrirConexion();
        $lugarDAO = new LugarDAO($this->idLugar);
        $conexion->ejecutarConsulta($lugarDAO->consultar());
        $registro = $conexion->siguienteRegistro();
        $this->nombreLugar = $registro[0];
        $this->direccionLugar = $registro[1];
        $ciudad = new Ciudad($registro[2]);
        $ciudad->consultar();
        $this->ciudad = $ciudad;
        $conexion -> cerrarConexion();
    } 

    public function insertar($nombreLugar="", $direccionLugar="", $capacidadMaximaLugar = "", $idCiudad=0){
        $conexion = new Conexion();
        $conexion -> abrirConexion();
        $lugarDAO = new LugarDAO();
        
        try {
            $query = $lugarDAO->insert($nombreLugar, $direccionLugar, $capacidadMaximaLugar, $idCiudad);
            $conexion->ejecutarConsulta($query);
        } catch (Exception $e) {
            $e->getMessage();
        }
        
        $conexion -> cerrarConexion();
    }
}

?>