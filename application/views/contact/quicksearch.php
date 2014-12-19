<!-- Recherche Rapide -->
<header>
    <form method="post" name="quicksearch" class="well form-search" <?php echo ('action="'.site_url('contact/quicksearch').'"'); ?>>
        <input name= "is_form_sent" type="hidden" value="true">
        <input type="text" name="recherche"  />
        <button type="submit" class="btn" value="Rechercher" title="Laissez le champ vide pour afficher la liste entière des contacts. Vous pouvez effectuer une recherche par nom, prénom ou identifiant contact">Recherche rapide</button>

        <div id="searchPattern">
            <a class="btn pull-center" href=<?php echo (site_url('contact/search')); ?> title="Permet d'effectuer une recherche en fonction de pluiseurs critères" Recherche avancée</a>	
            <a class="btn btn-primary" href=<?php echo (site_url('contact/create')); ?> title="Permet de créer un nouveau contact" >Créer un nouveau contact</a>
        </div>
    </form>
</header>
