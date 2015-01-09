<!-- Recherche Rapide -->
<header>
    <form method="post" name="quicksearch" class="well form-search" action="<?php echo site_url('don/quicksearch'); ?>">
	<input name= "is_form_sent" type="hidden" value="true"/>
    
	<select  name="search-type">
		<option  value="code" title="Identification d'un versement (unique)">Code de versement</option>
		<option  value="source" title="Identification d'un contact (unique)">Numéro d'adhérent</option>
	</select>
	<input type="text" name="search-value" value="" />
	<button type="submit" class="btn" value="Rechercher" title="Permet d'effectuer une recherche par code de versement ou code d’adhérent. Laisser en blanc pour afficher tout">Recherche rapide</button>
	
	<div id="searchPattern">
        <a class="btn pull-center" title="Permet d'effectuer une recherche en fonction de plusieurs critères" href=<?php echo (site_url('don/search')); ?>>Recherche avancée</a>
        <a class="btn btn-primary" title="Permet de créer un nouveau versement" href=<?php echo (site_url('don/create')); ?>>Créer un nouveau versement</a>
	</div>
</form>
</header>