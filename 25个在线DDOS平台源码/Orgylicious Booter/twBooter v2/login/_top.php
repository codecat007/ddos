<link href="includes/style.css" rel="stylesheet" type="text/css" />
<?php
$query = "SELECT * FROM users WHERE id={$_SESSION['SESS_MEMBER_ID']}";
$result = mysql_query($query);
$row = mysql_fetch_array($result, MYSQL_ASSOC);

$lastwut = $row['lastactive'];
$staff = $row['staff'];
$time = time();
$timesince = $time - $lastwut;
$tosaccept = $row['terms'];

$sql = "SELECT * FROM stats WHERE id=1";
$query = mysql_query($sql);
$row = mysql_fetch_array($query);
$bootTitle = $row['bootname'];

if ($tosaccept == 'no'){
	echo '<META HTTP-EQUIV="Refresh" CONTENT="0; URL=_accept.php">';
	exit();
}

if ($timesince > 1800){
	session_destroy();
	echo 'You are being automatically logged out due to inactivity. <META HTTP-EQUIV="Refresh" CONTENT="5; URL=index.php">';
	exit();
}

include('_active.php');
include('includes/selectAllCheckBoxes.js');

mysql_query("UPDATE users SET lastactive='$time' WHERE id={$_SESSION['SESS_MEMBER_ID']}");

/**
 * Securities
 * ---
 * Page Titles
**/

$exScriptName = explode("/", $_SERVER['SCRIPT_NAME']);
$exScriptName = end($exScriptName);
$exScriptName = explode(".", $exScriptName);
$exScriptName = $exScriptName[0] . ".php";
switch ($exScriptName){
	case "_main.php":
		echo "<title>" . $bootTitle . " - Settings</title>";
		break;
	case "_shells.php":
		echo "<title>" . $bootTitle . " - Shell Manager</title>";
		break;
	case "_massshells.php":
		echo "<title>" . $bootTitle . " - Mass Shell Manager</title>";
		break;
	case "_users.php":
		echo "<title>" . $bootTitle . " - User Manager</title>";
		break;
	case "_badips.php":
		echo "<title>" . $bootTitle . " - IP Blacklist</title>";
		break;
	case "_badlogs.php":
		echo "<title>" . $bootTitle . " - Malicious Logs</title>";
		break;
	case "_logs.php":
		echo "<title>" . $bootTitle . " - Boot Logs</title>";
		break;
	case "_boot.php":
		echo "<title>" . $bootTitle . " - Booting</title>";
		break;
	case "_usercp.php":
		echo "<title>" . $bootTitle . " - User Control Panel</title>";
		break;
	case "_friends.php":
		echo "<title>" . $bootTitle . " - Friend List</title>";
		break;
	case "_enemies.php":
		echo "<title>" . $bootTitle . " - Enemy List</title>";
		break;
	default:
		echo "<title>" . $bootTitle . "</title>";
}

/**
 * Page Titles
 * ---
 * User Navigation
**/

$adminTop = array();
$userTop = array();

$adminTop[] = "<a href=\"_main.php\">Settings</a>";
$adminTop[] = "<a href=\"_users.php\">Users</a>";
$adminTop[] = "<a href=\"_view.php\">View</a>";
$adminTop[] = "<a href=\"_badips.php\">IPs</a>";
$adminTop[] = "<a href=\"_badlogs.php\">Bad Logs</a>";
$adminTop[] = "<a href=\"_logs.php\">Logs</a>";

$userTop[] = "<a href=\"_boot.php\">Boot</a>";
$userTop[] = "<a href=\"_usercp.php\">UserCP</a>";
$userTop[] = "<a href=\"_friends.php\">Friend List</a>";
$userTop[] = "<a href=\"_enemies.php\">Enemy List</a>";
$userTop[] = "<a href=\"logout.php\">Logout</a>";
	
if ($staff == 'admin'){
	echo "<div align=\"center\">" . implode(" - ", $adminTop) . "<br /><br /></div>";
}
echo "<div align=\"center\">" . implode(" - ", $userTop) . "<br /><br /></div>";
?>

