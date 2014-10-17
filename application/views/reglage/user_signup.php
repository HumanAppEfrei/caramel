<div id="create">
    <h2 class="well">Créer un nouvel utilisateur</h2>

    <?php
    $form_errors = validation_errors();
    $messages = $this->session->flashdata('error');

    if ($form_errors != null OR $messages != null) : ?>
    <div class="alert alert-error">
        <h4>Le formulaire contient des erreurs :</h4><br/>
        <?php echo $form_errors; ?>
        <?php echo $messages; ?>
    </div>
    <?php endif;
    echo form_open("admin/user_signup", array('class' => 'form-horizontal'));
    echo form_hidden('form_sent', 'true');
    ?>

    <div class='control-group'>
        <?php echo form_label('Nom', 'lastname', array('class' => 'control-label')); ?>
        <div class='control'>
            <?php echo form_input(array('name' => 'lastname',
                'placeholder' => 'Dupond',
                'pattern' => '^[a-zA-Z]{1,30}$',
                'value' => set_value('lastname'))); ?>
        </div>
    </div>

    <div class='control-group'>
        <?php echo form_label('Prénom', 'firstname', array('class' => 'control-label')); ?>
        <div class='control'>
            <?php echo form_input(array('name' => 'firstname',
                'placeholder' => 'Martin',
                'pattern' => '^[a-zA-Z]{1,30}$',
                'value' => set_value('firstname'))); ?>
        </div>
    </div><br/>

    <div class='control-group'>
        <?php echo form_label("Nom d'utilisateur", 'username', array('class' => 'control-label')); ?>
        <div class='control'>
            <?php echo form_input(array('name' => 'username',
                'placeholder' => 'm.dupond',
                'pattern' => '^[a-zA-Z0-9_-]{1,30}$',
                'value' => set_value('username'))); ?>
        </div>
    </div>

    <div class='control-group'>
        <?php echo form_label('Adresse email', 'email', array('class' => 'control-label')); ?>
        <div class='control'>
            <?php echo form_input(array('type' => 'email',
                'name' => 'email',
                'placeholder' => 'm.dupond@domaine.com',
                'value' => set_value('email'))); ?>
        </div>
    </div><br/>

    <div class='control-group'>
        <?php echo form_label('Mot de passe', 'passwd', array('class' => 'control-label')); ?>
        <div class='control'>
            <?php echo form_password(array('name' => 'passwd',
                'placeholder' => '●●●●●●●●●●')); ?>
        </div>
    </div>

    <div class='control-group'>
        <?php echo form_label('Mot de passe (vérification)', 'passwd_chk', array('class' => 'control-label')); ?>
        <div class='control'>
            <?php echo form_password(array('name' => 'passwd_chk',
                'placeholder' => '●●●●●●●●●●')); ?>
        </div>
    </div><br/>

    <div class="control-group">
         <div class="controls">
             <?php
             echo form_submit(array(
                 'name' => 'submit_signup',
                 'value' => "Créer l'utilisateur",
                 'class' => 'btn btn-primary'));
             echo "</form>"; // Balise ouverte avec form_open()
             ?>
         </div>
    </div>
</div> <!-- #create -->