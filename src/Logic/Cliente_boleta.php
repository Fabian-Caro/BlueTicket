<?php
require_once(__DIR__ . '/../Database/Conexion.php');
require_once(__DIR__ . '/../Persistence/ClienteDAO.php');
class Cliente_boleta{
    private $idFactura;
    private $nombreCliente;
    private $apellidoCliente;
    private $nombreUsuario;
    private $nombreEvento;
    private $fecha;
    private $idCliente;

    // Constructor
    public function __construct($idFactura=0, $nombreCliente="", $apellidoCliente="", $nombreUsuario="", $nombreEvento="", $fecha="", $idCliente=0) {
        $this->idFactura = $idFactura;
        $this->nombreCliente = $nombreCliente;
        $this->apellidoCliente = $apellidoCliente;
        $this->nombreUsuario = $nombreUsuario;
        $this->nombreEvento = $nombreEvento;
        $this->fecha = $fecha;
        $this->idCliente = $idCliente;
    }

    // Getters
    public function getIdFactura() {
        return $this->idFactura;
    }

    public function getNombreCliente() {
        return $this->nombreCliente;
    }

    public function getApellidoCliente() {
        return $this->apellidoCliente;
    }

    public function getNombreUsuario() {
        return $this->nombreUsuario;
    }

    public function getNombreEvento() {
        return $this->nombreEvento;
    }

    public function getFecha() {
        return $this->fecha;
    }

    public function getIdCliente() {
        return $this->idCliente;
    }

    // Setters
    public function setIdFactura($idFactura) {
        $this->idFactura = $idFactura;
    }

    public function setNombreCliente($nombreCliente) {
        $this->nombreCliente = $nombreCliente;
    }

    public function setApellidoCliente($apellidoCliente) {
        $this->apellidoCliente = $apellidoCliente;
    }

    public function setNombreUsuario($nombreUsuario) {
        $this->nombreUsuario = $nombreUsuario;
    }

    public function setNombreEvento($nombreEvento) {
        $this->nombreEvento = $nombreEvento;
    }

    public function setFecha($fecha) {
        $this->fecha = $fecha;
    }

    public function setIdCliente($idCliente) {
        $this->idCliente = $idCliente;
    }

    public function consultarBoletas($idCliente=0){
        $conexion = new Conexion();
        $conexion -> abrirConexion();
        $clienteDAO = new ClienteDAO($idCliente);
        $conexion -> ejecutarConsulta($clienteDAO -> consultarBoletas());
        $boletas = array();
        while($registro = $conexion -> siguienteRegistro()){
            $boleta = new Cliente_boleta($registro[0], $registro[1], $registro[2], $registro[3],$registro[4],$registro[5],$registro[6]);
            array_push($boletas, $boleta);
        }
        $conexion -> cerrarConexion();
        return $boletas;
    }
}
?>