<?php
	//Start session
	session_start();
	
	//Include database connection details
	require_once('include/config.php');
	
	//Array to store validation errors
	$errmsg_arr = array();
	
	//Validation error flag
	$errflag = false;
	
	//Connect to mysql server
	$link = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD);
	if(!$link) {
		die('Failed to connect to server: ' . mysql_error());
	}
	
	//Select database
	$db = mysql_select_db(DB_DATABASE);
	if(!$db) {
		die("Unable to select database");
	}
	
	//Function to sanitize values received from the form. Prevents SQL injection
	function clean($str) {
		$str = @trim($str);
		if(get_magic_quotes_gpc()) {
			$str = stripslashes($str);
		}
		return mysql_real_escape_string($str);
	}
	
	//Sanitize the POST values
	$login = clean($_POST['login']);
	$password = clean($_POST['password']);
	
	//Input Validations
	if($login == '') {
		$errmsg_arr[] = 'Login ID missing';
		$errflag = true;
	}
	if($password == '') {
		$errmsg_arr[] = 'Password missing';
		$errflag = true;
	}
	
	//If there are input validations, redirect back to the login form
	if($errflag) {
		$_SESSION['ERRMSG_ARR'] = $errmsg_arr;
		session_write_close();
		header("location: login.php");
		exit();
	}
	
	//Create query
	$qry="SELECT * FROM users WHERE login='$login' AND passwd='".md5($_POST['password'])."'";
	$result=mysql_query($qry);
	
	//Check whether the query was successful or not
	if($result) {
		if(mysql_num_rows($result) == 1) {
			//Login Successful
			session_regenerate_id();
			$member = mysql_fetch_assoc($result);
			$_SESSION['SESS_MEMBER_ID'] = $member['member_id'];
			$_SESSION['SESS_passwd'] = $member['passwd'];
			$_SESSION['SESS_login'] = $member['login'];
			$_SESSION['SESS_type'] = $member['type'];
			$_SESSION['SESS_max'] = $member['max'];
			$_SESSION['SESS_attacks'] = $member['attacks'];
			$_SESSION['SESS_expiry'] = $member['expiry'];
			session_write_close();
			header("location: index.php");
			$ip = getenv("REMOTE_ADDR");
			$date = date("m.d.y"); 
			mysql_query("INSERT INTO `logs` (`username`, `ip`, `action`, `date`) VALUES ('$login', '$ip', 'Successfully logged in!', '$date');");
			exit();
		}else {
			//Login failed
			$ip = getenv("REMOTE_ADDR");
			$date = date("m.d.y"); 
			mysql_query("INSERT INTO `logs` (`username`, `ip`, `action`, `date`) VALUES ('$login', '$ip', 'Failed logged in!', '$date');");
			header("location: login.php?action=invalid");
			exit();
		}
	}else {
		die("Query failed");
	}
?>