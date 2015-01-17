<div id="menu">
    <div class="tabbable">
        <ul class="nav nav-tabs">
            <li><a href="<?php echo(site_url('contact/edit') . '/' . $contact[0]->CON_ID); ?>" title="Informations générales du contact" > Informations</a></li>
            <li><a href="<?php echo site_url('contact/list_dons') . '/' . $contact[0]->CON_ID; ?>" title="Historique des dons réalisés par le contact" >Dons</a></li>
            <li><a href="<?php echo site_url('don/export') . '/' . $contact[0]->CON_ID; ?>" title="Exporter la feuille de dons au format CSV" >Exporter les dons</a></li>
            <li><a href="<?php echo site_url('contact/list_offres') . '/' . $contact[0]->CON_ID; ?>" title="Informtions relatives aux offres de la campagne">Offres</a></li>
            <li><a href="<?php echo site_url('contact/infos_comp') . '/' . $contact[0]->CON_ID; ?>" title="Informations supplémentaires liées au contact">Informations complémentaires</a></li>
            <li><a href="<?php echo site_url('contact/historique') . '/' . $contact[0]->CON_ID; ?>" title="Historique des modifications apportées au contact" >Historique</a></li>
        </ul>
    </div>

    <!-- data-toggle="tab" supprimé car ça faisait tout buguer : on ne pouvait plus acceder aux pages... ça servait à quoi?-->
