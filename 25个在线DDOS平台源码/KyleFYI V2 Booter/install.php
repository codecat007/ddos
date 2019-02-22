<?PHP
	require('libs/Smarty.class.php');
	$smarty = new Smarty;
	$smarty->template_dir = 'templates';
	$smarty->compile_dir = 'temp';
	//dbpassword
	if(isset($_POST['username']) and ($_POST['password']) and ($_POST['host']) and ($_POST['user']) and ($_POST['name']) and ($_POST['dbpassword']) and ($_POST['bname']) and ($_POST['URL'])){
		$username = $_POST['username'];
		$password = md5($_POST['password']);
		$host = $_POST['host'];
		$user = $_POST['user'];
		$name = $_POST['name'];
		$dbpassword = $_POST['dbpassword'];
		$bname = $_POST['bname'];
		$URL = $_POST['URL'];
		$connect = mysql_connect($host, $user, $dbpassword);
		$select = mysql_select_db($name);
		mysql_query("INSERT INTO `users` (`member_id`, `login`, `passwd`, `max`, `attacks`, `expiry`, `type`, `key`) VALUES(1, '".$username."', '".$password."', '3600', '100', '0', 'admin', '')");
		$filename = 'include/config.php';
		$string = '
		<?php
		define("DB_HOST", "'.$host.'"); 
		define("DB_USER", "'.$user.'");
		define("DB_PASSWORD", "'.$dbpassword.'");
		define("DB_DATABASE", "'.$name.'");
		$con = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD);
		mysql_select_db(DB_DATABASE);
		$bootername = "'.$dname.'";
		$booterURL = "'.$URL.'";
		?>';

		$fp = fopen($filename, 'w');
		fwrite($fp, $string);
		fclose($fp);
		die("Installed, please remove the install file!");
	}
	
	$smarty->display("class.install.tpl");
?>