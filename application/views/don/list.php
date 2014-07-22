<?php if($not_for_contact) : ?>
    <div id="list">
<?php else : ?>
    <h2>Dons du contact : <?php echo $contact[0]->CON_FIRSTNAME.' '.$contact[0]->CON_LASTNAME; ?></h2>

    <div>
        <p><a class="btn" href="<?php echo site_url('don/create').'/'.$contact[0]->CON_ID; ?>">Ajouter un nouveau don</a>
            <?php if ($nbDonsSansRecu) : ?>
            <a class="btn" href="<?php echo site_url('don/recu_fiscal').'/'.$urlDonsSansRecu; ?>">Générer un reçu pour tous ceux manquant (<?php echo "$nbDonsSansRecu"; ?>)</a>
            <?php endif; ?>
        </p>
        
        <?php if(isset($stats) AND count($items) != 0) : ?>
        <p>Nombre : <?php echo count($items); ?> don<?php echo (count($items) > 1) ? "s" : null ; ?> | 
            Montant moyen : <?php echo $stats[0]->moyenne; ?> € | 
            Montant maximum : <?php echo $stats[0]->maximum; ?> € | 
            Montant minimum : <?php echo $stats[0]->minimum; ?> € | 
            Total des dons : <?php echo $stats[0]->total; ?> €
        </p>
        <?php endif; ?>
    </div>
<?php endif;

    if (count($items) == 0 || !$items) : ?>
        <p class="no-result">Aucun résultat.</p>
    <?php else : ?>
        <table class="table table-striped">
            <tr>
                <th></th>
                <th>Code</th>
                <th>Identifiant contact</th>
                <th>Montant</th>
                <th>Type de versement</th>
                <th>Date de saisie</th>
                <th>Reçu fiscal</th>
            </tr>
            
            <?php foreach($items as $don) :	?>
                <tr>
                    <td>
						<a href="<?php echo site_url('don/edit').'/'.$don->DON_ID; ?>"><img src="<?php echo img_url('icons/edit.png'); ?>"/></a>
						<a href="<?php echo site_url('don/remove').'/'.$don->DON_ID; ?>" onclick="if (window.confirm(\'Êtes-vous sûr de vouloir supprimer ce don ?\')) {return true;}else{return false;}"><img src="<?php echo img_url('icons/drop.png'); ?>"/></a>
					</td>
                    <td><a href="<?php echo site_url('don/edit').'/'.$don->DON_ID; ?>"><?php echo $don->DON_ID; ?></a></td>
                    <td><a href="<?php echo site_url('contact/edit').'/'.$don->CON_ID; ?>"><?php echo $don->CON_ID; ?></a></td>
                    <td><?php echo $don->DON_MONTANT; ?> €</td>
                    <td><?php echo $don->DON_TYPE; ?></td>
                    <td><?php echo date_usfr($don->DON_DATE, false); ?></td>
                    <td><a class="btn btn-mini" href="<?php echo site_url('don/recu_fiscal').'/'.$don->DON_ID; ?>"><?php echo ($don->DON_RECU_ID != NULL) ? "Voir le duplicata (#".$don->DON_RECU_ID.")" :  "Éditer maintenant"; ?></a></td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
		<?php if (isset($pagination)){
			
			echo $pagination;
		} ?>
    </div>