<!-- Recherche Rapide -->
<form method="post" name="quicksearch" class="well form-search" <?php echo ('action="' . site_url('document/quicksearch') . '"'); ?>>
    <input name= "is_form_sent" type="hidden" value="true">
    <select  name="selection" onchange='this.form.submit()'>
        <option  value="Types" <?php if (isset($modeChoice) && $modeChoice == "Types") echo 'selected'; ?> >Gestion des types</option>
        <option  value="Lettres" <?php if (isset($modeChoice) && $modeChoice == "Lettres") echo 'selected'; ?> >Edition des lettres</option>
    </select>
    <button type="submit" class="btn" value="Rechercher">Valider</button>

    <div id="searchPattern">
    <!--	<a class="btn pull-center" href=<?php echo (site_url('document/search')); ?>>Recherche avancée</a>	
    <a class="btn" href=<?php echo (site_url('document/create_letter')); ?>>Créer une nouvelle lettre</a>  -->
    </div>
</form>
