<?php

require('Smarty.class.php');
$smarty = new Smarty;

require_once('inc/db.php');
require_once('inc/functions.php');
require_once('inc/secur.php');

if ($_POST['email'] == true)
{
	if (empty($_POST['newEmail']) || empty($_POST['confirmEmail']) || empty($_POST['emailPassword']))
	{
		die('<span style="color: #e61e1e;">Please fill in all fields.</span>');
	}
	
	if (!filter_var($_POST['newEmail'], FILTER_VALIDATE_EMAIL))
	{
		die('<span style="color: #e61e1e;">You entered an invalid email address.</span>');
	}
	
	if ($_POST['newEmail'] != $_POST['confirmEmail'])
	{
		die('<span style="color: #e61e1e;">The emails you entered did not match.</span>');
	}
	
	$SQL = "SELECT `password`, `pw_salt` FROM `users` WHERE `id`={$_SESSION[uid]}";
	$query = mysql_query($SQL, $dbLink) OR die(mysql_error());
	$row = mysql_fetch_array($query);
	
	if ($row['password'] != hash('sha512', $_POST['emailPassword'] . $row['pw_salt']))
	{
		die('<span style="color: #e61e1e;">You entered an incorrect password.</span>');
	}
	
	$SQL = "UPDATE `users` SET `email`='{$_POST[newEmail]}' WHERE `id`={$_SESSION[uid]}";
	$query = mysql_query($SQL, $dbLink) OR die(mysql_error());
	
	die('<span style="color: green;">Your email has successfully been changed.</span>');
}
else if ($_POST['password'] == true)
{
	if (empty($_POST['currentPassword']) || empty($_POST['newPassword']) || empty($_POST['confirmPassword']))
	{
		die('<span style="color: #e61e1e;">Please fill in all fields.</span>');
	}
	
	$SQL = "SELECT `password`, `pw_salt` FROM `users` WHERE `id`={$_SESSION[uid]}";
	$query = mysql_query($SQL, $dbLink) OR die(mysql_error());
	$row = mysql_fetch_array($query);
	
	if ($row['password'] != hash('sha512', $_POST['currentPassword'] . $row['pw_salt']))
	{
		die('<span style="color: #e61e1e;">You entered an incorrect password.</span>');
	}
	
	if ($_POST['newPassword'] != $_POST['confirmPassword'])
	{
		die('<span style="color: #e61e1e;">The passwords you entered did not match.</span>');
	}
	
	$salt = random_string(10);
	$password = hash('sha512', $_POST['newPassword'] . $salt);
	
	$SQL = "UPDATE `users` SET `password`='{$password}', `pw_salt`='{$salt}' WHERE `id`=$_SESSION[uid]";
	$query = mysql_query($SQL, $dbLink) OR die(mysql_error());
	
	die('<span style="color: green;">Your password has successfully been changed.</span>');
	
}

?>