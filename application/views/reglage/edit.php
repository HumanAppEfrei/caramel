<div id="edit">

	<div class="message"><p><h3>Réglage paramètre :<?php echo($NomReglage) ?> </h3></p></div>

	<form method="post" name="editDon" <?php echo ('action="'.site_url("admin/editReg").'/'.$RegCode.'"'); ?> >
	
	<input name= "is_form_sent" type="hidden" value="true">
	
<?php 

	foreach($valeurs as $valeur)
	{	
		echo($valeur.'<a href="'.site_url('admin/removeReg').'/'.$RegCode.'/'.$valeur.'" onclick="if(window.confirm(\'Etes vous sur ?\')){return true;}else{return false;}"> <img src="'.img_url('icons/drop.png').'"/> </a> ,');
	}
	?>
	<br/>
	<input type="text" name="valeurAjoutee"/> <input type="submit" value="Ajouter" />
	<br/><?php echo form_error('valeurAjoutee'); ?><br/>
	<a href="<?php echo site_url('admin/reglage')?>"><input type="button" value="Retour"/></a>
		
	</form>
	
</div>