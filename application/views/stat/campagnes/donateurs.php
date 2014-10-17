<div class="well">
	<legend>Top Donateurs</legend>
	
	<div class="tabbable" id="donateurs">
		<ul class="nav nav-tabs">
			<li><a href="#by_dons" >top <?php echo $nb_top?> en dons</a></li>
			<li><a href="#by_offre_d" >top <?php echo $nb_top?> en réponse aux offres</a></li>
			<li><a href="#by_largeur" >top <?php echo $nb_top?> en largeur de dons</a></li>
		</ul>
	</div>
	
	<div class="tabDonateurs" id="by_dons">
		<div id="top_by_dons"></div>
	</div>
	<div class="tabDonateurs" id="by_offre_d">
		<div id="top_by_offre"></div>
	</div>
	<div class="tabDonateurs" id="by_largeur">
		<div id="top_by_largeur"></div>
	</div>
	</div>
</div>

<script language="javascript" type="text/javascript">  
	
	

	$(function () {  
		var data = [  
				<?php
				$i = 0;
				foreach($cols_top_by_dons as $col){
					echo (' {label: "'.$col.'", data:'.$rows_top_by_dons[$col].'}, ');
				}
				?>
		];  
		var options = {
			series: { 
				pie: {
					show: true,
					radius: 1,
					label: {
						show: true,
						radius: 3/4,
						<?php if($exp_vers == 'valeur'){ ?> formatter: function (label, series) { return '<div style="font-size:8pt;text-align:center;padding:5px;color:white;">' + label + '<br/>' + series.data[0][1] + ' €</div>'; },
						<?php } else {?>formatter: function (label, series) { return '<div style="font-size:8pt;text-align:center;padding:5px;color:white;">' + label + '<br/>' + series.data[0][1] + '</div>'; },
						<?php } ?>
						background: {
							opacity: 0.5
						}
					}
				}
			},
			legend: {
                show: false
            }
		};  
		var top_by_dons = $("#top_by_dons");  
		top_by_dons.css("height", "250px");  
		top_by_dons.css("width", "500px");  
		$.plot( top_by_dons , data, options );  
	});
	

	$(function () {  
		var data = [  
				<?php
				$i = 0;
				foreach($cols_top_by_offre as $col){
					echo (' {label: "'.$col.'", data:'.$rows_top_by_offre[$col].'}, ');
				}
				?>
		];  
		var options = {
			series: { 
				pie: {
					show: true,
					radius: 1,
					label: {
						show: true,
						radius: 3/4,
						formatter: function (label, series) { return '<div style="font-size:8pt;text-align:center;padding:5px;color:white;">' + label + '<br/>' + series.data[0][1] + '</div>'; },
						background: {
							opacity: 0.5
						}
					}
				}
			},
			legend: {
                show: false
            }
		};  
		var top_by_offre = $("#top_by_offre");  
		top_by_offre.css("height", "250px");  
		top_by_offre.css("width", "500px");  
		$.plot( top_by_offre , data, options );  
	});


		$(function () {  
		var data = [  
				<?php
				$i = 0;
				foreach($cols_top_by_largeur as $col){
					echo (' {label: "'.$col.'", data:'.$rows_top_by_largeur[$col].'}, ');
				}
				?>
		];  
		var options = {
			series: { 
				pie: {
					show: true,
					radius: 1,
					label: {
						show: true,
						radius: 3/4,
						formatter: function (label, series) { return '<div style="font-size:8pt;text-align:center;padding:5px;color:white;">' + label + '<br/>' + series.data[0][1] + '€</div>'; },
						background: {
							opacity: 0.5
						}
					}
				}
			},
			legend: {
                show: false
            }
		};  
		var top_by_largeur = $("#top_by_largeur");  
		top_by_largeur.css("height", "250px");  
		top_by_largeur.css("width", "500px");  
		$.plot( top_by_largeur , data, options );  
	});


	$(document).ready(function(){
		$(".tabDonateurs").each(function(i){
			this.id = "#" + this.id;
		});

		$(".tabDonateurs:not(:first)").hide();
		$(".tabDonateurs").not(":first").hide();

		$("#donateurs a").click(function() {
			var idTab_do = $(this).attr("href");
			$(".tabDonateurs").hide();
			$("div[id='" + idTab_do + "']").fadeIn();
			return false;
		}); 
	});
</script>  