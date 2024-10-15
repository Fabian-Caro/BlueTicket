<?php
require_once(__DIR__ . '/../persistencia/Conexion.php');
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

    public function getCliente()
    {
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
    public function insertar($fecha="",$valor_subtotal=0,$valor_total=0,$idCliente=0){
        $conexion = new Conexion();
        $conexion -> abrirConexion();
        $facturaDAO = new FacturaDAO();
        
        try {
            $query = $facturaDAO->insert($fecha, $valor_subtotal,$valor_total,$idCliente);
            $conexion->ejecutarConsulta($query);
            echo "Consulta ejecutada correctamente.";
        } catch (Exception $e) {
            echo "Error al ejecutar la consulta: " . $e->getMessage();
        }
        
        $conexion -> cerrarConexion();
    }
}

?>