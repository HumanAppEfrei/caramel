<div id="create">
    <h2 class="well">Créer un nouveau versement</h2>
    <form class="form-horizontal" method="post" name="createDon" <?php echo ('action="'.site_url("don/create").'"'); ?>>
        <input name="is_form_sent" type="hidden" value="true">
        <input id="base_url"type="hidden" value="<?php echo site_url(); ?>"/>
        <div class="inline-block">
            <div class="inner-block">
                <pretty> <!-- Donateur -->
                    <div class="control-group">
                        <label class="control-label" for="codeCon">Code Donateur*</label>
                        <div class="controls">
                            <input type="text" name="codeCon" id="codeCon" value="<?php if(isset($contact->CON_ID)) echo $contact->CON_ID; else echo set_value('codeCon'); ?>" />
                            <div id="msg_codeCon" class="error"></div>
                        </div>
                        <?php echo form_error('codeCon'); if(isset($check_contact) && (!$check_contact)) 
                            echo '<div class="error">Ce code donateur est inexistant</div>'
                        ?>
                    </div>
                </pretty> <!-- /Donateur -->
                
                <pretty> <!-- Type et montant -->
                    <div class="control-group">
                        <label class="control-label" for="type_versement">Type de Versement</label>
                        <div class="controls">
                            <select id="type_versement" name="type_versement">
                                <option value="don" <?php echo set_select('type_versement', 'don'); ?>>Don</option>
                                <option value="cotisation" <?php echo set_select('type_versement', 'cotisation'); ?>>Cotisation</option>
                                <option value="achat" <?php echo set_select('type_versement', 'achat'); ?>>Achat</option>
                                <option value="abonnement" <?php echo set_select('type_versement', 'abonnement'); ?>>Abonnement</option>
                                <option value="promesse" <?php echo set_select('type_versement', 'promesse'); ?>>Promesse</option>
                            </select>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="montant">Montant* (euros)</label>
                        <div class="controls">
                            <input type="text" name="montant" id="montant" value="<?php echo set_value('montant'); ?>"/>
                        </div>
                        <?php echo form_error('montant'); ?>
                    </div>
                </pretty> <!-- /Type et montant -->
                <pretty> <!-- Mode de paiement -->
                    <div id="block_mode_paiement">
                        <div class="control-group">
                            <label class="control-label" for="mode_paiement">Mode de paiement</label>
                            <div class="controls">
                                <select id="mode_paiement" name="mode_paiement">
                                    <option value="carte" <?php set_select('mode_paiement', 'carte'); ?>>Carte bleue</option>
                                    <option value="cheque" <?php set_select('mode_paiement', 'cheque'); ?>>Chèque</option>
                                    <option value="espece" <?php set_select('mode_paiement', 'espece'); ?>>Espèce</option>
                                    <option value="virement" <?php set_select('mode_paiement', 'virement'); ?>>Virement</option>
                                </select>
                            </div>
                        </div>
                        <div id="cheque">
                            <div class="control-group">
                                <label class="control-label" for="cheq_num">N° chèque</label>
                                <div class="controls">
                                    <input type="text" name="cheq_num" value="<?php echo set_value('cheq_num'); ?>" >
                                </div>
                                <?php echo form_error('cheq_num'); ?>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="cheq_compte">N° compte</label>
                                <div class="controls">
                                    <input type="text" name="cheq_compte" value="<?php echo set_value('cheq_compte'); ?>"/>
                                </div>
                                <?php echo form_error('cheq_compte'); ?>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="cheq_banq_emission">Banque d'émission</label>
                                <div class="controls">
                                    <input type="text" name="cheq_banq_emission" value="<?php echo set_value('cheq_banq_emission'); ?>"/>
                                </div>
                                <?php echo form_error('cheq_banq_emission'); ?>
                            </div>
                            <div class="control-group">
                                <label class="control-label" for="cheq_banq_depot">Banque de dépôt</label>
                                <div class="controls">
                                    <input type="text" name="cheq_banq_depot" value="<?php echo set_value('cheq_banq_depot'); ?>"/>
                                </div>
                                <?php echo form_error('cheq_banq_depot'); ?>
                            </div>
                            <div class="control-group">
                    <label class="control-label" for="cheq_depot_jour">Date de dépôt</label>
                        <div class="controls">
                            <input type="text" name="cheq_depot_jour" maxlength="2" placeholder="jj" class="input-mini" value="<?php echo set_value('cheq_depot_jour'); ?>"/> /
                            <input type="text" name="cheq_depot_mois" maxlength="2" placeholder="mm" class="input-mini" value="<?php echo set_value('cheq_depot_mois'); ?>"/> /
                            <input type="text" name="cheq_depot_annee" maxlength="4" placeholder="aaaa" class="input-mini" value="<?php echo set_value('cheq_depot_annee'); ?>"/>
                        </div>
                        <?php if (isset($message_cheq_date)) {
                            echo $message_cheq_date;
                        }?>
                    </div>
                        </div> <!-- /#cheque -->
                    </div> <!-- /#block_mode-paiement -->
                </pretty> <!-- /Mode de paiement -->
            </div>
        </div>
        
        <div class="inline-block">
            <div class="inner-block"> <!-- Date -->
                <pretty>
                    <div class="control-group">
                        <label class="control-label" for="jour">Date* </label>
                        <div class="controls">
                            <input type="text" style="width:40px;" name="jour" value="<?php echo set_value('jour') == '' ? date('d') : set_value('jour'); ?>" maxlength="2" placeholder="jj" > /
                            <input type="text" style="width:40px;" name="mois" value="<?php echo set_value('mois') == '' ? date('m') : set_value('mois'); ?>" maxlength="2" placeholder="mm" > /
                            <input type="text" style="width:50px;" name="annee" value="<?php echo set_value('annee') == '' ? date('Y') : set_value('annee'); ?>" maxlength="4" placeholder="aaaa" >
                        </div>
                        <?php if(isset($message_date)) echo('<div class="error">'.$message_date.'</div>'); ?>
                    </div>
                </pretty>   
            </div> <!-- /Date -->
            <div class="inner-block">
                <pretty> <!-- Offre -->
                    <div class="control-group">
                        <label class="control-label" for="offre">Répond à l'offre</label>
                        <div class="controls">
                            <select id="offre" name="offre" value="<?php echo set_value('offre'); ?>" >
                                <option value="aucune" <?php echo set_select('offre', 'aucune'); ?>>Aucune</option>
                                <?php foreach($list_offres as $offre) : ?>
                                <option value="<?php echo $offre->OFF_ID; ?>" <?php echo set_select('offre', $offre->OFF_ID); ?>>
                                    <?php echo $offre->OFF_ID.' : '.$offre->OFF_NOM; ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </pretty> <!-- /Offre -->
                
                <pretty> <!-- Commentaire -->
                    <div class="control-group">
                        <label class="control-label" for="commentaire">Commentaires</label>
                        <div class="controls">
                            <textarea name="commentaire" rows="5" cols="25" ><?php echo set_value('commentaire'); ?></textarea>
                        </div>
                        <?php echo form_error('commentaire'); ?>
                    </div>
                </pretty> <!-- /Commentaire -->
            </div>
        </div>

        <input type="hidden" name="ajouts" value="<?php
            if(isset($dons_ajoutes)) :
                foreach($dons_ajoutes as $da)
                    echo $da->DON_ID.",";
            endif; ?>"
        />
        <div id="clear"></div>
        <div class="control-group">
            <div class="well">
                <h3>Fléchage du versement</h3>
                <?php if(isset($message_flech)) echo('<div class="error">'.$message_flech.'</div>'); ?>
                
                <!--Generation dynamique-->
                <div class="inner-block" id="addFlechBlock">
                    <input type="hidden" id="flech_valide" name="flech_valide" value="false"/>
                </div>

                <!-- TODO : conservation de la liste après sauvegarde -->
                <div id="msg_flech" class="error"></div>
                <a id="addFlechage" > Ajouter </a>
            </div>
        </div>
        <div id="msg_save" class="error"></div>
        <button id="sauvegarder" type="submit" class="btn btn-large btn-success pull-right" disabled="disabled">Sauvegarder</button>
        <div id="clear"></div>
    </form>
    <?php if(isset($dons_ajoutes)) :
    $dons_ajout = array_reverse($dons_ajoutes); ?>
    <table class="table table-striped">
        <tr>
            <th></th>
            <th>Code</th>
            <th>Contact</th>
            <th>Montant</th>
            <th>Type de versement</th>
            <th>Date de saisie</th>
            <th></th>
        </tr>
        <?php foreach($dons_ajout as $don): ?>
        <tr>
            <td><a href="<?php echo site_url('don/edit').'/'.$don->DON_ID; ?>"><img src="<?php echo img_url('icons/edit.png'); ?>"/></a></td>
            <td><a href="<?php echo site_url('don/edit').'/'.$don->DON_ID; ?>"><?php echo $don->DON_ID; ?></a></td><!-- TODO vérifier si c'est pas un duplicata -->
            <td><a href="<?php echo site_url('contact/edit').'/'.$don->CON_ID; ?>"><?php echo $don->CON_ID; ?></a></td>
            <td><?php echo $don->DON_MONTANT; ?> €</td>
            <td><?php echo $don->DON_TYPE; ?></td>
            <td><?php echo $don->DON_DATE; ?></td> <!-- $date = preg_split("/[\s,]+/", $don->DON_DATE); puis $date[0] -->
            <td><button class="btn btn-danger suppr_don" name="<?php echo $don->DON_ID; ?>">Supprimer</button></td>
        </tr>
        <?php endforeach; ?>
    </table>
    <?php endif; ?>
</div> 
<script language="Javascript" src="<?php echo base_url().'assets/javascript/don_view.js'?>" ></script>
<script language="Javascript" src="<?php echo base_url().'assets/javascript/jquery.js'?>" ></script>
