<?php

require_once "core.php";

if (!isMember) redirect('index.php');

require_once THEME."header.php";
require_once THEME."nav.php";

$id = isset($_GET['id']) ? $_GET['id'] : "";

if (!is_numeric($id)) jsredirect('index.php');

$profile_q = mysql_query("SELECT * FROM users WHERE user_id = ".$id." LIMIT 1");
$profile = mysql_fetch_array($profile_q);

if (mysql_num_rows($profile_q) != 1) jsredirect('index.php');

opencontent("User Profile");

echo "<form>\n";

echo "<table cellpadding='5' cellspacing='5'>\n";
echo "<tr>\n";
echo "<td>Username:</td>\n<td>".$profile['username']."</td>\n";
echo "</tr>\n<tr>\n";
echo "<td>Email Address:</td>\n";

if ($profile['hide_email'] == 0)
	echo "<td><a href='mailto:".$profile['email']."' title='Send Email'>".$profile['email']."</a></td>\n";
else
	echo "<td><i>Email Hidden</i></td>\n";

echo "</tr>\n<tr>\n";
echo "<td>Date Joined:</td>\n<td>".showdate($profile['joined'])."</td>\n";
echo "</tr>\n<tr>\n";
echo "<td>Last Visit:</td>\n<td>".showdate($profile['lastvisit'])."</td>\n";
echo "</tr>\n<tr>\n";

if ($userinfo['user_id'] != $profile['user_id']) {

	if ($profile['acceptpm'] == 1)
		echo "<td></td><td><a href='messages.php?action=compose&to=".$profile['user_id']."' title='Send Message'>Send Private Message</a></td>\n";
	else
		echo "<td></td>\n<td><br />This user doesn't accept PM's.</td>\n";

}

echo "</tr>\n";
	
if (isAdmin) {

	echo "<tr>\n<td colspan='2'><br /></td>\n</tr>\n";
	
	echo "<tr>\n";
	echo "<td>IP Address:</td>\n<td>".$profile['ip_address']."</td>\n";
	echo "</tr>\n<tr>\n";
	echo "<td></td>\n<td><a href='admin/logs.php?user=".$profile['username']."' title='Attack Logs'>View Attack Logs</a></td>\n";
	echo "</tr>\n";


}

echo "</table>\n";
echo "</form>\n";

closecontent();

if (isAdmin) {

	$pass1 = isset($_POST['pass1']) ? $_POST['pass1'] : "";
	$pass2 = isset($_POST['pass2']) ? $_POST['pass2'] : "";

	opencontent("Aministrative Options");

	echo "<form action='' method='post'>\n";
	echo "<table cellpadding='5' cellspacing='5' style='text-align: center; width: 100%;'>\n<tr>\n";
	echo "<td colspan='2'>\n";

	if (isset($_POST['banstate'])) {
		if ($_POST['change'] == "Ban") {
			$query = mysql_query("UPDATE users SET banned = 1 WHERE user_id = ".$id." LIMIT 1") or die(mysql_error());
			echo "<span style='color: #00cc00;'>User was successfully banned.</span>\n<br /><br />\n";
		} elseif ($_POST['change'] == "Unban") {
			$query = mysql_query("UPDATE users SET banned = 0 WHERE user_id = ".$id." LIMIT 1") or die(mysql_error());
			echo "<span style='color: #00cc00;'>User was successfully unbanned.</span>\n<br /><br />\n";
		} else {
			jsredirect('index.php');
		}
	} elseif (isset($_POST['change'])) {
		echo "<span style='color: red;'>To ban a user, you must select the checkbox to the right first.</span>\n<br /><br />\n";
	} else {
		echo "Use the form below to ban/unban this user.<br /><br />\n";
	}
	
	echo "</td>\n</tr>\n<tr>\n";

	$profile_q = mysql_query("SELECT * FROM users WHERE user_id = ".$id." LIMIT 1");
	$profile = mysql_fetch_array($profile_q);

	echo "<td><input type='checkbox' name='banstate' value='continue' /> Check Before (Un)Banning</td>\n";

	if ($profile['banned'] == "0")
		echo "<td width='50%' style='text-align: right;'><input type='submit' name='change' value='Ban' /></td>\n";
	else
		echo "<td width='50%' style='text-align: right;'><input type='submit' name='change' value='Unban' /></td>\n";

	echo "</tr>\n</table>\n";
	echo "</form>\n";

	if ($profile['expiretime'] != "0") {

		echo "<form action='' method='post'>\n";
		echo "<table cellpadding='5' cellspacing='5' style='text-align: center; width: 100%;'>\n<tr>\n";
		echo "<td colspan='2'>\n";

		if (isset($_POST['months'])) {
	
			$errors = "";
	
			if (!is_numeric($_POST['months']))
				$errors .= "Please specify a valid number of months.<br />\n";
	
			if ($errors == "") {
	
				$timetoadd = $_POST['months'];
		
				if ($timetoadd == "0") {

					$update = mysql_query("UPDATE users SET expiretime = 0 WHERE user_id = ".$id." LIMIT 1") or die(mysql_error());
					echo "Successfully upgraded to a lifetime account.<br /><br />\n";

				} else {

					$timetoadd *= 2592000;
					$update = mysql_query("UPDATE users SET expiretime = expiretime + ".$timetoadd,", banned = 0 WHERE user_id = ".$id." LIMIT 1") or die(mysql_error());
					echo "Successfully added " . $_POST['months'] . " months to " . $lookupuser . "'s paid time.";

				}
			} else {
				echo "<span style='color: red;'>".$errors."<br /></span>\n";
			}
		
		} else {
			echo "Use the form below to add time to this account.<br /><br />\n";
		}
	
	
		echo "</td>\n</tr>\n<tr>\n";

		$profile_q = mysql_query("SELECT * FROM users WHERE user_id = ".$id." LIMIT 1");
		$profile = mysql_fetch_array($profile_q);

		echo "<td>\n";
		echo "<select name='months'>\n";
		echo "<option value='1'>1 Month</option>\n";
		echo "<option value='2'>2 Months</option>\n";
		echo "<option value='3'>3 Months</option>\n";
		echo "<option value='4'>4 Months</option>\n";
		echo "<option value='0'>Upgrade To Lifetime</option>\n";
		echo "</select>\n";
		echo "</td>\n";
		echo "</tr>\n<tr>\n";
		echo "<td><input type='submit' name='Submit' value='Add Time To Account' /></td>\n";
		echo "</tr>\n</table>\n";
		echo "</form>\n";

	}

echo "<form action='' method='post'>\n";

if ($pass1 != "" && $pass2 != "") {
	
		if ($pass1 == $pass2) {
		
			$update = mysql_query("UPDATE users SET password = '".md5(trim($pass1))."' WHERE user_id = ".$id." LIMIT 1") or die(mysql_error());
			echo "<div style='text-align: center; color: #00cc00;'>".$profile['username']."'s password has been updated.</div><br />\n";
			
		} else {
			echo "<div style='text-align: center; color: red;'>The new passwords do not match.</div><br />\n";
		}
	
} else {
	echo "<div style='text-align: center;'>Use the form below to change this user's password.</div><br />\n";
}

echo "<table cellpadding='5' cellspacing='5' style='text-align: center; width: 100%;'>\n";
echo "<tr>\n<td>New Password</td>\n<td><input type='password' name='pass1' /></td>\n</tr>\n";
echo "<tr>\n<td>Confirm Password</td>\n<td><input type='password' name='pass2' /></td>\n</tr>\n";
	echo "<tr>\n<td></td>\n<td><input type='submit' name='submit' value='Change Password' /></td>\n</tr>\n";

	echo "</table>\n";
	echo "</form>\n";
	
	closecontent();

}

require_once THEME."footer.php";

?>