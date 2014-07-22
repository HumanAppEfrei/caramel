<div id="menu">
    <div class="tabbable">
        <ul class="nav nav-tabs">
            <li><a href="<?php echo(site_url('contact/edit') . '/' . $contact[0]->CON_ID); ?>" > Informations</a></li>
            <li><a href="<?php echo site_url('contact/list_dons') . '/' . $contact[0]->CON_ID; ?>" >Dons</a></li>
            <li><a href="<?php echo site_url('don/export') . '/' . $contact[0]->CON_ID; ?>" >Exporter les dons</a></li>
            <li><a href="<?php echo site_url('contact/list_offres') . '/' . $contact[0]->CON_ID; ?>" >Offres</a></li>
            <li><a href="<?php echo site_url('contact/infos_comp') . '/' . $contact[0]->CON_ID; ?>" >Informations complémentaires</a></li>
            <li><a href="<?php echo site_url('contact/historique') . '/' . $contact[0]->CON_ID; ?>" >Historique</a></li>
        </ul>
    </div>

    <!-- data-toggle="tab" supprimé car ça faisait tout buguer : on ne pouvait plus acceder aux pages... ça servait à quoi?-->
