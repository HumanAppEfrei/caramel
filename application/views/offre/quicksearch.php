<!-- Recherche Rapide -->
<header>
    <form method="post" name="quicksearch" class="well form-search" <?php echo ('action="'.site_url('offre/quicksearch').'"'); ?>>
        <input name= "is_form_sent" type="hidden" value="true">
        <select  name="selection">
            <option  value="code" title="Identifiant d'une offre (unique)" >Code</option>
            <option  value="libelle" title="Description d'une offre" >Libelle</option>
        </select>
        <input type="text" name="recherche" value="" />

        <button type="submit" class="btn" value="Rechercher" title="Permet d'effectuer une recherche en fonction d'un code ou d'un libellé" >Recherche rapide</button>

        <div id="searchPattern">
            <a class="btn pull-center" href=<?php echo (site_url('offre/search')); ?> title="Permet d'effectuer une recherche en fonction de plusieurs critères" >Recherche avancée</a>
            <a class="btn btn-primary" href=<?php echo (site_url('offre/create')); ?> title="Permet de créer une nouvelle offre" >Créer une nouvelle offre</a>
        </div>
    </form>
</header>