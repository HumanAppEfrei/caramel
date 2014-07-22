<form class="form-horizontal" method="post" name="select_cam" <?php echo ('action='.site_url("stat/campagnes")); ?>>
	<input name= "is_form_sent" type="hidden" value="true">
	<pretty>
		<select name="campagne"">
		<?php foreach($list_campagnes as $list_campagne)
		{
			
			echo "<option value=".$list_campagne->CAM_ID." ";
			if($list_campagne->CAM_ID == $campagne) echo'selected';
			echo ">".$list_campagne->CAM_ID." : ".$list_campagne->CAM_NOM."</option>";			
		}
		?>
		</select>
		
		<div class="pull-right">		
			<input name="exp_vers" type="radio" id="exp_vers" value="volume" <?php if(!empty($exp_vers)){ if($exp_vers == "volume") echo "checked";} else echo "checked"; ?> /><font color="#008000">Versements exprimés en volume</font>
			<input name="exp_vers" type="radio" id="exp_vers" value="valeur" <?php if(!empty($exp_vers)){ if($exp_vers == "valeur") echo "checked";} ?> /><font color="red">Versements exprimés en Valeur (€)</font>
		</div>
	
		<button type="submit" class="btn">Sélectionner cette campagne</button>
	</pretty>
</form>