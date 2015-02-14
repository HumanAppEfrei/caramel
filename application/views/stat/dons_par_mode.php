<!-- HTML -->
<div id="example-section4">


<?php

/////////////////////////////////////////////
// Tableaux contenant les données des graphes
/////////////////////////////////////////////
$sommes_virements = array();
$sommes_cheques = array();
$sommes_cartes = array();
$sommes_cotisations = array();

/////////////////////////////////////////////
// Remplissage des tableaux via les variables passées par le controleur
/////////////////////////////////////////////

// on parcours tous les virements
foreach($virements as $don){
    // si la date n'est pas deja dans le tableau on ajoute une nouvelle date et une nouvelle valeur nulle
    if(!isset($sommes_virements[$don->DON_DATE])){
        $sommes_virements[$don->DON_DATE] = 0;
    }
    // on ajoute la valeur du don a cette date
    // on doit caster les valeurs de don en int ici pour ne pas additionner des strings
    $sommes_virements[$don->DON_DATE] += intVal($don->DON_MONTANT);
}
// on parcours tous les cheques
foreach($cheques as $don){
    // si la date n'est pas deja dans le tableau on ajoute une nouvelle date et une nouvelle valeur nulle
    if(!isset($sommes_cheques[$don->DON_DATE])){
        $sommes_cheques[$don->DON_DATE] = 0;
    }
    // on ajoute la valeur du don a cette date
    $sommes_cheques[$don->DON_DATE] += intVal($don->DON_MONTANT);
}
// on parcours toute les cartes
foreach($cartes as $don){
    // si la date n'est pas deja dans le tableau on ajoute une nouvelle date et une nouvelle valeur nulle
    if(!isset($sommes_cartes[$don->DON_DATE])){
        $sommes_cartes[$don->DON_DATE] = 0;
    }
    // on ajoute la valeur du don a cette date
    $sommes_cartes[$don->DON_DATE] += intVal($don->DON_MONTANT);
}
// on parcours toute les cotisations
foreach($cotisations as $don){
    // si la date n'est pas deja dans le tableau on ajoute une nouvelle date et une nouvelle valeur nulle
    if(!isset($sommes_cotisations[$don->DON_DATE])){
        $sommes_cotisationss[$don->DON_DATE] = 0;
    }
    // on ajoute la valeur du don a cette date
    $sommes_cotisations[$don->DON_DATE] += intVal($don->DON_MONTANT);
}
/////////////////////////////////////////////
//trie des valeurs par les cles (les dates)
/////////////////////////////////////////////
ksort($sommes_virements);
ksort($sommes_cheques);
ksort($sommes_cotisations);
ksort($sommes_cartes);

// on ne garde que 20 dates
//$sommes_virements = array_slice($sommes_virements, 0, 20);

/////////////////////////////////////////////
// creation du graphe
/////////////////////////////////////////////
?>
<div id="container" style="width:100%; height:400px;"></div>
<script>
$(function () {
    // Ici on a besoin d'installer StockChart.js pour pouvoir utiliser la ligne
    // suivante et surtout la fonctionnalité "navigator" dans le graphe
    //$("#container").highcharts("StockChart", {
    $("#container").highcharts({
        chart: {
            type: 'line'
        },
        title: {
            text: 'Tous les dons'
        },
        /*navigator: {
            enabled: true
        },*/
        yAxis: {
            title: { text : 'Montant journalier' }
        },
        xAxis: {
            title: { text: 'Date' },
            categories : <?php
                // on ajoute dans les categories toutes les dates
                // on recupere les cles du tableau cree et on les encodes en json qui sera lu par le javascript
                echo json_encode(array_keys($sommes_virements)); ?>
        },
        series: [
            {
                name: 'virements',
                data: <?php echo json_encode(array_values($sommes_virements)); // on ajoute dans la serie toutes les valeurs?>
            },
            {
                name: 'cheques',
                data: <?php echo json_encode(array_values($sommes_cheques)); ?>
            },
            {
                name: 'cartes',
                data: <?php echo json_encode(array_values($sommes_cartes)); ?>
            },
            {
                name: 'cotisations',
                data: <?php echo json_encode(array_values($sommes_cotisations)); ?>
            }
    ]
    });
});
</script>
</div>
