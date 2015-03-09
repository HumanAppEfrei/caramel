<?php
foreach ($contact as $contact) {
    $split = explode("-", $contact->CON_DATE);
    if (count($split) > 1) {
        $annee = $split[0];
        $mois = $split[1];
        $jourTmp = $split[2];

        if ($jourTmp[0] == '0')
            $jour = $jourTmp[1];
        else
            $jour = $jourTmp;

        if ($jourTmp[0] == '0' && $jourTmp[1] == '0')
            $jour = "";
        if ($mois[0] == '0' && $mois[1] == '0')
            $mois = "";
        if ($annee[0] == '0' && $annee[1] == '0' && $annee[2] == '0' && $annee[3] == '0')
            $annee = "";
    } ?>

    <div class="well"><h3>Edition du contact : <?php echo($contact->CON_FIRSTNAME . " " . $contact->CON_LASTNAME) ?> </h3>
        <div class="pull-right">
        </div>
    </div>

    <form class="form-horizontal" method="post" name="editContact" <?php echo (' action="' . site_url("contact/edit/" . $contact->CON_ID) . '"') ?> Onsubmit='return window.confirm("Attention, des données risquent d être écrasées\nSouhaitez vous continuez?");'>

        <input name= "is_form_sent" type="hidden" value="true">

        <div class="inline-block">
            <div class="inner-block">
                <legend><h4>Informations générales</h4></legend>

                <pretty>
                    <div class="control-group">
                        <label class="control-label" title="Code du contact (unique)" for="id">Identifiant</label>
                        <div class="controls">
                            <input type="text" value="<?php echo($contact->CON_ID) ?>" readonly="readonly">
                        </div>
                    </div>
                </pretty>

                <pretty>
                    <div class="control-group">
                        <label class="control-label" for="personType">Type de personne</label>
                        <div class="controls">
                            <select id="type" name="type" value=<?php echo($contact->CON_TYPE) ?> >
                                <option value="physique" <?php if ($contact->CON_TYPE == "physique") echo'selected' ?>>Physique</option>
                                <option value="morale" <?php if ($contact->CON_TYPE == "morale") echo'selected' ?>>Morale</option>
                            </select>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label" for="contactType">Type de contact</label>
                        <div class="controls">
                            <select id="typeC" name="typeC" value=<?php echo($contact->CON_TYPEC) ?> >
                                <option value="donateur" <?php if ($contact->CON_TYPEC == "donateur") echo'selected ' ?>>Donateur</option>
                                <option value="prospect" <?php if ($contact->CON_TYPEC == "prospect") echo'selected ' ?>>Prospect</option>
                                <option value="benevole" <?php if ($contact->CON_TYPEC == "benevole") echo'selected ' ?>>Bénévole</option>
                                <option value="entreprise" <?php if ($contact->CON_TYPEC == "entreprise") echo'selected ' ?>>Entreprise</option>
                                <option value="association" <?php if ($contact->CON_TYPEC == "association") echo'selected ' ?>>Association</option>
                                <option value="ong" <?php if ($contact->CON_TYPEC == "ong") echo'selected ' ?>>ONG</option>
                            </select>
                        </div>
                    </div>
                </pretty>

                <pretty>
                    <div class="control-group">
                        <label class="control-label" for="Civilite">Civilité</label>
                        <div class="controls">

                            <select  class="input-small" name="civilite" value=<?php echo($contact->CON_CIVILITE) ?> >
                                <option value="M." <?php if ($contact->CON_CIVILITE == "M.") echo'selected' ?>>M.</option>
                                <option value="Mme" <?php if ($contact->CON_CIVILITE == "Mme") echo'selected' ?>>Mme</option>
                                <option value="Mlle" <?php if ($contact->CON_CIVILITE == "Mlle") echo'selected' ?>>Mlle</option>
                                <?php foreach ($Options_civil as $Option_civil) {
                                    ?>
                                    <option value="<?php echo $Option_civil; ?>" 
                                            <?php if ($contact->CON_CIVILITE == $Option_civil) echo'selected' ?>><?php echo $Option_civil; ?></option>	 
                                        <?php } ?>
                            </select>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label" for="name">Prénom*</label>
                        <div class="controls">
                            <input type="text" name="firstname" value=<?php echo("'" . $contact->CON_FIRSTNAME . "'") ?> maxlength="38" >
                        </div>
                    </div>

                    <div class="control-group">
                        <label id="nom" class="control-label" for="surname">Nom*</label>
                        <div class="controls">
                            <input type="text" name="lastname" value=<?php echo("'" . $contact->CON_LASTNAME . "'") ?> maxlength="38" ><br />
                        </div>
                    </div>

                    <?php echo form_error('firstname'); ?>
                    <?php echo form_error('lastname'); ?>
                    <?php if (isset($message_identification)) echo('<div class="error">' . $message_identification . '</div>'); ?>
                </pretty>

                <pretty id="naissance">
                    <div class="control-group">
                        <label id="nom" class="control-label" for="surname">Date de naissance</label>
                        <div class="controls">
                            <input class="input-mini" type="text" name="jour" value="<?php if (isset($jour)) echo $jour; ?>" maxlength="2" placeholder="dd" > /
                            <input class="input-mini" type="text" name="mois" value="<?php if (isset($mois)) echo $mois; ?>" maxlength="2" placeholder="mm" > /
                            <input class="input-mini" type="text" name="annee" value="<?php if (isset($annee)) echo $annee; ?>" maxlength="4" placeholder="aaaa" >
                        </div>
                    </div>
                    <?php echo form_error('jour'); ?>
                    <?php echo form_error('mois'); ?>
                    <?php echo form_error('annee'); ?>
                    <?php if (isset($message_date)) echo('<div class="error">' . $message_date . '</div>'); ?>

                </pretty>

                <legend><h4>Contacts</h4></legend>

                <pretty>
                    <div class="input-prepend">
                        <div class="control-group">
                            <label class="control-label" for="Email">Email</label>
                            <div class="controls">
                                <span class="add-on"><i class="icon-envelope"></i></span><input class="span2" name="email" type="text" value=<?php echo($contact->CON_EMAIL) ?> >
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="telFixe">Téléphone Fixe</label>
                            <div class="controls">
                                <span class="add-on"><i class="icon-home"></i></span><input class="span2" name="telFixe" type="text" value=<?php echo($contact->CON_TELFIXE) ?> ><br />
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="Portable">Téléphone Portable</label>
                            <div class="controls">
                                <span class="add-on"><i class="icon-user"></i></span><input class="span2" name="telPort" type="text" value=<?php echo($contact->CON_TELPORT) ?> ><br />
                            </div>
                        </div>
                    </div>

                    <?php echo form_error('email'); ?>
                    <?php echo form_error('telFixe'); ?>
                    <?php echo form_error('telPort'); ?>
                </pretty>

                <div class="pull-left">
                    <?php
                    if ($contact->CON_DATEADDED != null) {
                        echo "Date de saisie : $contact->CON_DATEADDED <br>";
                    }
                    if ($contact->CON_DATEMODIF != null) {
                        $datetime = explode(' ', $contact->CON_DATEMODIF);
                        $time = $datetime[1];
                        $date = date_usfr($datetime[0]);
                        echo "Dernière modification : le $date à $time";
                    }
                    ?>
                </div>

            </div>
        </div>

        <div class="inline-block" style="margin-left: 30px;">
            <div class="inner-block">
                <legend><h4>Adresse Postale</h4></legend>

                <pretty>
                    <div class="control-group">
                        <label class="control-label" for="Complément">Complément</label>
                        <div class="controls">
                            <input type="text" name="complement" value=<?php echo("'" . $contact->CON_COMPL . "'") ?> maxlength="38" /><br />
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="voie">Voie</label>
                        <div class="controls">
                            <input class="input-mini" type="text" name="voie_num" value="<?php echo($contact->CON_VOIE_NUM) ?>" >
                            <select class="input-mini" name="voie_type" value="<?php echo set_value('voie_type'); ?>" >
                                <option value=" " <?php if ($contact->CON_VOIE_TYPE == " ") echo'selected' ?>> </option>
                                <option value="rue" <?php if ($contact->CON_VOIE_TYPE == "rue") echo'selected' ?>>rue</option>
                                <option value="avenue" <?php if ($contact->CON_VOIE_TYPE == "avenue") echo'selected' ?>>avenue</option>
                                <option value="allée" <?php if ($contact->CON_VOIE_TYPE == "allée") echo'selected' ?>>allée</option>
                                <option value="impasse" <?php if ($contact->CON_VOIE_TYPE == "impasse") echo'selected' ?>>impasse</option>
                                <option value="boulevard" <?php if ($contact->CON_VOIE_TYPE == "boulevard") echo'selected' ?>>boulevard</option>
                                <option value="chemin" <?php if ($contact->CON_VOIE_TYPE == "chemin") echo'selected' ?>>chemin</option>
                                <option value="faubourg" <?php if ($contact->CON_VOIE_TYPE == "faubourg") echo'selected' ?>>faubourg</option>
                                <option value="cours" <?php if ($contact->CON_VOIE_TYPE == "cours") echo'selected' ?>>cours</option>
                                <option value="lieu_dit" <?php if ($contact->CON_VOIE_TYPE == "lieu_dit") echo'selected' ?>>lieu dit</option>
                            </select>
                            <input class="input-medium" type="text" name="voie_nom" value="<?php echo $contact->CON_VOIE_NOM; ?>" >
                        </div>
                    </div>
                    <?php echo form_error('complement'); ?>
                    <?php echo form_error('voie_num'); ?>
                    <?php echo form_error('voie_type'); ?>
                    <?php echo form_error('voie_nom'); ?>
                    <?php if (isset($message_voie)) echo('<div class="error">' . $message_voie . '</div>'); ?>
                </pretty>


                <pretty>
                    <div class="control-group">
                        <label class="control-label" for="Civilite">CP / BP</label>
                        <div class="controls">
                            <input class="input-mini" type="text" name="cp" value="<?php echo set_value('cp', $contact->CON_CP); ?>" maxlength="38" placeholder="CP"/>
                            <input class="input-mini" type="text" name="bp" value="<?php echo set_value('bp', $contact->CON_BP); ?>" maxlength="38" placeholder="BP"/>	
                        </div> 
                    </div>

                    <div class="control-group">
                        <label class="control-label" for="ville">Ville</label>
                        <div class="controls">
                            <input type="text" name="city" value=<?php echo("'" . $contact->CON_CITY . "'"); ?> maxlength="38" >
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="pays">Pays</label>
                        <div class="controls">
                            <input type="text" name="country" value=<?php echo("'" . $contact->CON_COUNTRY . "'"); ?> >
                        </div>
                    </div>

                    <?php echo form_error('bp'); ?>
                    <?php echo form_error('cp'); ?>
                    <?php echo form_error('city'); ?>
                    <?php echo form_error('country'); ?>
                </pretty>

                <legend><h4>Divers</h4></legend>

                <pretty>
                    <div class="control-group">
                        <label class="control-label" for="NPAI" title="Permet de compter le nombre de lettres marquées de la mention pli non distribuable.">NPAI</label>
                        <div class="controls">
                            <?php echo("<span style='font-weight:bold'>" . $contact->CON_NPAI . "</span>") ?> 
                            <a href="<?php echo site_url("contact/IncrementNPAI/" . $contact->CON_ID); ?>">
                                <input type="button" class="btn" title="Le NPAI est augmenté de un" value="Incrémenter" onClick='return window.confirm("Incrémenter NPAI?");'/> </a> 
                            <a href="<?php echo site_url("contact/RAZ_NPAI/" . $contact->CON_ID); ?>">
                                <input type="button" class="btn" value="RAZ" onClick='return window.confirm("Remettre à zéro NPAI?");'title="Remise à Zéro"/> </a><br/><br/>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="solicitation" title="Permet de savoir si la personne souhaite être contactée">Solicitation </label>
                        <div class="controls">
                            <select name="solicitation" value="<?php echo set_value('solicitation'); ?>" >
                                <option value="yes" <?php if ($contact->CON_SOLICITATION == "yes") echo'selected' ?>>OK</option>
                                <option value="once" <?php if ($contact->CON_SOLICITATION == "once") echo'selected' ?>>Une seule fois</option>
                                <option value="not" <?php if ($contact->CON_SOLICITATION == "not") echo'selected' ?>>Ne veux pas être solicité</option>
                            </select>
                        </div>
                    </div>
                </pretty>

                <pretty>
                    <div class="control-group">
                        <label class="control-label" for="ville" title="Règle la fréquence de l’envoi des reçus fiscaux">Reçus fiscaux </label>
                        <div class="controls">
                            <select name="rf_type" id="rf_type" value="<?php echo set_value('voie_type'); ?>" >
                                <option value="never" <?php if ($contact->CON_RF_TYPE == "never") echo'selected' ?>>Jamais</option>
                                <option value="year" <?php if ($contact->CON_RF_TYPE == "year") echo'selected' ?>>Annuels</option>
                                <option value="month" <?php if ($contact->CON_RF_TYPE == "month") echo'selected' ?>>Mensuels</option>
                                <option value="eachTime" <?php if ($contact->CON_RF_TYPE == "eachTime") echo'selected' ?>>A chaque versement</option>
                            </select>
                        </div>
                    </div>
                    <div class="control-group" id="rf_envoi">
                        <label class="control-label" for="ville" title="Définit comment envoyer le reçu fiscal">Envoi par</label>
                        <div class="controls">
                            <select name="rf_envoi" value="<?php echo set_value('voie_type'); ?>" >
                                <option value="courrier" <?php if ($contact->CON_RF_ENVOI == "courrier") echo'selected' ?>>courrier</option>
                                <option value="email" <?php if ($contact->CON_RF_ENVOI == "email") echo'selected' ?>>email</option>
                            </select>
                        </div>
                    </div>
                </pretty>

                <pretty>
                    <div class="control-group">
                        <label class="control-label" for="comm" title="Ecrivez ici des informations complémentaires sur le contact">Commentaires</label>
                        <div class="controls">
                            <textarea name="commentaire" rows="5" cols="60"><?php echo($contact->CON_COMMENTAIRE) ?></textarea>
                        </div>
                    </div>
                </pretty>

                <div id="searchPattern">
                    <button type="submit" class="btn btn-success btn-large">Sauvegarder</button>
                </div>
            </div>
        </div>
        <div id="clear"></div>
    </form>

    <?php
}
?>

</div>
<script>
    var Options_morale ="<?php echo implode(',', $Options_morale) ?>";
    var Options_physique ="<?php echo implode(',', $Options_physique) ?>";
</script>

<SCRIPT LANGUAGE="Javascript" SRC="<?php echo js_url('contact_view.js') ?>" ></SCRIPT>