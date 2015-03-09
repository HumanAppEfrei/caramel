<div id="edit">
    <?php foreach ($items as $don) : ?>
    <h2 class="well">Edition du don n°<?php echo $don->DON_ID; ?></h2>
    <form method="post" class="form-horizontal" name="editDon" action="<?php echo site_url('don/edit').'/'.$don->DON_ID; ?>" Onsubmit='return window.confirm("Attention, des données risquent d être écrasées.\nSouhaitez vous continuer ?");'>
        <input name= "is_form_sent" type="hidden" value="true"/>
        <div class="inline-block">
            <pretty>
                <div class="control-group">
                    Code du versement : <?php echo($don->DON_ID) ?><br/>
                    Code du donateur : <a href="<?php echo site_url('contact/edit').'/'.$don->CON_ID; ?>"><?php echo $don->CON_ID; ?></a><br/>
                    Date de saisie : <?php echo date_usfr($don->DON_DATEADDED, true); ?>
                </div>
            </pretty>
            <pretty>
                <div class="control-group">
                    Type : <?php echo $don->DON_TYPE; ?><br/>
                    Montant : <?php echo $don->DON_MONTANT; ?> €<br/>
                    Mode de paiement : <?php echo($don->DON_MODE); ?><br/>
                </div>
                <?php if ($don->DON_MODE == "cheque") : ?>
                <div class="control-group">
                    <label class="control-label" for="cheq_num">N° chèque</label>
                    <div class="controls">
                        <input type="text" name="cheq_num" value="<?php echo $don->DON_C_NUM; ?>"/>
                    </div>
                    <?php echo form_error('cheq_num'); ?>
                </div>
                <div class="control-group">
                    <label class="control-label" for="cheq_compte">N° compte</label>
                    <div class="controls">
                        <input type="text" name="cheq_compte" value="<?php echo $don->DON_C_COMPTE; ?>"/>
                    </div>
                    <?php echo form_error('cheq_compte'); ?>
                </div>
                <div class="control-group">
                    <label class="control-label" for="cheq_banq_emission">Banque d'émission</label>
                    <div class="controls">
                        <input type="text" name="cheq_banq_emission" value="<?php echo $don->DON_C_BANQ_EMISSION; ?>"/>
                    </div>
                    <?php echo form_error('cheq_banq_emission'); ?>
                </div>
                <div class="control-group">
                    <label class="control-label" for="cheq_banq_depot">Banque de dépôt</label>
                    <div class="controls">
                        <input type="text" name="cheq_banq_depot" value="<?php echo $don->DON_C_BANQ_DEPOT; ?>"/>
                    </div>
                    <?php echo form_error('cheq_banq_depot'); ?>
                </div>
                <div class="control-group">
                    <label class="control-label" for="cheq_depot_date">Date de dépôt</label>
                    <div class="controls">
                        <?php $date = ($don->DON_C_DATE_DEPOT != null) ? explode('-', date_usfr($don->DON_C_DATE_DEPOT)) : null; ?>
                        <!-- <input type="text" name="cheq_depot_jour" value="<?php echo $date[0] ;?>" maxlength="2" placeholder="jj" class="input-mini"/> /
                        <input type="text" name="cheq_depot_mois" value="<?php echo $date[1] ;?>" maxlength="2" placeholder="mm" class="input-mini"/> /
                        <input type="text" name="cheq_depot_annee" value="<?php echo $date[2] ;?>" maxlength="4" placeholder="aaaa" class="input-mini"/> -->
                        <input type="text" class="datepicker" name="cheq_depot_date" value="<?php echo($datedepot); ?>" readonly>
                    </div>
                    <!-- <?php echo form_error('cheq_depot_jour'); ?>
                    <?php echo form_error('cheq_depot_mois'); ?>
                    <?php echo form_error('cheq_depot_annee'); ?> -->
                    <?php echo form_error('cheq_depot_date'); ?>
                    <?php if (isset($message_cheq_depot)) {
                        echo $message_cheq_depot;
                    }?>
                </div>
                <?php endif; ?>
            </pretty>
        </div>
        <div id="left-block">
            <div class="inline-block" margin-top="10px">
                <pretty>
                    <div class="control-group">
                        Reçu fiscal : <?php echo ($don->DON_RECU_ID != null) ? "Édité - <a href='".site_url('don/recu_fiscal')."/".$don->DON_ID."' class='btn btn-mini'>voir le duplicata (#".$don->DON_RECU_ID.")</a>" : "Non édité - <a href='".site_url('don/recu_fiscal')."/".$don->DON_ID."' class='btn btn-mini'>éditer maintenant</a>"; ?>
                    </div>
                </pretty>
                <pretty>
                    <div class="control-group">
                        Date du versement : <?php echo date_usfr($don->DON_DATE); ?>
                    </div>
                </pretty>
                <pretty>
                    <div class="control-group">
                        Offre : 
                        <?php
                        if ($don->OFF_ID == "aucune")
                            echo "aucune";
                        else
                            echo '<a href="'.site_url('offre/edit').'/'.$offre->OFF_ID.'" >'.$offre->OFF_ID.": ".$offre->OFF_NOM.'</a>';
                        ?>
                    </div>
                </pretty>
                <pretty>
                    <div class="control-group">
                        <label for="commentaire">Commentaire :</label>
                        <textarea name="commentaire" rows="5" class="span5"><?php echo($don->DON_COMMENTAIRE) ?></textarea>
                        <?php echo form_error('commentaire'); ?>
                    </div>
                </pretty>
                <button type="submit" class="btn btn-large btn-success pull-right">Sauvegarder les modifications</button>
            </div>
        </div>
        <div id="clear"></div>
    </form>
    <?php endforeach; ?>
</div>