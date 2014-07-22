<div id="content">
    <?php
    $error = $this->session->flashdata('error');
    $success = $this->session->flashdata('success');
    if ($success) :
        ?>
        <div id="success-message" class="alert alert-success">
            <?php echo $success; ?>
        </div>
    <?php
    endif;
    if ($error) :
        ?>
        <div id="error-message" class="alert alert-error">
        <?php echo $error; ?>
        </div>
<?php endif; ?>

    <a href="<?php echo (site_url('admin/reglage')); ?>">Réglage de critères existants</a>
    <br/> <br/>
    <a href="<?php echo (site_url('admin/infoComplementaires')); ?>">Informations complémentaire sur les contacts</a>
    <br/> <br/>
    <a href="<?php echo (site_url('admin/dedoublonnage')); ?>">Dédoublonnage manuel</a>
    <br/> <br/>
    <a href="<?php echo (site_url('admin/user_signup')); ?>">Inscrire un utilisateur</a>
    <br/> <br/>
    <a href="<?php echo (site_url('admin/database/all')); ?>">Gestion base de données</a>
</div>
