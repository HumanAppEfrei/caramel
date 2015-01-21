<div>
    <div id="content">
        <h1>Export de la bdd</h1>
        <?php
            foreach ($tables as $table => $columns) {
                ?></br>
                    <h3><?php echo $table ; ?></h3><?php
                foreach ($columns as $column) {
                    ?></br><?php
                    echo $column ;

                }
            }
        ?>
    </div>
</div>
