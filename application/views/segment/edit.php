<div id= "content">
	
<?php 
	foreach($items as $segment)
	{	
	?>
	<h2>Editer le segment : <?php echo($segment->SEG_CODE)?></h2>
    <a href="<?php echo site_url('segment/export')."/".$segment->SEG_CODE?>"><input type="button" value="Exporter les cibles potentielles" /> </a>
	<a href="<?php echo site_url('segment/potentiel')."/".$segment->SEG_CODE?>"><input type="button" value="Cible potentielle du segment" class='right'/></a>
	
	
	<form method="post" name="editSegment" <?php echo ('action="'.site_url("segment/edit/".$segment->SEG_CODE).'"'); ?> Onsubmit='return window.confirm("Attention, des données risquent d être écrasées\nSouhaitez vous continuez?");'>
	
	<input name= "is_form_sent" type="hidden" value="true">
	<pretty>
		Code :<?php echo($segment->SEG_CODE) ?>
		<div class="pull-right"> Date de création :<?php echo $segment->SEG_DATEADDED ?> </div>
		<br/>
		Libellé :<input type="text" name="libelle" value=<?php echo('"'.$segment->SEG_LIBELLE.'"')?> size=37 title="champ obligatoire" required/>*
		<div class="pull-right"> Dernière modification : <?php echo $segment->SEG_DATEMODIF ?> </div>
		<br/>
		<?php echo form_error('libelle'); ?>
		

	</pretty>	
		<br/>
	<div id='critere'> <table class="table table-striped">
<?php
	$critere = end($criteres);
	if($critere) $endcritID = $critere->CRIT_ID;
	
	$critere = reset($criteres);
	while($critere)
	{
		$valeur = convert_valeur($critere->CRIT_ATTRIBUT,$critere->CRIT_TYPE,$critere->CRIT_VAL);
		?>
		<tr>
			<td><?php echo convert_contrainte($critere->CRIT_ATTRIBUT);?></td>
			<td><?php echo $critere->CRIT_COMP;?></td>			
			<td><?php echo $valeur[0] ?></td>
			<td><?php echo $valeur[1] ?></td>
			<td><?php if($critere->CRIT_ID == $endcritID) echo('<a href="'.site_url('segment/removeCritere').'/'.$segment->SEG_CODE.'/'.$critere->CRIT_ID.'" 
						onclick="if(window.confirm(\'Etes vous sur ?\')){return true;}else{return false;}"> <img src="'.img_url('icons/drop.png').'"/> </a>');?></td>
		</tr>
		<?php
		$id1 = $critere->CRIT_ID;
		if($critere = next($criteres))
		{
			$id2 = $critere->CRIT_ID; 
?>
			<tr><td>
			et<INPUT type=radio name="<?php echo($id1."_".$id2)?>" value="et" <?php if($links["'".$id1.",".$id2."'"] == "et") echo 'checked'; ?>>
			ou<INPUT type=radio name="<?php echo($id1."_".$id2)?>" value="ou" <?php if($links["'".$id1.",".$id2."'"] == "ou") echo 'checked';?>>
			</td></tr>
<?php	}
	}
	if(!isset($id1)) $id1="";
	
?>
	</table>
	<br/>
	
<?php if($segment->SEG_EDIT) { ?> <!-- ajout possible que si le segment n'est pas bloqué -->
	<a href="<?php echo site_url('segment/addCritere/'.$segment->SEG_CODE.'/'.$id1)?>"><input type="button" value="Ajouter un critère"/></a>
<?php } ?>

	<p>NB : Le 'et' est prioritaire sur le 'ou'.</p>
	</div>
	
	<p>
		<a href="<?php echo site_url('segment')?>"><input type="button" value="Retour"/></a>    
	<?php if($segment->SEG_EDIT) { ?>	<input type="submit" value="Sauvegarder"/> <?php } ?>
	</p>
		
	</form>
	
	<?php 
	}
	?>
</div>
