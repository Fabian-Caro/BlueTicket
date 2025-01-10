<?php

require_once (__DIR__ . '/../Database/Conexion.php');
require_once(__DIR__ . '/../Persistence/CarroDAO.php');
require_once(__DIR__ . '/DetallesEvento.php');

class Carro {
    private $idCarro;
    private $nombre;
    private $cliente;
    private $detallesEvento;

    public function getIdCarro()
    {
        return $this->idCarro;
    }

    public function setIdCarro($idCarro)
    {
        $this->idCarro = $idCarro;

        return $this;
    }
    public function getNombre()
    {
        return $this->nombre;
    }

    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    public function getCliente()
    {
        return $this->cliente;
    }

    public function setCliente($cliente)
    {
        $this->cliente = $cliente;

        return $this;
    }

    public function getDetallesEvento()
    {
        return $this->detallesEvento;
    }

    public function setDetallesEvento($detallesEvento)
    {
        $this->detallesEvento = $detallesEvento;

        return $this;
    }
    
    public function __construct($idCarro = 0, $nombre = "", $cliente = null, $detallesEvento = null)
    {
        $this->idCarro = $idCarro;
        $this->nombre = $nombre;
        $this->cliente = $cliente;
        $this->detallesEvento = $detallesEvento;
    }
    public function ultimoId(){
        $conexion = new Conexion();
        $conexion -> abrirConexion();
        $carroDAO = new CarroDAO();
        $conexion -> ejecutarConsulta($carroDAO -> ultimoId());
        $registro = $conexion -> siguienteRegistro();

        $conexion -> cerrarConexion();
        if($registro[0]==null){
            $registro[0] = 0;
        }
        return $registro[0];
    }
    public function insertar($nombre_usuario="",$idCliente=0,$idDetalle=0){
        $conexion = new Conexion();
        $conexion -> abrirConexion();
        $carroDAO = new CarroDAO();
        $query = $carroDAO->insert($nombre_usuario,$idCliente,$idDetalle);
        try {
            $conexion->ejecutarConsulta($query);
        } catch (Exception $e) {
            $e->getMessage();
        }
        
        $conexion -> cerrarConexion();
    }
    public function eliminar($idCarro=0){
        $conexion = new Conexion();
        $conexion -> abrirConexion();
        $carroDAO = new CarroDAO();
        $query = $carroDAO->eliminar($idCarro);
        try {
            $conexion->ejecutarConsulta($query);
        } catch (Exception $e) {
            $e->getMessage();
        }
        
        $conexion -> cerrarConexion();
    }
    public function consultarTodos($idCliente): array|Carro{
        $carros = array();
        $detalles = array();

        $conexion = new Conexion();
        $conexion -> abrirConexion();
        $carroDAO = new CarroDAO();
        $conexion -> ejecutarConsulta($carroDAO -> consultarTodos($idCliente));
        while($registro = $conexion -> siguienteRegistro()){
            $carro = null;
            if(array_key_exists($registro[2], $detalles)){
                $detalle = $detalles[$registro[2]];
            }else{
                $detalle = new DetallesEvento($registro[2]);
                $detalle -> consultar();
                $detalles[$registro[2]] = $detalle;
            }

            $carro = new Carro($registro[0], $registro[1], null, $detalle);
            array_push($carros, $carro);
        }
        $conexion -> cerrarConexion();
        return $carros;    
    }
}
?>