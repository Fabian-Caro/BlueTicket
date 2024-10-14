<?php

require_once (__DIR__ . '/../persistencia/Conexion.php');
require (__DIR__ . '/../persistencia/DetallesEventoDAO.php');
require_once (__DIR__ . '/../logica/Lugar.php');
require_once (__DIR__ . '/../logica/Evento.php');

class DetallesEvento {
    private $idDetallesEvento;
    private $fechaEvento;
    private $horaInicioEvento;
    private $horaFinEvento;
    private $costoEvento;
    private $aforoEvento;
    private $idLugarEvento;
    private $idEvento;

    public function getIdDetallesEvento() {
        return $this->idDetallesEvento;
    }

    public function setIdDetallesEvento($idDetallesEvento) {
        $this->idDetallesEvento = $idDetallesEvento;
    }

    public function getFechaEvento() {
        return $this->fechaEvento;
    }

    public function setFechaEvento($fechaEvento) {
        $this->fechaEvento = $fechaEvento;
    }

    public function getHoraInicioEvento() {
        return $this->horaInicioEvento;
    }

    public function setHoraInicioEvento($horaInicioEvento) {
        $this->horaInicioEvento = $horaInicioEvento;
    }

    public function getHoraFinEvento() {
        return $this->horaFinEvento;
    }

    public function setHoraFinEvento($horaFinEvento) {
        $this->horaFinEvento = $horaFinEvento;
    }

    public function getCostoEvento() {
        return $this->costoEvento;
    }

    public function setCostoEvento($costoEvento) {
        $this->costoEvento = $costoEvento;
    }

    public function getAforoEvento() {
        return $this->aforoEvento;
    }

    public function setAforoEvento($aforoEvento) {
        $this->aforoEvento = $aforoEvento;
    }

    public function getIdLugarEvento() {
        return $this->idLugarEvento;
    }

    public function setIdLugarEvento($idLugarEvento) {
        $this->idLugarEvento = $idLugarEvento;
    }

    public function getIdEvento() {
        return $this->idEvento;
    }

    public function setIdEvento($idEvento) {
        $this->idEvento = $idEvento;
    }


    public function __construct($idDetallesEvento=0, $fechaEvento="", $horaInicioEvento="", $horaFinEvento="", $costoEvento=0, $aforoEvento=0, $idLugarEvento=null, $idEvento=null) {
        $this->idDetallesEvento = $idDetallesEvento;
        $this->fechaEvento = $fechaEvento;
        $this->horaInicioEvento = $horaInicioEvento;
        $this->horaFinEvento = $horaFinEvento;
        $this->costoEvento = $costoEvento;
        $this->aforoEvento = $aforoEvento;
        $this->idLugarEvento = $idLugarEvento;
        $this->idEvento = $idEvento;        
    }

    public function consultarTodos() {
        $lugaresEvento = array();
        $eventos = array();
        $detallesEventos = array();

        $conexion = new Conexion();
        $conexion->abrirConexion();
        $detallesEventoDAO = new DetallesEventoDAO();
        $conexion->ejecutarConsulta($detallesEventoDAO->consultarTodos());

        while($registro = $conexion->siguienteRegistro()) {
            $lugarEvento = null;
            $evento = null;

            if(array_key_exists($registro[6], $lugaresEvento)) {
                $lugarEvento = $lugaresEvento[$registro[6]];
            }
            else {
                $lugarEvento = new Lugar($registro[6]);
                $lugarEvento->consultar();
                $lugaresEvento[$registro[6]] = $lugarEvento;
            }

            if(array_key_exists($registro[7], $eventos)) {
                $evento = $eventos[$registro[7]];
            }
            else {
                $evento = new Evento($registro[7]);
                $evento->consultar();
                $eventos[$registro[7]] = $evento;
            }

            $detallesEvento = new DetallesEvento($registro[0], $registro[1], $registro[2], $registro[3], $registro[4], $registro[5], $lugaresEvento, $eventos);
            array_push($detallesEventos, $detallesEvento);
        }

        $conexion->cerrarConexion();
        return $detallesEventos;
    }

    public function consultarDetallesEvento($idEvento) {       
        $lugaresEvento = array();
        $eventos = array();
        $detallesEventos = array();

        $conexion = new Conexion();
        $conexion->abrirConexion();
        $detallesEventoDAO = new DetallesEventoDAO();
        $conexion->ejecutarConsulta($detallesEventoDAO->consultarDetallesEvento($idEvento));

        while($registro = $conexion->siguienteRegistro()) {
            $lugarEvento = null;
            $evento = null;

            if(array_key_exists($registro[6], $lugaresEvento)) {
                $lugarEvento = $lugaresEvento[$registro[6]];
            }
            else {
                $lugarEvento = new Lugar($registro[6]);
                $lugarEvento->consultar();
                $lugaresEvento[$registro[6]] = $lugarEvento;
            }

            if(array_key_exists($registro[7], $eventos)) {
                $evento = $eventos[$registro[7]];
            }
            else {
                $evento = new Evento($registro[7]);
                $evento->consultar();
                $eventos[$registro[7]] = $evento;
            }

            $detallesEvento = new DetallesEvento($registro[0], $registro[1], $registro[2], $registro[3], $registro[4], $registro[5], $lugaresEvento, $eventos);
            array_push($detallesEventos, $detallesEvento);
        }

        $conexion->cerrarConexion();
        return $detallesEventos;
    }

    public function consultarIdDetalles($idDetalle) {
        $conexion = new Conexion();
        $conexion->abrirConexion();
        $detallesEventoDAO = new DetallesEventoDAO();

        echo "en DTO" . $idDetalle;
        
        $conexion->ejecutarConsulta($detallesEventoDAO->consultarIdDetallesEvento($idDetalle));
        
        $registro = $conexion->siguienteRegistro();
        if (!$registro) {
            return null;
        }

        $lugar = new Lugar($registro[6]);
        $lugar->consultar();
        $idEvento = new Evento($registro[7]);
        $idEvento->consultar();
    
        $detalles = new DetallesEvento($registro[0], $registro[1], $registro[2], $registro[3], $registro[4], $registro[5], $lugar, $idEvento);
        
        $conexion->cerrarConexion();
        return $detalles;
    }
}

?>