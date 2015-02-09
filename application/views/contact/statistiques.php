<div>
<?php

// tri des periodes par dates pour affichage
ksort($periodes);

// tri des types pour aller avec highchart
$types_formates = array();
foreach ($types as $type => $value) {
    $arrayTmp = array();
    array_push($arrayTmp, $type, $value);
    array_push($types_formates,$arrayTmp);
}
// tri des montants pour aller avec highchart
ksort($montants);

?>

    <h2>Statistiques sur l'utilisateur </h2>
    <h3>Analyse sur la periode des dons</h3>
        <div id="stats-periode" style="height=400px; width=100%;"></div>
    <h3>Analyse par type de dons</h3>
        <div id="stats-types" style="height=400px; width=100%;"></div>
    <h3>Analyse par montant des dons</h3>
        <div id="stats-montants" style="height=400px; width=100%;"></div>
<script>
$(function () {
    // ajout du graphique sur les periodes
    $('#stats-periode').highcharts({
        title: { text: 'Tous les dons' },
        yAxis: { title: { text : 'Nombre de don' } },
        xAxis: {
            title: { text: 'Date' },
                categories : <?php echo json_encode(array_keys($periodes)); ?>
        },
        series: [{ data: <?php echo json_encode(array_values($periodes)); ?> }]
    });
    // ajout du graphique sur les periodes
    $('#stats-periode').highcharts({
        title: { text: 'Tous les dons' },
            yAxis: { title: { text : 'Nombre de don' } },
        xAxis: {
            title: { text: 'Date' },
                categories : <?php echo json_encode(array_keys($periodes)); ?>
        },
        series: [{ data: <?php echo json_encode(array_values($periodes)); ?> }]
    });
$('#stats-types').highcharts({
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false
        },
        title: { text: 'Types de payement' },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: true,
                    format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                }
            }
        },
        series: [{
            type: 'pie',
            name: 'Type de payement',
            data: <?php echo(json_encode($types_formates)); ?>     }]
    });
$('#stats-montants').highcharts({
        chart: { type: 'column' },
        title: { text: 'Nombre de dons en fonction du montant' },
        xAxis: {
            title: { text: 'Montants en €' },
            categories : <?php echo json_encode(array_keys($montants)); ?>
        },
        yAxis: { title: { text: 'Nombre de dons' } },
        plotOptions: {
            column: {
                pointPadding: 0.2,
                borderWidth: 0
            }
        },
        series: [{ data: <?php echo json_encode(array_values($montants)); ?> }]
    });
});
</script>
</div>
</div>
