<div class="well">
	<legend>Offres</legend>
	<div class="tabbable" id="offres">
		<ul class="nav nav-tabs">
			<li><a href="#nb_offres_by_year" >Nombre d'offres / annnée</a></li>
			<li><a href="#nb_offres_by_month" >Nombre d'offres / mois</a></li>
			<li><a href="#nb_dons_by_offre" >Nombre de dons / offre</a></li>
		</ul>
	</div>
	<div class="tabOffres" id="nb_offres_by_year"></div>
	<div class="tabOffres" id="nb_offres_by_month"></div>
	<div class="tabOffres" id="nb_dons_by_offre"></div>
</div>

<script language="javascript" type="text/javascript">  
	$(function () {  
		var data = [  
			{ 
				data: [<?php
				$i = 0;
				foreach($cols_nb_offres_by_year as $col){
					echo ("[".$i.", '".$rows_nb_offres_by_year[$col]."'],");
					$i = $i + 1;
				}
				?>]
					
			}  
		];  
		var options = {
			xaxis: {
				ticks: [<?php
				$i = 0;
				foreach($cols_nb_offres_by_year as $col){
					echo ("[".$i.", '".$col."'],");
					$i = $i + 1;
				}
				?>]
			},
			bars: {  
				show: true,
				align: 'center'
			}
		};  
		var nb_offres_by_year = $("#nb_offres_by_year");  
		nb_offres_by_year.css("height", "250px");  
		nb_offres_by_year.css("width", "500px");  
		$.plot( nb_offres_by_year , data, options );  
	});


	$(function () {  
		var data = [  
			{ 
				data: [<?php
				$i = 0;
				foreach($cols_nb_offres_by_month as $col){
					echo ("[".$i.", '".$rows_nb_offres_by_month[$col]."'],");
					$i = $i + 1;
				}
				?>]
					
			}  
		];  
		var options = {
			xaxis: {
				ticks: [<?php
				$i = 0;
				foreach($cols_nb_offres_by_month as $col){
					echo ("[".$i.", '".$col."'],");
					$i = $i + 1;
				}
				?>]
			},
			bars: {  
				show: true,
				align: 'center'
			}
		};  
		var nb_offres_by_month = $("#nb_offres_by_month");  
		nb_offres_by_month.css("height", "250px");  
		nb_offres_by_month.css("width", "500px");  
		$.plot( nb_offres_by_month , data, options );  
	});





	$(function () {  
		var data = [  
			{ 
				data: [<?php
				$i = 0;
				foreach($cols_nb_dons_by_offre as $col){
					echo ("[".$i.", '".$rows_nb_dons_by_offre[$col]."'],");
					$i = $i + 1;
				}
				?>]
					
			}  
		];  
		var options = {
			xaxis: {
				ticks: [<?php
				$i = 0;
				foreach($cols_nb_dons_by_offre as $col){
					echo ("[".$i.", '".$col."'],");
					$i = $i + 1;
				}
				?>]
			},
			bars: {  
				show: true,
				align: 'center'
			}
		};  
		var nb_dons_by_offre = $("#nb_dons_by_offre");  
		nb_dons_by_offre.css("height", "250px");  
		nb_dons_by_offre.css("width", "500px");  
		$.plot( nb_dons_by_offre , data, options );  
	});








	$(document).ready(function(){
		$(".tabOffres").each(function(i){
			this.id = "#" + this.id;
		});

		$(".tabOffres:not(:first)").hide();
		$(".tabOffres").not(":first").hide();

		$("#offres a").click(function() {
			var idTab = $(this).attr("href");
			$(".tabOffres").hide();
			$("div[id='" + idTab + "']").fadeIn();
			return false;
		}); 
	});
</script>  