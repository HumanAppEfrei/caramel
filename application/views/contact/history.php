<div>
    <?php
    //si on a un historique de modification non vide
    if (count($history) != 0) {
        //récuperation des données contact
        $contact_array = get_object_vars($contact[0]);
        $id_con = $contact_array['CON_ID'];
        ?>
        <div class='well'><h4>Historique des modificiations sur le contact <?php echo $id_con; ?></h4></div>
        <table class="table table-striped">
            <tr>
                <th></th>
                <th></th>
                <th>Date</th>
                <th>Champ modifié</th>
                <th>Ancienne valeur</th>
                <th>Nouvelle valeur</th>
            </tr>
            <?php
            //création du tableau de test pour affichage de "nouvelle valeur"
            $contact_array_verif_copy = $contact_array;
            foreach ($contact_array_verif_copy as $key => $value) {
                $contact_array_verif_copy[$key] = true;
            }

            //generation du tableau d'historique
            $old_datetime = null;
            for ($i = 0; $i < count($history); $i++) {
                $history_array = get_object_vars($history[$i]);

                //formattage date
                $datetime = explode(' ', $history_array['hist_datetime']);
                $time = $datetime[1];
                $date = date_usfr($datetime[0]);
                ?>

                <tr>
                    <?php
                    //factorisation de l'affichage des trois premières cellules si la date ne change pas
                    if ($old_datetime != $history_array['hist_datetime']) {
                        $current_datetime = $history_array['hist_datetime'];
                        //Pour pas afficher le lien, si la restauration ne changerait pas les données contact
                        for ($j = $i; $j < count($history); $j++) {
                            $history_checking_array = get_object_vars($history[$j]);
                            if ($current_datetime == $history_checking_array['hist_datetime']) {
                                if ($history_checking_array['hist_field_value'] != $contact_array[$history_checking_array['tabl_field']]) {
                                    ?>
                                    <td><a href="<?php echo site_url('contact/restauration') . '/' . $id_con . '/' . $date . '/' . $time ?>"><i class="icon-edit"></i></a></td>
                                    <?php
                                    break;
                                }
                            }
                        }
                        if ($j == count($history)) {
                            ?>
                            <td></td>
                            <?php
                        }

                        //affichage speciale pour les modifications de type restauration
                        if ($history_array['hist_modif_type'] == 1) {
                            ?>
                            <td><span class='label'>Restauration</span></td>
                            <?php
                        } else {
                            ?>
                            <td><span class='label label-info'>Modification</span></td>
                            <?php
                        }
                        ?>
                        <td><?php echo "$date à $time"; ?></td>
                        <?php
                        $old_datetime = $history_array['hist_datetime'];
                    } else {
                        ?>
                        <td></td>
                        <td></td>
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
            }
            ?>
        </table>
        <?php
    } else {
        //si l'historique est vide
        ?>
        <div class='well'><h4>Aucune modification depuis la création du contact</h4></div>
        <?php
    }
    ?>
</div>
</div>
