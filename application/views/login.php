<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <title>CaRaMel - Connexion</title>
  <link href="<?php echo css_url('style_login'); ?>" type="text/css" rel="stylesheet" />
  <link href="<?php echo css_url('bootstrap2'); ?>" type="text/css" rel="stylesheet" />

  <script language="Javascript" SRC="<?php echo base_url().'assets/javascript/jquery.js'?>" ></script>
  <script language="Javascript" SRC="<?php echo base_url().'assets/javascript/jquery-1.7.1.js'?>" ></script>
  <script language="Javascript" SRC="<?php echo base_url().'assets/javascript/bootstrap.js'?>" ></script>
  <script language="Javascript" SRC="<?php echo base_url().'assets/javascript/form-script.js'?>" ></script>
  <script language="Javascript" SRC="<?php echo base_url().'assets/javascript/jquery.validate.min.js'?>" ></script>
</head>
<body id="fixed-body">

  <div id="vertical">
    <div id="fixed-container">
      <!-- Bloc fixe orange -->
      <div id="title"></div>
      <div id="news-block">
        <?php      
        if(strlen($alert) > 1) {
          echo('  <div id="error-block">
            <div class="alert alert-error">
              <button type="button" class="close" data-dismiss="alert">×</button>
              <strong>Erreur !</strong> Identifiant/Mot de passe incorrect(s)
            </div>
          </div>
          ');
        }?>
      </div>
      <div id="login-container">
        <!-- Formulaire de connexion -->
        <form method="post"  <?php echo ('action="'.site_url("login/connect").'"'); ?>>
          <div class="control-group">
            <div class="controls">
              <div class="input-prepend">
                <span class="add-on"><i class="icon-user"></i></span>
                <input class="span2" name="username" id="inputIcon" type="text" placeholder="Identifiant" />
              </div>
            </div>
          </div>
          <div class="control-group">
            <div class="controls">
              <div class="input-prepend">
                <span class="add-on"><i class="icon-eye-open"></i></span>
                <input class="span2" name="password" id="inputIcon" type="password" placeholder="Mot de passe" />
              </div>
            </div>
          </div>

            <div id="margin-connexion"><input type="submit" button class="btn btn-primary" value="Connexion" /></div>
        </form>
      </div><!-- Fin Formulaire de connexion -->
    </div>
  </div>

</body>
</html>