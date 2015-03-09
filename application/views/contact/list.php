<?php if($div == "oui") echo('<div id="list">'); ?>
<?php if (count($items) == 0 || !$items) : ?>
        <p class="no-result">Aucun résultat.</p>
    <?php else : ?>

<table class="table table-striped">
			<tr>
				<th></th>
				<th>Identifiant contact</th>
				<th>Nom</th>
				<th>Prénom</th>
				<th>Type</th>
			</tr>

			<?php foreach($items as $contact) : ?>
				<tr>
					<td>
						<a href="<?php echo site_url('contact/edit').'/'.$contact->CON_ID; ?>" class ='icon-edit'></a>
						<a href="<?php echo site_url('contact/remove').'/'.$contact->CON_ID; ?>" class="icon-remove" onclick="if (window.confirm(\'Êtes-vous sûr de vouloir supprimer ce segment ?\')) {return true;}else{return false;}"></a>
					</td>
					<td><?php echo $contact->CON_ID; ?></td>
					<td><?php echo $contact->CON_LASTNAME; ?></td>
					<td><?php echo $contact->CON_FIRSTNAME; ?></td>
					<td><?php echo $contact->CON_TYPEC; ?></td>
				</tr>
			<?php endforeach; ?>
		</table>
	<?php endif; ?>
	<?php
		if (isset($pagination))
            echo $pagination; ?>
</div>
