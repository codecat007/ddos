<?php

include("config.php");

$footer = "";
$flag_error = "";

if(!isset($_SESSION['username'])) {
	header("Location: index.php");
}

switch ($_POST['form_type']) {
	case "change_password_form":
		$password_new = md5(SALT_1 . $_POST['p'] . SALT_2);
		$password_old = md5(SALT_1 . $_POST['op'] . SALT_2);
		$password_old_copy = mysql_fetch_array(mysql_query("SELECT `password` FROM `users` WHERE `id` = '" . $_SESSION['id'] . "';"));
		$password_old_copy = $password_old_copy['password'];
		if ($password_old != $password_old_copy) {
			$flag_error	= "Passwords don't match.";
		} else {
			mysql_query("UPDATE `users` SET `password` = '$password_new' WHERE `id` = '" . $_SESSION['id'] . "';") or die(mysql_error());
			$footer = "<div style='text-align:center; font-weight:bold; font-family:Arial, Helvetica, sans-serif; font-size:18px; color:#FFF; width:100%; height:25px; padding-top:6px; background-color:#006600; position:absolute; bottom:0px;'>Password Changed</div><br />";
		}
	break;
	case "logout_form":
		logout();
	break;
}
		
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo BOOTER_NAME . " - Control Panel"; ?></title>
<link rel="stylesheet" href="style.css" type="text/css" media="screen" /> 
<script type="text/javascript">
function validate_chage_password_form() {
	var form = document.getElementById("change_password_form");
	var error = false;
	if (form.elements["op"].value.length == 0 || form.elements["p"].value.length == 0) error = true;
	if (!error)	form.submit();
	else flag_error("Please fill in all fields.");
}
function flag_error(c) {
	document.getElementById("error_box").innerHTML = c;
}
</script>
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
<table cellpadding="0" cellspacing="0" border="0" align="center">
<tr><td width="150" style="text-align:right; padding-right:10px;"><span class="heading_1">ID</span></td><td><input type="text" class="input" value="<?php echo $_SESSION['id']; ?>" readonly /></td></tr>
<tr><td colspan="2"><div id="blank" style="height:5px;"> </div></td></tr>
<tr><td width="150" style="text-align:right; padding-right:10px;"><span class="heading_1">Username</span></td><td><input type="text" class="input"  value="<?php echo $_SESSION['username']; ?>"readonly /></td></tr>
<tr><td colspan="2"><div id="blank" style="height:5px;"> </div></td></tr>
<tr><td width="150" style="text-align:right; padding-right:10px;"><span class="heading_1">Group</span></td><td><input type="text" class="input" value="<?php echo $_SESSION['group']; ?>" readonly /></td></tr>
<tr><td colspan="2"><div id="blank" style="height:5px;"> </div></td></tr>
<tr><td width="150" style="text-align:right; padding-right:10px;"><span class="heading_1">Subscription Length</span></td><td><input type="text" class="input" value="<?php echo $_SESSION['sublength']; ?>" readonly /></td></tr>
<tr><td colspan="2"><div id="blank" style="height:5px;"> </div></td></tr>
<tr><td width="150" style="text-align:right; padding-right:10px;"><span class="heading_1">Start Date</span></td><td><input type="text" class="input" value="<?php echo $_SESSION['start_date']; ?>" readonly /></td></tr>
<tr><td colspan="2"><div id="blank" style="height:5px;"> </div></td></tr>
<tr><td width="150" style="text-align:right; padding-right:10px;"><span class="heading_1">End Date</span></td><td><input type="text" class="input" value="<?php echo $_SESSION['end_date']; ?>" placeholder="Lifetime" readonly /></td></tr>
<tr><td colspan="2"><div id="blank" style="height:5px;"> </div></td></tr>
</table>
<br />
</div>
<div class="right"><br /><br />

<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" id="change_password_form">
<input type="hidden" name="form_type" value="change_password_form" />
<table cellpadding="0" cellspacing="0" border="0" align="center">
<tr><td width="150" style="text-align:right; padding-right:10px;"><span class="heading_1">Old Password</span></td><td><input type="password" name="op" class="input" /></td></tr>
<tr><td colspan="2"><div id="blank" style="height:5px;"> </div></td></tr>
<tr><td width="150" style="text-align:right; padding-right:10px;"><span class="heading_1">New Password</span></td><td><input type="password" name="p" class="input" /></td></tr>
<tr><td colspan="2"><div id="blank" style="height:5px;"> </div></td></tr>
<tr><td colspan="2"><div style="float:right;"><table cellpadding="0" cellspacing="0" border="0"><tr><td width="100%" style="padding-right:10px;"><div style="float:right;"><span class="error_box" id="change_password_error"><?php echo $flag_error; ?></span></div></td><td><div style="float:right;"><a href="javascript:validate_chage_password_form();"><div id="button">Update</div></a></div></td></tr></table></div></td></tr>
</table>
</form>

<br />
</div>
</div>

<div id="footer"><?php echo footer(); ?></div>

</div>
</center>

<?php echo $footer; ?>

</body>
</html>