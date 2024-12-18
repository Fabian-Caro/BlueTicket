<?php
require_once(__DIR__ . '/../persistencia/Conexion.php');
require_once(__DIR__ . '/../logica/Cliente.php');
require_once(__DIR__ . '/../persistencia/FacturaDAO.php');

class Factura {
    private $idFactura;
    private $fecha;
    private $valorSubtotal;
    private $valorTotal;
    private $cliente;

    public function getIdFactura()
    {
        return $this->idFactura;
    }

    public function setIdFactura($idFactura)
    {
        $this->idFactura = $idFactura;

        return $this;
    }

    public function getFecha()
    {
        return $this->fecha;
    }

    public function setFecha($fecha)
    {
        $this->fecha = $fecha;

        return $this;
    }

    public function getValorSubtotal()
    {
        return $this->valorSubtotal;
    }

    public function setValorSubtotal($valorSubtotal)
    {
        $this->valorSubtotal = $valorSubtotal;

        return $this;
    }

    public function getValorTotal()
    {
        return $this->valorTotal;
    }

    public function setValorTotal($valorTotal)
    {
        $this->valorTotal = $valorTotal;

        return $this;
    }

    public function getCliente() {
        return $this->cliente;
    }

    public function setCliente($cliente)
    {
        $this->cliente = $cliente;

        return $this;
    }

    public function __construct($idFactura = 0, $fecha = "", $valorSubtotal=0, $valorTotal=0,$cliente=null) {
        $this->idFactura = $idFactura;
        $this->fecha = $fecha;
        $this->valorSubtotal = $valorSubtotal;
        $this->valorTotal = $valorTotal;
        $this->cliente = $cliente;
    }

    public function consultarTodos () {
        $clientes = array();
        $facturas = array();

        $conexion = new Conexion();
        $conexion->abrirConexion();
        $facturaDAO = new FacturaDAO();
        $conexion->ejecutarConsulta($facturaDAO->consultarTodos());
        while($registro = $conexion->siguienteRegistro()) {
            $clientes = null;

            if(array_keys($registro[4], $clientes)) {
                $cliente = $clientes[$registro[4]];
            }
            else {
                $cliente = new Cliente($registro[4]);
                $cliente->consultar();
                $clientes[$registro[4]] = $cliente;
            }

            $factura = new Factura($registro[0], $registro[1], $registro[2], $registro[3], $cliente);
            array_push($facturas, $factura);
        }
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

    public function insertar($fechaHoraActual="",$valor_subtotal=0,$valor_total=0,$idCliente=0){
        $conexion = new Conexion();
        $conexion -> abrirConexion();
        $facturaDAO = new FacturaDAO();
        
        try {
            $query = $facturaDAO->insert($fechaHoraActual, $valor_subtotal,$valor_total,$idCliente);
            $conexion->ejecutarConsulta($query);
        } catch (Exception $e) {
            $e->getMessage();
        }
        
        $conexion -> cerrarConexion();
    }

    public function consultar(){
        $conexion = new Conexion();
        $conexion -> abrirConexion();

        $facturaDAO = new FacturaDAO($this->idFactura);
        $conexion->ejecutarConsulta($facturaDAO->consultar());
        
        $registro = $conexion->siguienteRegistro();

        if (!$registro) {
            throw new Exception("Factura no encontrada.");
        }
        $this -> idFactura = $registro[0];
        $this -> fecha = $registro[1];
        $this -> valorSubtotal = $registro[2];
        $this -> valorTotal = $registro[3];
        
        $cliente = new Cliente($registro[4]);
        $cliente->consultar();
        $this->cliente = $cliente;
        $conexion -> cerrarConexion();
    } 
}

?>