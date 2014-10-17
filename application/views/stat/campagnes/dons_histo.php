<div class="well">
	<legend>Dons</legend>
	<div class="tabbable" id="dons">
		<ul class="nav nav-tabs">
			<li><a href="#nb_dons_by_year" >Nombre de dons / annnée</a></li>
			<li><a href="#nb_dons_by_month" >Nombre de dons / mois</a></li>
		</ul>
	</div>
	<div class="tabDons" id="nb_dons_by_year"></div>
	<div class="tabDons" id="nb_dons_by_month"></div>
</div>

<script language="javascript" type="text/javascript">  
	$(function () {  
		var data = [  
			{ 
				data: [<?php
				$i = 0;
				foreach($cols_nb_dons_by_year as $col){
					echo ("[".$i.", '".$rows_nb_dons_by_year[$col]."'],");
					$i = $i + 1;
				}
				?>]
					
			}  
		];  
		var options = {
			xaxis: {
				ticks: [<?php
				$i = 0;
				foreach($cols_nb_dons_by_year as $col){
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
				foreach($cols_nb_dons_by_month as $col){
					echo ("[".$i.", '".$rows_nb_dons_by_month[$col]."'],");
					$i = $i + 1;
				}
				?>]
					
			}  
		];  
		var options = {
			xaxis: {
				ticks: [<?php
				$i = 0;
				foreach($cols_nb_dons_by_month as $col){
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
		var nb_dons_by_month = $("#nb_dons_by_month");  
		nb_dons_by_month.css("height", "250px");  
		nb_dons_by_month.css("width", "500px");  
		$.plot( nb_dons_by_month , data, options );  
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