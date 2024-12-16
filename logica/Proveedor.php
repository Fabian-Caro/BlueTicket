<?php
require_once(__DIR__ . '/../persistencia/Conexion.php');
require_once(__DIR__ . '/../persistencia/ProveedorDAO.php');
require_once(__DIR__ . '/../logica/Categoria.php');
require_once(__DIR__ . '/../logica/Artista.php');
require_once(__DIR__ . '/../logica/Evento.php');
class Proveedor{
    private $idProveedor;
    private $nombre;
    private $apellido;
    private $correo;
    private $clave;
    public function getIdProveedor()
    {
        return $this->idProveedor;
    }
    public function setIdProveedor($idProveedor)
    {
        $this->idProveedor = $idProveedor;

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
    public function getApellido()
    {
        return $this->apellido;
    }
    public function setApellido($apellido)
    {
        $this->apellido = $apellido;

        return $this;
    }
    public function getCorreo()
    {
        return $this->correo;
    }
    public function setCorreo($correo)
    {
        $this->correo = $correo;

        return $this;
    }
    public function getClave()
    {
        return $this->clave;
    }
    public function setClave($clave)
    {
        $this->clave = $clave;

        return $this;
    }
    public function __construct($idProveedor=0, $nombre="", $apellido="", $correo="", $clave=""){
        $this -> idProveedor = $idProveedor;
        $this -> nombre = $nombre;
        $this -> apellido = $apellido;
        $this -> correo = $correo;
        $this -> clave = $clave;
    }

    public function autenticar(){
        $conexion = new Conexion();
        $conexion -> abrirConexion();
        $proveedorDAO = new ProveedorDAO(null, null, null, $this -> correo, $this -> clave);
        $conexion -> ejecutarConsulta($proveedorDAO -> autenticar());
        if($conexion -> numeroFilas() == 0){
            $conexion -> cerrarConexion();
            return false;
        }else{
            $registro = $conexion -> siguienteRegistro();
            $this -> idProveedor = $registro[0];
            $conexion -> cerrarConexion();
            return true;
        }
    }

    public function registrar($nombre, $apellido, $correo, $clave) {
        $conexion = new Conexion();
        $conexion -> abrirConexion();
        $proveedorDAO = new ProveedorDAO();
        $conexion -> ejecutarConsulta($proveedorDAO->insertar($nombre, $apellido, $correo, $clave));
        $conexion -> cerrarConexion();
        return true;
    }
    
    public function consultar(){
        $conexion = new Conexion();
        $conexion -> abrirConexion();
        $proveedorDAO = new ProveedorDAO($this -> idProveedor);
        $conexion -> ejecutarConsulta($proveedorDAO -> consultar());
        $registro = $conexion -> siguienteRegistro();
        $this -> nombre = $registro[0];
        $this -> apellido = $registro[1];
        $this -> correo = $registro[2];
        $conexion -> cerrarConexion();
    }

    public function consultarEventos(){
        $categorias = array();
        $artistas = array();
        $eventos = array();
        $conexion = new Conexion();
        $conexion -> abrirConexion();
        $proveedorDAO = new ProveedorDAO($this->idProveedor);
        $conexion -> ejecutarConsulta($proveedorDAO -> consultarEventos());
        while($registro = $conexion -> siguienteRegistro()){
            $categoria = null;
            $artista = null;
            if(array_key_exists($registro[2], $categorias)){
                $categoria = $categorias[$registro[2]];
            }else{
                $categoria = new Categoria($registro[2]);
                $categoria -> consultar();
                $categorias[$registro[2]] = $categoria;
            }
            if(array_key_exists($registro[3], $artistas)){
                $artista = $artistas[$registro[3]];
            }else{
                $artista = new Artista($registro[3]);
                $artista -> consultar();
                $artistas[$registro[3]] = $artista;
            }
            $evento = new Evento($registro[0], $registro[1], $categoria, $artista);
            array_push($eventos, $evento);
        }
        $conexion -> cerrarConexion();
        return $eventos;        
    }
}
?>