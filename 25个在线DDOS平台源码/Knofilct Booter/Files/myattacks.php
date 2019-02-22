<?php

include("config.php");

$footer = "";

if(!isset($_SESSION['username'])) {
	header("Location: index.php");
}

switch ($_POST['form_type']) {
	case "logout_form":
		logout();
	break;
}
		
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo BOOTER_NAME . " - My Attacks"; ?></title>
<link rel="stylesheet" href="style.css" type="text/css" media="screen" /> 
</head>
<body>
<center>
<div id="top">

<img class="logo" src="logo.png" />

<div class="tabs">
	<div class="tab" onclick="document.location.href='member.php';">Member Home</div>
	<div class="tab" onclick="document.location.href='ucp.php';">User CP</div>
    <div class="tab" onclick="document.getElementById('logout_form').submit();"><form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" id="logout_form" style="display:inline;"><input type="hidden" name="form_type" value="logout_form" id="logout_form" />Logout</form></div>
</div>

</div>

<div id="placeholder">

	<div id="placeholderL">
		<div class="left">
			<span class="title">Menu:</span>
			<ul class="menu">
				<?php echo left_menu(); ?>
           </ul>
		</div>
	</div>

<div id="placeholderR">
<div class="right"><br /><br />

<table cellpadding="5" cellspacing="0" border="1" align="center" style="color:#000; font-size:12px; width:100%;">
<tr><td id="tbox">Domain</td><td id="tbox">Date</td></tr>

<center><span class="heading_2">My Attacks</span></center><br />

<?php

	$cs = '<td id="tebox">';
	$ce = '</td>';
	
	$attack_list = mysql_fetch_array(mysql_query("SELECT `attacks` FROM `users` WHERE `id` = '" . $_SESSION['id'] . "';"));
	$attack_list = $attack_list['attacks'];

	$array = explode("::",$attack_list);

	for ($i = 0; $i < count($array); $i++) {
		if ($i != (count($array) - 1)) {
			$row = explode("--",$array[$i]);
			$url = $row[0];
			$date = date("Y-m-d",$row[1]);
			echo '<tr>' . $cs . $url . $ce . $cs . $date . $ce . '</tr>';
		}
	}

?>
</table>

</div>
</div>

<div id="footer"><?php echo footer(); ?></div>

</div>
</center>

<?php echo $footer; ?>

</body>
</html>