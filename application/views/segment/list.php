<div id="list">
	<?php if (count($items) == 0) : ?>
        <p class="no-result">Aucun résultat.</p>
    <?php else : ?>
		<table class="table table-striped">
            <tr>
                <th></th>
                <th>Code</th>
                <th>Libellé</th>
                <th>Date d ajout</th>
            </tr>

            <?php foreach($items as $segment) :	?>
                <tr>
                    <td>
						<a href="<?php echo site_url('segment/edit').'/'.$segment->SEG_CODE; ?>" class='icon-edit'></a>
						<a href="<?php echo site_url('segment/edit').'/'.$segment->SEG_CODE; ?>" class='icon-remove'  onclick="if (window.confirm(\'Êtes-vous sûr de vouloir supprimer ce segment ?\')) {return true;}else{return false;}"></a>
					</td>
                    <td><?php echo $segment->SEG_CODE; ?></td>
                    <td><?php echo $segment->SEG_LIBELLE; ?></td>
                    <td><?php echo explode(' ', date_usfr($segment->SEG_DATEADDED, true))[0]; ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
	<?php endif; ?>
</div>
