<div class="well">
	<legend>Offres</legend>
	
	<div class="tabbable" id="offres">
		<ul class="nav nav-tabs">
			<li><a href="#by_year_o" >/ année</a></li>
			<li><a href="#by_month_o" >/ mois</a></li>
			<li><a href="#by_offre_o" >dons / offre </a></li>
		</ul>
	</div>


	<div class="tabOffres" id="by_year_o">
		<div id="nb_offres_by_year"></div>
	</div>
	<div class="tabOffres" id="by_month_o">
		<div id="nb_offres_by_month"></div>
	</div>
	<div class="tabOffres" id="by_offre_o">
		<div id="nb_dons_by_offre"></div>
	</div>
</div>

<script language="javascript" type="text/javascript">  
	$(function () {  
		var data = [  
			{
				label: 'offres / année',
				color: '#1E90FF',
				data: [<?php
				$i = 0;
				foreach($cols_offres_by_year as $col){
					echo ("[".$i.", '".$rows_offres_by_year[$col]."'],");
					$i = $i + 1;
				}
				?>]
					
			},
			<?php 
			if($exp_offre == "valeur"){
			?>
			{ 
				label: 'objectif',
				color: '#CD5C5C',
				data: [<?php
				$i = 0;
				foreach($cols_offres_by_year as $col){
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
				foreach($cols_offres_by_year as $col){
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
		var nb_offres_by_year = $("#nb_offres_by_year");  
		nb_offres_by_year.css("height", "250px");  
		nb_offres_by_year.css("width", "500px");  
		$.plot( nb_offres_by_year , data, options );
	});

/*
$(function () {  
		var data = [  
			{
				label: 'offres / mois',
				color: '#1E90FF',
				data: [<?php
				$i = 0;
				foreach($cols_offres_by_month as $col){
					echo ("[".$i.", '".$rows_offres_by_month[$col]."'],");
					$i = $i + 1;
				}
				?>]
					
			},
			<?php 
			if($exp_offre == "valeur"){
			?>
			{ 
				label: 'objectif',
				color: '#CD5C5C',
				data: [<?php
				$i = 0;
				foreach($cols_offres_by_month as $col){
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
				foreach($cols_offres_by_month as $col){
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
		var nb_offres_by_month = $("#nb_offres_by_month");  
		nb_offres_by_month.css("height", "250px");  
		nb_offres_by_month.css("width", "500px");  

		$.plot( nb_offres_by_month , data, options );
	});
*/


	$(function () {  
		var data = [  
			{ 
				data: [<?php
				$i = 0;
				foreach($cols_offres_by_month as $col){
					echo ("[".$i.", '".$rows_offres_by_month[$col]."'],");
					$i = $i + 1;
				}
				?>]
					
			}  
		];  
		var options = {
			xaxis: {
				ticks: [<?php
				$i = 0;
				foreach($cols_offres_by_month as $col){
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
			}
		};  
		var nb_offres_by_month = $("#nb_offres_by_month");  
		nb_offres_by_month.css("height", "250px");  
		nb_offres_by_month.css("width", "500px");  
		$.plot( nb_offres_by_month , data, options );  
	});
	
	 $(function () {  
		var data = [  
				<?php
				$i = 0;
				foreach($cols_dons_by_offre as $col){
					echo (' {label: "'.$col.'", data:'.$rows_dons_by_offre[$col].'}, ');
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
						formatter: function (label, series) { return '<div style="font-size:8pt;text-align:center;padding:5px;color:white;">' + label + '<br/>' + Math.round(series.percent) + '%</div>'; },
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
		var nb_dons_by_offre = $("#nb_dons_by_offre");  
		nb_dons_by_offre.css("height", "250px");  
		nb_dons_by_offre.css("width", "500px");  
		$.plot( nb_dons_by_offre , data, options );  
	});
	
	/*$(function () {  
		var data = [  
				<?php
				$i = 0;
				foreach($cols_dons_by_offre as $col){
					echo (' {label: "'.(string)$col.'", data:'.$rows_dons_by_offre[$col].'}, ');
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
						formatter: function (label, series) { return '<div style="font-size:8pt;text-align:center;padding:5px;color:white;">' + label + '<br/>' + (string)Math.round(series.percent) + '%</div>'; },
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
		var nb_dons_by_offre = $("#nb_dons_by_offre");  
		nb_dons_by_offre.css("height", "250px");  
		nb_dons_by_offre.css("width", "500px");  
		$.plot( nb_dons_by_offre , data, options );  
	});*/

$(document).ready(function(){
		$(".tabOffres").each(function(i){
			this.id = "#" + this.id;
		});

		$(".tabOffres:not(:first)").hide();
		$(".tabOffres").not(":first").hide();

		$("#offres a").click(function() {
			var idTab_of = $(this).attr("href");
			$(".tabOffres").hide();
			$("div[id='" + idTab_of + "']").fadeIn();
			return false;
		}); 
	});
</script>  