<?php
	if($div == "oui") echo('<div id="list">');
	else{
		echo('<div class="well"><h2>Offres rattachées au contact : '.$contact[0]->CON_FIRSTNAME.' '.$contact[0]->CON_LASTNAME.'</h2></div>');
		echo('<div><div class="pull-right"><table class="table table-striped">
		<tr><td>Pourcentage de réponse aux offres = '.$nb_reponses*100/$nb_offres.'% &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp </td>  <td>Nombre de réponses aux offres = '.$nb_reponses.'&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp </td> <td>Nombre d\'offres rattachées au contact = '.$nb_offres.'</tr></table></div></div>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp');
	}
?>
<?php if (count($items) == 0) : ?>
        <p class="no-result">Aucun résultat.</p>
	<?php else : ?>

		<table class="table table-striped">
			<tr>
				<th></th>
				<th>Code</th>
				<th>Titre de l'offre</th>
				<th>Date de fin</th>
			</tr>

			<?php foreach($items as $offre) : ?>
				<tr>
					<td>
						<a href="<?php echo site_url('offre/edit').'/'.$offre->OFF_ID; ?>" class='icon-edit'></a>
						<a href="<?php echo site_url('offre/remove').'/'.$offre->OFF_ID; ?>" class='icon-remove' onclick="if (window.confirm(\'Êtes-vous sûr de vouloir supprimer ce segment ?\')) {return true;}else{return false;}"></a>
					</td>
					<td><?php echo $offre->OFF_ID; ?></td>
					<td><?php echo $offre->OFF_NOM; ?></td>
					<td><?php echo date_usfr($offre->OFF_FIN); ?></td>
				</tr>
			<?php endforeach; ?>
		</table>
	<?php endif; ?>
</div>
