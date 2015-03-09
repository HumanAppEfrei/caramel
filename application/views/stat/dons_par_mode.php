<!-- HTML -->
<div id="content">

<!-- saisie des dates pour la selection des dons -->
    <div id="content">
        <form method="post" name="select_dates" <?php echo ('action="'.site_url('stat/versements_par_mode').'"'); ?>>
            date de debut:
            <!-- <input type="date" name="debut" value="2013-01-01" min="1900-01-01" max="2100-08-01"> -->
            <input type="text" id="datepicker1" name="debut" />
            date de fin:
            <!-- <input type="date" name="fin" value="2015-03-01" min="1900-01-01" max="2100-01-01"> -->
            <input type="text" id="datepicker2" name="fin" />
            <select id="campagne-select" name="campagne-select">
                <option value='all'>Toutes les campagnes</option>
                <?php foreach($campagnes as $key => $name){ ?>
                <option value="<?php echo $key; ?>"><?php echo $name; ?></option>
                <?php } ?>
            </select>
            <button type="submit" class="btn" value="trier">Trier</button>
        </form>
    </div>

<?php

/////////////////////////////////////////////
// Tableaux contenant les données des graphes
/////////////////////////////////////////////
$sommes_virements = array();
$sommes_cheques = array();
$sommes_cartes = array();
$sommes_especes = array();

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
// on parcours toute les especes
foreach($especes as $don){
    // si la date n'est pas deja dans le tableau on ajoute une nouvelle date et une nouvelle valeur nulle
    if(!isset($sommes_especes[$don->DON_DATE])){
        $sommes_especess[$don->DON_DATE] = 0;
    }
    // on ajoute la valeur du don a cette date
    $sommes_especes[$don->DON_DATE] += intVal($don->DON_MONTANT);
}

/////////////////////////////////////////////
// recupération du nombre de dons dans chaque mode
/////////////////////////////////////////////
$nb_cheques = count($sommes_cheques);
$nb_cartes = count($sommes_cartes);
$nb_virements = count($sommes_virements);
$nb_especes = count($sommes_especes);
//var_dump($nb_cheques);
//var_dump($nb_especes);
//var_dump($nb_cartes);
//var_dump($nb_virements);


/////////////////////////////////////////////
// Harmonisation des tableaux
/////////////////////////////////////////////
// cette partie sert à harmoniser les tableaux en faisant en sorte que toutes
// les dates apparaissent dans tous les tableaux (sinon l'affichage est faussé)

// on récupère l'ensemble des dates de tous les versements
$dates = array_unique(array_merge(array_keys($sommes_virements), array_keys($sommes_cartes), array_keys($sommes_cheques), array_keys($sommes_especes)));
sort($dates);

// puis on rajoute les dates qui n'existaient pas en leur donnant une valeur de 0
foreach($dates as $date){
    if(!isset($sommes_especes[$date])){
        $sommes_especes[$date] = 0;
    }
    if(!isset($sommes_virements[$date])){
        $sommes_virements[$date] = 0;
    }
    if(!isset($sommes_cartes[$date])){
        $sommes_cartes[$date] = 0;
    }
    if(!isset($sommes_cheques[$date])){
        $sommes_cheques[$date] = 0;
    }
}

/////////////////////////////////////////////
//tri des valeurs par les cles (les dates)
/////////////////////////////////////////////
ksort($sommes_virements);
ksort($sommes_cheques);
ksort($sommes_especes);
ksort($sommes_cartes);


/////////////////////////////////////////////
// creation des graphes
/////////////////////////////////////////////
?>
<div id="lines" style="width:100%; height:400px;"></div>
<div id="pie" style="width:100%; height:400px;"></div>


<script>
$(function () {
    $("#lines").highcharts({
        chart: {
            type: 'line',
            zoomType: 'x'
        },
        title: {
            text: 'Evolution des modes de versements au cours du temps'
        },
        yAxis: {
            title: { text : 'Montant' }
        },
        xAxis: {
            title: { text: 'Date' },
            categories : <?php
                // on ajoute dans les categories toutes les dates et on les encodes en json qui sera lu par le javascript
                echo json_encode(array_values($dates));
                ?>
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
                name: 'especes',
                data: <?php echo json_encode(array_values($sommes_especes)); ?>
            }
    ]
    });


    $("#pie").highcharts({
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: true

        },
        title: {
            text: 'repartition des dons en fonction du mode de paiment'
        },
        series: [{
            type: 'pie',
            name: 'nombre de versements',
            data: [
                ['virements',   <?php echo $nb_virements; ?>],
                ['cheques',   <?php echo $nb_cheques; ?>],
                ['cartes',   <?php echo $nb_cartes; ?>],
                ['especes',   <?php echo $nb_especes; ?>],
            ]
        }]
    });

    $( '#datepicker1'  ).datepicker({ dateFormat: "yy-mm-dd" },$.datepicker.regional['fr']);
    $( '#datepicker2'  ).datepicker({ dateFormat: "yy-mm-dd" },$.datepicker.regional['fr']);

});


</script>
</div>
