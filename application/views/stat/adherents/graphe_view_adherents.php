<?php
        //tableaux pour le montant global des campagnes
        $data_evo_year = array();
        $data_evo_nombre = array();

        $data_evo_year_donateurs = array();
        $data_evo_nombre_donateurs = array();

        foreach ($stat_evolution_nombre_adhérents as $value) {
            array_push($data_evo_year, $value->YEAR);
            array_push($data_evo_nombre, $value->NOMBRE);
        }

        foreach($stat_evolution_donateurs as $value) {
        	array_push($data_evo_year_donateurs, $value->YEAR);
        	array_push($data_evo_nombre_donateurs, $value->NOMBRE);
        }
?>

<!--Div that will hold the pie chart-->
<div id='chart_container'>
	<div id='adherents_full'></div>
	<div id='donateurs'></div>
</div>

<link href="<?php echo css_url('style_graphe');?>" type="text/css" rel="stylesheet" />
<script type="text/javascript" src="<?php echo js_url('jsapi'); ?>"></script>
<script type="text/javascript">
	google.load("visualization", "1", {packages:["corechart"]});
	google.setOnLoadCallback(drawChart);
	function drawChart() {
		var data = google.visualization.arrayToDataTable([
			['Année', 'Adhérents'],
			['<?php echo $data_evo_year[2]; ?> ',  <?php echo (int)$data_evo_nombre[2]; ?> ],
          	['<?php echo $data_evo_year[1]; ?> ',  <?php echo (int)$data_evo_nombre[1]; ?> ]
          ]);

		var options = {
			title: 'évolution du nombre d\'adhérents total',
			vAxis: {title: 'Année',  titleTextStyle: {color: 'red'}}
		};

		var chart = new google.visualization.BarChart(document.getElementById('adherents_full'));
		chart.draw(data, options);
	}
</script>

<link href="<?php echo css_url('style_graphe');?>" type="text/css" rel="stylesheet" />
<script type="text/javascript" src="<?php echo js_url('jsapi'); ?>"></script>
<script type="text/javascript">
	google.load("visualization", "1", {packages:["corechart"]});
	google.setOnLoadCallback(drawChart);
	function drawChart() {
		var data = google.visualization.arrayToDataTable([
			['Année', 'Donateurs'],
			['<?php echo $data_evo_year_donateurs[2]; ?> ',  <?php echo (int)$data_evo_nombre_donateurs[2]; ?> ],
          	['<?php echo $data_evo_year_donateurs[1]; ?> ',  <?php echo (int)$data_evo_nombre_donateurs[1]; ?> ]
          ]);

		var options = {
			title: 'évolution du nombre de donateurs total',
			vAxis: {title: 'Année',  titleTextStyle: {color: 'red'}}
		};

		var chart = new google.visualization.BarChart(document.getElementById('donateurs'));
		chart.draw(data, options);
	}
</script>



