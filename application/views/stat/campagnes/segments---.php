<div class="well">
	<legend>Segements</legend>
	
	<form class="form-horizontal" method="post" name="select_cam" <?php echo ('action='.site_url("stat/campagnes")); ?>>
		<input name= "is_form_sent" type="hidden" value="true">
		<pretty>
			<select name="campagne"">
			<?php foreach($list_campagnes as $list_campagne)
			{
				
				echo "<option value=".$list_campagne->CAM_ID." ";
				if($list_campagne->CAM_ID == $campagne) echo'selected';
				echo ">".$list_campagne->CAM_ID." : ".$list_campagne->CAM_NOM."</option>";			
			}
			?>
			</select>
			
			<button type="submit" class="btn">Sélectionner cette offre</button>
		</pretty>
	</form>
	
	<div class="tabbable" id="segments">
		<ul class="nav nav-tabs">
			<li><a href="#by_year" >/ année</a></li>
		</ul>
	</div>
	
	<div class="tabSegments" id="by_year">
		<div id="nb_dons_by_year"></div>
	</div>
</div>

<script language="javascript" type="text/javascript">  
	$(function () {  
		var data = [  
			{
				label: 'versements / année',
				color: '#1E90FF',
				data: [<?php
				$i = 0;
				foreach($cols_versements_by_year as $col){
					echo ("[".$i.", '".$rows_versements_by_year[$col]."'],");
					$i = $i + 1;
				}
				?>]
					
			},
			<?php 
			if($exp_vers == "valeur"){
			?>
			{ 
				label: 'objectif',
				color: '#CD5C5C',
				data: [<?php
				$i = 0;
				foreach($cols_versements_by_year as $col){
					echo ("[".$i.", ".$objectif."],");
					$i = $i + 1;
				}
				?>]
					
			}
			<?php 
			}
			?>
			
		];
		var options = {
			xaxis: {
				ticks: [<?php
				$i = 0;
				foreach($cols_versements_by_year as $col){
					echo ("[".$i.", '".$col."'],");
					$i = $i + 1;
				}
				?>]
			},
			points: {  
				show: true
			},
			lines: { 
				show: true
			},
			legend: { position: 'ne', labelBoxBorderColor: "#000000", noColumns: 0 }
		};  
		var nb_dons_by_year = $("#nb_dons_by_year");  
		nb_dons_by_year.css("height", "250px");  
		nb_dons_by_year.css("width", "500px");  
		$.plot( nb_dons_by_year , data, options );
	});

	$(document).ready(function(){
		$(".tabDons").each(function(i){
			this.id = "#" + this.id;
		});

		$(".tabDons:not(:first)").hide();
		$(".tabDons").not(":first").hide();

		$("#dons a").click(function() {
			var idTab = $(this).attr("href");
			$(".tabDons").hide();
			$("div[id='" + idTab + "']").fadeIn();
			return false;
		}); 
	});
</script>  