<!-- Recherche Rapide -->
<header>
    <form method="post" name="quicksearch" class="well form-search" <?php echo ('action="'.site_url('campagne/quicksearch').'"'); ?>>
        <input name= "is_form_sent" type="hidden" value="true">
        <select  name="selection">
            <option  value="code">Code</option>
            <option  value="nom">Nom</option>
        </select>
        <input type="text" name="recherche" value="" />

        <button type="submit" class="btn" value="Rechercher">Recherche rapide</button>

        <div id="searchPattern">
            <a class="btn pull-center" href=<?php echo (site_url('campagne/search')); ?>>Recherche avancée</a>
            <a class="btn btn-primary" href=<?php echo (site_url('campagne/create')); ?>>Créer une nouvelle campagne</a>
        </div>
    </form>
</header>