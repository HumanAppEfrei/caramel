<div id="content">
    <form method="post" name="generate-choix_contact" class="well form-search" <?php echo ('action="' . site_url('document/generate_lettre') . '/' . $lettreID . '"'); ?>>
        <input name= "is_form_sent" type="hidden" value="true"/>
        Générer pour :
        <select id="selection" name="selection">
            <option value="contact" <?php if (set_value('selection') == "contact") echo'selected' ?> >Un contact</option>
            <option value="offre" <?php if (set_value('selection') == "offre") echo'selected' ?> >Toute une cible d'offre</option>
            <option value="segment" <?php if (set_value('selection') == "segment") echo'selected' ?> >Un segment</option>
        </select><br/>

        Veuillez saisir l'identifiant correspondant pour la génération : <br/>
        <input name= "identifiant" type="text" value="<?php echo set_value('identifiant'); ?>"/>
        <?php echo "<br/>" . form_error('identifiant'); ?>
        <?php echo $error; ?>
        <button type="submit" class="btn">Générer</button>
</div>
