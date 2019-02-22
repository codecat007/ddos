<?php

require_once "core.php";

if (!isMember) redirect('index.php');

require_once THEME."header.php";
require_once THEME."nav.php";

$host = isset($_POST['host']) ? $_POST['host'] : "";
$ip = isset($_POST['ip']) ? $_POST['ip'] : "";

opencontent("Host To IP Converter");

echo "<form action='' method='post'>\n";
echo "<table cellpadding='5' cellspacing='5' style='text-align: center; width: 100%;'>\n";

if ($host != "") {

	$result = gethostbyname($host);

	if ($host == $result) { $result = "Invalid Host Name"; }

	echo "<tr>\n<td>IP of <i>".$host."</i>:</td>\n<td>".$result."</td>\n</tr>\n";
	echo "<tr><td colspan='2'><br /></td></tr>\n";
	echo "<tr>\n<td>Hostname (ex. google.com):</td>\n<td><input type='text' name='host' maxlength='150' /></td>\n</tr>\n";
	echo "<tr>\n<td></td>\n<td><input type='submit' value='Convert To IP' /></td>\n</tr>\n";

} else {

	echo "<tr>\n<td>Hostname (ex. google.com):</td>\n<td><input type='text' name='host' maxlength='150' /></td>\n</tr>\n";
	echo "<tr>\n<td></td>\n<td><input type='submit' value='Convert To IP' /></td>\n</tr>\n";

}

echo "</table>\n";
echo "</form>\n";

closecontent();

opencontent("IP To Host Converter");

echo "<form action='' method='post'>\n";
echo "<table cellpadding='5' cellspacing='5' style='text-align: center; width: 100%;'>\n";

if ($ip != "") {

	$result = gethostbyaddr($ip);

	if ($result == "") { $result = "Invalid IP"; }

	echo "<tr>\n<td>Host Name of <i>".$ip."</i>:</td>\n<td><a href='http://".$result."' title='".$result."' target='_blank'>".$result."</a></td>\n</tr>\n";
	echo "<tr><td colspan='2'><br /></td></tr>\n";
	echo "<tr>\n<td>IP Address (ex. 127.0.0.1):</td>\n<td><input type='text' name='ip' maxlength='15' /></td>\n</tr>\n";
	echo "<tr>\n<td></td>\n<td><input type='submit' value='Convert To IP' /></td>\n</tr>\n";

} else {

	echo "<tr>\n<td>IP Address (ex. 127.0.0.1):</td>\n<td><input type='text' name='ip' maxlength='15' /></td>\n</tr>\n";
	echo "<tr>\n<td></td>\n<td><input type='submit' value='Convert To Host' /></td>\n</tr>\n";
}

echo "</table>\n";
echo "</form>\n";

closecontent();

require_once THEME."footer.php";

?>