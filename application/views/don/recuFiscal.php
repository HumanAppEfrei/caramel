<?php /*
Cette page correspond à la vue d'un reçu fiscal. Elle est utilisée pour générer un PDF du reçu.
Les variables disponibles sont celles de la méthode recu_fiscal du contrôleur don.
Les plus utiles :
    $contact objet Contact qui a fait le(s) don(s)
    $offre objet Offre sur laquelle porte le don s'il s'agit d'un reçu pour don unique (la variable n'existe pas sinon)
    $montant_total numérique Total des dons si le reçu est groupé
    $mode_paiement string Mode de versement du (des) don(s). Si plusieurs dons avec des modes différents : "mutiple"
    $dernier_don objet Dernier don du groupe fiscal. Il s'agit de celui qui donne son ID au reçu
*/ ?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Reçu fiscal #<?php echo $dernier_don->DON_ID; ?></title>
    </head>

    <body style="font-family: Verdana">
        <!-- Numéro du reçu -->
        <p style="position: absolute; top: 55px; left: 268px; width: 100px; color: grey; font-size: 1.3em"><?php echo $dernier_don->DON_ID; ?></p>

        <!-- Donateur -->
        <p style="position: absolute; top: 160px"><?php echo $contact->CON_FIRSTNAME." ".$contact->CON_LASTNAME; ?><br/>
            <?php echo $contact->CON_VOIE_NUM." ".$contact->CON_VOIE_TYPE." ".$contact->CON_VOIE_NOM; ?><br/>
            <?php echo $contact->CON_CP." ".$contact->CON_CITY.", ".$contact->CON_COUNTRY; ?></p>

        <!-- Duplicata -->
        <?php if ($dernier_don->DON_RECU_ID != null) : ?>
        <p style="position: absolute; top: 160px; left: 330px; font-size: 2em; border-top: 2px solid red; border-bottom: 2px solid red; color: red">DUPLICATA</p>
        <?php endif; ?>

        <!-- Objet du don -->
        <p style="position: absolute; top: 250px"><?php echo (isset($offre)) ? $offre->OFF_NOM : "Dons multiples"; ?></p>

        <!-- Date -->
        <p style="position: absolute; top: 295px; left: 110px"><?php echo date_usfr($dernier_don->DON_DATEADDED, true); ?></p>
        <!-- Mode de versement -->
        <p style="position: absolute; top: 325px; left: 240px"><?php echo $mode_paiement; ?></p>
        <!-- Montant -->
        <p style="position: absolute; top: 355px; left: 145px"><?php echo (isset($montant_total)) ? $montant_total : $dernier_don->DON_MONTANT; ?> euros</p>
    </body>
</html>