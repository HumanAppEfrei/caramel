<div id= "create">
	<div class="message"><p><h2>Créer un nouveau segment </h2></p></div>
	
	<form class="form-horizontal" method="post" name="creerSegment" <?php echo ('action="'.site_url("segment/create").'"'); ?>>
	
	
	<input name= "is_form_sent" type="hidden" value="true">
	
		<div class="control-group">
		<label class="control-label" for="description">Code</label>
		<div class="controls">
		<input type="text" name="code" value="<?php echo set_value('code');?>" required/> *
		<?php echo form_error('code'); ?>
		</div>
		</div>
		
		<div class="control-group">
		<label class="control-label" for="description">Libellé</label>
		<div class="controls">
		<input type="text" name="libelle" value="<?php echo set_value('libelle');?>" required/> *
		<?php echo form_error('libelle'); ?>
		</div>
		</div>

		<p/>
		<p><input class"btn" type="submit" value="Valider" />
		<input class "alert-btn" type="reset" value="Annuler" /></p>
		
	</form>

</div>