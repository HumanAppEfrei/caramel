<div id="list">

	<h2>Ajout de critère au segment <?php echo $segCode;?></h2>

	<table class="table table-striped">
	
	
		<tr>
			<td>Contrainte</td>
			<td>Comparaison</td>
			<td>Valeur</td>
		</tr>
		
	<form method="post" name="editSegment" id="form" <?php echo ('action="'.site_url("segment/addCritere/".$segCode."/".$ID_prevCrit).'"'); ?> >
	
	<input name= "is_form_sent" type="hidden" value="true">
	<input id="valeurCOMEBACK" name="valeurCOMEBACK" type="hidden">
	
		<tr>
			<td>
				
				<select id='contrainte' name="contrainte" size=22 required>
			
				<optgroup label="Attribut contact">
					<option value='CON_ID'>Numéro d'adhérent</option>
					<option value='CON_DATE'>Date de naissance</option>
					<option value='CON_TYPE'>Type de personne</option>
					<option value='CON_TYPEC'>Type de client</option>
					<option value='CON_CITY'>Ville</option>
					<option value='CON_COUNTRY'>Pays</option>
					<option value='departement'>Département</option>
					<option value='CON_NPAI'>NPAI</option>
					<option value='CON_DATEADDED'>Date d'inscription</option>
				</optgroup>	
				
				<optgroup label="Informations Complémentaires">
					<?php
						foreach($list_IC as $IC)
						{
							echo "<option value='".$IC->IC_ID.'/'.$IC->IC_TYPE."'>".$IC->IC_LABEL."</option>";
						}
					
					?>
				</optgroup>
				
				<optgroup label="Suivi contact">
					<option value='dateVersement'>Date dernier versement</option>
				</optgroup>
				
				<optgroup label="Statistique">
					<option value='NbDon'>Nombre de Don</option>
					<option value='DonMoyen'>Don moyen</option>
					<option value='TotalDon'>Total de dons</option>
				</optgroup>
				
				<optgroup label="Segmentation">
					<option value='segment'>Ajouter un segment déjà existant</option>
				</optgroup>

				</select>
			</td>
			
			<td>
				<select id='comparaison' name="comparaison" required>
					---
				</select>
			</td>
			
			<td id='val'>
			
				<?php	
					echo form_error('valeurCOMEBACK');
					if(isset($erreur)) echo $erreur;
				?>
			</td>
		</tr>
		<p>
			<a href="<?php echo site_url('segment/edit/'.$segCode)?>"><input type="button" value="Retour"/></a>    
			<input type="submit" value="Valider"/>
		</p>
	</form>
	</table>
	
</div>

<script>
	var Options_type_contact ="<?php echo $Options_type_contact; ?>";
</script>

<script language="Javascript" SRC="<?php echo base_url().'assets/javascript/jquery.js'?>" ></script>
<script language="Javascript" SRC="<?php echo base_url().'assets/javascript/addCritere.js'?>" ></script>
