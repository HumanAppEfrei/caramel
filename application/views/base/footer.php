</main> <!-- Closes the tag opened in <controller>/base.php -->
        <footer>
            <B>CaRaMel</B> - version en développement - Human App - contact: <a href="mailto:
humanapp-support.asso@groupe-efrei.net?Subject=CaRaMel" target="_top">
humanapp-support.asso@groupe-efrei.net</a>
        </footer>
        <script>

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
