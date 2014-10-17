<div id="content">

	<form method="post" name="creerType" class="well form-search" <?php echo ('action="'.site_url('document/create_type').'"'); ?>>
		<input name= "is_form_sent" type="hidden" value="true">	
		<input type="text" name="name" value="<?php echo set_value('name'); ?>" />
		<button type="submit" class="btn" value="sauvegarder">Sauvegarder</button>
		<?php echo "<br/>".form_error('name'); ?>
	</form>

</div>