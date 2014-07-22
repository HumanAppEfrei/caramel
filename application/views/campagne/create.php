<div id= "create">
	
	<div class="well"><h2>Créer une nouvelle campagne </h2></div>
	
	<form class="form-horizontal" method="post" name="creerCampagne" <?php echo ('action="'.site_url("campagne/create").'"'); ?>>
	
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
				<label class="control-label" for="description">Nom*</label>
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
					<option value="fidelisation" <?php if(set_value('type') == "fidelisation") echo'selected ' ?>>Fidélisation</option>
					<option value="prospection" <?php if(set_value('type') == "prospection") echo'selected ' ?>>Prospection</option>
				</select>
				</div>
				</div>
			</pretty>
			
			<pretty>
				<?php 
				// date du lendemain
				$date = strtotime("+1 day", strtotime(date("y-m-d")));?>
				<div class="control-group">
				<label class="control-label" for="description">Date de début</label>
				<div class="controls">
				<input type="text" style="width:40px;" name="jourd" value="<?php echo set_value('jourd',date("d")); ?>" maxlength="2" placeholder="dd" > /
				<input type="text" style="width:40px;" name="moisd" value="<?php echo set_value('moisd',date("m")); ?>" maxlength="2" placeholder="mm" > /
				<input type="text" style="width:50px;" name="anneed" value="<?php echo set_value('anneed',date("Y")); ?>" maxlength="4" placeholder="aaaa" >
				</div>
				</div>
				<div class="control-group">
				<label class="control-label" for="description">Date de fin</label>
				<div class="controls">
				<input type="text" style="width:40px;" name="jourf" value="<?php echo set_value('jourf',date("d",$date)); ?>" maxlength="2" placeholder="dd" > /
				<input type="text" style="width:40px;" name="moisf" value="<?php echo set_value('moisf',date("m",$date)); ?>" maxlength="2" placeholder="mm" > /
				<input type="text" style="width:50px;" name="anneef" value="<?php echo set_value('anneef',date("Y",$date)); ?>" maxlength="4" placeholder="aaaa" >
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
				<input type="checkbox" name="web" value="ok"/>
				Campagne web
				<input type="checkbox" name="courrier" value="ok"/>
				Campagne courrier
				<input type="checkbox" name="email" value="ok"/>
				Campagne email
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
				</div>
				</div>
				<?php echo form_error('description'); ?>
				<div class="control-group">
				<label class="control-label" for="description">Objectifs</label>
				<div class="controls">
				<input type="text" name="objectif" value="<?php echo(set_value('objectif')); ?>"> €
				</div>
				</div>
				<?php echo form_error('objectif'); ?>
			</pretty>
			
			<div id="searchPattern">
			<button type="submit" class="btn">Sauvegarder</button>
			</div>
			
		</div>
		</div>
	
		<div id="clear"></div>
		
	</form>
</div>