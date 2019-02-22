<?php

require_once "../core.php";

if (!isAdmin) redirect(BASE.'index.php');

require_once THEME."header.php";
require_once ADMIN_THEME."nav.php";

$host = isset($_POST['host']) ? htmlentities($_POST['host']) : "";
$submit = isset($_POST['submit']) ? $_POST['submit'] : "";

$delete = isset($_GET['delete']) ? mysql_real_escape_string($_GET['delete']) : "";
$edit = isset($_GET['edit']) ? mysql_real_escape_string($_GET['edit']) : "";

opencontent("Add Blacklisted Host");

if ($edit != "") {

	$check = mysql_query("SELECT * FROM blacklist WHERE id = '".$edit."' LIMIT 1");
	
	if (mysql_num_rows($check) == 1) {

		$item = mysql_fetch_array($check);
		
		if ($submit != "") {
		
			$update = mysql_query("UPDATE blacklist SET ip = '".$host."' WHERE id = ".$edit." LIMIT 1") or die(mysql_error());
			echo "<p style='text-align: center; color: #00cc00;'>Successfully edited the blacklisted host.</p>\n\n";
			
			closecontent();
			opencontent("Add Another Host To Blacklist");
		
		} else {
		
	echo "<form method='post' action='blacklist.php?edit=".$edit."'>\n";
	echo "<table cellpadding='5' cellspacing='5'>\n<tr>\n";
	echo "<td>Host To Blacklsit</td>\n";
	echo "<td><input type='text' name='host' value='".$item['ip']."' /></td>\n";
	echo "</tr>\n";
	echo "<tr>\n<td></td><td align='center'>\n";
	echo "<input type='submit' name='submit' value='Update Blacklisted Host' />\n";
	echo "</td>\n</tr>\n</table>\n</form>\n";
			
		}

	} else {
		echo "There is no blacklisted host with this ID.<br /><br />";
	}

} elseif ($delete != "") {

	$check = mysql_query("SELECT * FROM blacklist WHERE id = '".$delete."' LIMIT 1");
	
	if (mysql_num_rows($check) == 1) {
		$remove = mysql_query("DELETE FROM blacklist WHERE id = '".$delete."' LIMIT 1") or die(mysql_error());
		echo "Successfully deleted blacklisted host.<br /><br />\n";

	} else {
		echo "There is no blacklisted host with this ID.<br /><br />";
	}

} elseif ($host != "") {

		$insert = mysql_query("INSERT INTO blacklist (ip) VALUES ('".$host."')") or die(mysql_error());
		echo "Successfully added the blacklisted host.<br /><br />\n";
					
} elseif ($host == "") {

	echo "Please fill in the host field.<br /><br />\n";

}

if ($edit == "" || $submit != "") {

	echo "<form method='post' action='blacklist.php'>\n";
	echo "<table cellpadding='5' cellspacing='5'>\n<tr>\n";
	echo "<td>Host To Blacklsit</td>\n";
	echo "<td><input type='text' name='host' /></td>\n";
	echo "</tr>\n<tr>\n";
	echo "<td></td><td align='center'>\n";
	echo "<input type='submit' value='Add To Blacklist' />\n";
	echo "</td>\n</tr>\n</table>\n</form>\n";
	
}

closecontent();

opencontent("Current Blacklisted Hosts");

echo "<form>\n";
echo "<table cellpadding='5' cellspacing='5' style='text-align: center; margin-left: auto; margin-right: auto; text-align: center; border: 1px solid #fff; width: 65%;'>\n";
echo "<tr style='background: #222;'>\n";
echo "<td>Blacklisted Hosts</td>\n";
echo "</tr>\n";

$blacklisted = mysql_query("SELECT * FROM blacklist ORDER BY id DESC");

if (mysql_num_rows($blacklisted) > 0) {

	while ($item = mysql_fetch_array($blacklisted)) {

		echo "<tr>\n";
		echo "<td>".$item['ip']." [<a href='blacklist.php?edit=".$item['id']."'>Edit</a>] [<a href='blacklist.php?delete=".$item['id']."'>Delete</a>]</td>\n";
		echo "</tr>\n";

	}
	
} else {

	echo "<tr>\n<td colspan='2'>No existing blacklisted hosts.</td>\n</tr>\n";

}

echo "</table>\n</form>\n";

closecontent();

require_once THEME."footer.php";

?>