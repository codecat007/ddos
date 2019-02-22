<?php

if (preg_match("/nav.php/i", $_SERVER['PHP_SELF'])) die();

echo "<div id='navlist'>\n";
echo "<ul>\n";

echo hyperize("Home", "../index.php");
echo hyperize("Admin Home", "index.php");
echo hyperize("Settings", "settings.php");
echo hyperize("Add Shells", "add.php");
echo hyperize("Manage Shells", "shells.php");
echo hyperize("News", "news.php");
echo hyperize("Users", "users.php");
echo hyperize("Attack Logs", "logs.php");
echo hyperize("Blacklist", "blacklist.php");

echo "<li><br /></li>\n";

echo hyperize("View Profile", "profile.php?id=".$userinfo['user_id']);
echo hyperize("Edit Profile", "edit_profile.php");
echo hyperize("Messages", "messages.php");
echo hyperize("Statistics", "statistics.php");
echo "<li><a href='set_state.php?action=logout' title='Logout'>Logout</a></li>\n";

echo "</ul>\n";
echo "</div>\n";

?>