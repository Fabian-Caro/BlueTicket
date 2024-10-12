<?php
class EventoDAO{
    private $idEvento;
    private $nombre;
    
    public function __construct($idEvento=0, $nombre=""){
        $this -> idEvento = $idEvento;
        $this -> nombre = $nombre;
    }
    
    public function consultarTodos(){
        return "SELECT idEvento, nombre, idCategoria, idArtista 
                FROM evento";
    }

    public function consultarIdEvento($idEvento) {
        return "SELECT idEvento, nombre, idProveedor, idCategoria, idArtista FROM evento WHERE idEvento = $idEvento";
    }

    public function consultar() {
        return "SELECT nombre FROM evento WHERE idEvento ='" . $this->idEvento . "'";
    }
    
    // public function insert($id=0, $nombre="", $cantidad=0, $precioCompra=0, $precioVenta=0, $idMarca=0, $idCategoria=0, $idAdministrador=0) {
    //     return "INSERT INTO Producto (idProducto, nombre, cantidad, precioCompra, precioVenta, Marca_idMarca, Categoria_idCategoria, Administrador_idAdministrador) 
    //     VALUES ($id, $nombre, $cantidad, $precioCompra, $precioVenta, $idMarca, $idCategoria, $idAdministrador)";

    // }
    
}

?>