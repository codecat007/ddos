<?php

require_once "core.php";

if (!isMember || $userinfo['accepttos'] == "1") redirect('index.php');

$accept = isset($_POST['accept']) ? $_POST['accept'] : "";

if ($accept == "Accept"){

	$update = mysql_query("UPDATE users SET accepttos = 1 WHERE user_id = ".$userinfo['user_id']." LIMIT 1") or die(mysql_error());
	redirect('index.php');

}

require_once THEME."header.php";
require_once THEME."nav.php";

opencontent("Terms Of Service");

echo "<form action='' method='post'>\n";
echo "<table cellpadding='30' cellspacing='30'>\n<tr>\n";
echo "<td>To use this site, you must accept the <a href='tos.php' target='_blank'>Terms of Service</a>.</td>\n";
echo "</tr>\n<tr>\n";
echo "<td><input type='submit' name='accept' value='Accept' /></td>\n";
echo "</tr>\n</table>\n";
echo "</form>\n";

closecontent();

require_once THEME."footer.php";

?>