<?php
	//tableaux nombre offre sur les 12 derniers mois
$data_offre_date = array();
$data_offre_nombre = array();

    //tableaux nombre offre les 10 dernières années
$data_offre_date_ans = array();
$data_offre_nombre_ans = array();

	//tableaux valeur et nom des offres
$data_offre_nom = array();
$data_offre_valeur = array();

foreach($stat_nombre_offre_12_mois as $value){
	array_push($data_offre_date, $value->DATE);
	array_push($data_offre_nombre, $value->NUMBER);
}

foreach($stat_nombre_offre_10_ans as $value){
	array_push($data_offre_date_ans, $value->YEAR);
	array_push($data_offre_nombre_ans, $value->NUMBER);
}

foreach($stat_somme_recoltee_offre as $value){
	array_push($data_offre_nom, $value->NOM);
	array_push($data_offre_valeur, $value->VALUE);
}

?>

<!--Div qui contiendront les dessins de charte-->
<div id='chart_container'>
	<div id='table_offre'></div>
	<div id='chart_offre_12_mois'></div>
	<div id='chart_offre_10_ans'></div>
</div>

<link href="<?php echo css_url('style_graphe');?>" type="text/css" rel="stylesheet" />
<script type="text/javascript" src="<?php echo js_url('jsapi'); ?>"></script>
<script type="text/javascript">

	google.load("visualization", "1", {packages:["corechart"]});
	google.setOnLoadCallback(drawChart);
	function drawChart() {
		var data = google.visualization.arrayToDataTable([
			['Mois', 'Nombre'],
			['<?php echo $data_offre_date[0]; ?>' , <?php echo $data_offre_nombre[0]; ?>],
			['<?php echo $data_offre_date[1]; ?>' , <?php echo $data_offre_nombre[1]; ?>],			
			['<?php echo $data_offre_date[2]; ?>' , <?php echo $data_offre_nombre[2]; ?>]	
			]);

		var options = {
			title: 'Nombre d\'offres sur les 12 derniers mois'
		};

		var chart = new google.visualization.LineChart(document.getElementById('chart_offre_12_mois'));
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
			['Mois', 'Nombre'],
			['<?php echo $data_offre_date_ans[0]; ?>' , <?php echo $data_offre_nombre_ans[0]; ?>],
			['<?php echo $data_offre_date_ans[1]; ?>' , <?php echo $data_offre_nombre_ans[1]; ?>],			
			]);

		var options = {
			title: 'Nombre d\'offres sur les 10 dernières années'
		};

		var chart = new google.visualization.LineChart(document.getElementById('chart_offre_10_ans'));
		chart.draw(data, options);
	}
</script>

<link href="<?php echo css_url('style_graphe');?>" type="text/css" rel="stylesheet" />
<script type='text/javascript' src='<?php echo js_url('jsapi'); ?>'></script>
<script type='text/javascript'>

	google.load('visualization', '1', {packages:['table']});

	google.setOnLoadCallback(drawTable);

	function drawTable() {
		var data = new google.visualization.DataTable();
		data.addColumn('string', 'Nom de l\'offre');
		data.addColumn('number', 'Somme rapportée');
		data.addRows([
			['<?php echo $data_offre_nom[0] ?>', <?php echo $data_offre_valeur[0] ?>],
			['<?php echo $data_offre_nom[1] ?>', <?php echo $data_offre_valeur[1] ?>],
			['<?php echo $data_offre_nom[2] ?>', <?php echo $data_offre_valeur[2] ?>],
			['<?php echo $data_offre_nom[3] ?>', <?php echo $data_offre_valeur[3] ?>]
			]);

		var table = new google.visualization.Table(document.getElementById('table_offre'));
		table.draw(data, {showRowNumber: true});
	}
</script>
</head>



