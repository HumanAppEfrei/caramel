<div>
    <div id="list">
        <?php
        if (count($tables) != 0) {
            //affiche le nombre de table ou champ ajouté
            if (isset($to_display) && $to_display)
                if ($added_table == 0 && $added_field == 0) {
                    ?>
                    <div class="well"><h4>Aucun nouveau élément ajouté</h4></div>
                    <?php
                } else {
                    ?>
                    <div class="well"><h4>Nombre de table ajouté : <?php echo $added_table; ?> - Nombre de champ ajouté : <?php echo $added_field; ?></h4></div>
                    <?php
                }
            ?>
            <table class="table table-striped">
                <tr>
                    <th>Détails</th>
                    <th>Tables</th>
                </tr>
                <?php
                foreach ($tables as $key => $value) {
                    ?>
                    <tr>
                        <td><a href="<?php echo site_url('admin/database') . '/' . $value; ?>"><i class="icon-list"></i></a></td>
                        <td><?php echo $value; ?></td>
                    </tr>
                    <?php
                }
                ?>
            </table>
            <?php
        } else {
            ?>
            <div class='well'><h4>Aucunes tables répertoriées</h4></div>
            <?php
        }
        ?>
        <form method="POST">
            <center>
                <button type="submit" name="populate" class="btn">Peupler</button>
                <a href="<?php echo site_url('admin'); ?>">
                    <button class="btn" type="button">Retour</button>
                </a>
            </center>
        </form>
    </div>
</div>