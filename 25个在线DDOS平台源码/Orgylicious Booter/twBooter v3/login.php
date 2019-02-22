<?php

require_once('Smarty.class.php');
require_once('inc/db.php');
require_once('inc/functions.php');

$smarty = new Smarty;

if (isset($_POST['Submit']))
{

	$error = array();
	$logIn = false;
	
	if (!isset($_POST['username']) && !isset($_POST['password']))
	{
		array_push($error, "Please enter a username and password.");
	}
	else if (!isset($_POST['username']))
	{
		array_push($error, "Please enter a username.");
	}
	else if (!isset($_POST['password']))
	{
		array_push($error, "Please enter a password.");
	}
	
	if (isset($_POST['username']))
	{
		if (!ctype_alnum($_POST['username']) || strlen($_POST['username']) < 4 || strlen($_POST['username']) > 25)
		{
			array_push($error, "Username must be alphanumeric and 4-25 characters in length.");
		}
	}
	
	if (empty($error))
	{
		$userName = $_POST['username'];
		$SQL = "SELECT * FROM `users` WHERE `username`='{$userName}'";
		$query = mysql_query($SQL, $dbLink) OR die(mysql_error());
		$count = mysql_num_rows($query);
		
		if ($count === 1)
		{
			$result = mysql_fetch_array($query, MYSQL_ASSOC);
			$salt = $result['pw_salt'];
			if ($result['password'] == hash('sha512', $_POST['password'] . $salt))
			{
				$logIn = true;
				$login_key = random_string(10);
				$userIP = get_user_ip($_SERVER);
				$timeNow = time();
				$uid = $result['id'];
				
				$SQL = "UPDATE `users` SET `last_ip`='{$userIP}', `login_key`='{$login_key}' WHERE `username`='{$userName}'";
				$query = mysql_query($SQL, $dbLink) OR die(mysql_error());
				
				$SQL = "INSERT INTO `log_ins` (`id`, `uid`, `ip`, `time`) VALUES (NULL, '{$uid}', '{$userIP}', '{$timeNow}')";
				$query = mysql_query($SQL, $dbLink) OR die(mysql_error());
				
				session_start();
				$_SESSION['uid'] = $uid;
				$_SESSION['username'] = $result['username'];
				$_SESSION['login_key'] = $login_key;
				$_SESSION['HTTP_USER_AGENT'] = $_SERVER['HTTP_USER_AGENT'];
				$_SESSION['REMOTE_ADDR'] = $userIP;
				header('Location: dash.php');
				exit();
				
			}
		}
		
		if (!$logIn)
		{
			array_push($error, "Invalid username/password combination.");
		}
	}
	
	if (!empty($error))
	{
		$smarty->assign('error', $error);
	}
}

$smarty->display('templates/login.tpl');

?>