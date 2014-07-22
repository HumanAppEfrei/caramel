
<div id= "create">

    <div class="well"><h2>Exporter les données de contact </h2></div>


    <form class="form-inline" method ="post" name="exportContact"  <?php echo ('action="' . site_url("segment/exportation") . '"'); ?>>

        <pretty>
            <div class="inline-block">
                <div class="inner-block">
                    <input type="hidden" name="code" value="<?php echo $codeSegment; ?>" />

                    <div class="control-group">
                        <label class="control-label" for="description">Numéro d'adhérent</label>
                        <div class="controls">
                            <input type="checkbox" name="option[]" value="id" checked disabled="disabled"> 
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="description">Nom</label>
                        <div class="controls">
                            <input type="checkbox" name="option[]" value="nom" checked> 
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="description">Prenom</label>
                        <div class="controls">
                            <input type="checkbox" name="option[]" value="prenom" checked>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="description">	
                            Date de naissance 
                        </label>
                        <div class="controls">
                            <input type="checkbox" name="option[]" value="date_naissance" checked>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="description"> 
                            E-mail
                        </label>
                        <div class="controls">
                            <input type="checkbox" name="option[]" value="email" checked>
                        </div>
                    </div>
                </div>
            </div>
            <div class="inline-block">
                <div class="inner-block">
                    <div class="control-group">
                        <label class="control-label" for="description">Téléphone</label>
                        <div class="controls">
                            <input type="checkbox" name="option[]" value="tel" checked> 
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label" for="description">Adresse</label>
                        <div class="controls">
                            <input type="checkbox" name="option[]" value="adresse" checked>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label" for="description">Date d'ajout</label>
                        <div class="controls">
                            <input type="checkbox" name="option[]" value="date_ajout" checked>   
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="description">Date de modification</label>
                        <div class="controls">
                            <input type="checkbox" name="option[]" value="date_modif" checked> 
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="description">Liste des dons</label>
                        <div class="controls">
                            <input type="checkbox" name="option[]" value="dons" checked> 
                        </div>
                    </div>
                    <br/>
                </div>
            </div>
            <div class ="controls">
                <button type="submit" class="btn" name="export">Exporter</button>
            </div>
        </pretty>
    </form>

</div>

