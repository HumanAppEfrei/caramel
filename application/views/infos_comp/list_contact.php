	<div class="well"><h2>Informations complémentaires du contact : <?php echo($contact[0]->CON_FIRSTNAME." ".$contact[0]->CON_LASTNAME)?> </h2></div>
	
	<form class="form-horizontal" method="post" name="infos_comp" <?php echo (' action="'.site_url("contact/infos_comp/".$contact[0]->CON_ID).'"') ?> Onsubmit='return window.confirm("Attention, des données risquent d être écrasées\nSouhaitez vous continuez?");'>
	
		<input name= "is_form_sent" type="hidden" value="true">
		
				
		<div class="inline-block">
			<div class="inner-block">
		<?php 
			foreach($items as $info_comp)
			{
				$split = @split(":",$info_comp->IC_TYPE);
				$type = $split[0];
				if($type == "liste") $values = @split(",",$split[1]);
				else $values = "";
				
				echo "<pretty>";
				
				echo "<div class='control-group'><label class='control-label' for='Civilite'>".$info_comp->IC_LABEL."</label><div class='controls'>";
				
				if($type == "texte")
				{
					$id = $info_comp->IC_ID;
					if(!empty($infos_comp_contact)) echo "<input type='text' name=".$info_comp->IC_ID." value='".$infos_comp_contact[0]->$id."'></div></div>";
					else echo "<input type='text' name=".$info_comp->IC_ID."></div></div>";
				}
				else if($type == "checkbox")
				{
					$id = $info_comp->IC_ID;
					if(!empty($infos_comp_contact) && $infos_comp_contact[0]->$id == true) echo "<input type='checkbox' name=".$info_comp->IC_ID." checked></div></div>";
					else echo "<input type='checkbox' name=".$info_comp->IC_ID."></div></div>";
				}
				else if($type == "liste")
				{
					echo "<select name=".$info_comp->IC_ID.">";
					echo "<option value=''></option>";
					foreach($values as $value)
					{
						$id = $info_comp->IC_ID;
						if(!empty($infos_comp_contact) && $infos_comp_contact[0]->$id == $value) echo "<option value=".$value." selected>".$value."</option>";
						else echo "<option value=".$value.">".$value."</option>";
					}
					echo "</select></div></div>";
				}
				
				echo "</pretty>";
		?>
				
		<?php 
			}
		?>
		
		<div class="searchPattern">
			<button type="submit" class="btn">Sauvegarder</button>
		</div>
		
		</div>
		</div>

		<div id="clear"></div>
	</form>
</div>