<div id="search">

	<div class="well"><h2>Recherche de contacts </h2></div> 
	
	<form class="form-horizontal" method="post" name="searchContact" <?php echo ('action="'.site_url("contact/search").'"'); ?>>
	
		<input name= "is_form_sent" type="hidden" value="true">
		
		<div class="inline-block">
			<div class="inner-block">
			<legend><h4>Informations générales</h4></legend>
			
			<pretty>
				<div class="control-group">
				<label class="control-label" for="id">Identifiant contact</label>
				<div class="controls">
				<input type="text" name="numAd" value="<?php echo set_value('numAd'); ?>" >
				<?php echo form_error('numAd'); ?>
				</div>
				</div>
			</pretty>
			
			<pretty>
				<div class="control-group">
				<label class="control-label" for="id">Type de personne</label>
				<div class="controls">
				<select name="type" value="<?php echo set_value('type'); ?>" >
					<option value="" <?php if(set_value('type') == "") echo'selected' ?>></option>
					<option value="physique" <?php if(set_value('type') == "physique") echo'selected' ?>>Physique</option>
					<option value="moral" <?php if(set_value('type') == "moral") echo'selected' ?>>Morale</option>
				</select>
				</div>
				</div>
				
				<div class="control-group">
				<label class="control-label" for="id">Type de contact</label>
				<div class="controls">
				<select name="typeC" value="<?php echo set_value('typeC'); ?>" >
					<option value="" <?php if(set_value('typeC') == "donateur") echo'selected ' ?>></option>
					<option value="donateur" <?php if(set_value('typeC') == "donateur") echo'selected ' ?>>Donateur</option>
					<option value="prospect" <?php if(set_value('typeC') == "prospect") echo'selected ' ?>>Prospect</option>
					<option value="benevole" <?php if(set_value('typeC') == "benevole") echo'selected ' ?>>Benevole</option>
					<option value="entreprise" <?php if(set_value('typeC') == "entreprise") echo'selected ' ?>>Entreprise</option>
					<option value="association" <?php if(set_value('typeC') == "association") echo'selected ' ?>>Association</option>
					<option value="ong" <?php if(set_value('typeC') == "ong") echo'selected ' ?>>ONG</option>
				</select>
				</div>
				</div>
			</pretty>
			
			<pretty>
				<div class="control-group">
				<label class="control-label" for="id">Sexe</label>
				<div class="controls">
				<select name="sexe" id="sexe">
					<option value=""></option>
					<option value="homme">Homme</option>
					<option value="femme">Femme</option>
				</select> 
				</div>
				</div>
				<div class="control-group">
				<label class="control-label" for="id">Prénom</label>
				<div class="controls">
				<input type="text" name="firstname" value="<?php echo set_value('firstname'); ?>" maxlength="38" >
				</div>
				</div>
				<div class="control-group">
				<label class="control-label" for="id">Nom</label>
				<div class="controls">
				<input type="text" name="lastname" value="<?php echo set_value('lastname'); ?>" maxlength="38" >
				
				<?php echo form_error('firstname'); ?>
				<?php echo form_error('lastname'); ?>
				</div>
				</div>
			</pretty>
			
			<pretty>
				<div class="control-group">
					<label class="control-label" for="Complément">Age entre</label>
					<div class="controls">
						<input class="input-small" type="text" name="age1" value="<?php echo set_value('age1'); ?>" maxlength="3" >
						 et 
						<input class="input-small" type="text" name="age2" value="<?php echo set_value('age2'); ?>" maxlength="3" >
						ans 
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="Complément">Né(e) entre</label>
					<div class="controls">
						<input class="datepicker input-small" type="text" name="datenaissance1" readonly>
						 et 
						<input class="datepicker input-small" type="text" name="datenaissance2" readonly>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="Complément">Contact créé en</label>
					<div class="controls">
						<input type="text" class="monthpicker" name="dateEn" readonly>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="Complément">Contact créé depuis</label>
					<div class="controls">
						<input type="text" class="datepicker" name="dateDepuis" readonly >
					</div>
				</div>			
			
			<?php echo form_error('age1'); ?>
			<?php echo form_error('age2'); ?>
			<?php if(isset($msg_alert)) echo('<div class="error">'.$msg_alert.'</div>'); ?>
			<?php echo form_error('datenaissance1'); ?>
			<?php echo form_error('datenaissance2'); ?>
			<?php echo form_error('dateEn'); ?>
			<?php echo form_error('dateDepuis'); ?>
			
			</pretty>
			
			<legend><h4>Contacts</h4></legend>
			
			<pretty>
				<div class="input-prepend">
					<div class="control-group">
					<label class="control-label" for="id">Email</label>
					<div class="controls">
					<span class="add-on"><i class="icon-envelope"></i></span><input class="span2" type="text" name="email" value="<?php echo set_value('email'); ?>" >
					</div>
					</div>
					<div class="control-group">
					<label class="control-label" for="id">Téléphone fixe</label>
					<div class="controls">
					<span class="add-on"><i class="icon-home"></i></span><input class="span2" type="text" name="telFixe" value="<?php echo set_value('telFixe'); ?>" >
					</div>
					</div>
					<div class="control-group">
					<label class="control-label" for="id">Téléphone portable</label>
					<div class="controls">
					<span class="add-on"><i class="icon-user"></i></span><input class="span2" type="text" name="telPort" value="<?php echo set_value('telPort'); ?>" >
					</div>
					</div>
					<?php echo form_error('email'); ?>
					<?php echo form_error('telFixe'); ?>
					<?php echo form_error('telPort'); ?>
				</div>
			</pretty>
			</div>
			</div>
			
			<div class="inline-block">
			<div class="inner-block">
			<legend><h4>Adresse Postale</h4></legend>
			
			<pretty>
				<div class="control-group">
					<label class="control-label" for="id">Complément</label>
					<div class="controls">
						<input type="text" name="complement" value="<?php echo set_value('complement'); ?>" maxlength="38" />
					</div>
				</div>			
				<div class="control-group">
					<label class="control-label" for="id">Voie</label>
					<div class="controls">
						<input type="text" name="voie" value="<?php echo set_value('voie'); ?>" maxlength="38" />
					</div>
				</div>
				<?php echo form_error('voie'); ?>
				<?php echo form_error('complement'); ?>
			</pretty>
			
			
			<pretty>
				<div class="control-group">
					<label class="control-label" for="Civilite">CP / BP</label>
 					<div class="controls">
						<input class="input-mini" type="text" name="cp" value="<?php echo set_value('cp'); ?>" maxlength="38" placeholder="CP"/>
						<input class="input-mini" type="text" name="bp" value="<?php echo set_value('bp'); ?>" maxlength="38" placeholder="BP"/>	
 					</div> 
 				</div>
				<div class="control-group">
					<label class="control-label" for="id">Ville</label>
					<div class="controls">
						<input type="text" name="city" value="<?php echo set_value('city')?>" maxlength="38" >
					</div>
					</div>
				<div class="control-group">
					<label class="control-label" for="id">Pays</label>
					<div class="controls">
						<input type="text" name="country" value="<?php echo set_value('country'); ?>" >
				
						<?php echo form_error('bp'); ?>
						<?php echo form_error('cp'); ?>
						<?php echo form_error('city'); ?>
						<?php echo form_error('country'); ?>
					</div>
				</div>
			</pretty>
			
			<legend><h4>Divers</h4></legend>
		
			<pretty>
				<div class="control-group">
				<label class="control-label" for="id">Commentaires</label>
				<div class="controls">
				<textarea name="commentaire" rows="5" cols="60"><?php echo set_value('commentaire'); ?></textarea>
				</div>
				</div>
			</pretty>
		
		</div>
		</div>
		
		<div id="searchPattern"><button type="submit" class="btn">Rechercher</button></div>
		<div id="clear"></div>
		
	</form>
</div>