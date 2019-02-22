<?php

require_once "../core.php";

if (!isAdmin) redirect(BASE.'index.php');

require_once THEME."header.php";
require_once ADMIN_THEME."nav.php";

$page = isset($_GET['page']) ? mysql_real_escape_string($_GET['page']) : "";
$perpage = isset($_GET['perpage']) ? mysql_real_escape_string($_GET['perpage']) : "100";
$user = isset($_GET['user']) ? mysql_real_escape_string($_GET['user']) : "";

opencontent("Attack Logs");

echo "<form action='logs.php' method='post' name='logsform'>\n";
echo "<center>\n";

if (isset($_POST['delete'])) {

	$checkbox = $_POST['checkbox'];

	for ($i = 0; $i < count($checkbox); $i++) {

		$del_id = $checkbox[$i];
		$delete = mysql_query("DELETE FROM logs WHERE id = '".$del_id."' LIMIT 1") or die(mysql_error());

	}
	
	echo "Selected logs have been removed.<br /><br />\n";

} elseif (isset($_POST['prune'])) {

	$prune_query = mysql_query("DELETE FROM logs WHERE time < now() - interval 1 hour") or die(mysql_error());
	echo "Logs have been pruned.<br /><br />\n";

}

if ($page == "") {
	$pagelim = 0;
	$page = 1;
} else { $pagelim = $page * $perpage - $perpage; }

$countlogs = mysql_num_rows(mysql_query("SELECT * FROM logs"));
$pagenum = round($countlogs / $perpage);

for ($i = 1; $i <= $pagenum; $i++) {
	
	if ($i != $page)
		echo "<a href='logs.php?page=".$i."&perpage=".$perpage."'>".$i."</a> ";
	else
		echo $i." ";
		
}

echo "</center>\n";
echo "<table cellpadding='5' cellspacing='5' style='text-align: center; font-size: 9px;'>\n<tr>\n";
echo "<td></td>\n";
echo "<td>User</td>\n";
echo "<td>User IP</td>\n";
echo "<td>Type</td>\n";
echo "<td>Target</td>\n";
echo "<td>Duration</td>\n";
echo "<td>Shell %</td>\n";
echo "<td>Port</td>\n";
echo "<td>Time</td>\n";
echo "</tr>\n";

$whereclause = "";

if ($user != "")
	$whereclause = " WHERE username = '".$user."'";

$log_query = mysql_query("SELECT * FROM logs".$whereclause." ORDER BY id DESC LIMIT ".$pagelim.", ".$perpage) or die(mysql_error());

while ($row = mysql_fetch_array($log_query)){

	echo "<tr>\n";
	echo "<td><input name='checkbox[]' type='checkbox' id='checkbox[]' value='".$row['id']."' /></td>\n";
	echo "<td><a href='logs.php?user=".$row['username']."'>".$row['username']."</a></td>\n";
	echo "<td>".$row['ip']."</td>\n";
	echo "<td>".$row['type']."</td>\n";     
	echo "<td>".$row['target']."</td>\n";
	echo "<td>".$row['duration']." sec</td>\n";
	echo "<td>".$row['power']."%</td>\n";
	echo "<td>".$row['port']."</td>\n";
	echo "<td>".showdate($row['time'], "m/j H:i")."</td>\n";
	echo "</tr>\n";

}

echo "<tr></tr>\n<tr>\n";
echo "<td style='vertical-align: middle;'><input type='checkbox' id='checkall' value='true' onchange=\"selectAllCheckBoxes('logsform', 'checkbox[]');\" /></td>\n";
echo "<td colspan='9' style='text-align: left;'>\n\n";
echo "<input name='delete' type='submit' id='delete' value='Delete' />\n";
echo " <input type='submit' name='prune' id='prune' value='Prune' />\n";
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