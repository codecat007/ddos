<?php

require_once "core.php";

if (!isMember) redirect('index.php');

require_once THEME."header.php";
require_once THEME."nav.php";

$page = isset($_GET['page']) ? mysql_real_escape_string($_GET['page']) : "";
$perpage = isset($_GET['perpage']) ? mysql_real_escape_string($_GET['perpage']) : "100";

opencontent("Attack Logs");

echo "<form action='' method='post' name='logsform'>\n";
echo "<center>\n";

if ($page == "") {
	$pagelim = 0;
	$page = 1;
} else { $pagelim = $page * $perpage - $perpage; }

$countlogs = mysql_num_rows(mysql_query("SELECT * FROM logs WHERE username = '".$userinfo['username']."' LIMIT 1"));
$pagenum = round($countlogs / $perpage);

for ($i = 1; $i <= $pagenum; $i++) {
	
	if ($i != $page)
		echo "<a href='attacks.php?page=".$i."&perpage=".$perpage."'>".$i."</a> ";
	else
		echo $i." ";
		
}

echo "</center>\n";
echo "<table cellpadding='5' cellspacing='5' style='text-align: center; font-size: 12px;'>\n<tr>\n";
echo "<td>Type</td>
	  <td>Target</td>
	  <td>Duration</td>
	  <td>Shell %</td>
	  <td>Port</td>
	  <td>Time</td>
	</tr>";

$log_query = mysql_query("SELECT * FROM logs WHERE username = '".$userinfo['username']."' ORDER BY id DESC LIMIT ".$pagelim.", ".$perpage) or die(mysql_error());

if (mysql_num_rows($log_query) > 0) {

	while ($row = mysql_fetch_array($log_query)){

		echo "<tr>\n";
		echo "<td>".$row['type']."</td>\n";     
		echo "<td>".$row['target']."</td>\n";
		echo "<td>".$row['duration']." sec</td>\n";
		echo "<td>".$row['power']."%</td>\n";
		echo "<td>".$row['port']."</td>\n";
		echo "<td>".showdate($row['time'], "m/j g:i")."</td>\n";
		echo "</tr>\n";

	}

} else {
	echo "<tr>\n<td colspan='6'><br />You have not initiated any attacks yet.</td>\n</tr>\n";
}

echo "</table>\n";
echo "</form>\n";

closecontent();

require_once THEME."footer.php";

?>