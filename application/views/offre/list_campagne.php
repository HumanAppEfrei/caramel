<?php if($div == "oui") echo('<div id="list">'); 
	else{
		echo('<div class="well"><h2>Offres rattachées à la campagne : '.$campagne[0]->CAM_NOM.'</h2></div>');
		echo('<div><a class="btn" href="'.site_url('offre/create').'/'.$campagne[0]->CAM_ID.'">Ajouter une nouvelle offre</a></div><br/>');
	}
	?>
	<?php 
		if (count($items)==0)
			echo ('0 resultat trouvé');
	?>
	<table class="table table-striped">
	<?php 
	
		echo('<tr>');
		echo('<td></td><td></td>');
			echo('<td><center><h3>'.'Code'.'</center></h3></td>');
			echo('<td><center><h3>'.'Titre de l\'offre'.'</center></h3></td>');
			echo('<td><center><h3>'.'Date de fin'.'</center></h3></td>');
		echo('</tr>');
		foreach($items as $offre) 
		{		
				echo('<td> <a href="'.site_url('offre/edit').'/'.$offre->OFF_ID.'"><center> <img src="'.img_url('icons/edit.png').'"/> </a></center> </td>');
				echo('<td> <a href="'.site_url('offre/remove').'/'.$offre->OFF_ID.'" onclick="if(window.confirm(\'Etes vous sur ?\')){return true;}else{return false;}"> <center><img src="'.img_url('icons/drop.png').'"/> </a></center> </td>');
				echo('<td><center><p id="plist">'.$offre->OFF_ID.'</p></center></td>');
				echo('<td><center><a href="'.site_url('offre/edit').'/'.$offre->OFF_ID.'"><p id="plist"><p id="plist">'.$offre->OFF_NOM.'</p></a></center></td>');
				echo('<td><center><p id="plist">'.date_usfr($offre->OFF_FIN).'</p></center></td>');
			echo('</tr>');
		}
	?>
	</table>
</div>