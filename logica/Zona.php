<?php
require_once('../persistencia/Conexion.php');
require_once('../persistencia/ZonaDAO.php');

class Zona {
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

    public function getIdZona () {
        return $this -> idZona;
    }

    public function setIdZona ($idZona) {
        $this -> idZona = $idZona;
    }

    public function getNombreZona () {
        return $this -> nombreZona;
    }

    public function setNombreZona ($nombreZona) {
        $this -> nombreZona = $nombreZona;
    }

    public function getCostoZona () {
        return $this -> costoZona;
    }

    public function setCostoZona ($costoZona) {
        $this -> costoZona = $costoZona;
    }

    public function getAforoZona () {
        return $this -> aforoZona;
    }

    public function setAforoZona ($aforoZona) {
        $this -> aforoZona = $aforoZona;
    }

    public function getDetalle () {
        return $this -> detalle;
    }

    public function setDetalle ($detalle) {
        $this -> detalle = $detalle;
    }

    public function agregarZona (
        $nombreZona = "",
        $costoZona = 0,
        $aforoZona = 0,
        $idDetalle = 0,
    ) {
        $conexion = new Conexion();
        $conexion -> abrirConexion();
        $zonaDAO = new ZonaDAO();

        try {
            $query = $zonaDAO -> insertar($nombreZona, $costoZona, $aforoZona, $idDetalle);
            $conexion -> ejecutarConsulta($query);
        } catch (Exception $excepcion) {
            $excepcion -> getMessage();
        }

        $conexion -> cerrarConexion();
            
    }

    public function consultarZonas () {
        $detallesEventos = array();
        $zonas = array();

        $conexion = new Conexion();
        $conexion -> abrirConexion();

        $zonaDAO = new ZonaDAO();
        
        $conexion -> ejecutarConsulta($zonaDAO -> consultar());

        while ($registro = $conexion -> siguienteRegistro()) {
            $detalleEvento = null;

            if (array_key_exists($registro[4], $detallesEventos)) {
                $detalleEvento = $detallesEventos[$registro[4]];
            } else {
                $detalleEvento = new DetallesEvento();
                $detalleEvento -> consultarTodos();
                $detallesEventos[$registro[4]] = $detalleEvento;                
            }

            $zona = new Zona($registro[0], $registro[1], $registro[2], $registro[3], $registro[4]);
            array_push($zonas, $zona);
        }

        $conexion -> cerrarConexion();
        return $zonas;
    }
}

?>