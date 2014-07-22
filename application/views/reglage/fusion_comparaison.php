<div class="well" id="fusion_id_selection"><h2>Dédoublonnage Manuel</h2>
	
<?php
echo('
<pretty>
	<form method="post" action="'.site_url("admin/dedoublonnage").'">
		<table class="table table-striped">				
			<tr>
				<td><left><h3>'.'Numéro Adhérent'.'</h3></center></td>
				<td>'.$contact1[0]->CON_ID.'</td>
				<td></td>
				<td>'.$contact2[0]->CON_ID.'</td>
			</tr>
			<tr>
				<td><left><h3>'.'Date de création'.'</h3></center></td>
				<td>'.$contact1[0]->CON_DATEADDED.'</td>
				<td></td>
				<td>'.$contact2[0]->CON_DATEADDED.'</td>
			</tr>
			<tr>
				<td><left><h3>'.'Dernière modif.'.'</h3></center></td>
				<td>'.$contact1[0]->CON_DATEMODIF.'</td>
				<td></td>
				<td>'.$contact2[0]->CON_DATEMODIF.'</td>
			</tr>
			<tr>
				<td><left><h3>'.'Civilité'.'</h3></center></td>
				<td>'.$contact1[0]->CON_CIVILITE.'</td>
				'); if($contact1[0]->CON_CIVILITE != $contact2[0]->CON_CIVILITE) echo('
				<td> <input type="radio" name="choix_civilite" value="1" checked="checked"> <input type="radio" name="choix_civilite" value="2"> </td>
				'); else echo('<td> <input type="hidden" name="choix_civilite" value="1"> </td>'); echo('
				<td>'.$contact2[0]->CON_CIVILITE.'</td>
			</tr>
			<tr>
				<td><left><h3>'.'Nom'.'</h3></center></td>
				<td>'.$contact1[0]->CON_LASTNAME.'</td>
				'); if($contact1[0]->CON_LASTNAME != $contact2[0]->CON_LASTNAME) echo('
				<td> <input type="radio" name="choix_nom" value="1" checked="checked"> <input type="radio" name="choix_nom" value="2"> </td>
				'); else echo('<td> <input type="hidden" name="choix_nom" value="1"> </td>'); echo('
				<td>'.$contact2[0]->CON_LASTNAME.'</td>
			</tr>
			<tr>
				<td><left><h3>'.'Prénom'.'</h3></center></td>
				<td>'.$contact1[0]->CON_FIRSTNAME.'</td>
				'); if($contact1[0]->CON_FIRSTNAME != $contact2[0]->CON_FIRSTNAME) echo('
				<td> <input type="radio" name="choix_prenom" value="1" checked="checked"> <input type="radio" name="choix_prenom" value="2"> </td>
				'); else echo('<td> <input type="hidden" name="choix_prenom" value="1"> </td>'); echo('
				<td>'.$contact2[0]->CON_FIRSTNAME.'</td>
			</tr>
			<tr>
				<td><left><h3>'.'Date de naissance'.'</h3></center></td>
				<td>'.$contact1[0]->CON_DATE.'</td>
				'); if($contact1[0]->CON_DATE != $contact2[0]->CON_DATE) echo('
				<td> <input type="radio" name="choix_date" value="1" checked="checked"> <input type="radio" name="choix_date" value="2"> </td>
				'); else echo('<td> <input type="hidden" name="choix_date" value="1"> </td>'); echo('
				<td>'.$contact2[0]->CON_DATE.'</td>
			</tr>
			<tr>
				<td><left><h3>'.'Adresse email'.'</h3></center></td>
				<td>'.$contact1[0]->CON_EMAIL.'</td>
				'); if($contact1[0]->CON_EMAIL != $contact2[0]->CON_EMAIL) echo('
				<td> <input type="radio" name="choix_email" value="1" checked="checked"> <input type="radio" name="choix_email" value="2"> </td>
				'); else echo('<td> <input type="hidden" name="choix_email" value="1"> </td>'); echo('
				<td>'.$contact2[0]->CON_EMAIL.'</td>
			</tr>
			<tr>
				<td><left><h3>'.'Tel.Fixe'.'</h3></center></td>
				<td>'.$contact1[0]->CON_TELFIXE.'</td>
				'); if($contact1[0]->CON_TELFIXE != $contact2[0]->CON_TELFIXE) echo('
				<td> <input type="radio" name="choix_telfix" value="1" checked="checked"> <input type="radio" name="choix_telfix" value="2"> </td>
				'); else echo('<td> <input type="hidden" name="choix_telfix" value="1"> </td>'); echo('
				<td>'.$contact2[0]->CON_TELFIXE.'</td>
			</tr>
			<tr>
				<td><left><h3>'.'Tel.Portable'.'</h3></center></td>
				<td>'.$contact1[0]->CON_TELPORT.'</td>
				'); if($contact1[0]->CON_TELPORT != $contact2[0]->CON_TELPORT) echo('
				<td> <input type="radio" name="choix_telport" value="1" checked="checked"> <input type="radio" name="choix_telport" value="2"> </td>
				'); else echo('<td> <input type="hidden" name="choix_telport" value="1"> </td>'); echo('
				<td>'.$contact2[0]->CON_TELPORT.'</td>
			</tr>
			<tr>
				<td><left><h3>'.'Type de personne'.'</h3></center></td>
				<td>'.$contact1[0]->CON_TYPE.'</td>
				'); if($contact1[0]->CON_TYPE != $contact2[0]->CON_TYPE) echo('
				<td> <input type="radio" name="choix_type" value="1" checked="checked"> <input type="radio" name="choix_type" value="2"> </td>
				'); else echo('<td> <input type="hidden" name="choix_type" value="1"> </td>'); echo('
				<td>'.$contact2[0]->CON_TYPE.'</td>
			</tr>
			<tr>
				<td><left><h3>'.'Type de client'.'</h3></center></td>
				<td>'.$contact1[0]->CON_TYPEC.'</td>
				'); if($contact1[0]->CON_TYPEC != $contact2[0]->CON_TYPEC) echo('
				<td> <input type="radio" name="choix_typec" value="1" checked="checked"> <input type="radio" name="choix_typec" value="2"> </td>
				'); else echo('<td> <input type="hidden" name="choix_typec" value="1"> </td>'); echo('
				<td>'.$contact2[0]->CON_TYPEC.'</td>
			</tr>
			<tr>
				<td><left><h3>'.'Num. de voie'.'</h3></center></td>
				<td>'.$contact1[0]->CON_VOIE_NUM.'</td>
				'); if($contact1[0]->CON_VOIE_NUM != $contact2[0]->CON_VOIE_NUM) echo('
				<td> <input type="radio" name="choix_voienum" value="1" checked="checked"> <input type="radio" name="choix_voienum" value="2"> </td>
				'); else echo('<td> <input type="hidden" name="choix_voienum" value="1"> </td>'); echo('
				<td>'.$contact2[0]->CON_VOIE_NUM.'</td>
			</tr>
			<tr>
				<td><left><h3>'.'Type de voie'.'</h3></center></td>
				<td>'.$contact1[0]->CON_VOIE_TYPE.'</td>
				'); if($contact1[0]->CON_VOIE_TYPE != $contact2[0]->CON_VOIE_TYPE) echo('
				<td> <input type="radio" name="choix_voietype" value="1" checked="checked"> <input type="radio" name="choix_voietype" value="2"> </td>
				'); else echo('<td> <input type="hidden" name="choix_voietype" value="1"> </td>'); echo('
				<td>'.$contact2[0]->CON_VOIE_TYPE.'</td>
			</tr>
			<tr>
				<td><left><h3>'.'Nom de voie'.'</h3></center></td>
				<td>'.$contact1[0]->CON_VOIE_NOM.'</td>
				'); if($contact1[0]->CON_VOIE_NOM != $contact2[0]->CON_VOIE_NOM) echo('
				<td> <input type="radio" name="choix_voienom" value="1" checked="checked"> <input type="radio" name="choix_voienom" value="2"> </td>
				'); else echo('<td> <input type="hidden" name="choix_voienom" value="1"> </td>'); echo('
				<td>'.$contact2[0]->CON_VOIE_NOM.'</td>
			</tr>
			<tr>
				<td><left><h3>'.'Boite postale'.'</h3></center></td>
				<td>'.$contact1[0]->CON_BP.'</td>
				'); if($contact1[0]->CON_BP != $contact2[0]->CON_BP) echo('
				<td> <input type="radio" name="choix_bp" value="1" checked="checked"> <input type="radio" name="choix_bp" value="2"> </td>
				'); else echo('<td> <input type="hidden" name="choix_bp" value="1"> </td>'); echo('
				<td>'.$contact2[0]->CON_BP.'</td>
			</tr>
			<tr>
				<td><left><h3>'.'Code Postal'.'</h3></center></td>
				<td>'.$contact1[0]->CON_CP.'</td>
				'); if($contact1[0]->CON_CP != $contact2[0]->CON_CP) echo('
				<td> <input type="radio" name="choix_cp" value="1" checked="checked"> <input type="radio" name="choix_cp" value="2"> </td>
				'); else echo('<td> <input type="hidden" name="choix_cp" value="1"> </td>'); echo('
				<td>'.$contact2[0]->CON_CP.'</td>
			</tr>
			<tr>
				<td><left><h3>'.'Ville'.'</h3></center></td>
				<td>'.$contact1[0]->CON_CITY.'</td>
				'); if($contact1[0]->CON_CITY != $contact2[0]->CON_CITY) echo('
				<td> <input type="radio" name="choix_city" value="1" checked="checked"> <input type="radio" name="choix_city" value="2"> </td>
				'); else echo('<td> <input type="hidden" name="choix_city" value="1"> </td>'); echo('
				<td>'.$contact2[0]->CON_CITY.'</td>
			</tr>
			<tr>
				<td><left><h3>'.'Pays'.'</h3></center></td>
				<td>'.$contact1[0]->CON_COUNTRY.'</td>
				'); if($contact1[0]->CON_COUNTRY != $contact2[0]->CON_COUNTRY) echo('
				<td> <input type="radio" name="choix_country" value="1" checked="checked"> <input type="radio" name="choix_country" value="2"> </td>
				'); else echo('<td> <input type="hidden" name="choix_country" value="1"> </td>'); echo('
				<td>'.$contact2[0]->CON_COUNTRY.'</td>
			</tr>
			<tr>
				<td><left><h3>'.'NPAI'.'</h3></center></td>
				<td>'.$contact1[0]->CON_NPAI.'</td>
				'); if($contact1[0]->CON_NPAI != $contact2[0]->CON_NPAI) echo('
				<td> <input type="radio" name="choix_npai" value="1" checked="checked"> <input type="radio" name="choix_npai" value="2"> </td>
				'); else echo('<td> <input type="hidden" name="choix_npai" value="1"> </td>'); echo('
				<td>'.$contact2[0]->CON_NPAI.'</td>
			</tr>
			<tr>
				<td><left><h3>'.'Fréquence d\'envoi RF'.'</h3></center></td>
				<td>'.$contact1[0]->CON_RF_TYPE.'</td>
				'); if($contact1[0]->CON_RF_TYPE != $contact2[0]->CON_RF_TYPE) echo('
				<td> <input type="radio" name="choix_rftype" value="1" checked="checked"> <input type="radio" name="choix_rftype" value="2"> </td>
				'); else echo('<td> <input type="hidden" name="choix_rftype" value="1"> </td>'); echo('
				<td>'.$contact2[0]->CON_RF_TYPE.'</td>
			</tr>
			<tr>
				<td><left><h3>'.'Mode d\'envoi RF'.'</h3></center></td>
				<td>'.$contact1[0]->CON_RF_ENVOI.'</td>
				'); if($contact1[0]->CON_RF_ENVOI != $contact2[0]->CON_RF_ENVOI) echo('
				<td> <input type="radio" name="choix_rfenvoi" value="1" checked="checked"> <input type="radio" name="choix_rfenvoi" value="2"> </td>
				'); else echo('<td> <input type="hidden" name="choix_rfenvoi" value="1"> </td>'); echo('
				<td>'.$contact2[0]->CON_RF_ENVOI.'</td>
			</tr>
			<tr>
				<td><left><h3>'.'Solicitation'.'</h3></center></td>
				<td>'.$contact1[0]->CON_SOLICITATION.'</td>
				'); if($contact1[0]->CON_SOLICITATION != $contact2[0]->CON_SOLICITATION) echo('
				<td> <input type="radio" name="choix_solicitation" value="1" checked="checked"> <input type="radio" name="choix_solicitation" value="2"> </td>
				'); else echo('<td> <input type="hidden" name="choix_solicitation" value="1"> </td>'); echo('
				<td>'.$contact2[0]->CON_SOLICITATION.'</td>
			</tr>
			<tr>
				<td><left><h3>'.'Complément.'.'</h3></center></td>
				<td>'.$contact1[0]->CON_COMPL.'</td>
				'); if($contact1[0]->CON_COMPL != $contact2[0]->CON_COMPL) echo('
				<td> <input type="radio" name="choix_compl" value="1" checked="checked"> <input type="radio" name="choix_compl" value="2"> </td>
				'); else echo('<td> <input type="hidden" name="choix_compl" value="1"> </td>'); echo('
				<td>'.$contact2[0]->CON_COMPL.'</td>
			</tr>
			<tr>
				<td><left><h3>'.'Commentaire'.'</h3></center></td>
				<td>'.$contact1[0]->CON_COMMENTAIRE.'</td>
				'); if($contact1[0]->CON_COMMENTAIRE != $contact2[0]->CON_COMMENTAIRE) echo('
				<td> <input type="radio" name="choix_commentaire" value="1" checked="checked"> <input type="radio" name="choix_commentaire" value="2"> </td>
				'); else echo('<td> <input type="hidden" name="choix_commentaire" value="1"> </td>'); echo('
				<td>'.$contact2[0]->CON_COMMENTAIRE.'</td>
			</tr>');
			
			foreach($ic_array as $i => $value)
			{
				echo('<tr>
					<td><left><h3>'.${$value}.'</h3></center></td>
					<td>'.$ic_contact1[0][$value].'</td>
					'); if($ic_contact1[0][$value] != $ic_contact2[0][$value]) echo('
					<td> <input type="radio" name="choix_'.$value.'" value="1" checked="checked"> <input type="radio" name="choix_'.$value.'" value="2"> </td>
					'); else echo('<td> <input type="hidden" name="choix_'.$value.'" value="1"> </td>'); echo('
					<td>'.$ic_contact2[0][$value].'</td>
				</tr>');
			}	
			
		echo('	
		</table>
		<input name= "ID1" type="hidden" value="'.$contact1[0]->CON_ID.'">
		<input name= "ID2" type="hidden" value="'.$contact2[0]->CON_ID.'">
		<input name= "is_form_sent2" type="hidden" value="true">
		<button type="submit" class="btn">Fusionner</button>
	</form>
</pretty>
'); ?>

</div>