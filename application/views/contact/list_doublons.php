<!--<div id="list_doublons">-->
	<?php
		$size_items=count($items,1);
		if($size_items==1)
		{
			echo('<div class="accordion" id="accordion2">');
			echo('<div class="accordion-heading">');
			echo('<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseOne">');
			echo('<div class="well"><h2>1 Similarité trouvée</h2></div></a></div>');
		}else{
			echo('<div class="accordion" id="accordion2">');
			echo('<div class="accordion-heading">');
			echo('<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseOne">');
			echo('<div class="well"><h2>'.$size_items.' similarités trouvées</h2></div></a></div>');
		}
		
		echo('<div id="collapseOne" class="accordion-body collapse in">');
		echo('<div class="accordion-inner">');
		echo('<table class="table table-striped">');
	
		echo('<tr>');
		echo('<td><center><h4>'.'Numéro Adhérent'.'</h4></center></td>');
		echo('<td><center><h4>'.'Nom'.'</h4></center></td>');
		echo('<td><center><h4>'.'Prénom'.'</h4></center></td>');
		echo('<td><center><h4>'.'Tel.Fixe'.'</h4></center></td>');
		echo('<td><center><h4>'.'Tel.Portable'.'</h4></center></td>');
		echo('<td><center><h4>'.'E-mail'.'</h4></center></td>');
		echo('</tr>');
		
		foreach($items as $contact) {		
			echo('<td><center><p id="plist">'.$contact->CON_ID.'</p></center></td>');
			echo('<td><a href="'.site_url('contact/edit').'/'.$contact->CON_ID.'"><center><p id="plist">'.$contact->CON_LASTNAME.'</p></a></center></td>');
			echo('<td><center><p id="plist">'.$contact->CON_FIRSTNAME.'</p></center></td>');
			echo('<td><center><p id="plist">'.$contact->CON_TELFIXE.'</p></center></td>');
			echo('<td><center><p id="plist">'.$contact->CON_TELPORT.'</p></center></td>');
			echo('<td><center><p id="plist">'.$contact->CON_EMAIL.'</p></center></td>');
			echo('</tr>');
		}
		
		echo('</div>');
		echo('</div>');
		echo('</div>');
	?>
	</table>	
<!--</div>-->

