<?php

require_once "core.php";

if (!isMember) redirect('index.php');

require_once THEME."header.php";
require_once THEME."nav.php";

$target = isset($_POST['host']) ? htmlentities($_POST['host']) : "";
$delete = isset($_GET['delete']) ? mysql_real_escape_string($_GET['delete']) : "";

if ($userinfo['logcode'] == "") {

	$key = substr(md5((time() + (time() + 1))), 0, 8);

	$get_keys = mysql_query("SELECT * FROM users");
	$duplicate_key = "no";
		
	while ($keys = mysql_fetch_array($get_keys)) {
		if ($key == $keys['logcode']) {
			$duplicate_key = "yes";
			break;
		}
	}

	if ($duplicate_key == "no") {
		$addkey = mysql_query("UPDATE users SET logcode = '".$key."' WHERE user_id = '".$userinfo['user_id']."' LIMIT 1") or die(mysql_error());
	}
	
	jsredirect('ip_logger.php');
	exit();

}

opencontent("IP Logger");

if ($delete == "all") {

	$delete = mysql_query("DELETE FROM ip_logs WHERE username = '".$userinfo['username']."'");
	if ($delete) {
		echo "Successfully deleted all IP logs.<br /><br />\n";
	} else {
		die(mysql_error());
	}

} elseif ($delete != "") {

	$delete_log = mysql_query("SELECT * FROM ip_logs WHERE ip = '".$_GET['delete']."' AND username = '".$userinfo['username']."'");

	if (mysql_num_rows($delete_log) > 0) {

		$delete = mysql_query("DELETE FROM ip_logs WHERE ip = '".$_GET['delete']."' AND username = '".$userinfo['username']."'");
		if ($delete) {
			echo "Successfully deleted all IP logs.<br /><br />\n";
		} else {
			die(mysql_error());
		}
		
	} else {
	
		echo "You have no logs of this IP address.<br /><br />\n";
	
	}

}

echo "<form>\n";
echo "<table cellpadding='3' cellspacing='3'>\n";
echo "<tr>\n";
echo "<td align='center'>To grab an IP addresses, send the following link to people. Check this page when anyone has clicked the link, and their IP address will be listed below.</td>\n";
echo "</tr>\n<tr>\n";
echo "<td align='center'><input type='text' class='entryfield' readonly='readonly' value='";

if ($userinfo['logcode'] != "")
	echo "http://".$_SERVER['HTTP_HOST'].preg_replace('/\/ip_logger\.php/', '', $_SERVER['PHP_SELF'])."/funny.php?id=".$userinfo['logcode']."' style='text-align: center; width: 350px;' />\n";
else
	echo "Please refresh the page to get your link.";

echo "</td>\n</tr>\n</table>\n";
echo "<br /><br />\n";

$logs = mysql_query("SELECT * FROM ip_logs WHERE username = '".$userinfo['username']."'");

if (mysql_num_rows($logs) > 0)
	echo "<center>\n<a href='ip_logger.php?delete=all'>Delete All IP Logs</a>\n</center>\n<br /><br />\n";

echo "<table cellpadding='3' cellspacing='3'>\n";
echo "<tr>\n";
echo "<td align='center'>Target IP</td>\n";
echo "<td align='center'>Manage</td>\n";
echo "<td align='center'>Time</td>\n";
echo "</tr>\n";

if (mysql_num_rows($logs) > 0) {

	while ($log = mysql_fetch_array($logs)) {

		echo "<tr>\n";
		echo "<td align='center'>".$log['ip']."</td><td align='center'>[<a href='ip_logger.php?delete=".$log['ip']."' title='Delete All Logs of This IP'>Delete This IP</a>]</td>\n<td align='center'>".date('m-j-y h:i:s', $log['timestamp'])."</td>\n";
		echo "</tr>\n";

	}
	
} else {

	echo "<tr>\n<td colspan='3' align='center'>You currently have no logged IP addresses.</td>\n</tr>\n";

}

echo "</table>\n</form>\n";

closecontent();

require_once THEME."footer.php";

?>