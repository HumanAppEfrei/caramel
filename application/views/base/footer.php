</main> <!-- Closes the tag opened in <controller>/base.php -->
        <?php
            var_dump($this->router->uri->rsegments[1]);
        ?>

		<footer>
            <a class="btn btn-large btn-success" href="javascript:void(0);" onclick="javascript:introJs().start();">Premiers pas</a>
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
