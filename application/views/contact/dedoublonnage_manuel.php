<div class="well"><h2>Dédoublonnage Manuel</h2></div>

<?php  
	
	$debug = 0;
	
	/*
	$post :
	 1 -> les 2 IDs passés en POST existent
	 0 -> pas d'ID passé en POST
	-1 -> au moins l'un des IDs passés en POST n'existe pas
	-2 -> les deux IDs passés sont identiques
	
	*/
	
	
	// On vérifie l'existance ou non de données passées en POST
	if(isset($_POST['ID1']) && isset($_POST['ID2'])) 
	{
		$ID1 = $_POST['ID1'];
		$ID2 = $_POST['ID2'];
		
		$ID1abs = 0;
		$ID2abs = 0;
		
		$post = 1;
		
		// Si l'ID1 n'est pas dans la BDD
		if(!isset($contact1[0]->CON_ID))
		{		
			$post = -1;
			$ID1abs = 1;
		}
		
		// Si l'ID2 n'est pas dans la BDD
		if(!isset($contact2[0]->CON_ID))
		{		
			$post = -1;
			$ID2abs = 1;
		}
		
		// Si l'utilisateur a entré deux fois le même ID
		if($ID1 == $ID2) $post = -2;
		
	}
	else $post = 0;
	
	// On affiche le résultat (si debug)
	if($debug) 
	{
		echo('<p>');
		if($post == 1) echo "Données existantes : \"{$_POST['ID1']}\" & \"{$_POST['ID2']}\"";
		else echo('Données inexistantes !');
		echo('</p>');
	}
	
	// Si il n'y a pas encore eu d'ID sélectionné, on affiche le formulaire de sélection :
	if($post <= 0)
	{
		echo('
			<pretty>
				<p>
					Pour fusionner les données d\'un doublon de contacts, veuillez entrer les deux IDs concernés ci dessous :
				</p>

				<form method="post" action="'.site_url("admin/dedoublonnage").'">
				<!-- <form method="post" action="./dedoublonnage"> -->
					<p>
						<input type="text" name="ID1" id="ID1" placeholder="Numéro Adhérent 1" required/>
						<input type="text" name="ID2" id="ID2" placeholder="Numéro Adhérent 2" required/>
						<input type="reset" value="Vider les champs" />
						
					</p>
			');
			
			if($post == -1)
			{
				if($ID1abs) echo('<p><strong>Le numéro d\'adhérent '.$ID1.' est inexisant !</strong></p>');
				if($ID2abs) echo('<p><strong>Le numéro d\'adhérent '.$ID2.' est inexisant !</strong></p>');
			}
			else if($post == -2) echo('
					<p>
						<strong>Les deux numéros d\'adhérent ne peuvent être identiques !</strong>
					</p>
			');			
			echo('
				   <input name= "is_form_sent1" type="hidden" value="true">
				   <input type="submit" value="Envoyer" />
				   
				</form>
				
			</pretty>
		');
	}
	
	// Si les IDs ont été sélectionnés, on affiche les données de chacun :
	else if($post == 1) 
	{
		echo('
			<pretty>
				<form method="post" action="'.site_url("admin/dedoublonnage").'">
					<table class="table table-striped">			
						
						<tr>
							<td><left><h3>'.'Numéro Adhérent'.'</h3></center></td>
							<td>'.$contact1[0]->CON_ID.'</td>
							<td> </td>
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
							<td> <input type="radio" name="choix_civilite" value=""> <input type="radio" name="choix_civilite" value=""> </td>
							'); else echo('<td></td>'); echo('
							<td>'.$contact2[0]->CON_CIVILITE.'</td>
						</tr>
						<tr>
							<td><left><h3>'.'Nom'.'</h3></center></td>
							<td>'.$contact1[0]->CON_LASTNAME.'</td>
							'); if($contact1[0]->CON_LASTNAME != $contact2[0]->CON_LASTNAME) echo('
							<td> <input type="radio" name="choix_nom" value=""> <input type="radio" name="choix_nom" value=""> </td>
							'); else echo('<td></td>'); echo('
							<td>'.$contact2[0]->CON_LASTNAME.'</td>
						</tr>
						<tr>
							<td><left><h3>'.'Prénom'.'</h3></center></td>
							<td>'.$contact1[0]->CON_FIRSTNAME.'</td>
							'); if($contact1[0]->CON_FIRSTNAME != $contact2[0]->CON_FIRSTNAME) echo('
							<td> <input type="radio" name="choix_prenom" value=""> <input type="radio" name="choix_prenom" value=""> </td>
							'); else echo('<td></td>'); echo('
							<td>'.$contact2[0]->CON_FIRSTNAME.'</td>
						</tr>
						<tr>
							<td><left><h3>'.'Date de naissance'.'</h3></center></td>
							<td>'.$contact1[0]->CON_DATE.'</td>
							'); if($contact1[0]->CON_DATE != $contact2[0]->CON_DATE) echo('
							<td> <input type="radio" name="choix_date" value=""> <input type="radio" name="choix_date" value=""> </td>
							'); else echo('<td></td>'); echo('
							<td>'.$contact2[0]->CON_DATE.'</td>
						</tr>
						<tr>
							<td><left><h3>'.'Adresse email'.'</h3></center></td>
							<td>'.$contact1[0]->CON_EMAIL.'</td>
							'); if($contact1[0]->CON_EMAIL != $contact2[0]->CON_EMAIL) echo('
							<td> <input type="radio" name="choix_email" value=""> <input type="radio" name="choix_email" value=""> </td>
							'); else echo('<td></td>'); echo('
							<td>'.$contact2[0]->CON_EMAIL.'</td>
						</tr>
						<tr>
							<td><left><h3>'.'Tel.Fixe'.'</h3></center></td>
							<td>'.$contact1[0]->CON_TELFIXE.'</td>
							'); if($contact1[0]->CON_TELFIXE != $contact2[0]->CON_TELFIXE) echo('
							<td> <input type="radio" name="choix_telfix" value=""> <input type="radio" name="choix_telfix" value=""> </td>
							'); else echo('<td></td>'); echo('
							<td>'.$contact2[0]->CON_TELFIXE.'</td>
						</tr>
						<tr>
							<td><left><h3>'.'Tel.Portable'.'</h3></center></td>
							<td>'.$contact1[0]->CON_TELPORT.'</td>
							'); if($contact1[0]->CON_TELPORT != $contact2[0]->CON_TELPORT) echo('
							<td> <input type="radio" name="choix_telport" value=""> <input type="radio" name="choix_telport" value=""> </td>
							'); else echo('<td></td>'); echo('
							<td>'.$contact2[0]->CON_TELPORT.'</td>
						</tr>
						<tr>
							<td><left><h3>'.'Type de personne'.'</h3></center></td>
							<td>'.$contact1[0]->CON_TYPE.'</td>
							'); if($contact1[0]->CON_TYPE != $contact2[0]->CON_TYPE) echo('
							<td> <input type="radio" name="choix_type" value=""> <input type="radio" name="choix_type" value=""> </td>
							'); else echo('<td></td>'); echo('
							<td>'.$contact2[0]->CON_TYPE.'</td>
						</tr>
						<tr>
							<td><left><h3>'.'Type de client'.'</h3></center></td>
							<td>'.$contact1[0]->CON_TYPEC.'</td>
							'); if($contact1[0]->CON_TYPEC != $contact2[0]->CON_TYPEC) echo('
							<td> <input type="radio" name="choix_typec" value=""> <input type="radio" name="choix_typec" value=""> </td>
							'); else echo('<td></td>'); echo('
							<td>'.$contact2[0]->CON_TYPEC.'</td>
						</tr>
						<tr>
							<td><left><h3>'.'Num. de voie'.'</h3></center></td>
							<td>'.$contact1[0]->CON_VOIE_NUM.'</td>
							'); if($contact1[0]->CON_VOIE_NUM != $contact2[0]->CON_VOIE_NUM) echo('
							<td> <input type="radio" name="choix_voienum" value=""> <input type="radio" name="choix_voienum" value=""> </td>
							'); else echo('<td></td>'); echo('
							<td>'.$contact2[0]->CON_VOIE_NUM.'</td>
						</tr>
						<tr>
							<td><left><h3>'.'Type de voie'.'</h3></center></td>
							<td>'.$contact1[0]->CON_VOIE_TYPE.'</td>
							'); if($contact1[0]->CON_VOIE_TYPE != $contact2[0]->CON_VOIE_TYPE) echo('
							<td> <input type="radio" name="choix_voietype" value=""> <input type="radio" name="choix_voietype" value=""> </td>
							'); else echo('<td></td>'); echo('
							<td>'.$contact2[0]->CON_VOIE_TYPE.'</td>
						</tr>
						<tr>
							<td><left><h3>'.'Nom de voie'.'</h3></center></td>
							<td>'.$contact1[0]->CON_VOIE_NOM.'</td>
							'); if($contact1[0]->CON_VOIE_NOM != $contact2[0]->CON_VOIE_NOM) echo('
							<td> <input type="radio" name="choix_voienom" value=""> <input type="radio" name="choix_voienom" value=""> </td>
							'); else echo('<td></td>'); echo('
							<td>'.$contact2[0]->CON_VOIE_NOM.'</td>
						</tr>
						<tr>
							<td><left><h3>'.'Boite postale'.'</h3></center></td>
							<td>'.$contact1[0]->CON_BP.'</td>
							'); if($contact1[0]->CON_BP != $contact2[0]->CON_BP) echo('
							<td> <input type="radio" name="choix_bp" value=""> <input type="radio" name="choix_bp" value=""> </td>
							'); else echo('<td></td>'); echo('
							<td>'.$contact2[0]->CON_BP.'</td>
						</tr>
						<tr>
							<td><left><h3>'.'Code Postal'.'</h3></center></td>
							<td>'.$contact1[0]->CON_CP.'</td>
							'); if($contact1[0]->CON_CP != $contact2[0]->CON_CP) echo('
							<td> <input type="radio" name="choix_cp" value=""> <input type="radio" name="choix_cp" value=""> </td>
							'); else echo('<td></td>'); echo('
							<td>'.$contact2[0]->CON_CP.'</td>
						</tr>
						<tr>
							<td><left><h3>'.'Ville'.'</h3></center></td>
							<td>'.$contact1[0]->CON_CITY.'</td>
							'); if($contact1[0]->CON_CITY != $contact2[0]->CON_CITY) echo('
							<td> <input type="radio" name="choix_city" value=""> <input type="radio" name="choix_city" value=""> </td>
							'); else echo('<td></td>'); echo('
							<td>'.$contact2[0]->CON_CITY.'</td>
						</tr>
						<tr>
							<td><left><h3>'.'Pays'.'</h3></center></td>
							<td>'.$contact1[0]->CON_COUNTRY.'</td>
							'); if($contact1[0]->CON_COUNTRY != $contact2[0]->CON_COUNTRY) echo('
							<td> <input type="radio" name="choix_country" value=""> <input type="radio" name="choix_country" value=""> </td>
							'); else echo('<td></td>'); echo('
							<td>'.$contact2[0]->CON_COUNTRY.'</td>
						</tr>
						<tr>
							<td><left><h3>'.'NPAI'.'</h3></center></td>
							<td>'.$contact1[0]->CON_NPAI.'</td>
							'); if($contact1[0]->CON_NPAI != $contact2[0]->CON_NPAI) echo('
							<td> <input type="radio" name="choix_npai" value=""> <input type="radio" name="choix_npai" value=""> </td>
							'); else echo('<td></td>'); echo('
							<td>'.$contact2[0]->CON_NPAI.'</td>
						</tr>
						<tr>
							<td><left><h3>'.'Fréquence d\'envoi RF'.'</h3></center></td>
							<td>'.$contact1[0]->CON_RF_TYPE.'</td>
							'); if($contact1[0]->CON_RF_TYPE != $contact2[0]->CON_RF_TYPE) echo('
							<td> <input type="radio" name="choix_rftype" value=""> <input type="radio" name="choix_rftype" value=""> </td>
							'); else echo('<td></td>'); echo('
							<td>'.$contact2[0]->CON_RF_TYPE.'</td>
						</tr>
						<tr>
							<td><left><h3>'.'Mode d\'envoi RF'.'</h3></center></td>
							<td>'.$contact1[0]->CON_RF_ENVOI.'</td>
							'); if($contact1[0]->CON_RF_ENVOI != $contact2[0]->CON_RF_ENVOI) echo('
							<td> <input type="radio" name="choix_rfenvoi" value=""> <input type="radio" name="choix_rfenvoi" value=""> </td>
							'); else echo('<td></td>'); echo('
							<td>'.$contact2[0]->CON_RF_ENVOI.'</td>
						</tr>
						<tr>
							<td><left><h3>'.'Solicitation'.'</h3></center></td>
							<td>'.$contact1[0]->CON_SOLICITATION.'</td>
							'); if($contact1[0]->CON_SOLICITATION != $contact2[0]->CON_SOLICITATION) echo('
							<td> <input type="radio" name="choix_solicitation" value=""> <input type="radio" name="choix_solicitation" value=""> </td>
							'); else echo('<td></td>'); echo('
							<td>'.$contact2[0]->CON_SOLICITATION.'</td>
						</tr>
						<tr>
							<td><left><h3>'.'Infos Complément.'.'</h3></center></td>
							<td>'.$contact1[0]->CON_COMPL.'</td>
							'); if($contact1[0]->CON_COMPL != $contact2[0]->CON_COMPL) echo('
							<td> <input type="radio" name="choix_compl" value=""> <input type="radio" name="choix_compl" value=""> </td>
							'); else echo('<td></td>'); echo('
							<td>'.$contact2[0]->CON_COMPL.'</td>
						</tr>
						<tr>
							<td><left><h3>'.'Commentaire'.'</h3></center></td>
							<td>'.$contact1[0]->CON_COMMENTAIRE.'</td>
							'); if($contact1[0]->CON_COMMENTAIRE != $contact2[0]->CON_COMMENTAIRE) echo('
							<td> <input type="radio" name="choix_commentaire" value=""> <input type="radio" name="choix_commentaire" value=""> </td>
							'); else echo('<td></td>'); echo('
							<td>'.$contact2[0]->CON_COMMENTAIRE.'</td>
						</tr>
					</table>
					<input type="submit" value="Fusionner" />
				</form>
			</pretty>
		');
	}
?>