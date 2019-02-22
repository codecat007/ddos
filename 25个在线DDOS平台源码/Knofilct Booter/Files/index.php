<?php

include("config.php");

if(isset($_SESSION['username'])) {
	header("Location: member.php");
}

$flag_error = "";
$footer = "";

function flag_error($error, $text) {
	
	global $flag_error;
	$flag_error[0] = $error;
	$flag_error[1] = $text;
	
}

function setSession($user) {

	$user["password"] = NULL;
	$_SESSION = $user;
	
	header("Location: member.php");
	
}

if (isset($_POST['form_type'])) {
	
	switch ($_POST['form_type']) {
		case "login_form":
			$username = strtolower($_POST['u']);
			$password = md5(SALT_1 . $_POST['p'] . SALT_2);
			
			$query = mysql_query("SELECT * FROM `users` WHERE `username` = '" . $username . "' LIMIT 1;");
			if (mysql_num_rows($query) == 0) {
				flag_error("login_error","Invalid credentials.");
			} else {
				$user = mysql_fetch_array($query);
				if ($password == $user['password']) {
					if ($user['enabled'] == "TRUE") {
						$end = 999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999999;
						if ($user['end_date'] != "") $end = strtotime($user['end_date']);
						if ($end > strtotime(date("Y-m-d"))) { 
							setSession($user);
						} else {
							?>

<script type="text/javascript">
<!--
window.location = "http://www.mangoguava.com/purchase.php"
//-->
</script>
<?php
						}
					} else {
						flag_error("login_error","Account disabled.");
					}
				} else {
					flag_error("login_error","Invalid credentials.");	
				}
			}
		break;
		case "register_user_form":
			$username = mysql_real_escape_string(htmlentities(strtolower($_POST['u'])));
			$password = md5 (SALT_1 . $_POST['p'] . SALT_2);
			$group = "guest";
			$length = "lifetime";
			$length_to_add = 0;
			$end_date = "";
			if ($length_to_add != 0) $end_date = date("Y-m-d", $length_to_add);
			
			if (mysql_num_rows(mysql_query("SELECT * FROM `users` WHERE `username` = '" . $username . "';")) == 0) {
			
				mysql_query("INSERT INTO `users`(`username`,`password`,`group`,`sublength`,`start_date`,`end_date`,`enabled`) VALUES ('" . $username . "','" . $password . "','" . $group . "','" . $length . "','" . date("Y-m-d") . "','" . $end_date . "','TRUE');"); 
				
				$footer = "<div style='text-align:center; font-weight:bold; font-family:Arial, Helvetica, sans-serif; font-size:18px; color:#FFF; width:100%; height:25px; padding-top:6px; background-color:#006600; position:absolute; bottom:0px;'>User Registered</div><br />";
				
			} else {
				
				flag_error("register_error","User already exists.");
				
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
<title><?php echo BOOTER_NAME . " - Member Login"; ?></title>
<link rel="stylesheet" href="style.css" type="text/css" media="screen" /> 
<script type="text/javascript">
function evaluate_form() {
	var form = document.getElementById("login_form");
	var error = false;
	if (form.elements["u"].value.length == 0 || form.elements["p"].value.length == 0) error = true;
	if (!error)	form.submit();
	else flag_error("Please fill in all fields.","error_box");
}
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
</script>
</head>
<body>
<center>
<div id="top">

<img class="logo" src="logo.png" />

</div>

<div id="placeholder">

<div id="footer" style="height:200px;"><br /><br />

<center><span class="heading_2" style="text-align:center; width:100%;">Member Login</span></center><br />

<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" id="login_form">
<input type="hidden" name="form_type" value="login_form" />
<table cellpadding="0" cellspacing="0" border="0" align="center" width="350">
<tr><td width="200" style="text-align:right; padding-right:10px;"><span class="heading_1">Username</span></td><td><input type="text" name="u" class="input" /></td></tr>
<tr><td colspan="2"><div id="blank" style="height:5px;"> </div></td></tr>
<tr><td width="200" style="text-align:right; padding-right:10px;"><span class="heading_1">Password</span></td><td><input type="password" name="p" class="input" /></td></tr>
<tr><td colspan="2"><div id="blank" style="height:5px;"> </div></td></tr>
<tr><td colspan="2"><div style="float:right;"><table cellpadding="0" cellspacing="0" border="0"><tr><td width="100%" style="padding-right:10px;"><div style="float:right;"><span class="error_box" id="error_box"><?php if ($flag_error[0] == "login_error") echo $flag_error[1]; ?></span></div></td><td><div style="float:right;"><a href="javascript:evaluate_form();"><div id="button">Login</div></a></div></td></tr></table></div></td></tr>
</table>
</form>

<br /><br />
</div>

<div id="footer" style="height:280px;"><br /><br />

<center><span class="heading_2" style="text-align:center; width:100%;">Register As Guest</span></center><br />

<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" id="register_user_form">
<input type="hidden" name="form_type" value="register_user_form" />
<table cellpadding="0" cellspacing="0" border="0" align="center" width="350">
<tr><td colspan="2" style="background-color:#333; padding:7px; border:#FFF 1px solid;">
<center style="color:#FFF; text-align:left;">Registering as a guest allows you to reserve your username.<br />Guests cannot use the booter, but can look around.<br />Once registered and paid, an administrator can upgrade your account.</center></td></tr>
<tr><td colspan="2"><div id="blank" style="height:10px;"> </div></td></tr>
<tr><td width="200" style="text-align:right; padding-right:10px;"><span class="heading_1">Username</span></td><td><input type="text" name="u" class="input" /></td></tr>
<tr><td colspan="2"><div id="blank" style="height:5px;"> </div></td></tr>
<tr><td width="200" style="text-align:right; padding-right:10px;"><span class="heading_1">Password</span></td><td><input type="password" name="p" class="input" /></td></tr>
<tr><td colspan="2"><div id="blank" style="height:5px;"> </div></td></tr>
<tr><td colspan="2"><div style="float:right;"><table cellpadding="0" cellspacing="0" border="0"><tr><td width="100%" style="padding-right:10px;"><div style="float:right;"><span class="error_box" id="register_error"><?php if ($flag_error[0] == "register_error") echo $flag_error[1]; ?></span></div></td><td><div style="float:right;"><a href="javascript:evaluate_register_form();"><div id="button">Register</div></a></div></td></tr></table></div></td></tr>
</table>
</form>
</div>

<div id="footer"><?php echo footer(); ?></div>

</div>
</center>

<?php echo $footer; ?>

</body>
</html>