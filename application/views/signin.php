<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>CaRaMel - Inscription</title>
		<link href="<?php echo css_url('style_login'); ?>" type="text/css" rel="stylesheet" />
	</head>
	<body>
		<div id="page">
		
			<div id="title">
			CaRaMel
			</div>

			<div id="login">
				
				
				<div class="message"><p>Formulaire de demande de compte.</p></div>
				
				<p>Inscription : </p>
				
				<form method="post" <?php echo ('action="'.site_url("signin/create_user").'"'); ?>>
					<label for="firstname">Prénom :</label>
					<input type="text" name="firstname" value="" />
					<br/>
					<label for="lastname">Nom :</label>
					<input type="text" name="lastname" value="" />
					<br/>
					<br/>
					
					<label for="username">Nom d'utilisateur :</label>
					<input type="text" name="username" value="" />
					<br/>
					<label for="email">Adresse e-mail :</label>
					<input type="text" name="email" value="" />
					<br/>
					<br/>
					
					<label for="password">Mot de passe :</label>
					<input type="password" name="password" value="" />
					<br/>
					<label for="passwordverif">Répétez le MDP :</label>
					<input type="password" name="passwordverif" value="" />
					<br/>
					<p><input type="submit" value="Valider" /></p>
				</form>
				
				
					<?php      
					echo('<div id = "alert">'.$alert.'</div>');
					?>
					
					
			</div>
			
			<div id="footer">
			</div>
			
		</div> <!--fin de la div "page"-->
	</body>
</html>