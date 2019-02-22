<?
	require_once("include/config.php");
	require_once("include/auth.php");
	$username = $_SESSION['SESS_login'];
	$password = $_SESSION['SESS_passwd'];
	$qry="SELECT * FROM users WHERE login='$username' AND passwd='$password'";
	$result=mysql_query($qry);
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
?>