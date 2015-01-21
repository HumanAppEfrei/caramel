<div>
    <div id="content">
        <?php
            Echo "Page d'export de la BDD";

            foreach ($tables as $key => $value) {
                ?></br><?php
                echo $value ; 
            }
        ?>
    </div>
</div>
