<?php

include("config.php");

$flag_error = "";

function flag_error($text) {
	
	global $flag_error;
	$flag_error = $text;
	
}

function setSession($user) {

	$user["password"] = NULL;
	$_SESSION = $user;
	
}

if (isset($_POST['form_type'])) {
	
	switch ($_POST['form_type']) {
		case "login_form":
			$username = strtolower($_POST['u']);
			$password = md5(SALT_1 . $_POST['p'] . SALT_2);
			
			$query = mysql_query("SELECT * FROM `users` WHERE `username` = '" . $username . "' LIMIT 1;");
			if (mysql_num_rows($query) == 0) {
				flag_error("Invalid credentials.");
			} else {
				$user = mysql_fetch_array($query);
				if ($password == $user['password']) {
					if ($user['group'] == "administrator") {
						if ($user['enabled'] == "TRUE") {
							$end = 999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999;
							if ($user['end_date'] != "") $end = strtotime($user['end_date']);
							if ($end > strtotime(date("Y-m-d"))) { 
								setSession($user);
							} else {
								flag_error("Account expired.");	
							}
						} else {
							flag_error("Account disabled.");
						}
					} else {
						flag_error("Invalid privilages.");	
					}
				} else {
					flag_error("Invalid credentials.");	
				}
			}
		break;
		case "logout_form":
			logout();
		break;
		default:
		break;
	}
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo BOOTER_NAME . " - Admin"; ?></title>
<link rel="stylesheet" href="style.css" type="text/css" media="screen" /> 
<script type="text/javascript">
function evaluate_form() {
	var form = document.getElementById("login_form");
	var error = false;
	if (form.elements["u"].value.length == 0 || form.elements["p"].value.length == 0) error = true;
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
	<div class="tab" onclick="document.location.href='admin.php';">Admin Home</div>
	<div class="tab" onclick="document.location.href='admin_users.php';">Users</div>
	<div class="tab" onclick="document.location.href='admin_shells.php';">Shells</div>
    <div class="tab"><form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" id="logout_form" style="display:inline;"><input type="hidden" name="form_type" value="logout_form" /><a href="javascript:document.getElementById('logout_form').submit();">Logout</a></form></div>
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

<?php if ($_SESSION['group'] != "administrator") { ?>

<center><span class="heading_2" style="text-align:center; width:100%;">Admin Login</span></center><br />

<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" id="login_form">
<input type="hidden" name="form_type" value="login_form" />
<table cellpadding="0" cellspacing="0" border="0" align="center">
<tr><td width="100" style="text-align:right; padding-right:10px;"><span class="heading_1">Username</span></td><td><input type="username" name="u" class="input" /></td></tr>
<tr><td colspan="2"><div id="blank" style="height:5px;"> </div></td></tr>
<tr><td width="100" style="text-align:right; padding-right:10px;"><span class="heading_1">Password</span></td><td><input type="password" name="p" class="input" /></td></tr>
<tr><td colspan="2"><div id="blank" style="height:5px;"> </div></td></tr>
<tr><td colspan="2"><div style="float:right;"><table cellpadding="0" cellspacing="0" border="0"><tr><td width="100%" style="padding-right:10px;"><div style="float:right;"><span class="error_box" id="error_box"><?php echo $flag_error; ?></span></div></td><td><div style="float:right;"><a href="javascript:evaluate_form();"><div id="button">Login</div></a></div></td></tr></table></div></td></tr>
</table>
</form>

<?php } else { ?>

<div style="margin-left:10px; margin-right:10px;">This is the administration panel.  From here, you can use the menu on the top to intricately manage the ins and outs of your booting life.</div>

<?php } ?>

<br /><br />
</div>
</div>

<div id="footer"><?php echo footer(); ?></div>

</div>
</center>
</body>
</html>