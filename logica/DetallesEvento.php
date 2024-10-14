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
    private $lugar;
    private $evento;

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

    public function getLugar() {
        return $this->lugar;
    }

    public function setLugar($lugar) {
        $this->lugar = $lugar;
    }

    public function getEvento() {
        return $this->evento;
    }

    public function setEvento($evento) {
        $this->evento = $evento;
    }


    public function __construct($idDetallesEvento=0, $fechaEvento="", $horaInicioEvento="", $horaFinEvento="", $costoEvento=0, $aforoEvento=0, $lugar=null, $evento=null) {
        $this->idDetallesEvento = $idDetallesEvento;
        $this->fechaEvento = $fechaEvento;
        $this->horaInicioEvento = $horaInicioEvento;
        $this->horaFinEvento = $horaFinEvento;
        $this->costoEvento = $costoEvento;
        $this->aforoEvento = $aforoEvento;
        $this->lugar = $lugar;
        $this->evento = $evento;        
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

            $detallesEvento = new DetallesEvento($registro[0], $registro[1], $registro[2], $registro[3], $registro[4], $registro[5], $lugarEvento, $evento);
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

            $detallesEvento = new DetallesEvento($registro[0], $registro[1], $registro[2], $registro[3], $registro[4], $registro[5], $lugarEvento, $evento);
            array_push($detallesEventos, $detallesEvento);
        }

        $conexion->cerrarConexion();
        return $detallesEventos;
    }

    public function insertar($fecha="",$horaInicio="",$horaFinal="",$costo=0,$aforo=0,$idLugar=0,$idEvento=0){
        $conexion = new Conexion();
        $conexion -> abrirConexion();
        $detalleEventoDAO = new DetallesEventoDAO();
        
        try {
            $query = $detalleEventoDAO->insert($fecha,$horaInicio,$horaFinal,$costo,$aforo,$idLugar,$idEvento);
            $conexion->ejecutarConsulta($query);
            echo "Consulta ejecutada correctamente.";
        } catch (Exception $e) {
            echo "Error al ejecutar la consulta: " . $e->getMessage();
        }
        
        $conexion -> cerrarConexion();
    }
}

?>