<div id= "search">
	
	<div class="message"><p><h2>Rechercher un segment </h2></p></div>
	
	<form method="post" name="searchSegment" <?php echo ('action="'.site_url("segment/search").'"'); ?>>
		
		<input name= "is_form_sent" type="hidden" value="true">
		
		<label for="code">Code :</label>
		<input type="text" name="code" value="<?php echo set_value('code'); ?>"/>
		<?php echo form_error('code'); ?>
		<br/>
		<label for="nom">Libellé :</label>
		<input type="text" name="libelle" value="<?php echo set_value('libelle'); ?>"/>
		<?php echo form_error('libelle'); ?>
		<br/>
		
		<!-- A rajouter : les dons liés -->
		<p><input type="submit" value="Valider" />
		<input type="reset" value="Annuler" /></p>
		
	</form>

</div>