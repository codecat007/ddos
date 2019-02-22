<?php
	//Start session
	session_start();
	
	//Connect to mysql server
     include('includes/db.php');
	//Sanitize the value received from login field
	//to prevent SQL Injection
	if(!get_magic_quotes_gpc()) {
		$login=mysql_real_escape_string($_POST['login']);
	}else {
		$login=$_POST['login'];
	}

	$thepass = md5(trim($_POST['password']));

	//Create query
	$qry="SELECT * FROM users WHERE username ='$login' AND password='$thepass'";
	$result=mysql_query($qry);
	//Check whether the query was successful or not
	if($result) {
		if(mysql_num_rows($result)>0) {
			//Login Successful
			session_regenerate_id();
			$member=mysql_fetch_assoc($result);
			$_SESSION['SESS_MEMBER_ID']=$member['id'];
			session_write_close();
			$query = "SELECT * FROM users WHERE id={$_SESSION['SESS_MEMBER_ID']}";
			$result = mysql_query($query);
			$row = mysql_fetch_array($result);
			$time = time();
			$userip = $_SERVER['REMOTE_ADDR'];
			mysql_query("UPDATE users SET lastactive='$time' WHERE id={$_SESSION['SESS_MEMBER_ID']}");
			mysql_query("UPDATE users SET userip='$userip' WHERE id={$_SESSION['SESS_MEMBER_ID']}");
			if(empty($row['loginip'])){
				$row['loginip'] = $_SERVER['REMOTE_ADDR'];
				$loginip = $row['loginip'];
			}else{
				$ip_information = explode("-", $row['loginip']);
				if (in_array($_SERVER['REMOTE_ADDR'], $ip_information)) {	
					$loginip = $row['loginip'];
				}else{	
					$loginip = $row['loginip']."-".$_SERVER['REMOTE_ADDR'];
				}
			}
			mysql_query("UPDATE users SET loginip='$loginip' WHERE id={$_SESSION['SESS_MEMBER_ID']}");
			$staff = $row['staff'];
			if ($staff == 'admin') {
				header("location: _main.php");
				exit();
			}else{
				header("location: _boot.php");
				exit();
			}
		}else {
			//Login failed
			header("location: index.php");
			exit();
		}
	}else {
		die("Query failed");
	}
?>