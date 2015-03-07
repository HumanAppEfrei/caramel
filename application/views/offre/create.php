<div id= "create">

	<div class="well"><h2>Créer une nouvelle offre </h2></div>
	
	<form class="form-horizontal" method="post" name="creerOffre" <?php echo ('action="'.site_url("offre/create").'"'); ?>>
	
		<input name= "is_form_sent" type="hidden" value="true">
		
		<div class="inline-block">
		<div class="inner-block">
		
			<pretty>
				<div class="control-group">
				<label class="control-label" for="description">Code*</label>
				<div class="controls">
				<input type="text" name="code" value="<?php echo set_value('code');?>" >
				<?php echo form_error('code'); ?>
				</div>
				</div>
				<div class="control-group">
				<label class="control-label" for="description">Libellé</label>
				<div class="controls">
				<input type="text" name="libelle" value="<?php echo set_value('libelle');?>" >
				<?php echo form_error('libelle'); ?>
				</div>
				</div>
			</pretty>
			
			<pretty>
				<div class="control-group">
				<label class="control-label" for="description">Date de début</label>
				<div class="controls">
					<input class="datepicker" type="text" name="datedebut" />
				</div>
				</div>
				<div class="control-group">
				<label class="control-label" for="description">Date de fin</label>
				<div class="controls">
					<input class="datepicker" type="text" name="datefin" />
				<!-- <?php echo form_error('jourd'); ?>
				<?php echo form_error('moisd'); ?>
				<?php echo form_error('anneed'); ?>
				<?php if(isset($message_debut)) echo('<div class="error">'.$message_debut.'</div>'); ?>
				<?php echo form_error('jourf'); ?>
				<?php echo form_error('moisf'); ?>
				<?php echo form_error('anneef'); ?>
				<?php if(isset($message_fin)) echo('<div class="error">'.$message_fin.'</div>'); ?> -->
				</div>
				</div>
			</pretty>
			
			<pretty>
				<div class="control-group">
				<label class="control-label" for="description">Relier à la campagne</label>
				<div class="controls">
				<select name="campagne" >
				<?php foreach($list_campagnes as $list_campagne)
				{
					if(isset($campagne[0]->CAM_ID))
					{
						if($campagne[0]->CAM_ID == $list_campagne->CAM_ID) echo "<option value='".$list_campagne->CAM_ID."' selected>".$list_campagne->CAM_ID." : ".$list_campagne->CAM_NOM."</option>";
						else echo "<option value='".$list_campagne->CAM_ID."'>".$list_campagne->CAM_ID." : ".$list_campagne->CAM_NOM."</option>";
					}
					else
					{ ?><?php if(set_value('mode') == "carte") echo'selected ' ?>
						<option value="<?php echo $list_campagne->CAM_ID; ?>"  <?php if(set_value('campagne') == $list_campagne->CAM_ID) echo'selected ' ?> ><?php echo $list_campagne->CAM_ID." : ".$list_campagne->CAM_NOM ?></option>
				<?php	}
				}
				?>
				</select>
				</div>
				</div>
			</pretty>
			
			<pretty>
				<div class="control-group">
				<input type="hidden" id="segments" name="segments" value="<?php echo set_value('segments');?>" >
	
				<label class="control-label" for="description">Segments</label>
				<div class="controls">
				<input type="text" id="seg" value="<?php echo set_value('segment');?>" >
				<button type="button" class="btn" id="seg_ajout" >Ajouter</button>
				<div id="affich_segs"></div>
				<?php echo form_error('segments'); ?>
				</div>
				<div id="error_seg" class="error">Le segment saisi est inexistant</div>
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
			<input type="text" name="objectif" value="<?php echo set_value('objectif');?>"/> €
			<?php echo form_error('objectif'); ?>
			</div>
			</div>
		</pretty>
		
		<div id="searchPattern">
			<button type="submit" class="btn">Sauvegarder</button>
		</div>
		
		</div>
		</div>
		
		<div id="clear"></div>
		
	</form>
</div>
<script LANGUAGE="Javascript"> var baseURL = "<?php echo site_url();?>"</script>
<SCRIPT LANGUAGE="Javascript" SRC="<?php echo base_url().'assets/javascript/offre_view.js'?>" ></SCRIPT>