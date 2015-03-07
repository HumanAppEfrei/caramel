</main> <!-- Closes the tag opened in <controller>/base.php -->
        <footer>
            <b>CaRaMel Prototype v8.4-dev</b> - Efrei - <em>Contact :  pa8-club-du-don@googlegroups.com</em>
        </footer>

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
        </script>
	</body>
</html>