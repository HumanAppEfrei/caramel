<?php if($div == "oui") echo('<div id="list">'); ?>
<?php if (count($items) == 0) : ?>
        <p class="no-result">Aucun résultat.</p>
    <?php else : ?>

		<table class="table table-striped">
			<tr>
				<th></th>
				<th>Code</th>
				<th>Nom</th>
				<th>Date de début</th>
				<th>Date de fin</th>
				<th>Type de campagne</th>
			</tr>

			<?php foreach($items as $campagne) : ?>
				<tr>
					<td>
						<a href="<?php echo site_url('campagne/edit').'/'.$campagne->CAM_ID; ?>" class='icon-edit'></a>
						<a href="<?php echo site_url('campagne/edit').'/'.$campagne->CAM_ID; ?>" class='icon-remove' onclick="if (window.confirm(\'Êtes-vous sûr de vouloir supprimer ce segment ?\')) {return true;}else{return false;}"></a>
					</td>
					<td><?php echo $campagne->CAM_ID; ?></td>
					<td><?php echo $campagne->CAM_NOM; ?></td>
					<td><?php echo date_usfr($campagne->CAM_DEBUT); ?></td>
					<td><?php echo date_usfr($campagne->CAM_FIN); ?></td>
					<td><?php echo $campagne->CAM_TYPE; ?></td>
				</tr>
			<?php endforeach; ?>
		</table>
	<?php endif; ?>
</div>
