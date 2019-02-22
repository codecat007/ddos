<?php

require('inc/functions.php');
require('inc/db.php');

if (!isset($_GET['user']) || !ctype_alnum($_GET['user']) || $_SERVER['REQUEST_URI'] != "/images/{$_GET['user']}.png")
{
	header("{$_SERVER['SERVER_PROTOCOL']} 404 Not Found");
	echo "No input file specified.";
	exit();
}

$SQL = "SELECT * FROM `users` WHERE `username`='{$_GET[user]}'";
$query = mysql_query($SQL, $dbLink) OR die();
$count = mysql_num_rows($query);

if ($count < 1)
{
	header("{$_SERVER['SERVER_PROTOCOL']} 404 Not Found");
	echo "No input file specified.";
	exit();
}

$row = mysql_fetch_array($query);

$uid = $row['id'];
$loggedIP = get_user_ip($_SERVER);
$timeNow = time();

$SQL = "INSERT INTO `ip_logs` (`uid`, `ip`, `time`) VALUES ({$uid}, '{$loggedIP}', '{$timeNow}')";
$query = mysql_query($SQL, $dbLink) OR die();

$im = imagecreatefrompng("storedimages/{$uid}.png");
header('Content-Type: image/png');
imagepng($im);
imagedestroy($im);

?>