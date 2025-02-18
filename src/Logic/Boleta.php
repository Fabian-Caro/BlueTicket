<?php

use PSpell\Config;

require_once (__DIR__ . '/../Database/Conexion.php');
require_once(__DIR__ . '/../Persistence/BoletaDAO.php');

class Boleta {
    private $idBoleta;
    private $nombre;
    private $factura;
    private $detalleEvento;

    public function __construct($idBoleta = 0, $nombre = "", $factura=null,$detalleEvento=null) {
        $this->idBoleta = $idBoleta;
        $this->nombre = $nombre;
        $this->factura = $factura;
        $this->detalleEvento = $detalleEvento;
    }

    public function ultimoId(){
        $conexion = new Conexion();
        $conexion -> abrirConexion();
        $facturaDAO = new FacturaDAO();
        $conexion -> ejecutarConsulta($facturaDAO -> ultimoId());
        $registro = $conexion -> siguienteRegistro();

        $conexion -> cerrarConexion();
        if($registro[0]==null){
            $registro[0] = 0;
        }
        return $registro[0];
    }
    public function insertar($nombre_usuario="",$idFactura=0,$idDetalle=0){
        $conexion = new Conexion();
        $conexion -> abrirConexion();
        $boletaDAO = new BoletaDAO();
        
        try {
            $query = $boletaDAO->insert($nombre_usuario,$idFactura,$idDetalle);
            $conexion->ejecutarConsulta($query);
        } catch (Exception $e) {
            $e->getMessage();
        }
        
        $conexion -> cerrarConexion();
    }

    public function consultarPorFactura ($idFactura){
        $conexion = new Conexion();
        $conexion -> abrirConexion();
        $boletaDAO = new BoletaDAO();
        $conexion -> ejecutarConsulta($boletaDAO -> consultarPorFactura($idFactura));
        $boletas = [];
        while ($registro = $conexion -> siguienteRegistro()) {
            $boletas[] = [
                'idDetalle' => $registro[0],
                'nombreEvento' => $registro[1],
                'costoUnitario' => $registro[2]
            ];
        }
        $conexion -> cerrarConexion();
        return $boletas;
    }
}

?>