<div class="well">
	<legend>Versements</legend>
	
	<div class="tabbable" id="dons">
		<ul class="nav nav-tabs">
			<li><a href="#by_year" >/ année</a></li>
			<li><a href="#by_month" >/ mois</a></li>
			<li><a href="#by_type" >/ type</a></li>
			<li><a href="#by_mode" >/ mode</a></li>
		</ul>
	</div>
	
	<div class="tabDons" id="by_year">
		<div id="nb_dons_by_year"></div>
	</div>
	<div class="tabDons" id="by_month">
		<div id="nb_dons_by_month"></div>
	</div>
	<div class="tabDons" id="by_type">
		<div id="nb_versements_by_type"></div>
	</div>
	<div class="tabDons" id="by_mode">
		<div id="nb_versements_by_mode"></div>
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


	$(function () {  
		var data = [  
			{ 
				data: [<?php
				$i = 0;
				foreach($cols_versements_by_month as $col){
					echo ("[".$i.", '".$rows_versements_by_month[$col]."'],");
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
				foreach($cols_versements_by_month as $col){
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
		var nb_dons_by_month = $("#nb_dons_by_month");  
		nb_dons_by_month.css("height", "250px");  
		nb_dons_by_month.css("width", "500px");  
		$.plot( nb_dons_by_month , data, options );  
	});
	
	$(function () {  
		var data = [  
				<?php
				$i = 0;
				foreach($cols_versements_by_type as $col){
					echo (' {label: "'.$col.'", data:'.$rows_versements_by_type[$col].'}, ');
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
		var nb_versements_by_type = $("#nb_versements_by_type");  
		nb_versements_by_type.css("height", "250px");  
		nb_versements_by_type.css("width", "500px");  
		$.plot( nb_versements_by_type , data, options );  
	});
	
	$(function () {  
		var data = [  
				<?php
				$i = 0;
				foreach($cols_versements_by_mode as $col){
					echo (' {label: "'.$col.'", data:'.$rows_versements_by_mode[$col].'}, ');
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
		var nb_versements_by_mode = $("#nb_versements_by_mode");  
		nb_versements_by_mode.css("height", "250px");  
		nb_versements_by_mode.css("width", "500px");  
		$.plot( nb_versements_by_mode , data, options );  
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