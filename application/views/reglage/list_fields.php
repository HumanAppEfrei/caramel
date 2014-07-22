<div>
    <div id="list">
        <div class='well'><h4>Champs de la table <?php echo $table; ?></h4></div>
        <form method='POST'>
            <table class="table table-striped">
                <tr>
                    <th>Champs</th>
                    <th>Noms</th>
                </tr>
                <?php
                for ($i = 0; $i < count($fields); $i++) {
                    ?>
                    <tr>
                        <td><?php echo $fields[$i]->tabl_field; ?></td>
                        <td><input type='text' name='<?php echo $fields[$i]->tabl_field_id; ?>' value="<?php echo $fields[$i]->tabl_field_name; ?>"></td>
                    </tr>
                    <?php
                }
                ?>
            </table>
            <center>
                <button type="submit" name="submit" class="btn btn-success btn-large">Sauvegarder</button>
                <a href="<?php echo site_url('admin/database/all'); ?>">
                    <button class="btn" type="button">Retour</button>
                </a>
            </center>
        </form>
    </div>
</div>