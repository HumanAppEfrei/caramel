<!-- Recherche Rapide -->
<header>
    <form method="post" name="quicksearch" class="well form-search" <?php echo ('action="'.site_url('contact/quicksearch').'"'); ?>>
        <input name= "is_form_sent" type="hidden" value="true">
        <input type="text" name="recherche"  />
        <button type="submit" class="btn" value="Rechercher">Recherche rapide</button>

        <div id="searchPattern">
            <a class="btn pull-center" href=<?php echo (site_url('contact/search')); ?>>Recherche avancée</a>	
            <a class="btn btn-primary" href=<?php echo (site_url('contact/create')); ?>>Créer un nouveau contact</a>
        </div>
    </form>
</header>
