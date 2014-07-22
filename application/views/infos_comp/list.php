<div id="list">
	<table class="table table-striped">
	<?php 
		echo('<tr>');
		echo('<td> </td>');
		echo('<td>'.'Informations complémentaires des contacts'.'</td>');
		echo('<td>'.'Type'.'</td>');
		echo('</tr>');
		
		foreach($infos_comp as $info) {		
			echo('<td> <a href="'.site_url('admin/removeIC').'/'.$info->IC_ID.'" onclick="if(window.confirm(\'Etes vous sur ?\')){return true;}else{return false;}"> <img src="'.img_url('icons/drop.png').'"/> </a> </td>');
			echo('<td>'.$info->IC_LABEL.'</td>');
			echo('<td>'.$info->IC_TYPE.'</td>');
			echo('</tr>');
		}
	?>
	</table>
		<br/>
	<a href="<?php echo site_url('admin/createIC')?>"><input type="button" value="Ajouter une information complémentaire" /></a>
</div>