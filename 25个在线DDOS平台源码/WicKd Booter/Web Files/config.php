<?php
//DB Config
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'free_source');
define('DB_HOST', 'localhost');
$odb = new PDO('mysql: host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASS);

//General Config
$sn = 'Free Source';
$url = 'http://localhost/free/';
//Use that format or CSS will be broken

//Other Configs
if (!empty($_SERVER['HTTP_CF_CONNECTING_IP']))
{
	$userIP = $_SERVER['HTTP_CF_CONNECTING_IP'];
}
else if(!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
{
	$userIP = $_SERVER['HTTP_X_FORWARDED_FOR'];
}
else if(!empty($_SERVER['HTTP_CLIENT_IP']))
{
	$userIP = $_SERVER['HTTP_CLIENT_IP'];
}
else
{
	$userIP = $_SERVER['REMOTE_ADDR'];
}
?>