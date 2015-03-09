<?php
        // nombre d'adhérents au cours du temps
        $stats_adherents = array();
        foreach ($stat_evolution_nombre_adhérents as $value) {
            $stats_adherents[$value->YEAR] = (int) $value->NOMBRE;
        }
        ksort($stats_adherents);

        // nombre de donateurs au cours du temps
        $stats_donateurs = array();
        foreach($stat_evolution_donateurs as $value) {
            $stats_donateurs[$value->YEAR] = (int) $value->NOMBRE;
        }
        ksort($stats_donateurs);

        // dons répartis en fonction de leur valeur
        $dons_par_valeur = array();
        foreach($dons_repartis_par_montant as $value) {
            if(!isset($dons_par_valeur[$value->TOTAL])){
                $dons_par_valeur[$value->TOTAL] = 0;
            }
            $dons_par_valeur[$value->TOTAL] ++;
        }
        ksort($dons_par_valeur);
?>

<div id="evolution_adherents" style="width:100%; height:400px;"></div>
<div id="evolution_donateurs" style="width:100%; height:400px;"></div>
<div id="repartition_dons_valeur" style="width:100%; height:400px;"></div>


<script>
$(function () {

    $("#evolution_adherents").highcharts({
        chart: {
            type: 'column',
            zoomType: 'x'
        },
        title: {
            text: 'Evolution du nombre d\'adhérents au cours du temps'
        },
        yAxis: {
            min: 0,
            title: { text : 'Nombre d\'adhérents' }
        },
        xAxis: {
            title: { text: 'Date' },
            categories : <?php echo json_encode(array_keys($stats_adherents)); ?>
        },
        series: [
            {
                name: 'adhérents',
                data: <?php echo json_encode(array_values($stats_adherents)); ?>
            },
        ]
    });    

    $("#evolution_donateurs").highcharts({
        chart: {
            type: 'column',
            zoomType: 'x'
        },
        title: {
            text: 'Evolution du nombre de donateurs au cours du temps'
        },
        yAxis: {
            min: 0,
            title: { text : 'Nombre de donateurs' }
        },
        xAxis: {
            title: { text: 'Date' },
            categories : <?php echo json_encode(array_keys($stats_donateurs)); ?>
        },
        series: [
            {
                name: 'donateurs',
                data: <?php echo json_encode(array_values($stats_donateurs)); ?>
            },
        ]
    });

    $("#repartition_dons_valeur").highcharts({
        chart: {
            type: 'column',
            zoomType: 'x'
        },
        title: {
            text: 'Répartition de la valeur des dons'
        },
        yAxis: {
            min: 0,
            title: { text : 'Nombre de dons' }
        },
        xAxis: {
            title: { text: 'valeur (Euros)' },
            categories : <?php echo json_encode(array_keys($dons_par_valeur)); ?>
        },
        series: [
            {
                name: 'nombre de dons',
                data: <?php echo json_encode(array_values($dons_par_valeur)); ?>
            },
        ]
    });
});
</script>



