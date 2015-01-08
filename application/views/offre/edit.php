<div id="edit">

<?php 
	foreach($items as $offre)
	{	
		$split1 = @split("-",$offre->OFF_DEBUT); 
		$anneed = $split1[0]; 
		$moisd = $split1[1]; 
		$jourTmpd = $split1[2];
		
		if($jourTmpd[0] =='0') $jourd = $jourTmpd[1];
		else $jourd = $jourTmpd;
		
		if($jourTmpd[0] =='0' && $jourTmpd[1] =='0') $jourd = "";
		if($moisd[0] =='0' && $moisd[1] =='0') $moisd = "";
		if($anneed[0] =='0' && $anneed[1] =='0' && $anneed[2] =='0' && $anneed[3] =='0')  $anneed = "";
		
		$split2 = @split("-",$offre->OFF_FIN); 
		$anneef = $split2[0]; 
		$moisf = $split2[1]; 
		$jourTmpf = $split2[2];
		
		if($jourTmpf[0] =='0') $jourf = $jourTmpf[1];
		else $jourf = $jourTmpf;
		
		if($jourTmpf[0] =='0' && $jourTmpf[1] =='0') $jourf = "";
		if($moisf[0] =='0' && $moisf[1] =='0') $moisf = "";
		if($anneef[0] =='0' && $anneef[1] =='0' && $anneef[2] =='0' && $anneef[3] =='0')  $anneef = "";
?>
	
	<div class="well"><h2>Edition de l'offre : <?php echo($offre->OFF_NOM)?> </h2></div>
	
	<form method="post" class="form-horizontal" name="editOffre" <?php echo ('action="'.site_url("offre/edit/".$offre->OFF_ID).'"'); ?> Onsubmit='return window.confirm("Attention, des données risquent d être écrasées\nSouhaitez vous continuez?");'>
	
		<input name= "is_form_sent" type="hidden" value="true">
		
		
		<div class="inline-block">
		<div class="inner-block">
		
		<pretty>
		<div class="control-group">
			<label class="control-label" for="code" title="Code de l'offre (unique)">Code</label>
			<div class="controls">
				<input type="text" name="libelle" value="<?php echo($offre->OFF_ID);?>" readonly="readonly">
			</div>
		</div>

			<div class="control-group">
			<label class="control-label" for="Libele" title="Description de l'offre">libéllé</label>
			<div class="controls">
				<input type="text" name="libelle" value="<?php echo($offre->OFF_NOM);?>" >
				<?php echo form_error('libelle'); ?>
			</div>
			</div>
			</pretty>

			<pretty>
				<div class="control-group">
					<label class="control-label" for="dateDebut">Date de début</label>
					<div class="controls">
						<input type="text" style="width:40px;" name="jourd" value="<?php echo($jourd); ?>" maxlength="2" placeholder="dd" > /
						<input type="text" style="width:40px;" name="moisd" value="<?php echo($moisd); ?>" maxlength="2" placeholder="mm" > /
						<input type="text" style="width:50px;" name="anneed" value="<?php echo($anneed); ?>" maxlength="4" placeholder="aaaa" >
					</div>
				</div>

				<div class="control-group">
					<label class="control-label" for="dateDebut">Date de fin</label>
					<div class="controls">
						<input type="text" style="width:40px;" name="jourf" value="<?php echo($jourf); ?>" maxlength="2" placeholder="dd" > /
						<input type="text" style="width:40px;" name="moisf" value="<?php echo($moisf); ?>" maxlength="2" placeholder="mm" > /
						<input type="text" style="width:50px;" name="anneef" value="<?php echo($anneef); ?>" maxlength="4" placeholder="aaaa" >
						<?php echo form_error('jourd'); ?>
						<?php echo form_error('moisd'); ?>
						<?php echo form_error('anneed'); ?>
					</div>
				</div>

				<?php if(isset($message_debut)) echo('<div class="error">'.$message_debut.'</div>'); ?>
				<?php echo form_error('jourf'); ?>
				<?php echo form_error('moisf'); ?>
				<?php echo form_error('anneef'); ?>
				<?php if(isset($message_fin)) echo('<div class="error">'.$message_fin.'</div>'); ?>
			</pretty>
			
		
			
			<pretty>
				<div class="control-group">
					<label class="control-label" title="Offre en relation">Reliée à la campagne</label>
					<div class="controls">
						<a href=<?php echo site_url('campagne/edit').'/'.$campagne->CAM_ID;?>><?php echo $campagne->CAM_ID." : ".$campagne->CAM_NOM;?> </a></p>
					</div>
				</div>
			</pretty>
			
			<pretty>
				<div class="control-group">
					<label class="control-label" for="segments" title="Critères de selection" liés à l'offre>Segments associés </label>
					<div class="controls">
						<?php foreach($segments as $segment)
						{ ?>
							<div><a href=<?php echo site_url('segment/edit').'/'.$segment;?>><?php echo $segment;?></a></div>
				  <?php } ?>
						<br/>
							<a href="<?php echo site_url('cible/affich/'.$offre->OFF_ID);?>"><input class="btn" type="button" value="Voir la cible enregistrée"> </a> 
					</div>
				</div>
			</pretty>
			
			<div class="pull-left">
			Date de saisie : <?php echo $offre->OFF_DATEADDED ?>
			<br>
			Dernière modification : <?php echo $offre->OFF_DATEMODIF ?>
			</div>
			
			</div>
			</div>
			
			<div class="inline-block">
			<div class="inner-block">
			
			<pretty>
			<div class="control-group">
			<label class="control-label" for="description">Description</label>
			<div class="controls">
				<textarea name="description" rows="5" cols="40" ><?php echo($offre->OFF_DESCRIPTION); ?></textarea>
				<?php echo form_error('description'); ?>
			</div>
			</div>

			<div class="control-group">
			<label class="control-label" for="objectif">Objectif</label>
			<div class="controls">
				<input type="text" name="objectif" value="<?php echo($offre->OFF_OBJECTIF); ?>"> €
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