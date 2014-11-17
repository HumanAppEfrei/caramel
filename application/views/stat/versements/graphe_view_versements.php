    <?php
            //tableaux nombre versements en fonction des types
            $data_don_type = array();
            $data_don_nombre_type = array();

            //tableaux nombre versements en fonction des modes 
            $data_don_mode = array();
            $data_don_nombre_mode = array();

            foreach($stat_percent_type_versement as $value){
                array_push($data_don_type, $value->DON_TYPE);
                array_push($data_don_nombre_type, $value->NUMBER);
            }

            foreach($stat_percent_mode_versement as $value){
                array_push($data_don_mode, $value->DON_MODE);
                array_push($data_don_nombre_mode, $value->NUMBER);
            }
    ?>

    <!--Div that will hold the pie chart-->
    <div id='chart_container'>
        <div id='versements_type'></div>
        <div id='versements_mode'></div>
    </div>

    <!--Load the AJAX API-->

    <!--il faudra télécharger le jspai.js et le mettre en local!-->
    <link href="<?php echo css_url('style_graphe');?>" type="text/css" rel="stylesheet" />
    <script type="text/javascript" src="<?php echo js_url('jsapi'); ?>"></script>
        
        <script type="text/javascript">
         
          google.load("visualization", "1", {packages:["corechart"]});
          google.setOnLoadCallback(drawChart);
          
          function drawChart() {
            var data = google.visualization.arrayToDataTable([
              ['Types de versement', 'nombre'],
              ['<?php echo $data_don_type[0]?>',     <?php echo (int)$data_don_nombre_type[0]?>],
              ['<?php echo $data_don_type[1]?>',      <?php echo (int)$data_don_nombre_type[1]?>],
              ['<?php echo $data_don_type[2]?>',   <?php echo (int)$data_don_nombre_type[2]?>]
            ]);

            var options = {'title':'répartition des dons en fonction de leurs types',
        'backgroundColor': {
          'fill': '#F4F4F4',
          'opacity' : 100,
      },
      'is3D':true};

            var chart = new google.visualization.PieChart(document.getElementById('versements_type'));
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
              ['Types de versement', 'nombre'],
              ['<?php echo $data_don_mode[0]?>',     <?php echo (int)$data_don_nombre_mode[0]?>],
              ['<?php echo $data_don_mode[1]?>',      <?php echo (int)$data_don_nombre_mode[1]?>],
              ['<?php echo $data_don_mode[2]?>',   <?php echo (int)$data_don_nombre_mode[2]?>]
            ]);

            var options = {'title':'répartition des dons en fonction de leurs modes',
        'backgroundColor': {
          'fill': '#F4F4F4',
          'opacity' : 100,
      },
      'is3D':true};

            var chart = new google.visualization.PieChart(document.getElementById('versements_mode'));
            chart.draw(data, options);
          }
        </script>