<?php
require_once (__DIR__ . '/../Database/Conexion.php');
require_once(__DIR__ . '/../Persistence/CiudadDAO.php');

class Ciudad {
    private $idCiudad;
    private $nombreCiudad;

    public function getIdCiudad() {
        return $this->idCiudad;
    }

    public function setIdCiudad($idCiudad) {
        $this->idCiudad = $idCiudad;
    }

    public function getNombreCiudad() {
        return $this->nombreCiudad;
    }

    public function setNombreCiudad($nombreCiudad) {
        $this->nombreCiudad = $nombreCiudad;
    }

    public function __construct($idCiudad = 0, $nombreCiudad = "") {
        $this->idCiudad = $idCiudad;
        $this->nombreCiudad = $nombreCiudad;
    }

    public function consultarTodos(){
        $ciudades = array();

        $conexion = new Conexion();
        $conexion->abrirConexion();
        $ciudadDAO = new CiudadDAO();
        $conexion -> ejecutarConsulta($ciudadDAO->consultarTodos());
        while($registro = $conexion->siguienteRegistro()){
            $ciudad = new Ciudad($registro[0], $registro[1]);
            array_push($ciudades, $ciudad);
        }
        $conexion -> cerrarConexion();
        return $ciudades;        
    }

    public function consultar() {
        $conexion = new Conexion();
        $conexion->abrirConexion();
        $ciudadDAO = new CiudadDAO($this->idCiudad);
        $conexion->ejecutarConsulta($ciudadDAO->consultar());
        $registro = $conexion->siguienteRegistro();
        $this->nombreCiudad = $registro[0];
        $conexion->cerrarConexion();
    }
}

?>