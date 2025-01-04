<?php
class CarroDAO
{
    private $idCarro;
    private $nombre;
    private $cliente;
    private $detallesEvento;

    public function __construct($idCarro = 0, $nombre = "", $cliente = null, $detallesEvento = null)
    {
        $this->idCarro = $idCarro;
        $this->nombre = $nombre;
        $this->cliente = $cliente;
        $this->detallesEvento = $detallesEvento;
    }

    public function consultarTodos($idCliente = 0)
    {
        return "SELECT idCarro, nombre_usuario, idDetalle FROM Carro
                where idCliente = ". $idCliente. ";";
    }


    public function ultimoId()
    {
        return "SELECT MAX(idCarro) FROM Carro ";
    }

    public function insert($nombre_usuario = "", $idCliente = 0, $idDetalle = 0)
    {
        return "INSERT into Carro (nombre_usuario,idCliente,idDetalle)
                VALUES ($nombre_usuario,$idCliente,$idDetalle);";
    }
    public function eliminar($idCarro=0)
    {
        return "DELETE FROM Carro WHERE idCarro = ". $idCarro. ";";
    }
}
