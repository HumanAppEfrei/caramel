<div id="content">
    <div id="documentButtons">
        <div id="centerButtons">
            <center>
                <div id="selectedButton">
                    <a href=<?php echo (site_url('document/create_type')); ?>>
                        <button class="btn btn-large btn-block btn-primary" type="button" id="buttonCreate">Créer</button><br/>
                    </a>
                </div>	
                <div id="selectedButton">
                    <button class="btn btn-large btn-block btn-inverse" type="button" id="buttonModif">Modifier</button><br/>
                </div>	
                <div id="selectedButton">
                    <button class="btn btn-large btn-block btn-danger" type="button" id="buttonSuppr">Supprimer</button><br/>
                </div>
            </center>
        </div>
    </div>

    <select id="selectTypes" name="fid[]" size="15" >
        <?php
        foreach ($types as $type) {
            echo "<option value='" . $type->TYP_ID . "'>" . $type->TYP_NAME . "</option>";
        }
        ?>
    </select>

    <select id="selectLetters" name="fid[]" size="15" disabled>
    </select>
</div>

<script>
    var baseURL = "<?php echo site_url('document'); ?>";
</script>
<script language="Javascript" SRC="<?php echo base_url() . 'assets/javascript/type.js' ?>" ></script>