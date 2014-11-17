<?php
        //tableaux pour le montant global des campagnes
        $data_global_nom = array();
        $data_global_value = array();
        $data_global_date_debut = array();
        $data_global_date_fin = array();

        $nb_campagne = $stat_nb_campagne[0]->NUMBER;

        var_dump($stat_montant_global);

        //echo json_encode($stat_montant_global);

        foreach ($stat_montant_global as $value) {
            array_push($data_global_value, $value->NUMBER);
            array_push($data_global_nom, $value->NOM);
            array_push($data_global_date_debut, $value->DEBUT);
            array_push($data_global_date_fin, $value->FIN);
        }
?>

<div id='chart_container'>
    <div id='campagne_global'>lol</div>
</div>

<link href="<?php echo css_url('style_graphe'); ?>" type="text/css" rel="stylesheet" />
<script type="text/javascript" src="<?php echo js_url('jsapi'); ?>"> </script>
<script type='text/javascript'>

  google.load('visualization', '1', {packages:['table']});

  google.setOnLoadCallback(drawTable);

  function drawTable() {

    var data = new google.visualization.DataTable(<? echo json_encode($stat_montant_global)?>);
        //c'est sale, mais le json de mes couilles marche pas
        data.addColumn('string', 'valeur');
        data.addColumn('string', 'nom');
        //data.addColumn('string', 'date de début');
        //data.addColumn('string', 'date de fin');
      
        <?php
            for ($i=0; $i < $nb_campagne; $i++) {
                ?>data.addRow(['<?php echo $stat_montant_global[$i]->NUMBER; ?>
                , <?php echo $stat_montant_global[$i]->NOM; ?>']); 
                <?php }
        ?>

    var table = new google.visualization.Table(document.getElementById('campagne_global'));
        
    //dessiner la table    
    table.draw(data, {showRowNumber: true});

}
</script>