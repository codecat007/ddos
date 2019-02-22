<?php

require_once "core.php";

if (!isMember) redirect('index.php');

require_once THEME."header.php";
require_once THEME."nav.php";

$host = isset($_POST['host']) ? mysql_real_escape_string($_POST['host']) : "";
$start = isset($_POST['start']) ? $_POST['start'] : "";
$end = isset($_POST['end']) ? $_POST['end'] : "";

opencontent("Port Scanner");

echo "<form action='' method='post'>\n";
echo "<table cellpadding='5' cellspacing='5' style='text-align: center; width: 100%;'>\n";

if ($host != "") {

	error_reporting(0);

	if ($start == "" || $end == "")
		jsredirect('index.php');
	
	if ($start != "" && !is_numeric($start))
		jsredirect('index.php');
	
	if ($end != "" && !is_numeric($end))
		jsredirect('index.php');

	if ($start < 0) { $start = 0; }
	if ($end < 0) { $end = 0; }
	if ($start > 65535) { $start = 65535; }
	if ($start > $end) { $end = $start; }
	if ($end - $start > 25) { $end = $start + 25; }
	if ($end > 65535) { $end = 65535; }

	echo "<center>\n";

	for ($i = $start; $i <= $end; $i++) {

		$fp = fsockopen($host, $i, $errno, $errstr, 10);
		
		if($fp) {

			echo "Port ".$i." <span style='color: #00cc00;'>&nbsp;open&nbsp;</span> on <i>".$host."</i>\n";
			fclose($fp);

		} else {
			echo "Port ".$i." closed on <i>".$host."</i>\n";
		}

		flush();
		
		echo "<br />\n";
	}
	
	echo "<br />\n";
	echo "</center>\n";
			
} else {

	echo "<center>You may only scan up to 25 ports at a time.<br />Any attempts to scan more will scan 25 ports, starting at the specified start port.<br /><br />\n";
	echo "Please note that the 25 port limit per scan is because port scanning takes time and bandwidth.<br />Be patient. You may want to open a new tab, as well...</center>\n<br /><br />\n";

}

echo "<form method='post' action=''>\n";
echo "<table cellpadding='5' cellspacing='5' style='text-align: left;'>\n";

$enemies = mysql_query("SELECT * FROM enemies WHERE username = '".$userinfo['username']."'");

if (mysql_num_rows($enemies) > 0) {

	echo "<tr>\n";
	echo "<td align='right'>Select Enemy<div style='font-size: 9px;'>(Optional)</div></td>\n";
	echo "<td>\n";
	echo "<select onchange='document.getElementById(\"host\").value=this.value;'>\n";
	echo "<option value=''>-Select-</option>\n";

	while ($enemy = mysql_fetch_array($enemies))
		echo "<option value='".$enemy['ip']."'>".$enemy['description']."</option>\n";

	echo "</select></td>\n</tr>\n";

} else {

	echo "<tr>\n";
	echo "<td align='right'>Select Enemy<div style='font-size: 9px;'>(Optional)</div></td>\n";
	echo "<td colspan='2' align='left'>\n";
	echo "<select onchange='window.location.href=this.value;'>\n";
	echo "<option value='#'>-Select-</option>\n";
	echo "<option value='enemies.php'>Add Enemies</option>\n\n";
	echo "</select></td>\n";
	echo "</tr>\n";

}

echo "<tr>\n";
echo "<td align='right'><strong>IP To Scan</strong></td>\n";
echo "<td><input type='text' name='host' /></td>\n";
echo "</tr>\n<tr>\n";
echo "<td align='right'><strong>Start Port (0-65535)</strong></td>\n";
echo "<td><input type='text' name='start' maxlength='5' /></td>\n";
echo "</tr>\n<tr>\n";
echo "<td align='right'><strong>End Port (Start-65535)</strong></td>\n";
echo "<td><input type='text' name='end' maxlength='5' /></td>\n";
echo "</tr>\n<tr>\n";
echo "<td></td>\n";
echo "<td><input type='submit' value='Submit'></td>\n";
echo "</tr>\n</table>\n</form>\n";

echo "</table>\n";
echo "</form>\n";

closecontent();

require_once THEME."footer.php";

?>