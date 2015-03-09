<!-- HTML -->
<div id="example-section4">
<?php

// la somme de toutes les valeurs
$sommes = array();

// on parcours tous les dons
foreach($dons as $don){
    // si la date n'est pas deja dans le tableau on ajoute une nouvelle date et une nouvelle valeur nulle
    if(!isset($sommes[$don->DON_DATE])){
        $sommes[$don->DON_DATE] = 0;
    }
    // on ajoute la valeur du don a cette date
    // on doit caster les valeurs de don en int ici pour ne pas additionner des strings
    $sommes[$don->DON_DATE] += intVal($don->DON_MONTANT);
}
//trie des valeurs par les cles (les dates)
ksort($sommes);

// on ne garde que 20 dates
$sommes = array_slice($sommes, 0, 20);

// example from : http://www.highcharts.com/docs/getting-started/your-first-chart
?>
<div id="container" style="width:100%; height:400px;"></div>
<script>
$(function () {
    $('#container').highcharts({
        title: { text: 'Tous les dons' },
        yAxis: {
            title: { text : 'Montant journalier' }
        },
        xAxis: {
            title: { text: 'Date' },
            categories : <?php
// on ajoute dans les categories toutes les dates
// on recupere les cles du tableau cree et on les encodes en json qui sera lu par le javascript
echo json_encode(array_keys($sommes)); ?>
        },
        series: [{
            data: <?php
// on ajoute dans la serie toutes les valeurs
echo json_encode(array_values($sommes)); ?>
        }]
    });
});
</script>
</div>
