<?php
if(empty($items))
		{
		
			echo "Votre liste d'offres associées est vide.<br/>Il peut s'agir d'une erreur system ou d'une erreur dans vos segment lié aux offres.";
		
		}else{
			if($div == "oui") echo('<div id="list">'); 
			else{
		echo('<div class="well"><h2>Offres rattachées au contact : '.$contact[0]->CON_FIRSTNAME.' '.$contact[0]->CON_LASTNAME.'</h2></div>');
		$percent = $nb_reponses*100/$nb_offres;
		echo('<div><div class="pull-right"><table class="table table-striped">
		<tr><td>Pourcentage de réponse aux offres = '.number_format($percent,2).'% &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp </td>  <td>Nombre de réponses aux offres = '.$nb_reponses.'&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp </td> <td>Nombre d\'offres rattachées au contact = '.$nb_offres.'<td></td><td></td><td></td><td></td><td></td></tr></table></div></div>');
	}
	?>
	<?php 
		if (count($items)==0)
			echo ('0 resultat trouve');
	?>
	<table class="table table-striped">
	<?php 
	
		echo('<tr>');
			echo('<td><center><h3>'.'Code'.'</center></h3></td>');
			echo('<td><center><h3>'.'Titre de l\'offre'.'</center></h3></td>');
			echo('<td><center><h3>'.'Montant de la réponse'.'</center></h3></td>');
			echo('<td><center><h3>'.'Date de fin'.'</center></h3></td>');
		echo('</tr>');
		foreach($items as $offre) 
		{		
				echo('<td><center><p id="plist">'.$offre->OFF_ID.'</p></center></td>');
				echo('<td><center><a href="'.site_url('offre/edit').'/'.$offre->OFF_ID.'"><p id="plist"><p id="plist">'.$offre->OFF_NOM.'</p></a></center></td>');
				if(isset($offre->DON_MONTANT))
				{
					echo('<td><center><a href="'.site_url('don/edit').'/'.$offre->DON_ID.'"><p id="plist">'.$offre->DON_MONTANT.' euros</p></a></center></td>');
				}
				else
				{
					echo('<td><center><p id="plist">NON</p></center></td>');

				}
				echo('<td><center><p id="plist">'.date_usfr($offre->OFF_FIN).'</p></center></td>');
			echo('</tr>');
		}
	}
	?>
	</table>

</div>