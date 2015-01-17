<!-- Recherche Rapide -->
<header>
    <form method="post" name="quicksearch" class="well form-search" <?php echo ('action="'.site_url('segment/quicksearch').'"'); ?>>
        <input name= "is_form_sent" type="hidden" value="true">
        <select  name="selection">
            <option  value="code" title="Identifiant d'un segment (unique)">Code</option>
            <option  value="libelle" title="Description d'un segment">Libellé</option>
        </select>
        <input type="text" name="recherche"  />

        <button type="submit" class="btn" value="Rechercher" title="Permet d'effectuer une recherche en fonction d'un code ou d'in libellé. Laisser le champ vide permet d'afficher toute la liste">Recherche rapide</button>

        <div id="searchPattern">
            <a class="btn pull-center" href=<?php echo (site_url('segment/search')); ?> title="Permet d'effectuer une recherche en fonciton de plusieurs critères">Recherche avancée</a>
            <a class="btn btn-primary" href=<?php echo (site_url('segment/create')); ?> title="Permet de créer un nouveau segment">Créer un nouveau segment</a>
        </div>
    </form>
</header>