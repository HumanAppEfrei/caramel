<form class="form-horizontal" method="post" action="<?php echo site_url('document/edit_type/' . $type->TYP_ID) ?>">
    <div id="content-form">
        <div class="input-prepend">
            <div class="control-group">
                <label class="control-label" for="titre">Type</label>
                <div class="controls">
                    <input class="span2" name="typ_name" type="text" value="<?php echo $type->TYP_NAME; ?>" >
                    <?php echo "<br/>" . form_error('titre'); ?>
                </div>
            </div>
            <input name= "is_form_sent" type="hidden" value="true">	
        </div>
    </div>

    <div id="button-container">
        <center>
            <div id="button-position" style="margin-top: 20px">
                <button class="btn btn-small" type="submit">Sauvegarder</button>
                <a href="<?php echo site_url('document/type') ?>" ><button class="btn btn-small" type="button">Retour</button></a>
            </div>
        </center>
    </div>
</form>
