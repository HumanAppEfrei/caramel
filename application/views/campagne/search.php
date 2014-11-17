<div id="search">

	<div class="well"><h2>Rechercher une campagne </h2></div>
	
	<form class="form-horizontal" method="post" name="searchCampagne" <?php echo ('action="'.site_url("campagne/search").'"'); ?>>
	
		<input name= "is_form_sent" type="hidden" value="true">
		
		<div class="inline-block">
			<div class="inner-block">
		
			<pretty>
				<div class="control-group">
				<label class="control-label" for="description">Code</label>
				<div class="controls">
				<input type="text" name="code" value="<?php echo set_value('code');?>" >
				<?php echo form_error('code'); ?>
				</div>
				</div>
				<div class="control-group">
				<label class="control-label" for="description">Nom</label>
				<div class="controls">
				<input type="text" name="nom" value="<?php echo set_value('nom');?>" >
				<?php echo form_error('nom'); ?>
				</div>
				</div>
			</pretty>
			
			<pretty>
				<div class="control-group">
				<label class="control-label" for="description">Type</label>
				<div class="controls">
				<select name="type" id="type">
					<option value="" <?php if(set_value('type') == "") echo'selected ' ?>></option>
					<option value="fidelisation" <?php if(set_value('type') == "fidelisation") echo'selected ' ?>>Fidélisation</option>
					<option value="prospection" <?php if(set_value('type') == "prospection") echo'selected ' ?>>Prospection</option>
				</select>
				</div>
				</div>
			</pretty>
			
			<pretty>
				
				<div class="control-group">
				<label class="control-label" for="description">Date de début</label>
				<div class="controls">
				<input type="text" style="width:40px;" name="jourd" maxlength="2" placeholder="jj" > /
				<input type="text" style="width:40px;" name="moisd" maxlength="2" placeholder="mm" > /
				<input type="text" style="width:50px;" name="anneed" maxlength="4" placeholder="aaaa" >
				</div>
				</div>
				<div class="control-group">
				<label class="control-label" for="description">Date de fin</label>
				<div class="controls">
				<input type="text" style="width:40px;" name="jourf" maxlength="2" placeholder="jj" > /
				<input type="text" style="width:40px;" name="moisf" maxlength="2" placeholder="mm" > /
				<input type="text" style="width:50px;" name="anneef" maxlength="4" placeholder="aaaa" >
				</div>
				</div>
				<?php echo form_error('jourd'); ?>
				<?php echo form_error('moisd'); ?>
				<?php echo form_error('anneed'); ?>
				<?php if(isset($message_debut)) echo('<div class="error">'.$message_debut.'</div>'); ?>
				<?php echo form_error('jourf'); ?>
				<?php echo form_error('moisf'); ?>
				<?php echo form_error('anneef'); ?>
				<?php if(isset($message_fin)) echo('<div class="error">'.$message_fin.'</div>'); ?>
			</pretty>
		
			<pretty>
				<input type="checkbox" name="web" value="ok"/> Campagne web
				<input type="checkbox" name="courrier" value="ok"/> Campagne courrier
				<input type="checkbox" name="email" value="ok"/> Campagne email
				<br/>
				<input type="radio" name="mediatype" value="et" id="et" checked="checked"/> ET
				<input type="radio" name="mediatype" value="ou" id="ou"/> OU
			</pretty>
	
			</div>
			</div>
			
			<div class="inline-block">
				<div class="inner-block">
				
			<pretty>
				<div class="control-group">
				<label class="control-label" for="description">Description</label>
				<div class="controls">
				<textarea name="description" rows="5" cols="40" ><?php echo set_value('description'); ?></textarea>
				<?php echo form_error('description'); ?>
				</div>
				</div>
				<div class="control-group">
				<label class="control-label" for="description">Objectifs</label>
				<div class="controls">
				<textarea name="objectif" rows="5" cols="40" ><?php echo set_value('objectif'); ?></textarea>
				<?php echo form_error('objectif'); ?>
				</div>
				</div>
			</pretty>
		
			</div>
			</div>
			
		<div id="searchPattern">
			<button type="submit" class="btn">Rechercher</button>
		</div>
		<div id="clear"></div>
		
	</form>
</div>