<div id="list">
	<table class="table table-striped">
	<?php 
		
		echo('<tr>');
			echo('<td>'.'Champs'.'</td>');
			echo('<td>'.'Données ajoutées'.'</td>');
		echo('</tr>');
		$nonVide = 0;
		foreach($reglages as $count){
			if ($count->REG_LIST != ''){
				$nonVide = 1;
			}
		}
		if ($nonVide==0){
			echo "Vous n'avez pas encore ajouté de critère personnalisé";
		}
		foreach($reglages as $reglage) 
			{	
				echo('<tr>');		
					echo('<td> <a href="'.site_url('admin/editReg/'.$reglage->REG_CODE).'">'.$reglage->REG_DESCRIP.'</a></td>');
					echo('<td>'.$reglage->REG_LIST.'</td>');
				echo('</tr>');
			}
		
	?>
	</table>
</div>