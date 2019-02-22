<?php

require_once "core.php";

if (!isMember) redirect('index.php');

require_once THEME."header.php";
require_once THEME."nav.php";

$ip = isset($_POST['ip']) ? htmlentities($_POST['ip']) : "";
$description = isset($_POST['description']) ? htmlentities($_POST['description']) : "";
$delete = isset($_POST['delete']) ? $_POST['delete'] : "";

opencontent("Enemies");

echo "<form action='enemies.php' method='post'>\n";
echo "<center>\n";

if ($ip != "") {
	if (!filter_var($_POST['ip'], FILTER_VALIDATE_IP)) {
		echo "The entered IP address is invalid.<br />\n";
	} else {

		$insert = mysql_query("INSERT INTO enemies (ip, username, description) VALUES ('".$ip."', '".$userinfo['username']."', '".$description."')") or die(mysql_error());
		echo "Successfully added ".$ip."<br />\n";

	}
}

if ($delete != "") {

	$checkbox = $_POST['checkbox'];
	for ($i = 0; $i < count($checkbox); $i++) {

		$todelete = $checkbox[$i];
		$to_del_query = mysql_query("SELECT * FROM enemies where id='".$todelete."'") or die(mysql_error());
		$friend = mysql_fetch_array($to_del_query);
		
		if ($userinfo['username'] == $friend['username'])
			$delete = mysql_query("DELETE FROM enemies WHERE id='".$todelete."'") or die(mysql_error());

	}

	echo "Selected enemies have been deleted.<br />\n";

}

echo "</center>\n";
echo "<table cellpadding='5' cellspacing='5' style='width: 100%;'>\n<tr>\n";
echo "<td>IP Address</td>\n";
echo "<td><input type='text' name='ip' /></td>\n";
echo "</tr>\n<tr>\n";
echo "<td>Description</td>\n";
echo "<td><input type='text' name='description' /></td>\n";
echo "</tr>\n<tr>\n";
echo "<td></td>\n";
echo "<td><input type='submit' name='Submit' value='Submit' /></td>\n";
echo "</tr>\n</table>\n</form>\n";

echo "<form action='' method='post' id='friendform'>\n";    
echo "<table cellpadding='3' cellspacing='3'>\n";
echo "<tr>\n";
echo "<td></td>\n";
echo "<td align='center'>Enemy's IP</td>\n";
echo "<td align='center'>Description</td>\n";
echo "</tr>\n";

$user_query = mysql_query("SELECT * FROM enemies WHERE username = '".$userinfo['username']."'") or die(mysql_error());

while ($row = mysql_fetch_array($user_query)){
	
	echo "<tr>\n";
	echo "<td><input name='checkbox[]' type='checkbox' id='checkbox[]' value='".$row['id']."' /></td>\n";
	echo "<td>".$row['ip']."</td>\n";
	echo "<td>".$row['description']."</td>\n";
	echo "</tr>\n";

}

echo "<tr></tr>\n<tr>\n";
echo "<td style='vertical-align: middle;'><input type='checkbox' id='checkall' value='true' onchange=\"selectAllCheckBoxes('friendform', 'checkbox[]');\" /></td>\n";
echo "<td style='text-align: left;'>\n\n";
echo "<input name='delete' type='submit' id='delete' value='Delete' />\n";
echo "</td>\n";
echo "</tr>\n</table>\n";
echo "</form>\n";

echo "<script>

var CheckValue = true;

function selectAllCheckBoxes(FormName, FieldName) {
		

	if(!document.forms[FormName])
		return;

	var objCheckBoxes = document.forms[FormName].elements[FieldName];

	if(!objCheckBoxes)
		return;

	var countCheckBoxes = objCheckBoxes.length;
	
	if(!countCheckBoxes)
		objCheckBoxes.checked = CheckValue;
	else
		for(var i = 0; i < countCheckBoxes; i++)
			objCheckBoxes[i].checked = CheckValue;
			
	if (CheckValue == true)
		CheckValue = false;
	else
		CheckValue = true;

}

</script>";

closecontent();

require_once THEME."footer.php";

?>