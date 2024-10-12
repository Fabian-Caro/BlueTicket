<?php
require_once ("./persistencia/Conexion.php");
require ("./persistencia/CategoriaDAO.php");

class Categoria{
    private $idCategoria;
    private $nombre;

    public function getIdCategoria() {
        return $this->idCategoria;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function setIdCategoria($idCategoria){
        $this->idCategoria = $idCategoria;
    }

    public function setNombre($nombre){
        $this->nombre = $nombre;
    }

    public function __construct($idCategoria=0, $nombre=""){
        $this -> idCategoria = $idCategoria;
        $this -> nombre = $nombre;
    }
    
    public function consultarTodos(){
        $categorias = array();
        $conexion = new Conexion();
        $conexion -> abrirConexion();
        $categoriaDAO = new CategoriaDAO();
        $conexion -> ejecutarConsulta($categoriaDAO -> consultarTodos());
        while($registro = $conexion -> siguienteRegistro()){
            $categoria = new Categoria($registro[0], $registro[1]);
            array_push($categorias, $categoria);
        }
        $conexion -> cerrarConexion();
        return $categorias;        
    }
    
    public function consultar(){
        $conexion = new Conexion();
        $conexion -> abrirConexion();
        $categoriaDAO = new CategoriaDAO($this -> idCategoria);
        $conexion -> ejecutarConsulta($categoriaDAO -> consultar());
        $registro = $conexion -> siguienteRegistro();
        $this -> nombre = $registro[0];
        $conexion -> cerrarConexion();
    }    
}

?>