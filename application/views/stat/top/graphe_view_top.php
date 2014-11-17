<?php
        //tableaux pour le top des dons individuels: valeur et nom du donateur
        $data_top_value_single = array();
        $data_top_name_single = array();

        //tableauxp pour le top donateurs cumulé: valeur cumulé des dons, et nom du donateur
        $data_top_value = array();
        $data_top_name = array();

        //tableau pour le top des villes: valeur cumulé des dons, et nom de la ville
        $data_top_value_ville = array();
        $data_top_name_ville = array();

        foreach($stat_top10_montant as $value){
            array_push($data_top_value_single, $value->DON_MONTANT);
            array_push($data_top_name_single, $value->CON_LASTNAME);
        }

        foreach($stat_top10_cumule as $value){
            array_push($data_top_value, $value->NUMBER);
            array_push($data_top_name, $value->CON_LASTNAME);
        }

        foreach ($stat_top10_ville as $value) {
            array_push($data_top_value_ville, $value->CON_CITY);
            array_push($data_top_name_ville, $value->NUMBER);
        }
?>

<div id='chart_container'>
    <div id='top_don'></div>
    <div id='top_cumule'></div>
</div>
<div id='chart_container'>
    <div id='top_ville'></div>
</div>

<!--script pour le top 10 des dons individuels -->
<link href="<?php echo css_url('style_graphe'); ?>" type="text/css" rel="stylesheet" />
<script type="text/javascript" src="<?php echo js_url('jsapi'); ?>"> </script>

<script type='text/javascript'>

  google.load('visualization', '1', {packages:['table']});

  google.setOnLoadCallback(drawTable);

  function drawTable() {


    var data = new google.visualization.DataTable();

        data.addColumn('string', 'valeur');
        data.addColumn('string', 'nom');
        data.addRows([
          ['<?php echo $data_top_value_single[0]?>','<?php echo $data_top_name_single[0]?>'],
          ['<?php echo $data_top_value_single[1]?>','<?php echo $data_top_name_single[1]?>'],
          ["<?php echo $data_top_value_single[2]?>",'<?php echo $data_top_name_single[2]?>'],
          ["<?php echo $data_top_value_single[3]?>",'<?php echo $data_top_name_single[3]?>'],
          ['<?php echo $data_top_value_single[4]?>','<?php echo $data_top_name_single[4]?>'],
          ['<?php echo $data_top_value_single[5]?>','<?php echo $data_top_name_single[5]?>'],
          ["<?php echo $data_top_value_single[6]?>",'<?php echo $data_top_name_single[6]?>'],
          ["<?php echo $data_top_value_single[7]?>",'<?php echo $data_top_name_single[7]?>'],
          ["<?php echo $data_top_value_single[8]?>",'<?php echo $data_top_name_single[8]?>'],
          ["<?php echo $data_top_value_single[9]?>",'<?php echo $data_top_name_single[9]?>'],
        ]);
    
        var table = new google.visualization.Table(document.getElementById('top_don'));
        
    //dessiner la table    
    table.draw(data, {showRowNumber: true});

}
</script>

<!--script pour le top 10 cumule-->
<link href="<?php echo css_url('style_graphe'); ?>" type="text/css" rel="stylesheet" />
<script type="text/javascript" src="<?php echo js_url('jsapi'); ?>"> </script>

<script type='text/javascript'>

  google.load('visualization', '1', {packages:['table']});

  google.setOnLoadCallback(drawTable);

  function drawTable() {

    var data = new google.visualization.DataTable();

    data.addColumn('string', 'valeur');
        data.addColumn('string', 'nom');
        data.addRows([
          ['<?php echo $data_top_value[0]?>','<?php echo $data_top_name[0]?>'],
          ['<?php echo $data_top_value[1]?>','<?php echo $data_top_name[1]?>'],
          ["<?php echo $data_top_value[2]?>",'<?php echo $data_top_name[2]?>'],
          ["<?php echo $data_top_value[3]?>",'<?php echo $data_top_name[3]?>'],
          ['<?php echo $data_top_value[4]?>','<?php echo $data_top_name[4]?>'],
          ['<?php echo $data_top_value[5]?>','<?php echo $data_top_name[5]?>'],
          ["<?php echo $data_top_value[6]?>",'<?php echo $data_top_name[6]?>'],
          ["<?php echo $data_top_value[7]?>",'<?php echo $data_top_name[7]?>'],
          ["<?php echo $data_top_value[8]?>",'<?php echo $data_top_name[8]?>'],
          ["<?php echo $data_top_value[9]?>",'<?php echo $data_top_name[9]?>'],
        ]);

    var table = new google.visualization.Table(document.getElementById('top_cumule'));
        
    //dessiner la table    
    table.draw(data, {showRowNumber: true});

}
</script>
<!--script pour le top 10 des villes -->
<link href="<?php echo css_url('style_graphe'); ?>" type="text/css" rel="stylesheet" />
<script type="text/javascript" src="<?php echo js_url('jsapi'); ?>"> </script>

<script type='text/javascript'>

  google.load('visualization', '1', {packages:['table']});

  google.setOnLoadCallback(drawTable);

  function drawTable() {

    var data = new google.visualization.DataTable();

    data.addColumn('string', 'Nom');
        data.addColumn('string', 'Valeur');
        data.addRows([
          ['<?php echo $data_top_value_ville[0]?>','<?php echo $data_top_name_ville[0]?>'],
          ['<?php echo $data_top_value_ville[1]?>','<?php echo $data_top_name_ville[1]?>'],
          ["<?php echo $data_top_value_ville[2]?>",'<?php echo $data_top_name_ville[2]?>'],
          ["<?php echo $data_top_value_ville[3]?>",'<?php echo $data_top_name_ville[3]?>'],
          ['<?php echo $data_top_value_ville[4]?>','<?php echo $data_top_name_ville[4]?>'],
          ['<?php echo $data_top_value_ville[5]?>','<?php echo $data_top_name_ville[5]?>'],
          ["<?php echo $data_top_value_ville[6]?>",'<?php echo $data_top_name_ville[6]?>'],
          ["<?php echo $data_top_value_ville[7]?>",'<?php echo $data_top_name_ville[7]?>'],
          ["<?php echo $data_top_value_ville[8]?>",'<?php echo $data_top_name_ville[8]?>'],
          ["<?php echo $data_top_value_ville[9]?>",'<?php echo $data_top_name_ville[9]?>'],
        ]);

    var table = new google.visualization.Table(document.getElementById('top_ville'));
        
    //dessiner la table    
    table.draw(data, {showRowNumber: true});

}
</script>

