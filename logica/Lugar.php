<?php
require_once(__DIR__ . '/../persistencia/Conexion.php');
require(__DIR__ . '/../persistencia/LugarDAO.php');
require_once(__DIR__ . '/../logica/Ciudad.php');

class Lugar {
    private $idLugar;
    private $nombreLugar;
    private $direccionLugar;
    private $idCiudad;

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

    public function getIdCiudad() {
        return $this->idCiudad;
    }

    public function setIdCiudad($idCiudad) {
        $this->idCiudad = $idCiudad;
    }

    public function __construct($idLugar = 0, $nombreLugar = "", $direccionLugar = "", $idCiudad = null) {
        $this->idLugar = $idLugar;
        $this->nombreLugar = $nombreLugar;
        $this->direccionLugar = $direccionLugar;
        $this->idCiudad = $idCiudad;
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
                $ciudad = $ciudad[$registro[3]];
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
        $conexion -> cerrarConexion();
    } 
}

?>