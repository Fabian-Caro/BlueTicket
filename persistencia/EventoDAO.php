<?php
class EventoDAO{
    private $idEvento;
    private $nombre;
    
    public function __construct($idEvento=0, $nombre=""){
        $this -> idEvento = $idEvento;
        $this -> nombre = $nombre;
    }
    
    public function consultarTodos(){
        return "select idEvento, nombre, idCategoria, idArtista 
                from Evento";
    }
    
    // public function insert($id=0, $nombre="", $cantidad=0, $precioCompra=0, $precioVenta=0, $idMarca=0, $idCategoria=0, $idAdministrador=0) {
    //     return "INSERT INTO Producto (idProducto, nombre, cantidad, precioCompra, precioVenta, Marca_idMarca, Categoria_idCategoria, Administrador_idAdministrador) 
    //     VALUES ($id, $nombre, $cantidad, $precioCompra, $precioVenta, $idMarca, $idCategoria, $idAdministrador)";

    // }
    
}

?>