<div id="list">
	
	
	
	<div class="message"><p><h2>Cible potentielle du Segment : <?php echo($segment)?> 
<!--	<span class='right'>
	<a href="<?php echo site_url('cible/search')."/".$offre->OFF_ID?>"><input type="button" value="Ajouter des éléments à la cible" class='right'/></a>
	</span> -->
	</h2></p></div>
	
	<?php
		
		if(empty($items))
		{
		
			echo "Votre cible est vide.<br/>Il peut s'agir d'une erreur system ou d'une erreur dans votre définition du segment en question.";
		
		}else{

			//$percent = $nb_reponses*100/$nb_cibles;
			/*echo('<div><div class="pull-right"><table class="table table-striped">
		<tr><td>Pourcentage de réponse aux offres = '.number_format($percent,2).'% &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp </td>  <td>Nombre de réponses aux offres = '.$nb_reponses.'&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp </td> <td>Nombre d\'offres rattachées au contact = '.$nb_cibles.' <td></td><td></td><td></td><td></td><td></td></tr></table></div></div>*/
		echo('<table class="table table-striped">');


			echo('<tr>');
			//echo('<td> </td>');
			echo('<td><center><h3>'.'Numéro Adéhrent'.'</h3></center></td>');
			echo('<td><center><h3>'.'Nom'.'</h3></center></td>');
			echo('<td><center><h3>'.'Prénom'.'</h3></center></td>');
			//echo('<td><center><h3>'.'A répondu à l\'offre'.'</h3></center></td>');
		echo('</tr>');
		foreach($items as $contact) {		
				//echo('<td> <a href="'.site_url('cible/remove').'/'.$offre->OFF_ID."/".$contact->CON_ID.'" onclick="if(window.confirm('."'Supprimer de la cible?'".')){return true;}else{return false;}"> <img src="'.img_url('icons/drop.png').'"/> </a> </td>');
				echo('<td><center><p id="plist"><a href="'.site_url('contact/edit').'/'.$contact->CON_ID.'">'.$contact->CON_ID.'</a></p></center></td>');
				echo('<td><center><p id="plist">'.$contact->CON_LASTNAME.'</p></center></td>');
				echo('<td><center><p id="plist">'.$contact->CON_FIRSTNAME.'</p></center></td>');
				//if(isset($contact->DON_MONTANT))
				//{
				//	echo('<td><center><a href="'.site_url('don/edit').'/'.$contact->DON_ID.'"><p id="plist">'.$contact->DON_MONTANT.' euros</p></a></center></td>');
	
				//}
				//else
				//{
				//	echo('<td><center><p id="plist">NON</p></center></td>');
				//}

				echo('</tr>');
			}
		}
		
	?>
	</table>

	<!--
	<div id = "page">
		<?php for($i = 1 ; $i <= $numPages ; ++$i): ?>
		<a href="/contact/"<?php echo $i; ?>"><?php echo $i . '-'; ?></a>
		<?php endfor; ?>
	</div>-->
	
</div>