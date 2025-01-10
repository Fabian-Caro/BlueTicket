<?php
class LugarDAO {
    private $idLugar;
    private $nombreLugar;
    private $direccionLugar;

    public function __construct($idLugar = 0, $nombreLugar = "", $direccionLugar = "") {
        $this->idLugar = $idLugar;
        $this->nombreLugar = $nombreLugar;
        $this->direccionLugar = $direccionLugar;
    }

    public function consultarTodos() {
        return "SELECT idLugar, nombre, direccion, idCiudad FROM Lugar";
    }

    public function consultar() {
        return "SELECT nombre,direccion,idCiudad FROM lugar WHERE idLugar ='" . $this->idLugar . "'";
    }

    public function insert($nombreLugar="", $direccionLugar="", $capacidadMaximaLugar = "", $idCiudad=0) {
        $sentenciaSQL = "INSERT INTO lugar (nombre, direccion, capacidad_maxima, idCiudad) VALUES ($nombreLugar, $direccionLugar, $capacidadMaximaLugar, $idCiudad)";
        return $sentenciaSQL;
    }
}

?>