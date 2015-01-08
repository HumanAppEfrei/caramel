<div id="search">
	
	<div class="well"><h2>Rechercher une offre </h2></div>
	
	<form class="form-horizontal" method="post" name="searchOffre" <?php echo ('action="'.site_url("offre/search").'"'); ?>>
	
		<input name= "is_form_sent" type="hidden" value="true">
	
		<div class="inline-block">
		<div class="inner-block">
		
			<pretty>
				<div class="control-group">
				<label class="control-label" for="description" title="Identifiant de l'offre (unique)">Code de l'offre</label>
				<div class="controls">
				<input type="text" name="code" value="<?php echo set_value('code'); ?>" />
				<?php echo form_error('code'); ?>
				</div>
				</div>
				<div class="control-group">
				<label class="control-label" for="description" title="Description de l'offre">Libélée de l'offre</label>
				<div class="controls">
				<input type="text" name="libelle" value="<?php echo set_value('libelle'); ?>" />
				<?php echo form_error('libelle'); ?>
				</div>
				</div>
			</pretty>
			
			<pretty>
				<div class="control-group">
				<label class="control-label" for="description">Date de début</label>
				<div class="controls">
				<input type="text" style="width:40px;" name="jourd" value="<?php echo set_value('jourd'); ?>" maxlength="2" placeholder="dd" > /
				<input type="text" style="width:40px;" name="moisd" value="<?php echo set_value('moisd'); ?>" maxlength="2" placeholder="mm" > /
				<input type="text" style="width:50px;" name="anneed" value="<?php echo set_value('anneed'); ?>" maxlength="4" placeholder="aaaa" >
				</div>
				</div>
				<div class="control-group">
				<label class="control-label" for="description">Date de fin</label>
				<div class="controls">
				<input type="text" style="width:40px;" name="jourf" value="<?php echo set_value('jourf'); ?>" maxlength="2" placeholder="dd" > /
				<input type="text" style="width:40px;" name="moisf" value="<?php echo set_value('moisf'); ?>" maxlength="2" placeholder="mm" > /
				<input type="text" style="width:50px;" name="anneef" value="<?php echo set_value('anneef'); ?>" maxlength="4" placeholder="aaaa" >
				<?php echo form_error('jourd'); ?>
				<?php echo form_error('moisd'); ?>
				<?php echo form_error('anneed'); ?>
				<?php if(isset($message_debut)) echo('<div class="error">'.$message_debut.'</div>'); ?>
				<?php echo form_error('jourf'); ?>
				<?php echo form_error('moisf'); ?>
				<?php echo form_error('anneef'); ?>
				<?php if(isset($message_fin)) echo('<div class="error">'.$message_fin.'</div>'); ?>
				</div>
				</div>
			</pretty>
			
			<pretty>
				<div class="control-group">
				<label class="control-label" for="description">Relié à la campagne</label>
				<div class="controls">
				<select name="campagne" >
				<?php foreach($list_campagnes as $campagne)
				{
					echo "<option value='".$campagne->CAM_ID."'>".$campagne->CAM_ID." : ".$campagne->CAM_NOM."</option>";
				}
				?>
				</select>
				</div>
				</div>
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