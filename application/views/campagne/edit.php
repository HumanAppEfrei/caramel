<?php 
	foreach($campagne as $campagne)
	{	
		$debut = $campagne->CAM_DEBUT;
		$fin = $campagne->CAM_FIN;
		/*$split1 = @split("-",$campagne->CAM_DEBUT); 
		$anneed = $split1[0]; 
		$moisd = $split1[1]; 
		$jourTmpd = $split1[2];
		
		if($jourTmpd[0] =='0') $jourd = $jourTmpd[1];
		else $jourd = $jourTmpd;
		
		if($jourTmpd[0] =='0' && $jourTmpd[1] =='0') $jourd = "";
		if($moisd[0] =='0' && $moisd[1] =='0') $moisd = "";
		if($anneed[0] =='0' && $anneed[1] =='0' && $anneed[2] =='0' && $anneed[3] =='0')  $anneed = "";
		
		$split2 = @split("-",$campagne->CAM_FIN); 
		$anneef = $split2[0]; 
		$moisf = $split2[1]; 
		$jourTmpf = $split2[2];
		
		if($jourTmpf[0] =='0') $jourf = $jourTmpf[1];
		else $jourf = $jourTmpf;
		
		if($jourTmpf[0] =='0' && $jourTmpf[1] =='0') $jourf = "";
		if($moisf[0] =='0' && $moisf[1] =='0') $moisf = "";
		if($anneef[0] =='0' && $anneef[1] =='0' && $anneef[2] =='0' && $anneef[3] =='0')  $anneef = "";*/
?>
		
	<div class="well"><h2>Edition de la campagne : <?php echo($campagne->CAM_NOM)?> </h2></div>
	
	<a href="<?php echo site_url('cible/affich')."/".$campagne->CAM_ID?>"><input type="button" value="Cible de la campagne" class='right'/></a>
		
	<form method="post" class="form-horizontal" name="editCampagne" <?php echo ('action="'.site_url("campagne/edit/".$campagne->CAM_ID).'"'); ?> Onsubmit='return window.confirm("Attention, des données risquent d être écrasées\nSouhaitez vous continuez?");'>
	
		<input name= "is_form_sent" type="hidden" value="true">
		
		
		<div class="inline-block">
		<div class="inner-block">
			<pretty>
				<div class="control-group">
				<label class="control-label" for="description">Code</label>
				<div class="controls">
				<input type="text" value="<?php echo($campagne->CAM_ID);?>" readonly="readonly">
				</div>
				</div>
				
				<div class="control-group">
				<label class="control-label" for="description">Nom*</label>
				<div class="controls">
				<input type="text" name="nom" value="<?php echo($campagne->CAM_NOM);?>" >
				<?php echo form_error('nom'); ?>
				</div>
				</div>
			</pretty>
			
			<pretty>
				<div class="control-group">
				<label class="control-label" for="description">Type</label>
				<div class="controls">
				<select name="type" id="type">
					<option value="fidelisation" <?php if($campagne->CAM_TYPE == "fidelisation") echo'selected' ?>>Fidélisation</option>
					<option value="prospection" <?php if($campagne->CAM_TYPE == "prospection") echo'selected' ?>>Prospection</option>
				</select>
				</div>
				</div>
			</pretty>
			
			<pretty>
				<div class="control-group">
				<label class="control-label" for="description">Date de début</label>
				<div class="controls">
				<!-- <input type="text" style="width:40px;" name="jourd" value="<?php echo($jourd); ?>" maxlength="2" placeholder="dd" > /
				<input type="text" style="width:40px;" name="moisd" value="<?php echo($moisd); ?>" maxlength="2" placeholder="mm" > /
				<input type="text" style="width:50px;" name="anneed" value="<?php echo($anneed); ?>" maxlength="4" placeholder="aaaa" > -->
				<input type="text" class="datepicker" name="datedebut" value="<?php echo($debut); ?>" readonly/> 
				</div>
				</div>
				
				<div class="control-group">
				<label class="control-label" for="description">Date de fin</label>
				<div class="controls">
				<!-- <input type="text" style="width:40px;" name="jourf" value="<?php echo($jourf); ?>" maxlength="2" placeholder="dd" > /
				<input type="text" style="width:40px;" name="moisf" value="<?php echo($moisf); ?>" maxlength="2" placeholder="mm" > /
				<input type="text" style="width:50px;" name="anneef" value="<?php echo($anneef); ?>" maxlength="4" placeholder="aaaa" > -->
				<input type="text" class="datepicker" name="datefin" value="<?php echo($fin); ?>" readonly/>
				</div>
				</div>
				<!-- <?php echo form_error('jourd'); ?>
				<?php echo form_error('moisd'); ?>
				<?php echo form_error('anneed'); ?> -->
				<?php echo form_error('debut'); ?>
				<?php if(isset($message_error)) echo('<div class="error">'.$message_error.'</div>'); ?>
				<!-- <?php echo form_error('jourf'); ?>
				<?php echo form_error('moisf'); ?>
				<?php echo form_error('anneef'); ?> -->
				<?php echo form_error('fin'); ?>
				<?php if(isset($message_date_error)) echo('<div class="error">'.$message_date_error.'</div>'); ?>
			</pretty>
		
			<pretty>
				<input type="checkbox" name="web" value="ok" <?php if($campagne->CAM_WEB == "ok") echo'checked' ?>/>
				Campagne web
				<input type="checkbox" name="courrier" value="ok" <?php if($campagne->CAM_COURRIER == "ok") echo'checked' ?>/>
				Campagne courrier
				<input type="checkbox" name="email" value="ok" <?php if($campagne->CAM_EMAIL == "ok") echo'checked' ?>/>
				Campagne email
			</pretty>
			
			<div class="pull-left">
			Date de saisie : <?php echo $campagne->CAM_DATEADDED ?>
			<br>
			Dernière modification : <?php echo $campagne->CAM_DATEMODIF ?>
			</div>
			
			</div>
			</div>
			
			<div class="inline-block">
			<div class="inner-block">
			<pretty>
				<div class="control-group">
				<label class="control-label" for="description">Description</label>
				<div class="controls">
				<textarea name="description" rows="5" cols="40" ><?php echo($campagne->CAM_DESCRIPTION); ?></textarea>
				<?php echo form_error('description'); ?>
				</div>
				</div>
				
				<div class="control-group">
				<label class="control-label" for="description">Objectifs</label>
				<div class="controls">
				<input type="text" name="objectif" value="<?php echo($campagne->CAM_OBJECTIF); ?>"> €
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
	<?php 
	}
	?>

</div>