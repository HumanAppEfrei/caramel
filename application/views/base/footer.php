</main> <!-- Closes the tag opened in <controller>/base.php -->
        <footer>
            <B>CaRaMel</B> - version en développement - Human App - contact: <a href="mailto:
humanapp-support.asso@groupe-efrei.net?Subject=CaRaMel" target="_top">
humanapp-support.asso@groupe-efrei.net</a>
        </footer>

        <?php // lancement de intro.js a la premiere connexion
            if ($first_conn == 1 ){ ?>
            <script>introJs().start();</script>
        <?php } ?>
        <script>
            $( '.datepicker'  ).datepicker(
                {
                    dateFormat: "yy-mm-dd",
                    yearRange: "-100:+0",
                    changeYear: true,
                    changeMonth: true
                },
                $.datepicker.regional['fr']);

            $( '.monthpicker'  ).datepicker(
                {
                    dateFormat: "yy-mm",
                    yearRange: "-100:+0",
                    changeYear: true,
                    changeMonth: true
                },
                $.datepicker.regional['fr']);
            // auto start intro js if requested
            if (RegExp('multipage', 'gi').test(window.location.search)) {
                introJs().start();
            }
            $("#aide_button").popup({
                width:window.innerWidth*0.7,
                height:window.innerHeight*0.9
		    });
        </script>
        
	</body>
</html>
