<?php

$host = 'localhost';
$user = 'ggddos_gg';
$pass = 'ggddos_ggddos';
$data = 'twdata';

$dbLink = mysql_connect($host, $user, $pass);
if (!$dbLink)
{
	die(mysql_error());
}

if (!mysql_select_db($data, $dbLink))
{
	die("Unable to select database: " . mysql_error());
}

?>