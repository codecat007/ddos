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

$username = $_POST['username'];
$password = $_POST['password'];
$email = $_POST['email'];
$days = $_POST['days'];
$time = $_POST['time'];
$method = $_POST['payment'];
$trans_id = mysql_real_escape_string($_POST['trans']);
$notes = mysql_real_escape_string($_POST['other']);

$methodArr = array("PayPal", "AlertPay", "LR", "WMZ", "other");

if (empty($username) || empty($password) || empty($email) || empty($days) || empty($method) || empty($trans_id) || empty($time))
{
	die('<span style="color: #e61e1e;">Please fill in all fields.</span>');
}

if (!ctype_alnum($_POST['username']) || strlen($_POST['username']) < 4 || strlen($_POST['username']) > 25)
{
	die('<span style="color: #e61e1e;">Username must be alphanumeric and 4-25 characters in length.</span>');
}

$SQL = "SELECT COUNT(`id`) FROM `users` WHERE `username`='{$username}'";
$query = mysql_query($SQL, $dbLink) OR die(mysql_error());
$count = mysql_result($query, 0);

if ($count > 0)
{
	die('<span style="color: #e61e1e;">That username already exists.</span>');
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL))
{
	die('<span style="color: #e61e1e;">Please enter a valid email address.</span>');
}

if (!is_numeric($days) || $days < 1)
{
	die('<span style="color: #e61e1e;">Invalid number of days.</span>');
}

if (!is_numeric($time) || $time < 15)
{
	die('<span style="color: #e61e1e;">What kind of jackass sets a time lower than 15 seconds? Dick.</span>');
}

if (!in_array($method, $methodArr))
{
	die('<span style="color: #e61e1e;">Please select a payment method from the list.</span>');
}

$sub_ends = time() + (86400 * $days);
$pw_salt = random_string(10);
$dbpass = hash('sha512', $password . $pw_salt);

$SQL = "INSERT INTO `users` (`username`, `email`, `password`, `pw_salt`, `sub_ends`, `length`) VALUES ('{$username}', '{$email}', '{$dbpass}', '{$pw_salt}', {$sub_ends}, {$time})";
$query = mysql_query($SQL, $dbLink) OR die(mysql_error());

$SQL = "SELECT `id` FROM `users` WHERE `username`='{$username}'";
$query = mysql_query($SQL, $dbLink) OR die(mysql_error());
$newUID = mysql_result($query, 0);

$timeNow = time();
$SQL = "INSERT INTO `payments` (`method`, `trans_id`, `uid`, `time`, `notes`) VALUES ('{$method}', '{$trans_id}', {$newUID}, {$time}, '{$notes}')";
$query = mysql_query($SQL, $dbLink) OR die(mysql_error());

die('<span style="color: green;">User successfully added.</span>');

?>