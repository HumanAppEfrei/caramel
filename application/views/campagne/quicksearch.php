<!-- Recherche Rapide -->
<header>
    <form method="post" name="quicksearch" class="well form-search" <?php echo ('action="'.site_url('campagne/quicksearch').'"'); ?>>
        <input name= "is_form_sent" type="hidden" value="true">
        <select  name="selection">
            <option  value="code" title="Identifiant d'une campagne (unique) " >Code</option>
            <option  value="nom" title="Nom de la campagne" >Nom</option>
        </select>
        <input type="text" name="recherche" value="" />

        <button type="submit" class="btn" value="Rechercher" title="Permet d'effectuer une recherche en fonction d'un code ou d'un nom. Laisser le champ vide permet d'afficher toute la liste">Recherche rapide</button>

        <div id="searchPattern">
            <a class="btn pull-center" href=<?php echo (site_url('campagne/search')); ?> title="Permet d'effectuer une recherche en fonction de plusieurs critères">Recherche avancée</a>
            <a class="btn btn-primary" href=<?php echo (site_url('campagne/create')); ?> title="Permet de créer une nouvelle campagne">Créer une nouvelle campagne</a>
        </div>
    </form>
</header>