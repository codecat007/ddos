<?php

/*
 * Standard Security for logged in pages.
 */

require_once('sesscheck.php');

$timeNow = time();
$SQL = "UPDATE `users` SET `last_active`={$timeNow} WHERE `id`={$uid}";
$query = mysql_query($SQL, $dbLink) OR die(mysql_error());

$SQL = "SELECT * FROM `users` WHERE `id`={$uid}";
$query = mysql_query($SQL, $dbLink) OR die(mysql_error());
$row = mysql_fetch_array($query);

$sub_ends = $row['sub_ends'];
$status = $row['status'];

if ($sub_ends < $timeNow)
{
	session_destroy();
	$_SESSION = array();
	header("{$_SERVER['SERVER_PROTOCOL']} 404 Not Found");
	echo "Your subscription has run out.";
	exit();
}

if ($status == "banned")
{
	session_destroy();
	$_SESSION = array();
	header("{$_SERVER['SERVER_PROTOCOL']} 404 Not Found");
	echo "You have been banned! Reason: {$row['ban_reason']}";
	exit();
}

$rounded = round(($sub_ends - $timeNow)/86400);
if ($rounded <= 5)
{
	$smarty->assign('alert', TRUE);
}

$smarty->assign('alertLeft', $rounded);
$smarty->assign('alertDate', $sub_ends);

//Better and super improved user variables!

$SQL = "SELECT * FROM `users` WHERE `id`={$_SESSION[uid]}";
$query = mysql_query($SQL, $dbLink) OR die(mysql_error());
$row = mysql_fetch_array($query);

$smarty->assign('bootLength', $row['length']);

?>