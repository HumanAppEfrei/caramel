<div id="create">

	<div class="well"><h2>Créer un nouveau contact</h2></div>
	<div id="list_doublons">
	</div>
	<form class="form-horizontal" method="post" name="createContact" <?php echo ('action="'.site_url("contact/create").'"'); ?>>
	
		<input name= "is_form_sent" type="hidden" value="true">
		
		
		<div class="inline-block">
			<div class="inner-block">
			<legend><h4>Informations générales</h4></legend>
			
			<pretty>
				<div class="control-group">
				<label class="control-label" for="Civilite">Type de personne</label>
				<div class="controls">
				<select id="type" name="type" value="<?php echo set_value('type'); ?>" >
				   <option value="physique" <?php if(set_value('type') == "physique") echo'selected' ?>>Physique</option>
				   <option value="morale" <?php if(set_value('type') == "morale") echo'selected' ?>>Morale</option>
				</select>
				</div>
				</div>
				
				<div class="control-group">
				<label class="control-label" for="Civilite">Type de contact</label>
				<div class="controls">
				<select id="typeC" name="typeC" value="<?php echo set_value('typeC'); ?>" >
				   <option value="donateur" <?php if(set_value('typeC') == "donateur") echo'selected ' ?>>Donateur</option>
				   <option value="prospect" <?php if(set_value('typeC')  == "prospect") echo'selected ' ?>>Prospect</option>
				   <option value="benevole" <?php if(set_value('typeC')  == "benevole") echo'selected ' ?>>Bénévole</option>
				   <option value="entreprise" <?php if(set_value('typeC')  == "entreprise") echo'selected ' ?>>Entreprise</option>
				   <option value="association" <?php if(set_value('typeC')  == "association") echo'selected ' ?>>Association</option>
				   <option value="ong" <?php if(set_value('typeC') == "ong") echo'selected ' ?>>ONG</option>
				</select>
				</div>
			</div>
			</pretty>
	
			<pretty>
				<div class="control-group">
				<label class="control-label" for="Civilite">Civilité</label>
				<div class="controls">
					<select class="input-small" name="civilite" value="<?php echo set_value('civilite'); ?>" >
					   <option value="M." <?php if(set_value('civilite') == "M.") echo'selected' ?>>M.</option>
					   <option value="Mme" <?php if(set_value('civilite') == "Mme") echo'selected' ?>>Mme</option>
					   <option value="Mlle" <?php if(set_value('civilite') == "Mlle") echo'selected' ?>>Mlle</option>
					   <!-- ajout parametres -->
						<?php foreach($Options_civil as $Option_civil){ ?>
							<option value="<?php echo $Option_civil;?>" 
							<?php if(set_value('civilite')==$Option_civil) echo'selected' ?>><?php echo $Option_civil;?></option>	 
						<?php }?>					   
					</select>
				</div>
			</div>
				<div class="control-group">
				<label class="control-label" for="Civilite">Prénom*</label>
				<div class="controls">
					<input type="text" id="firstname" name="firstname" value="<?php echo set_value('firstname'); ?>" maxlength="38" >
				</div>
				</div>
				<div class="control-group">
				<label id="nom" class="control-label" for="Civilite">Nom*</label>
				<div class="controls">
				<input type="text" id="lastname" name="lastname" value="<?php echo set_value('lastname'); ?>" maxlength="38" >
				
				<?php echo form_error('firstname'); ?>
				<?php echo form_error('lastname'); ?>
				<?php if(isset($message_identification)) echo('<div class="error">'.$message_identification.'</div>'); ?>
				</div>
				</div>
			</pretty>
			
			<pretty id="naissance">
				<div class="control-group">
					<label class="control-label" for="Civilite">Date de naissance</label>
					<div class="controls">
						<input class="datepicker" type="text" name="datenaissance" />
						
						<!-- <?php echo form_error('jour'); ?>
						<?php echo form_error('mois'); ?>
						<?php echo form_error('annee'); ?> -->
						<?php echo form_error('datenaissance'); ?>
						<?php if(isset($message_date)) echo('<div class="error">'.$message_date.'</div>'); ?>
					</div>
				</div>
			</pretty>	

			<legend><h4>Contacts</h4></legend>
			
			<pretty>
				<div class="input-prepend">
				
				<div class="control-group">
				<label class="control-label" for="Civilite">Adresse e-mail</label>
				<div class="controls">
					<span class="add-on"><i class="icon-envelope"></i></span><input class="span2" id="email" name="email" type="text" value="<?php echo set_value('email'); ?>" >
				</div>
			    </div>
				
				<div class="control-group">
				<label class="control-label" for="Civilite">Téléphone fixe</label>				
				<div class="controls">
					<span class="add-on"><i class="icon-home"></i></span><input class="span2" id="telFixe" name="telFixe" type="text" value="<?php echo set_value('telFixe'); ?>" >
				</div>
			    </div>
				
				<div class="control-group">
				<label class="control-label" for="Civilite">Téléphone mobile</label>
				<div class="controls">
					<span class="add-on"><i class="icon-user"></i></span><input class="span2" id="telPort" name="telPort" type="text" value="<?php echo set_value('telPort'); ?>" >
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
					<label class="control-label" for="Civilite">Complément</label>
					<div class="controls">
						<input type="text" name="complement" value="<?php echo set_value('complement'); ?>" maxlength="38" >
					</div>
				</div>
				<div class="control-group">
				<label class="control-label" for="Civilite">Voie</label>
				<div class="controls">
					<input class="input-mini" type="text" name="voie_num" value="<?php echo set_value('voie_num'); ?>" >
					<select class="input-mini" name="voie_type" value="<?php echo set_value('voie_type'); ?>" >
					   <option value=" " <?php if(set_value('voie_type') == " ") echo'selected' ?>> </option>
					   <option value="rue" <?php if(set_value('voie_type') == "rue") echo'selected' ?>>rue</option>
					   <option value="avenue" <?php if(set_value('voie_type') == "avenue") echo'selected' ?>>avenue</option>
					   <option value="allée" <?php if(set_value('voie_type') == "allée") echo'selected' ?>>allée</option>
					   <option value="impasse" <?php if(set_value('voie_type') == "impasse") echo'selected' ?>>impasse</option>
					   <option value="boulevard" <?php if(set_value('voie_type') == "boulevard") echo'selected' ?>>boulevard</option>
					   <option value="chemin" <?php if(set_value('voie_type') == "chemin") echo'selected' ?>>chemin</option>
					   <option value="faubourg" <?php if(set_value('voie_type') == "faubourg") echo'selected' ?>>faubourg</option>
					   <option value="cours" <?php if(set_value('voie_type') == "cours") echo'selected' ?>>cours</option>
					   <option value="lieu_dit" <?php if(set_value('voie_type') == "lieu_dit") echo'selected' ?>>lieu dit</option>
					</select>
					<input class="input-medium" type="text" name="voie_nom" value="<?php echo set_value('voie_nom'); ?>" >
				</div>
				</div>
				
				<?php echo form_error('complement'); ?>
				<?php echo form_error('voie_num'); ?>
				<?php echo form_error('voie_type'); ?>
				<?php echo form_error('voie_nom'); ?>
				<?php if(isset($message_voie)) echo('<div class="error">'.$message_voie.'</div>'); ?>
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
					<label class="control-label" for="Civilite">Ville</label>
					<div class="controls">
						<input type="text" name="city" value="<?php echo set_value('city')?>" maxlength="38" />
					</div>
				</div>
				
				<div class="control-group">
					<label class="control-label" for="Civilite">Pays</label>
					<div class="controls">
						<input type="text" name="country" value="<?php echo set_value('country'); ?>" />
					</div>
				</div>
				
				<?php echo form_error('bp'); ?>
				<?php echo form_error('cp'); ?>
				<?php echo form_error('city'); ?>
				<?php echo form_error('country'); ?>
				<?php if(isset($message_localite)) echo('<div class="error">'.$message_localite.'</div>'); ?>
			
			</pretty>

			<legend><h4>Divers</h4></legend>
			
			<pretty>
				<div class="control-group">
				<label class="control-label" for="Civilite">Commentaires</label>
				<div class="controls">
				<textarea name="commentaire" rows="5" cols="60"><?php echo set_value('commentaire'); ?></textarea>
				</div>
				</div>
			</pretty>
			
			<div id="searchPattern">
			<button type="submit" class="btn">Sauvegarder</button>
			</div>
			
		</div>
		</div>
		
		<div id="clear"></div>
		
	</form>
	
	
</div>



<script>
	var Options_morale ="<?php echo implode(',',$Options_morale) ?>";
	var Options_physique ="<?php echo implode(',',$Options_physique) ?>";
	var URL_ajax="<?php echo site_url('contact/traitement_ajax');?>";
</script>

<SCRIPT LANGUAGE="Javascript" SRC="<?php echo base_url().'assets/javascript/contact_view.js'?>" ></SCRIPT>