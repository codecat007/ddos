<?php

session_start();

//This is ugly but I really don't know what to do here. There's a shitload of checks.
if
(
	!isset($_SESSION['uid']) ||
	!is_numeric($_SESSION['uid']) ||
	!isset($_SESSION['username']) ||
	!ctype_alnum($_SESSION['username']) ||
	!isset($_SESSION['login_key']) ||
	!ctype_alnum($_SESSION['login_key']) ||
	!isset($_SESSION['HTTP_USER_AGENT']) ||
	$_SESSION['HTTP_USER_AGENT'] !== $_SERVER['HTTP_USER_AGENT'] ||
	!isset($_SESSION['REMOTE_ADDR']) ||
	!filter_var($_SESSION['REMOTE_ADDR'], FILTER_VALIDATE_IP) ||
	$_SESSION['REMOTE_ADDR'] !== get_user_ip($_SERVER)
)
{
	session_destroy();
	$_SESSION = array();
	header("{$_SERVER['SERVER_PROTOCOL']} 404 Not Found");
	echo "No input file specified.";
	exit();
}

$uid = $_SESSION['uid'];

$SQL = "SELECT * FROM `users` WHERE `id`={$uid}";
$query = mysql_query($SQL, $dbLink) OR die(mysql_error());
$result = mysql_fetch_array($query);

if
(
	$_SESSION['username'] != $result['username'] ||
	strtolower($_SESSION['login_key']) != strtolower($result['login_key']) ||
	$_SESSION['REMOTE_ADDR'] != $result['last_ip']
)
{
	session_destroy();
	$_SESSION = array();
	header("{$_SERVER['SERVER_PROTOCOL']} 404 Not Found");
	echo "No input file specified.";
	exit();
}

?>