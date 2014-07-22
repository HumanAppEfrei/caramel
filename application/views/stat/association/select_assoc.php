<form class="form-horizontal" method="post" name="select_assoc" <?php echo ('action='.site_url("stat/association")); ?>>
	<input name= "is_form_sent" type="hidden" value="true">
	<pretty>
		
		
		<div class="pull-right">		
			<input name="exp_vers" type="radio" id="exp_vers" value="volume" <?php if(!empty($exp_vers)){ if($exp_vers == "volume") echo "checked";} else echo "checked"; ?> /><font color="#008000">Versements exprimés en volume</font>
			<input name="exp_vers" type="radio" id="exp_vers" value="valeur" <?php if(!empty($exp_vers)){ if($exp_vers == "valeur") echo "checked";} ?> /><font color="red">Versements exprimés en Valeur (€)</font>
		</div>
	
		<button type="submit" class="btn">Sélectionner cet affichage</button>
	</pretty>
</form>