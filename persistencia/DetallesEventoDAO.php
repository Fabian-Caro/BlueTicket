<?php


class DetallesEventoDAO {
    private $idDetallesEvento;
    private $fechaEvento;
    private $horaInicioEvento;
    private $horaFinEvento;
    private $costoEvento;
    private $aforoEvento;
    private $idLugarEvento;
    private $idEvento;

    public function __construct($idDetallesEvento=0, $fechaEvento="", $horaInicioEvento="", $horaFinEvento="", $costoEvento=0, $aforoEvento=0, $idLugarEvento=null, $idEvento=null) {
        $this->idDetallesEvento = $idDetallesEvento;
        $this->fechaEvento = $fechaEvento;
        $this->horaInicioEvento = $horaInicioEvento;
        $this->horaFinEvento = $horaFinEvento;
        $this->costoEvento = $costoEvento;
        $this->aforoEvento = $aforoEvento;
        $this->idLugarEvento = $idLugarEvento;
        $this->idEvento = $idEvento;        
    }

    public function consultarTodos() {
        return "SELECT idDetalle, fecha, hora_inicio, hora_final, costo, aforo, idLugar, idEvento FROM detalle_evento";
    }

    public function consultarDetallesEvento($idEvento) {
        return "SELECT idDetalle, fecha, hora_inicio, hora_final, costo, aforo, idLugar, idEvento FROM detalle_evento WHERE idEvento = $idEvento ORDER BY fecha ASC";
    }

    public function consultarIdDetallesEvento($idDetalle) {
        return "SELECT idDetalle, fecha, hora_inicio, hora_final, costo, aforo, idLugar, idEvento FROM detalle_evento WHERE idDetalle = ". intval($idDetalle);
    }
  
    public function insert($fecha="",$horaInicio="",$horaFinal="",$costo=0,$aforo=0,$idLugar=0,$idEvento=0) {
        return "INSERT INTO Detalle_evento (fecha,hora_inicio,hora_final,costo,aforo,idLugar,idEvento) 
        VALUES ($fecha,$horaInicio,$horaFinal,$costo,$aforo,$idLugar,$idEvento)";
    }

    public function descontarAforo($valorAforo,$idDetalle){
        return "UPDATE `Detalle_evento` SET `aforo` = $valorAforo WHERE `detalle_evento`.`idDetalle` = $idDetalle;";
    }
}

?>