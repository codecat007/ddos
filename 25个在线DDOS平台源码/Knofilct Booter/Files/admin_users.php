<?php

include("config.php");

if ($_SESSION['group'] != "administrator") header("Location: admin.php");

$flag_error = array();

function flag_error($text,$type) {
	
	global $flag_error;
	$flag_error[1] = $text;
	$flag_error[0] = $type;
	
}

if (isset($_POST['form_type'])) {
	
	switch ($_POST['form_type']) {
		case "register_user_form":
			$username = mysql_real_escape_string(htmlentities(strtolower($_POST['u'])));
			$password = md5 (SALT_1 . $_POST['p'] . SALT_2);
			$group = $_POST['g'];
			$length = $_POST['l'];
			
			$length_to_add = 0;
			switch ($length) {
                                case "1d":
					$length_to_add = time() + (2 * 24 * 60 * 60);
				break;
                                case "1w":
					$length_to_add = time() + (7 * 24 * 60 * 60);
				break;
				case "1m":
					$length_to_add = time() + (31 * 24 * 60 * 60);
				break;
				case "2m":
					$length_to_add = time() + (62 * 24 * 60 * 60);
				break;
				case "3m":
					$length_to_add = time() + (93 * 24 * 60 * 60);
				break;
				case "6m":
					$length_to_add = time() + (186 * 24 * 60 * 60);
				break;
				case "1y":
					$length_to_add = time() + (365 * 24 * 60 * 60);
				break;
				case "2y":
					$length_to_add = time() + (730 * 24 * 60 * 60);
				break;
				case "lifetime":
					$length_to_add = 0;
				break;
				default:
				break;
			}
			
			$end_date = "";
			if ($length_to_add != 0) $end_date = date("Y-m-d", $length_to_add);
			
			if (mysql_num_rows(mysql_query("SELECT * FROM `users` WHERE `username` = '" . $username . "';")) == 0) {
			
				mysql_query("INSERT INTO `users`(`username`,`password`,`group`,`sublength`,`start_date`,`end_date`,`enabled`) VALUES ('" . $username . "','" . $password . "','" . $group . "','" . $length . "','" . date("Y-m-d") . "','" . $end_date . "','TRUE');"); 
				
			} else {
				
				flag_error("User already exists.","register_error");
				
			}
		break;
		case "disable_form":
			$id = $_POST['disable_account_id'];
			$e = mysql_fetch_array(mysql_query("SELECT `enabled` FROM `users` WHERE `id` = " . $id . ";"));
			$e = $e['enabled'];
			if ($e == "TRUE") mysql_query("UPDATE `users` SET `enabled` = 'FALSE' WHERE `id` = '" . $id . "';") or die (mysql_error());
			else mysql_query("UPDATE `users` SET `enabled` = 'TRUE' WHERE `id` = '" . $id . "';") or die (mysql_error());
		break;
		case "delete_form":
			$id = $_POST['delete_account_id'];
			mysql_query("DELETE FROM `users` WHERE `id` = '" . $id . "';") or die (mysql_error());
		break;
		case "logout_form":
			logout();
		break;
		default:
		break;
	}
}

$user_array = array();
$user_id_array = array();
$user_query = mysql_query('SELECT * FROM `users`;');
if (mysql_num_rows($user_query) != 0) {
	while ($row = mysql_fetch_array($user_query)) {
		$user_array[] = $row;	
		$user_id_array[] = $row['id'];
	}
	array_multisort($user_id_array, $user_array);
}


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo BOOTER_NAME . " - Admin Users"; ?></title>
<link rel="stylesheet" href="style.css" type="text/css" media="screen" /> 
<script type="text/javascript">
function evaluate_register_form() {
	var form = document.getElementById("register_user_form");
	var error = false;
	if (form.elements["u"].value.length == 0 || form.elements["p"].value.length == 0) error = true;
	if (!error)	form.submit();
	else flag_error("Please fill in all fields.","register_error");
}
function flag_error(c,id) {
	document.getElementById(id).innerHTML = c;
}
function enable_disable_account(id) {
	document.getElementById("disable_account_id").value = id;	
	if (confirm("Are you sure you wish to enable/disable this account?")) document.getElementById("disable_form").submit();
}
function delete_account(id) {
	document.getElementById("delete_account_id").value = id;	
	if (confirm("Are you sure you wish to delete this account?")) document.getElementById("delete_form").submit();	
}
</script>
</head>
<body>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" id="disable_form"><input type="hidden" name="form_type" value="disable_form" /><input type="hidden" name="disable_account_id" value="" id="disable_account_id" /></form>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" id="delete_form"><input type="hidden" name="form_type" value="delete_form" /><input type="hidden" name="delete_account_id" value="" id="delete_account_id" /></form>
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

<div class="right">
<br /><br />

<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" id="register_user_form">
<input type="hidden" name="form_type" value="register_user_form" />
<table cellpadding="0" cellspacing="0" border="0" style="padding:5px;">
<tr><td width="100"><span class="heading_1">Username</span></td><td><input type="username" name="u" class="input" /></td></tr>
<tr><td colspan="2"><div id="blank" style="height:5px;"> </div></td></tr>
<tr><td width="100"><span class="heading_1">Password</span></td><td><input type="password" name="p" class="input" /></td></tr>
<tr><td colspan="2"><div id="blank" style="height:5px;"> </div></td></tr>
<tr><td width="100"><span class="heading_1">Group</span></td><td>
<select name="g" class="select_input">
<option value="administrator">Administrator</option>
<option value="subscriber">Subscriber</option>
<option selected value="guest">Guest</option>
</select>
</td></tr>
<tr><td colspan="2"><div id="blank" style="height:5px;"> </div></td></tr>
<tr><td width="100"><span class="heading_1">Length</span></td><td>
<select name="l" class="select_input">
<option selected value="1m">1 Month</option>
<option value="2m">2 Months</option>
<option value="3m">3 Months</option>
<option value="6m">6 Months</option>
<option value="1y">1 Year</option>
<option value="2y">2 Years</option>
<option value="lifetime">Lifetime</option>
</select>
</td></tr>
<tr><td colspan="2"><div id="blank" style="height:5px;"> </div></td></tr>
<tr><td colspan="2"><div style="float:right;"><table cellpadding="0" cellspacing="0" border="0"><tr><td width="100%" style="padding-right:10px;"><div style="float:right;"><span id="register_error" class="error_box"><?php if ($flag_error[0] == "register_error") echo $flag_error[1]; ?></span></div></td><td><div style="float:right;"><a href="javascript:evaluate_register_form();" style="text-decoration:none;"><div id="button">Add User</div></a></div></td></tr></table></div></td></tr>
</table>
</form>

<br />
</div>

<div class="right">
<table cellpadding="5" cellspacing="0" border="1" style="color:#000; font-size:12px; width:100%;">
<tr><td id="tbox">ID</td><td id="tbox">Username</td><td id="tbox">Group</td><td id="tbox">Subscription Length</td><td id="tbox">Start Date</td><td id="tbox">End Date</td><td id="tbox">Enabled</td><td id="tbox">Other</td><td id="tbox">Transid</td></tr>
<?php

	$cs = '<td id="tebox">';
	$ce = '</td>';

	foreach ($user_array as $row) {
		$id = $row['id'];
		$username = $row['username'];
		$password = $row['password'];
		$group = $row['group'];
		$sublength = $row['sublength'];
		$start_date = $row['start_date'];
		$end_date = $row['end_date'];
		$account_enabled = $row['enabled'];
		
		$ending = "";
		
		if ($id != 1) $ending = '<a href="javascript:enable_disable_account(' . $id . ');"><img src="lock.gif" alt="Disable/Enable Account" border="0" width="15" height="15" /></a> <a href="javascript:window.open(\'admin_user_popup.php?id=' . $id . '\',width=550,height=550,menubar=0,toolbar=0,resizable=0);"><img src="edit.png" alt="Edit User" border="0" width="15" height="15" /></a> <a href="javascript:delete_account(' . $id . ');"><img src="delete.gif" alt="Delete Account" border="0" width="15" height="15" /></a>';
		
		echo '<tr>' . $cs . $id . $ce , $cs . $username . $ce . $ce . $cs . $group . $ce . $cs . $sublength . $ce . $cs . $start_date . $ce . $cs . $end_date . $ce . $cs . $account_enabled . $ce . $cs . $ending . $ce . $cs . $transactionid . $ce . '</tr>';
		
	}

?>
</table>
</div>

</div>

<div id="footer"><?php echo footer(); ?></div>

</div>
</center>
</body>
</html>