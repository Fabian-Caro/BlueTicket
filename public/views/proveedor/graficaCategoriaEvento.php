<?php
require_once(__DIR__ . '/../../../src/Logic/Categoria.php');

$categoria = new Categoria();
$categoria_eventos = $categoria -> consultarCategoriaEvento();
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
					<div id='pieCategoria_Evento'></div>
					<hr>
					<div id='columnCategoria_Event'></div>
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
      ['Categoria', 'Eventos'],
    <?php 
    foreach ($categoria_eventos as $c){
        echo "['" . $c[0] . "', " . $c[1] . "],";
    }
    ?>
    ]);
    var options = {
      title: 'Categoria por Evento'
    };
    var chartPie = new google.visualization.PieChart(document.getElementById('pieCategoria_Evento'));
    chartPie.draw(data, options);
    var chartColumn = new google.visualization.ColumnChart(document.getElementById('columnCategoria_Event'));
    chartColumn.draw(data, options);
  }
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>