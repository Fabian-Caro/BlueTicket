<?php
class CiudadDAO {
    private $idCiudad;
    private $nombreCiudad;

    public function __construct($idCiudad = 0, $nombreCiudad = "") {
        $this->idCiudad = $idCiudad;
        $this->nombreCiudad = $nombreCiudad;
    }

    public function consultarTodos() {
        return "SELECT idCiudad, nombre FROM ciudad";
    }

    public function consultar() {
        return "SELECT nombre FROM ciudad WHERE idCiudad = '" . $this->idCiudad . "'";
    }
}
?>