<?php

require('Smarty.class.php');
$smarty = new Smarty;

require_once('inc/db.php');
require_once('inc/functions.php');
require_once('inc/secur.php');
require_once('right.php');

//for the boot history, start the loop before the the <tr> and end it after the </tr> :D

$page = basename($_SERVER['PHP_SELF']);
$page = substr($page, 0, -4);
$smarty->assign('page', $page);
$smarty->assign('pageTitle', 'Dashboard');

//Latest news
$SQL = "SELECT * FROM `news` ORDER BY `id` DESC LIMIT 1";
$query = mysql_query($SQL, $dbLink) OR die(mysql_error());
$newsResult = mysql_fetch_array($query, MYSQL_ASSOC);
$SQL = "SELECT * FROM `users` WHERE `id`='{$newsResult['poster_id']}'";
$query = mysql_query($SQL, $dbLink) OR die(mysql_error());
$result = mysql_fetch_array($query, MYSQL_ASSOC);
$newsResult['poster'] = $result['username'];
$smarty->assign('news', $newsResult);

//Recent boots, ya dig?
$SQL = "SELECT * FROM `boot_logs` WHERE `uid`='{$uid}' ORDER BY `id` DESC LIMIT 10";
$query = mysql_query($SQL, $dbLink) OR die(mysql_error());

$sendRow = array();
while ($row = mysql_fetch_array($query))
{
	array_push($sendRow, $row);
}
$smarty->assign('recentBoots', $sendRow);

$smarty->display('templates/dash.tpl');

?>