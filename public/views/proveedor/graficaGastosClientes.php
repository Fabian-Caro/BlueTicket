<?php
require_once(__DIR__ . '/../../../src/Logic/Cliente.php');

$cliente = new Cliente();
$gasto_cliente = $cliente -> consultarGastoCliente();
?>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript"></script>
<div class="container">
	<div class="row mt-5">
		<div class="col">
			<div class="card border-primary">
				<div class="card-header text-bg-info">
					<h4>Grafica gasto por cliente</h4>
				</div>
				<div class="card-body">
					<div id='pieGasto_Cliente'></div>
					<hr>
					<div id='columnGasto_Cliente'></div>
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
      ['Cliente', 'Gasto total'],
    <?php 
    foreach ($gasto_cliente as $c){
        echo "['" . $c[0] . "', " . $c[1] . "],";
    }
    ?>
    ]);
    var options = {
      title: 'cliente por gasto total'
    };
    var chartPie = new google.visualization.PieChart(document.getElementById('pieGasto_Cliente'));
    chartPie.draw(data, options);
    var chartColumn = new google.visualization.ColumnChart(document.getElementById('columnGasto_Cliente'));
    chartColumn.draw(data, options);
  }
</script>