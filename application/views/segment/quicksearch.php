<!-- Recherche Rapide -->
<header>
    <form method="post" name="quicksearch" class="well form-search" <?php echo ('action="'.site_url('segment/quicksearch').'"'); ?>>
        <input name= "is_form_sent" type="hidden" value="true">
        <select  name="selection">
            <option  value="code">Code</option>
            <option  value="libelle">Libellé</option>
        </select>
        <input type="text" name="recherche"  />

        <button type="submit" class="btn" value="Rechercher">Recherche rapide</button>

        <div id="searchPattern">
            <a class="btn pull-center" href=<?php echo (site_url('segment/search')); ?>>Recherche avancée</a>
            <a class="btn btn-primary" href=<?php echo (site_url('segment/create')); ?>>Créer un nouveau segment</a>
        </div>
    </form>
</header>