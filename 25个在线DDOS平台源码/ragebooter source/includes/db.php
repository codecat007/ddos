<?php
define('DB_HOST', 'localhost');
define('DB_NAME', 'elitemod_booter');
define('DB_USERNAME', 'elitemod_admin');
define('DB_PASSWORD', 'lilman1');

$odb = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USERNAME, DB_PASSWORD);
?>