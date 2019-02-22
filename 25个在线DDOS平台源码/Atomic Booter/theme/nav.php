<?php

if (preg_match("/nav.php/i", $_SERVER['PHP_SELF'])) die();

echo "<div id='navlist'>\n";
echo "<ul>\n";
echo hyperize("Home", "index.php");

if (isMember && $_REQUEST['action'] != "logout") {

	echo hyperize("Boot", "hub.php");
	echo hyperize("Host -> IP", "converter.php");
	echo hyperize("IP Logger", "ip_logger.php");
	echo hyperize("Port Scanner", "port_scanner.php");
	echo hyperize("Friends", "friends.php");
	echo hyperize("Enemies", "enemies.php");
	echo hyperize("My Attacks", "attacks.php");
	echo hyperize("Proxy", "proxy/");
	
	echo "<li><br /></li>\n";
	
	echo hyperize("View Profile", "profile.php?id=".$userinfo['user_id']);
	echo hyperize("Edit Profile", "edit_profile.php");
	echo hyperize("Messages", "messages.php");

	if (isAdmin)
		echo hyperize("Admin Panel", "admin/index.php");

	echo hyperize("Statistics", "statistics.php");
	echo "<li><a href='set_state.php?action=logout' title='Logout'>Logout</a></li>\n";

}

echo "</ul>\n";
echo "</div>\n";

?>