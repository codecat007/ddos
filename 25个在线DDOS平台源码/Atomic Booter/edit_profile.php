<?php

require_once "core.php";

if (!isMember) redirect('index.php');

require_once THEME."header.php";
require_once THEME."nav.php";

$hide_email = isset($_POST['hide_email']) ? $_POST['hide_email'] : "0";
$accept_pms = isset($_POST['accept_pms']) ? $_POST['accept_pms'] : "0";

$pass0 = isset($_POST['pass0']) ? $_POST['pass0'] : "";
$pass1 = isset($_POST['pass1']) ? $_POST['pass1'] : "";
$pass2 = isset($_POST['pass2']) ? $_POST['pass2'] : "";

opencontent("User Control Panel");

echo "<form>\n<table cellpadding='5' cellspacing='5' style='width: 300px;'>\n<tr>\n";
echo "<td style='width: 50%;'>Username</td>\n";
echo "<td>".$userinfo['username']."</td>\n";
echo "</tr>\n<tr>\n";
echo "<td>Next Payment Due:</td>\n";
echo "<td>";

if ($userinfo['expiretime'] == 0) echo "Never";
else echo showdate($userinfo['expiretime']);

echo "</td>\n";
echo "</tr>\n<tr>\n";
echo "<td>Next Boot Time:</td>\n";
echo "<td>";

if (time() - $userinfo['nextboot'] > 0) echo "Now";
else echo showdate($userinfo['nextboot']);

echo "</td>\n";
echo "</tr>\n</table>\n</form>\n";

closecontent();

opencontent("Edit Profile");

echo "<form action='' method='post'>\n";
echo "<table cellpadding='5' cellspacing='5' style='text-align: center; width: 100%;'>\n";

if (isset($_POST['submit'])) {

	$update = mysql_query("UPDATE users SET hide_email = ".$hide_email.", acceptpm = ".$accept_pms." WHERE user_id = ".$userinfo['user_id']." LIMIT 1") or die(mysql_error());
	echo "<div style='text-align: center; color: #00cc00;'>Your privacy settings have been updated.</div><br />\n";


}

if ($pass0 != "" && $pass1 != "" && $pass2 != "") {

	if (md5(trim($pass0)) == $userinfo['password']) {
	
		if ($pass1 == $pass2) {
		
			$update = mysql_query("UPDATE users SET password = '".md5(trim($pass1))."' WHERE user_id = ".$userinfo['user_id']." LIMIT 1") or die(mysql_error());
			echo "<div style='text-align: center; color: #00cc00;'>Your password has been updated.</div><br />\n";
			
		} else {
			echo "<div style='text-align: center; color: red;'>Your new passwords do not match.</div><br />\n";
		}
		
	} else {
		echo "<div style='text-align: center; color: red;'>Your current password is incorrect.</div><br />\n";
	}

}

$profile_q = mysql_query("SELECT * FROM users WHERE user_id = ".$userinfo['user_id']." LIMIT 1");
$profile = mysql_fetch_array($profile_q);

$hide_email_check = "";
if ($profile['hide_email'] == 1) $hide_email_check = " checked='checked'";

$accept_pms_check = "";
if ($profile['acceptpm'] == 1) $accept_pms_check = " checked='checked'";

echo "<tr>\n<td>Hide Email Address</td>\n<td><input type='checkbox' name='hide_email'".$hide_email_check." value='1' /></td>\n</tr>\n";
echo "<tr>\n<td>Accept Private Messages</td>\n<td><input type='checkbox' name='accept_pms'".$accept_pms_check." value='1' /></td>\n</tr>\n";
echo "<tr>\n<td colspan='2'><br /><i>Change Password:</i><br /><span style='font-size: 10px;'>Only fill in the fields below if you would like to change your password.</span></td>\n</tr>\n";
echo "<tr>\n<td>Current Password</td>\n<td><input type='password' name='pass0' /></td>\n</tr>\n";
echo "<tr>\n<td>New Password</td>\n<td><input type='password' name='pass1' /></td>\n</tr>\n";
echo "<tr>\n<td>Confirm Password</td>\n<td><input type='password' name='pass2' /></td>\n</tr>\n";
echo "<tr>\n<td></td>\n<td><input type='submit' name='submit' value='Update Profile' /></td>\n</tr>\n";

echo "</table>\n";
echo "</form>\n";

closecontent();

require_once THEME."footer.php";

?>