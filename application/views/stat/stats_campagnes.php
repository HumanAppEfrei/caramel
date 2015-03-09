<!-- HTML -->
<script src="http://code.highcharts.com/highcharts.js"></script>
<script src="http://code.highcharts.com/modules/data.js"></script>
<script src="http://code.highcharts.com/modules/exporting.js"></script>

<?php

    $objData = intval($objectif[0]->CAM_OBJECTIF);
    $resData = intval($montant[0]->DON_MONTANT);
    $campagne_choisie_name;
?>

<!-- Menu déroulant affichant le nom des campagnes (post l'id de la campagne) -->
<div id="content">
    <div align="center">
        Selectionnez une campagne 
        <form method="post" name="campagne_form" <?php echo ('action="'.site_url('stat/stat_campagne').'"'); ?>>
            <select name="campagne_select">
            <?php            
                foreach ($campagne_name as $cam_name) {
                    echo '<option value="';
                    echo $cam_name->CAM_ID;
                    echo '">';
                    echo $cam_name->CAM_NOM;
                    if($campagne_choisie_id == $cam_name->CAM_ID) {
                        echo 'selected';
                        $campagne_choisie_name = $cam_name->CAM_NOM;

                    }
                    echo '</option>';
                } 
            ?>
            </select>
            <button type="submit" class="btn" value="selectionner">Selectionner</button>
        </form>
    </div>
</div>

<!-- div contenant les tableaux de stats générés par highchart -->
<br>
<div id="campagne_graphe" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
<br>
<div id="campagne_graphe_par_mois" style="min-width: 310px; height: 400px; margin: 0 auto"></div>

<script>

$(function () {

    $('#campagne_graphe').highcharts({
        chart: {
           type: 'column'
        },
        title: {
            text: '<?php echo $campagne_choisie_name; ?>'
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Montant (€)'
            }
        },
        xAxis: {
            title: {
                text: 'Campagne'
            }
        },
        plotOptions: {
            column: {
                pointPadding: 0.4,
                borderWidth: 0
            }
        },
        series: [
            {
                name: 'Objectif',
                data: [<?php echo $objData ?>]
            }, 
            {
                name: 'Résultat',
                data: [<?php echo $resData ?>]
            }
        ]
    });
});

$(function () {
    $('#campagne_graphe_par_mois').highcharts({
        chart: {
            type: 'column',
            zoomType: 'x'
        },
        title: {
            text: '<?php echo $campagne_choisie_name; ?>'
        },
        subtitle: {
            text: 'Résultat par mois'
        },
        xAxis: {
            title: {
                text: 'Temps'
            },
            categories:
                <?php echo json_encode(array_keys($historique)); ?>
            
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Montant (€)'
            }
        },
        plotOptions: {
            column: {
                pointPadding: 0.1,
                borderWidth: 0
            }
        },
        series: [
        {
            name: 'Résultat',
            data: <?php echo json_encode(array_values($historique)); ?>
        }]
    });
});

</script>