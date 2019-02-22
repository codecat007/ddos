<?php

$query = "SELECT * FROM users WHERE id={$_SESSION['SESS_MEMBER_ID']}";
$result = mysql_query($query);
$row = mysql_fetch_array($result, MYSQL_ASSOC);
$months = $row['months'];
$active = $row['active'];
$userip = $row['userip'];
$time = time();

if ($months !== lifetime) {
	if (($active == 'activated') AND ($months < $time)) {
		$active = 'Your login is deactivated.<br />REASON: Payment is overdue. Please pay your bill by sending a private message to http://www.hackforums.net/member.php?action=profile&uid=148750.';
		$query = "UPDATE users SET active='$active' WHERE id={$_SESSION['SESS_MEMBER_ID']}";
		$result = mysql_query($query);
	}
}

if (($userip != $_SERVER['REMOTE_ADDR']) AND ($active == 'activated')){
	$active = 'Your login is deactivated.<br />REASON: Logged in with another IP while still logged in with a different IP. Contact me on MSN/HF. As soon as I see your PM I will fix it.';
	$query = "UPDATE users SET active='$active' WHERE id={$_SESSION['SESS_MEMBER_ID']}";
	$result = mysql_query($query);
}
	
if ($active !== 'activated'){
	echo $active;
	exit();
}

?>
