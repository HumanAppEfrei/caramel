<div id="create">

	<div class="well"><h2>Ajout d'informations complémentaires de contacts</h2></div>
	
	<form method="post" id="form" name="createIC" <?php echo ('action="'.site_url("admin/createIC").'"'); ?>>
	
		<input name= "is_form_sent" type="hidden" value="true"/>
		
		<input id="choixlist" name= "choixlist" type="hidden" />
		
		<pretty>
				Nom du critere : 
				<input type="text" id="nom" name="nom" value="<?php echo set_value('nom'); ?>" />
				<br/><?php echo form_error('nom'); ?>
		</pretty>
		<pretty>
				Type : 
				<select id="type" name="type" value="<?php echo set_value('type'); ?>" >
				   <option value="texte" <?php if(set_value('type') == "texte") echo'selected ' ?>>Texte</option>
				   <option value="liste" <?php if(set_value('type')  == "liste") echo'selected ' ?>>Liste</option>
				   <option value="checkbox" <?php if(set_value('type')  == "checkbox") echo'selected ' ?>>Checkbox</option>
				</select>
			 | 	
				Exemple :
				<span id="exemple">
				<input type="text" name="ex" placeholder="text"/>
				</span>
				
				<div id="Emplacement_choixlist">
				
				</div>
				<br/><?php echo form_error('choixlist'); ?>
		</pretty>
		
	<div class="form-actions">
			<button type="submit" class="btn">Créer</button>
		</div>	
		
	</form>
</div>

<SCRIPT LANGUAGE="Javascript" SRC="<?php echo base_url().'assets/javascript/create_ic.js'?>" ></SCRIPT>