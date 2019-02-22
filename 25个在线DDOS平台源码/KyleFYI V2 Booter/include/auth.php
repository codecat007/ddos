<?php
	session_start();
	if(!isset($_SESSION['SESS_MEMBER_ID']) || (trim($_SESSION['SESS_MEMBER_ID']) == '')) {
		header("location: login.php");
		exit();
	}
?>