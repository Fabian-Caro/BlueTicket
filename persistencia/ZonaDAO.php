<?php
class ZonaDAO {
    private $idZona;
    private $nombreZona;
    private $costoZona;
    private $aforoZona;
    private $detalle;

    public function __construct (
        $idZona = 0,
        $nombreZona = "",
        $costoZona = 0,
        $aforoZona = 0,
        $detalle = 0
    ) {
        $this -> idZona = $idZona;
        $this -> nombreZona = $nombreZona;
        $this -> costoZona = $costoZona;
        $this -> aforoZona = $aforoZona;
        $this -> detalle = $detalle;
    }

    public function insertar (
        $nombreZona = "",
        $costoZona = 0,
        $aforoZona = 0,
        $idDetalle = 0
    ) {
        $sentenciaSQL = "INSERT INTO zonas (nombreZona, costoZona, aforoZona, idDetalle)
                         VALUES ('$nombreZona', $costoZona, $aforoZona, $idDetalle)";
        return $sentenciaSQL;
    }

    public function consultar () {
        $sentenciaSQL = "SELECT idZona, nombre_zona, costo_zona, aforo_zona, idDetalle
                         FROM zonas";
        return $sentenciaSQL;
    }
}
?>