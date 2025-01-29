<?php
require_once(__DIR__ . '/../../../src/Logic/Evento.php');

$evento = new Evento();
$eventos_vendidos = $evento -> consultarEventoBoleta();
?>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript"></script>
<div class="container">
	<div class="row mt-5">
		<div class="col">
			<div class="card border-primary">
				<div class="card-header text-bg-info">
					<h4>Grafica Evento por boleta</h4>
				</div>
				<div class="card-body">
					<div id='pieEvento_Boleta'></div>
					<hr>
					<div id='columnEvento_Boleta'></div>
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
  google.charts.load('current', {'packages':['corechart']});
  google.charts.setOnLoadCallback(drawChart);
  function drawChart() {
    var data = google.visualization.arrayToDataTable([
      ['Evento', 'Boletas vendidas'],
    <?php 
    foreach ($eventos_vendidos as $e){
        echo "['" . $e[0] . "', " . $e[1] . "],";
    }
    ?>
    ]);
    var options = {
      title: 'Eventos por Boleta'
    };
    var chartPie = new google.visualization.PieChart(document.getElementById('pieEvento_Boleta'));
    chartPie.draw(data, options);
    var chartColumn = new google.visualization.ColumnChart(document.getElementById('columnEvento_Boleta'));
    chartColumn.draw(data, options);
  }
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>