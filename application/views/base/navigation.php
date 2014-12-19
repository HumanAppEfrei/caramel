			
<div class="navbar">
	<div class="navbar-inner">
		<div class="container">	
	<nav id="navigation">
			<ul>
				<li><a href = <?php echo (site_url('')); ?> title="Retour à l'accueil">
				<img <?php echo('src="'.img_url('icons/home.png').'"'); ?> alt="Home"/> </a></li>
				<li>
				<a href="<?php echo (site_url('contact')); ?>" title="Permet de créer, éditer ou supprimer un ou des contacts de la base de données.">Contacts</a>
				</li>
				<li>
				<a href="<?php echo (site_url('don')); ?>" title="Permet de créer, rechercher, éditer, supprimer un nouveau versement, et éditer un reçu fiscal">Versements</a>
				</li>
				<li>
				<a href="<?php echo (site_url('campagne')); ?>" title="Permet de créer, rechercher, éditer, supprimer une nouvelle campagne">Campagnes</a>
				</li>
				<li>
				<a href="<?php echo (site_url('offre')); ?>" title="Permet de créer, rechercher, éditer, supprimer une nouvelle offre" >Offres</a>
				</li>
				<li>
				<a href="<?php echo (site_url('segment')); ?>" title="Permet de créer, rechercher, éditer, supprimer un nouveau segment">Segments</a>
				</li>
			</ul>
	</nav>

	<!--
			<ul>
				<li class="menu">
				<a> <?php echo($username) ?> </a>
				</li>
			<ul>
	-->
	
	<nav id="navigation" style="margin-left: 800px">
			<ul>
				<li><a href = <?php echo (site_url('stat')); ?> title="Accès aux outils statistiques">
				<img <?php echo('src="'.img_url('icons/stat.png').'"'); ?> alt="Statistics"/> </a></li>
				<li><a href = <?php echo (site_url('document')); ?> title="Edition de reçus fiscaux et de lettres pré-enregistrées" >
				<img <?php echo('src="'.img_url('icons/document.png').'"'); ?> alt="Documents"/> </a></li>
				<!-- <li><a href = <?php echo (site_url('user')); ?> title="Utilisateur">
				<img <?php echo('src="'.img_url('icons/user.png').'"'); ?> alt="User"/> </a></li> -->
				<li><a href = <?php echo (site_url('admin')); ?> title="Accès aux paramètres de Caramel">
				<img <?php echo('src="'.img_url('icons/admin.png').'"'); ?> alt="Admin"/> </a></li>
				<li><a href = <?php echo (site_url('login/disconnect')); ?> title="Fermeture de votre compte">
				<img <?php echo('src="'.img_url('icons/logout.png').'"'); ?> alt="Logout"/> </a></li>
			</ul>
	</nav>

		</div>
	</div>
</div>

