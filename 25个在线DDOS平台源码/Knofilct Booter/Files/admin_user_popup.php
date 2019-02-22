<?php

include("config.php");

if ($_SESSION['group'] != "administrator") die("Invalid user privelages.");

$footer = "";

$id = mysql_real_escape_string($_GET['id']);
if (!is_numeric($id) || mysql_num_rows(mysql_query("SELECT * FROM `users` WHERE `id` = '$id';")) == 0 || $id == 1) {

	die ("Invalid user.  Please retry.");
	
}

if (isset($_POST['form_type'])) {

	$user = mysql_fetch_array(mysql_query("SELECT * FROM `users` WHERE `id` = '$id';"));
	$id = $user['id'];
	$group = $_POST['g'];
	$length = $_POST['l'];
	$end_date = $_POST['end_date'];
	$enabled = $_POST['e'];
	
	mysql_query("UPDATE `users` SET `group` = '$group', `sublength` = '$length', `end_date` = '$end_date', `enabled` = '$enabled' WHERE `id` = '$id';") or die(mysql_error());
	
	$footer = "<div style='text-align:center; font-weight:bold; font-family:Arial, Helvetica, sans-serif; font-size:18px; color:#FFF; width:100%; height:25px; padding-top:6px; background-color:#006600; position:absolute; bottom:0px;'>User updated.</div><br />";
	
}

$user = mysql_fetch_array(mysql_query("SELECT * FROM `users` WHERE `id` = '$id';"));

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo BOOTER_NAME . " - Admin Edit User"; ?></title>
<link rel="stylesheet" href="style.css" type="text/css" media="screen" /> 
<script type="text/javascript">
function evaluate_update_form() {
	var form = document.getElementById("update_user_form");
	form.submit();
}
function flag_error(c,id) {
	document.getElementById(id).innerHTML = c;
}
function change_end(s) {
	var date = new Date();
	switch (s.value) {
                case "1d":
			var nd = new Date();
			nd.setTime(date.getTime() + (31 * 24 * 60 * 60 * 1000));
			var month = nd.getMonth() + 1;
			if (month < 10) month = "0" + month;
			document.getElementById("end_date").value = nd.getFullYear() + "-" + month + "-" + nd.getDate();		
		break;
                case "1w":
			var nd = new Date();
			nd.setTime(date.getTime() + (7 * 24 * 60 * 60 * 1000));
			var month = nd.getMonth() + 1;
			if (month < 10) month = "0" + month;
			document.getElementById("end_date").value = nd.getFullYear() + "-" + month + "-" + nd.getDate();		
		break;
		case "1m":
			var nd = new Date();
			nd.setTime(date.getTime() + (31 * 24 * 60 * 60 * 1000));
			var month = nd.getMonth() + 1;
			if (month < 10) month = "0" + month;
			document.getElementById("end_date").value = nd.getFullYear() + "-" + month + "-" + nd.getDate();		
		break;
		case "2m":
			var nd = new Date();
			nd.setTime(date.getTime() + (62 * 24 * 60 * 60 * 1000));
			var month = nd.getMonth() + 1;
			if (month < 10) month = "0" + month;
			document.getElementById("end_date").value = nd.getFullYear() + "-" + month + "-" + nd.getDate();		
		break;
		case "3m":
			var nd = new Date();
			nd.setTime(date.getTime() + (93 * 24 * 60 * 60 * 1000));
			var month = nd.getMonth() + 1;
			if (month < 10) month = "0" + month;
			document.getElementById("end_date").value = nd.getFullYear() + "-" + month + "-" + nd.getDate();				
		break;
		case "6m":
			var nd = new Date();
			nd.setTime(date.getTime() + (186 * 24 * 60 * 60 * 1000));
			var month = nd.getMonth() + 1;
			if (month < 10) month = "0" + month;
			document.getElementById("end_date").value = nd.getFullYear() + "-" + month + "-" + nd.getDate();				
		break;
		case "1y":
			var nd = new Date();
			nd.setTime(date.getTime() + (365 * 24 * 60 * 60 * 1000));
			var month = nd.getMonth() + 1;
			if (month < 10) month = "0" + month;
			document.getElementById("end_date").value = nd.getFullYear() + "-" + month + "-" + nd.getDate();		
		break;
		case "2y":
			var nd = new Date();
			nd.setTime(date.getTime() + (712 * 24 * 60 * 60 * 1000));
			var month = nd.getMonth() + 1;
			if (month < 10) month = "0" + month;
			document.getElementById("end_date").value = nd.getFullYear() + "-" + month + "-" + nd.getDate();	
		break;
		case "lifetime":
			document.getElementById("end_date").value = null;	
		break;
		default:
		break;
	}
}
</script>
</head>
<body><br /><br />
<center>
<div class="box" style="width:500px;">
<span class="heading_2"><?php echo "Edit \"" . ucfirst($user['username']) . "\""; ?></span>
<br /><br />

<form action="<?php echo $_SERVER['PHP_SELF'] . "?id=" . $user['id']; ?>" method="post" id="update_user_form">
<input type="hidden" name="form_type" value="update_user_form" />
<table cellpadding="0" cellspacing="0" border="0" style="padding:5px;">
<tr><td width="100"><span class="heading_1">Username</span></td><td><input type="text" name="u" class="input" value="<?php echo ucfirst($user['username']); ?>" readonly /></td></tr>
<tr><td colspan="2"><div id="blank" style="height:5px;"> </div></td></tr>
<tr><td width="100"><span class="heading_1">Group</span></td><td>
<select name="g" class="select_input">
<option <?php if ($user['group'] == "administrator") echo "selected "; ?>value="administrator">Administrator</option>
<option <?php if ($user['group'] == "subscriber") echo "selected "; ?>value="subscriber">Subscriber</option>
<option <?php if ($user['group'] == "guest") echo "selected "; ?>value="guest">Guest</option>
</select>
</td></tr>
<tr><td colspan="2"><div id="blank" style="height:5px;"> </div></td></tr>
<tr><td width="100"><span class="heading_1">Length</span></td><td>
<select name="l" class="select_input" onchange="change_end(this);">
<option <?php if ($user['sublength'] == "1d")echo "selected "; ?>value="1d">1 Day</option>
<option <?php if ($user['sublength'] == "1w")echo "selected "; ?>value="1w">1 Week</option>
<option <?php if ($user['sublength'] == "1m")echo "selected "; ?>value="1m">1 Month</option>
<option <?php if ($user['sublength'] == "2m")echo "selected "; ?>value="2m">2 Months</option>
<option <?php if ($user['sublength'] == "3m")echo "selected "; ?>value="3m">3 Months</option>
<option <?php if ($user['sublength'] == "6m")echo "selected "; ?>value="6m">6 Months</option>
<option <?php if ($user['sublength'] == "1y")echo "selected "; ?>value="1y">1 Year</option>
<option <?php if ($user['sublength'] == "2y")echo "selected "; ?>value="2y">2 Years</option>
<option <?php if ($user['sublength'] == "lifetime")echo "selected "; ?>value="lifetime">Lifetime</option>
</select>
</td></tr>
<tr><td colspan="2"><div id="blank" style="height:5px;"> </div></td></tr>
<tr><td width="100"><span class="heading_1">Start Date</span></td><td><input type="text" name="start_date" class="input" value="<?php echo $user['start_date']; ?>" readonly /></td></tr>
<tr><td colspan="2"><div id="blank" style="height:5px;"> </div></td></tr>
<tr><td width="100"><span class="heading_1">End Date</span></td><td><input type="text" name="end_date" id="end_date" class="input" value="<?php echo $user['end_date']; ?>" placeholder="<?php if ($user['sublength'] == "lifetime") echo "Lifetime"; ?>" readonly /></td></tr>
<tr><td colspan="2"><div id="blank" style="height:5px;"> </div></td></tr>
<tr><td width="100"><span class="heading_1">Enabled</span></td><td>
<select name="e" class="select_input" onchange="change_end(this);">
<option <?php if ($user['enabled'] == "TRUE")echo "selected "; ?>value="TRUE">TRUE</option>
<option <?php if ($user['enabled'] == "FALSE")echo "selected "; ?>value="FALSE">FALSE</option>
</select>
</td></tr>
<tr><td colspan="2"><div id="blank" style="height:5px;"> </div></td></tr>
<tr><td colspan="2"><div style="float:right;"><table cellpadding="0" cellspacing="0" border="0"><tr><td width="100%" style="padding-right:10px;"><div style="float:right;"><span id="update_error" class="error_box"></span></div></td><td><div style="float:right;"><a href="javascript:evaluate_update_form();" style="text-decoration:none;"><div id="button">Update User</div></a></div></td></tr></table></div></td></tr>
</table>
</form>

</div>
</center>

<?php echo $footer; ?>

</body>
</html>