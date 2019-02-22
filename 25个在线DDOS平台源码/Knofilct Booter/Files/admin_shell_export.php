<?php

include('config.php');

if ($_SESSION['group'] != "administrator") header("Location: admin.php");

$query = mysql_query("SELECT * FROM `shells`;");

$get_array = array();
$post_array = array();
$slowloris_array = array();

while ($row = mysql_fetch_array($query)) {
	
	$loc = $row['location'];
	$type = $row['type'];
	
	switch ($type) {
		
		case 'g':
			$get_array[] = $loc;
		break;
			
		case'p':
			$post_array[] = $loc;
		break;
		case 's':
			$slowloris_array[] = $loc;
		break;
		
	}
	
}

echo "=== GET SHELLS ==<br /><br />";
foreach ($get_array as $row) echo $row . '<br />';

echo "<br />=== POST SHELLS ==<br /><br />";
foreach ($post_array as $row) echo $row . '<br />';

echo "<br />=== SLOWLORIS SHELLS ==<br /><br />";
foreach ($slowloris_array as $row) echo $row . '<br />';

?>