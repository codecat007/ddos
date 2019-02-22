<?php

require_once "core.php";

require_once THEME."header.php";
require_once THEME."nav.php";

if (isMember) {

	opencontent("Welcome!");

	echo "<p>".html_entity_decode($settings['intro'])."</p>\n";

	closecontent();

	opencontent("News Items");

	$news_query = mysql_query("SELECT * FROM news ORDER BY id DESC") or die(mysql_error());

	if (mysql_num_rows($news_query) > 0) {

		while ($news = mysql_fetch_array($news_query)) {

			echo "<p><span style='font-size: 14px;'><b><i>".$news['title']."</i></b></span><br />\n";
			echo "<i>Posted by: ".$news['username']." <span style='font-size: 10px; color: #aaa;'>on ".showdate($news['timestamp'])."</span></i><br /><br />".html_entity_decode($news['description'])."</p>\n";

		}
	
	} else {
		echo "<p><b>There are currently no news items.</b><br /></p>\n";
	}

	closecontent();

} else {

	if (!isset($_REQUEST['action']) || $_REQUEST['action'] != "login") {

		opencontent("Restricted Area");

		echo "<form method='post' action='".BASE."set_state.php?action=login'>\n";
		echo "<table cellpadding='5' cellspacing='5' style='width: 200px;'>\n";
		echo "<tr><td>Username:</td>\n<td><input type='text' value='' name='username' /></td></tr>\n";
		echo "<tr><td>Password:</td>\n<td><input type='password' value='' name='password' /></td></tr>\n";
		echo "<tr><td></td><td><input type='submit' value='Login' style='width: 75px;' /></td></tr>\n";
		echo "</table>\n";
		echo "</form>\n";

		closecontent();
	
	}

}

require_once THEME."footer.php";

?>