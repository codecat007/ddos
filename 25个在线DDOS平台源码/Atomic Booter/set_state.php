<?php

require_once "core.php";

require_once THEME."header.php";
require_once THEME."nav.php";

$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : "login";
$user = isset($_POST['username']) ? mysql_real_escape_string(trim($_POST['username'])) : "";
$pass = isset($_POST['password']) ? md5(trim($_POST['password'])) : "";

if ($action == "login") {

	if (isset($_SESSION['username']) && $_SESSION['username'] != "") jsredirect('index.php');
	
	if ($user == "" || $pass == "") jsredirect('index.php');

	$login_query = mysql_query("SELECT * FROM users WHERE username = '".$user."' AND password = '".$pass."' LIMIT 1");

	if (mysql_num_rows($login_query) == 1) {

		$login_array = mysql_fetch_array($login_query);
		
		if ($login_array['banned'] == "0") {
		
			$_SESSION['username'] = $login_array['username'];

			opencontent("Login");
			echo "<p style='text-align: center;'>Login successful. Welcome, ".$_SESSION['username']."!<br />Redirecting in 3 seconds..</p>\n";
			jsredirect("index.php", 3);
			
		} else {
		
			opencontent("Account Banned");
			echo "<p style='text-align: center;'>Your account has been banned due to violation of our Terms Of Service.<br /></p>\n";

			unset($_SESSION['username']);
			session_destroy();

		}

	} else {

		opencontent("Login");
		echo "<p style='text-align: center;'>Error: Invalid username:password combination.<br />Redirecting in 3 seconds..</p>\n";
		jsredirect("index.php", 3);
		closecontent();
		
	}

} elseif ($action == "logout") {

	if (!isset($_SESSION['username']) || $_SESSION['username'] == "") jsredirect('index.php');

	if ($userinfo['banned'] == "0") {
		
		opencontent("Logout");
		echo "<p style='text-align: center;'>Logout successful! Goodbye, ".$userinfo['username']."<br />Redirecting in 3 seconds..</p>\n";
		jsredirect("index.php", 3);

		unset($_SESSION['username']);
		session_destroy();
		
	} else {
		
		opencontent("Account Banned");
		echo "<p style='text-align: center;'>Your account has been banned due to violation of our Terms Of Service.<br /></p>\n";

		unset($_SESSION['username']);
		session_destroy();

	}

} else {
	jsredirect('index.php');
}

closecontent();

require_once THEME."footer.php";

?>