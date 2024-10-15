<?php
require_once(__DIR__ . '/../persistencia/Conexion.php');
require_once(__DIR__ . '/../persistencia/BoletaDAO.php');

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
    // public function insertar($fecha="",$valor_subtotal=0,$valor_total=0,$idCliente=0){
    //     $conexion = new Conexion();
    //     $conexion -> abrirConexion();
    //     $facturaDAO = new FacturaDAO();
        
    //     try {
    //         $query = $facturaDAO->insert($fecha, $valor_subtotal,$valor_total,$idCliente);
    //         $conexion->ejecutarConsulta($query);
    //         echo "Consulta ejecutada correctamente.";
    //     } catch (Exception $e) {
    //         echo "Error al ejecutar la consulta: " . $e->getMessage();
    //     }
        
    //     $conexion -> cerrarConexion();
    // }
}

?>