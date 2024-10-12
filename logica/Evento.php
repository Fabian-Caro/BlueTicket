<?php
require_once ("./persistencia/Conexion.php");
require ("./persistencia/EventoDAO.php");
require_once("./logica/Categoria.php");
require_once("./logica/Artista.php");
class Evento{
    private $idEvento;
    private $nombre;
    private $proveedor;
    private $categoria;
    private $artista;

    public function getIdEvento()
    {
        return $this->idEvento;
    }

    public function setIdEvento($idEvento)
    {
        $this->idEvento = $idEvento;

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

    public function getProveedor()
    {
        return $this->proveedor;
    }

    public function setProveedor($proveedor)
    {
        $this->proveedor = $proveedor;

        return $this;
    }

    public function getCategoria()
    {
        return $this->categoria;
    }

    public function setCategoria($categoria)
    {
        $this->categoria = $categoria;

        return $this;
    }

    public function getArtista()
    {
        return $this->artista;
    }

    public function setArtista($artista)
    {
        $this->artista = $artista;

        return $this;
    }

    public function __construct($idEvento=0, $nombre="", $categoria=null, $artista=null){
        $this -> idEvento = $idEvento;
        $this -> nombre = $nombre;
        $this -> categoria = $categoria;
        $this -> artista = $artista;
    }
    public function consultarTodos(){
        $categorias = array();
        $artistas = array();
        $eventos = array();
        $conexion = new Conexion();
        $conexion -> abrirConexion();
        $eventoDAO = new EventoDAO();
        $conexion -> ejecutarConsulta($eventoDAO -> consultarTodos());
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