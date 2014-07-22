<div class="inner-block">
    <form method="POST" name="restauration">
        <table class="table table-striped">
            <tr>
                <th><input type="checkbox" checked id="select_all"/>&nbsp;Restauration</th>
                <th>Champ modifié</th>
                <th>Ancienne valeur</th>
                <th>Nouvelle valeur</th>
            </tr>

            <!-- javascript pour check et uncheck toutes les inputs checkbox -->
            <script type="text/javascript">
                $('#select_all').change(function() {
                    var checkboxes = $(this).closest('form').find(':checkbox');
                    if($(this).is(':checked')) {
                        checkboxes.attr('checked', 'checked');
                    } else {
                        checkboxes.removeAttr('checked');
                    }
                });
            </script>

            <?php
            //récuperation des données contact
            $contact_array = get_object_vars($contact[0]);
            $id_con = $contact_array['CON_ID'];

            //création du tableau de test pour affichage de "nouvelle valeur"
            $contact_array_verif_copy = $contact_array;
            foreach ($contact_array_verif_copy as $key => $value) {
                $contact_array_verif_copy[$key] = true;
            }
            ?>
            <div class='well'><h4>Annulation des modifications effectuées le <?php echo "$date à $time sur le contact $id_con"; ?></h4></div>
            <p> Cochez pour restaurer : l'ancienne valeur remplacera la nouvelle valeur</p>
            <?php
            //generation tableau pour la date en question
            for ($i = 0; $i < count($history); $i++) {
                $history_array = get_object_vars($history[$i]);

                //formatage date
                $hist_datetime = explode(' ', $history_array['hist_datetime']);
                $hist_time = $hist_datetime[1];
                $hist_date = date_usfr($hist_datetime[0]);

                //s'il s'agit de la date demandée
                if ($hist_date == $date && $hist_time == $time) {
                    ?>
                    <tr>
                        <?php
                        //checkbox non editable si la donnée actuelle est aussi l'ancienne valeur
                        if ($history_array['hist_field_value'] != $contact_array[$history_array['tabl_field']]) {
                            ?>
                            <td><input type='checkbox' checked id='<?php echo $history_array['tabl_field']; ?>' name='<?php echo $history_array['tabl_field']; ?>' value='<?php echo $history_array['hist_field_value']; ?>'></td>
                            <?php
                        } else {
                            ?>
                            <td></td>
                            <?php
                        }
                        ?>
                        <td><?php echo $history_array['tabl_field_name']; ?></td>
                        <?php
                        //affichage de vide pour les champs de contact à null
                        if ($history_array['hist_field_value'] != null) {
                            //conversion de la date au format francais
                            $hist_field_value = $history_array['hist_field_value'];
                            if (preg_match('/....-..-../', $hist_field_value)) {
                                $hist_field_value = date_usfr($hist_field_value);
                            }
                            ?>
                            <td><?php echo $hist_field_value; ?></td>
                            <?php
                        } else {
                            ?>
                            <td><em>vide</em></td>
                            <?php
                        }

                        //retrouve la bonne "nouvelle valeur" et l'affiche
                        $index = $history_array['tabl_field'];
                        //s'il s'agit de la dernière modification, alors la nouvelle valeur est la valeur actuel de contact
                        if ($contact_array_verif_copy[$index]) {
                            //affichage de vide pour les champs de contact à null
                            if ($contact_array[$index] != null) {
                                //conversion de la date au format francais
                                $hist_field_value = $contact_array[$index];
                                if (preg_match('/....-..-../', $hist_field_value)) {
                                    $hist_field_value = date_usfr($hist_field_value);
                                }
                                ?>
                                <td><?php echo $hist_field_value; ?></td>
                                <?php
                            } else {
                                ?>
                                <td><em>vide</em></td>
                                <?php
                            }
                            $contact_array_verif_copy[$index] = false;
                        } else {
                            //recherche de la "nouvelle valeur" en remontant dans la pile de modification
                            for ($j = $i - 1; $j >= 0; $j--) {
                                $previous_history_array = get_object_vars($history[$j]);
                                //on retrouve la "nouvelle valeur"
                                if ($previous_history_array['tabl_field'] == $index) {
                                    //affichage de vide pour les champs de contact à null
                                    if ($previous_history_array['hist_field_value'] != null) {
                                        //conversion de la date au format francais
                                        $previous_hist_field_value = $previous_history_array['hist_field_value'];
                                        if (preg_match('/....-..-../', $previous_hist_field_value)) {
                                            $previous_hist_field_value = date_usfr($previous_hist_field_value);
                                        }
                                        ?>
                                        <td><?php echo $previous_hist_field_value; ?></td>
                                        <?php
                                        break;
                                    } else {
                                        ?>
                                        <td><em>vide</em></td>
                                        <?php
                                    }
                                }
                            }
                        }
                        ?>
                    </tr>
                    <?php
                } else {
                    //mise à jour du tableau de test
                    $index = $history_array['tabl_field'];
                    if ($contact_array_verif_copy[$index]) {
                        $contact_array_verif_copy[$index] = false;
                    }
                }
            }
            ?>
        </table>
        <center>
            <button type="submit" name="submit" class="btn">Restaurer</button>
            <a href="<?php echo site_url('contact/historique') . '/' . $id_con; ?>">
                <button class="btn" type="button">Retour</button>
            </a>
        </center>
    </form>
</div>
</div>
