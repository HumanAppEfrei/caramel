			
<div class="navbar">
	<div class="navbar-inner">
		<div class="container">	
	<nav id="navigation">
			<ul>
				<li><a href = <?php echo (site_url('')); ?> title="Home">
				<img <?php echo('src="'.img_url('icons/home.png').'"'); ?> alt="Home"/> </a></li>
				<li>
				<a href="<?php echo (site_url('contact')); ?>">Contacts</a>
				</li>
				<li>
				<a href="<?php echo (site_url('don')); ?>">Versements</a>
				</li>
				<li>
				<a href="<?php echo (site_url('campagne')); ?>">Campagnes</a>
				</li>
				<li>
				<a href="<?php echo (site_url('offre')); ?>">Offres</a>
				</li>
				<li>
				<a href="<?php echo (site_url('segment')); ?>">Segments</a>
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
				<li><a href = <?php echo (site_url('stat')); ?> title="Statistiques">
				<img <?php echo('src="'.img_url('icons/stat.png').'"'); ?> alt="Statistics"/> </a></li>
				<li><a href = <?php echo (site_url('document')); ?> title="Documents" >
				<img <?php echo('src="'.img_url('icons/document.png').'"'); ?> alt="Documents"/> </a></li>
				<!-- <li><a href = <?php echo (site_url('user')); ?> title="Utilisateur">
				<img <?php echo('src="'.img_url('icons/user.png').'"'); ?> alt="User"/> </a></li> -->
				<li><a href = <?php echo (site_url('admin')); ?> title="Réglages">
				<img <?php echo('src="'.img_url('icons/admin.png').'"'); ?> alt="Admin"/> </a></li>
				<li><a href = <?php echo (site_url('login/disconnect')); ?> title="Déconnexion">
				<img <?php echo('src="'.img_url('icons/logout.png').'"'); ?> alt="Logout"/> </a></li>
			</ul>
	</nav>

		</div>
	</div>
</div>

