<?php

if (preg_match("/header.php/i", $_SERVER['PHP_SELF'])) die();

if (!isMember) $title = "Restricted Area";

echo "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>\n";
echo "<html xmlns='http://www.w3.org/1999/xhtml' xml:lang='en' lang='en'>\n";
echo "<head>\n";
echo "<title>".$title."</title>\n";
echo "<meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1'>\n";

if ($settings['crawlable'] == "0")
	echo "<meta name='robots' content='noindex,nofollow'>\n";

echo "<link rel='stylesheet' type='text/css' href='".BASE."css/".$settings['theme'].".css' />\n";
echo "</head>\n";
echo "<body>\n";
echo "<div id='container'>\n";
echo "<div id='logo'>\n";

if (isMember)
	echo "<a href='".BASE."index.php' title='Home'><img src='".BASE.$settings['logourl']."' alt='".$settings['sitename']."' /></a>\n";

//echo "<h1><span class='blue'>ProWeb</span>SB</h1>\n";
echo "</div>\n";

if (isMember) {

	echo "<div id='login'>\n";
	
	if ($_REQUEST['action'] != "logout")
		echo "Welcome, <a href='".BASE."profile.php?id=".$userinfo['user_id']."' title='View My Profile'>".$userinfo['username']."</a>!<br />\n";

	echo "</div>\n";

}
	
echo "<div class='br'></div>\n";

if (isAdmin) {

	if ($updateversion == "Invalid")
		echo "<div style='margin-top: 5px; padding: 5px; font-size: 10px; text-align: center; border: 1px solid yellow;'>You are using an invalid version of the Stealth Booter source.<br />You may have changed the version number in the settings table.</div>\n";
	elseif ($updateversion != "")
		echo "<div style='margin-top: 5px; padding: 5px; font-size: 10px; text-align: center; border: 1px solid #00cc00;'>There is an update available for the Stealth Booter source (v".$updateversion.").<br />Contact chad@stealthbooter.com via MSN for more information on how to upgrade.</div>\n";


}

if (isMember) {

	$unread_query = mysql_query("SELECT * FROM messages WHERE `to` = ".$userinfo['user_id']." AND `read` = 0") or die(mysql_error());
	$unread_count = mysql_num_rows($unread_query);
	
	if ($unread_count > 0) {

		$unread = mysql_fetch_array(mysql_query("SELECT * FROM messages WHERE `to` = ".$userinfo['user_id']." AND `read` = 0 ORDER BY id DESC LIMIT 1"));
		echo "<div style='margin-top: 5px; padding: 5px; font-size: 10px; text-align: center; border: 1px solid #00cc00;'>You have ".$unread_count." new message".($unread_count == 1 ? "" : "s").". <a href='".BASE."messages.php?action=read&id=".$unread['id']."' title='Read Message' style='color: #00cc00;'>".$unread['subject']."</a> from <a href='".BASE."profile.php?id=".$unread['from']."' title='View Profile' style='color: #00cc00;'>".getuserbyid($unread['from'])."</a></div>\n";
	
	}

}

?>