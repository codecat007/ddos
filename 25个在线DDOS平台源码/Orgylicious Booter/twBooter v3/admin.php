<?php

require('Smarty.class.php');
$smarty = new Smarty;

require_once('inc/db.php');
require_once('inc/functions.php');
require_once('inc/secur.php');
require_once('right.php');

if (!is_admin($_SESSION['uid'], $dbLink))
{
	header("{$_SERVER['SERVER_PROTOCOL']} 404 Not Found");
	echo "No input file specified.";
	exit();
}

$usersArr = array();

$SQL = "SELECT * FROM `users` ORDER BY `id` ASC";
$query = mysql_query($SQL, $dbLink) OR die(mysql_error());

while ($row = mysql_fetch_array($query))
{
	array_push($usersArr, $row);
}

$smarty->assign('usersArr', $usersArr);

$smarty->display('templates/admin.tpl');

?>