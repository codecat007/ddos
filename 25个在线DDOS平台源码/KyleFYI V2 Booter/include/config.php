
		<?php
		define("DB_HOST", "localhost"); 
		define("DB_USER", "root");
		define("DB_PASSWORD", "password");
		define("DB_DATABASE", "sexy");
		$con = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD);
		mysql_select_db(DB_DATABASE);
		$bootername = "";
		$booterURL = "http://blazehost.net";
		?>