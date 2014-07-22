<div id="search">

	<div class="well"><h2>Recherche de versements </h2></div>
	
	<form class="form-horizontal" method="post" name="searchDon" <?php echo ('action="'.site_url("don/search").'"'); ?>>
	
		<input name= "is_form_sent" type="hidden" value="true">
		
		<div class="inline-block">
			<div class="inner-block">
			<pretty> 
				<div class="control-group">
				<label class="control-label" for="Civilite">Code du versement</label>
				<div class="controls">
				<input type="text" name="code" value="<?php echo set_value('code'); ?>" />
				<?php echo form_error('code'); ?>
			</div>
			</div>
			</pretty>
			
			<pretty> 
				<div class="control-group">
				<label class="control-label" for="Civilite">Identifiant contact</label>
				<div class="controls">
				<input type="text" name="codeCon" value="<?php echo set_value('codeCon'); ?>" />
				<?php echo form_error('codeCon'); ?>
				</div>
				</div>
				<div class="control-group">
				<label class="control-label" for="Civilite">Nom du donateur</label>
				<div class="controls">
				<input type="text" name="nomCon" value="<?php echo set_value('nomCon'); ?>" />
				<?php echo form_error('nomCon'); ?>
				</div>
				</div>
				<div class="control-group">
				<label class="control-label" for="Civilite">Prénom du donateur</label>
				<div class="controls">
				<input type="text" name="prenomCon" value="<?php echo set_value('prenomCon'); ?>" />
				<?php echo form_error('prenomCon'); ?>
				</div>
				</div>
			</pretty>

			<pretty>
				<div class="control-group">
					<label class="control-label" for="Civilite">Type de versement</label>
					<div class="controls">
					<select name="type" id="type">
						<option value="" <?php if(set_value('type') == "") echo'selected ' ?>></option>
						<option value="don" <?php if(set_value('type') == "don") echo'selected ' ?>>Don</option>
						<option value="cotisation" <?php if(set_value('type') == "cotisation") echo'selected ' ?>>Cotisation</option>
						<option value="achat" <?php if(set_value('type') == "achat") echo'selected ' ?>>Achat</option>
						<option value="abonnement" <?php if(set_value('type') == "abonnement") echo'selected ' ?>>Abonnement</option>
						<option value="autre" <?php if(set_value('type') == "autre") echo'selected ' ?>>Autre</option>
					</select>
					</div>
				</div>
			</pretty>


			<legend><h4>Montant du versement (€)</h4></legend>
			<pretty>
			<div class="control-group">
				<label class="control-label" for="Civilite">de</label>
				<div class="controls">
					<input type="text" name="min" value="<?php echo set_value('min'); ?>" /><br/>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="Civilite">à</label>
				<div class="controls">
					<input type="text" name="max" value="<?php echo set_value('max'); ?>" /><br/>
				</div>
			</div>
			<?php echo form_error('min'); ?>
			<?php echo form_error('max'); ?>
			</pretty>
			</div>
		</div>

		<div class="inline-block">
			<div class="inner-block">
			<pretty>
				<div class="control-group">
				<label class="control-label" for="Civilite">Mode de paiement</label>
				<div class="controls">
				<select name="mode" id="mode">
					<option value="" <?php if(set_value('mode') == "") echo'selected ' ?>></option>
					<option value="carte" <?php if(set_value('mode') == "carte") echo'selected ' ?>>Carte bleue</option>
					<option value="cheque" <?php if(set_value('mode') == "cheque") echo'selected ' ?>>Chèque</option>
					<option value="espece" <?php if(set_value('mode') == "espece") echo'selected ' ?>>Espèce</option>
					<option value="virement" <?php if(set_value('mode') == "virement") echo'selected ' ?>>Virement</option>
				</select>
				</div>
				</div>
			</pretty>
			
			<pretty>
				<div class="control-group">
				<label class="control-label" for="Civilite">Répond à l'offre</label>
				<div class="controls">
				<select name="offre" value="<?php echo set_value('offre'); ?>" >
					<option value="" <?php if(set_value('offre') == "") echo'selected ' ?>></option>
					<option value="aucune" <?php if(set_value('offre') == "aucune") echo'selected ' ?>>Aucune</option>
				<?php foreach($list_offres as $offre)
				{
					echo "<option value='".$offre->OFF_ID."'>".$offre->OFF_ID." : ".$offre->OFF_NOM."</option>";
				}
				?>
				</select>
				</div>
				</div>
			</pretty>
			</div>
		</div>

		<div id="searchPattern"><button type="submit" class="btn">Rechercher</button></div>
		<div id="clear"></div>
	</form>
</div>