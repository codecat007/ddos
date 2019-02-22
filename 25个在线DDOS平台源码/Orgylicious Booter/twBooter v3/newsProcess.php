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

if (empty($_POST['title']) || empty($_POST['news']))
{
	die('<span style="color: #e61e1e;">Please fill in all fields.</span>');
}

if (strlen($_POST['title']) > 100)
{
	die('<span style="color: #e61e1e;">The title cannot exceed 100 characters.</span>');
}

if (strlen($_POST['title']) > 1000)
{
	die('<span style="color: #e61e1e;">The content cannot exceed 1000 characters.</span>');
}

$timeNow = time();
$subject = mysql_real_escape_string($_POST['title']);
$content = mysql_real_escape_string($_POST['news']);

$SQL = "INSERT INTO `news` (`poster_id`, `time`, `subject`, `content`) VALUES ({$_SESSION[uid]}, {$timeNow}, '{$subject}', '{$content}')";
$query = mysql_query($SQL, $dbLink) OR die(mysql_error());

die('<span style="color: green;">News successfully added and posted.</span>');

?>