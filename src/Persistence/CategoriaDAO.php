<?php
class CategoriaDAO{
    private $idCategoria;
    private $nombre;
    
    public function __construct($idCategoria=0, $nombre=""){
        $this -> idCategoria = $idCategoria;
        $this -> nombre = $nombre;
    }
    
    public function consultarTodos(){
        return "select idCategoria, nombre
                from Categoria
                order by nombre asc";
    }
    
    public function consultar(){
        return "select nombre 
                from Categoria
                where idCategoria = '" . $this -> idCategoria . "'";
    }

    public function consultarCategoriaEvento(){
        return "SELECT c.nombre, COUNT(e.idEvento) AS count
                FROM categoria c 
                LEFT JOIN evento e ON c.idCategoria = e.idCategoria
                GROUP BY c.idCategoria
                ORDER BY count DESC;";
    }
}

?>