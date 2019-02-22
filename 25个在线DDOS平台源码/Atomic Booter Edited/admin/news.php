<?php

require_once "../core.php";

if (!isAdmin) redirect(BASE.'index.php');

require_once THEME."header.php";
require_once ADMIN_THEME."nav.php";

$title = isset($_POST['title']) ? htmlentities($_POST['title']) : "";
$description = isset($_POST['description']) ? htmlentities(nl2br($_POST['description'])) : "";
$submit = isset($_POST['submit']) ? $_POST['submit'] : "";

$delete = isset($_GET['delete']) ? mysql_real_escape_string($_GET['delete']) : "";
$edit = isset($_GET['edit']) ? mysql_real_escape_string($_GET['edit']) : "";

opencontent("Add News Item");

if ($edit != "") {

	$check = mysql_query("SELECT * FROM news WHERE id = '".$edit."' LIMIT 1");
	
	if (mysql_num_rows($check) == 1) {

		$item = mysql_fetch_array($check);
		
		if ($submit != "") {
		
			$update = mysql_query("UPDATE news SET username = '".$userinfo['username']."', title = '".$title."', description = '".$description."' WHERE id = ".$edit." LIMIT 1") or die(mysql_error());
			echo "<p style='text-align: center; color: #00cc00;'>Successfully edited the news item.</p>\n\n";
			
			closecontent();
			opencontent("Add Another News Item");
		
		} else {
		
	echo "<form method='post' action='news.php?edit=".$edit."'>\n";
	echo "<table cellpadding='5' cellspacing='5'>\n<tr>\n";
	echo "<td>News Title</td>\n";
	echo "<td><input type='text' class='entryfield' name='title' value='".$item['title']."' style='width: 350px;' /></td>\n";
	echo "</tr>\n<tr>\n";
	echo "<td>News Description<br />(HTML is allowed)</td>\n";
	echo "<td><textarea class='textbox' name='description' style='width: 350px; height: 120px;'>".preg_replace('/\&lt\;br \/\&gt\;/', '', $item['description'])."</textarea></td>\n";
	echo "</tr>\n";
	echo "<tr>\n<td></td><td align='center'>\n";
	echo "<input type='submit' name='submit' value='Update News Item' />\n";
	echo "</td>\n</tr>\n</table>\n</form>\n";
			
		}

	} else {
		echo "There is no news item with this ID.<br /><br />";
	}

} elseif ($delete != "") {

	$check = mysql_query("SELECT * FROM news WHERE id = '".$delete."' LIMIT 1");
	
	if (mysql_num_rows($check) == 1) {
		$remove = mysql_query("DELETE FROM news WHERE id = '".$delete."' LIMIT 1");
		if ($remove) {
			echo "Successfully deleted news item.<br /><br />\n";
		} else {
			echo mysql_error();
		}
	} else {
		echo "There is no news item with this ID.<br /><br />";
	}

} elseif ($title != "" && $description != "") {

		$insert = mysql_query("INSERT INTO news (username, title, description, timestamp) VALUES ('".$userinfo['username']."', '".$title."', '".$description."', ".time().")");
		if ($insert) {
			echo "Successfully added news item.<br /><br />\n";
		} else {
			echo mysql_error();
		}
		
} elseif ($title != "" || $description != "") {

	echo "Please fill in both the title and news description fields.<br /><br />\n";

}

if ($edit == "" || $submit != "") {

	echo "<form method='post' action='news.php'>\n";
	echo "<table cellpadding='5' cellspacing='5'>\n<tr>\n";
	echo "<td>News Title</td>\n";
	echo "<td><input type='text' name='title' style='width: 350px;' /></td>\n";
	echo "</tr>\n<tr>\n";
	echo "<td>News Description<br />(HTML is allowed)</td>\n";
	echo "<td><textarea name='description' style='width: 350px; height: 120px;'></textarea></td>\n";
	echo "</tr>\n";
	echo "<tr>\n<td></td><td align='center'>\n";
	echo "<input type='submit' value='Add News Item' />\n";
	echo "</td>\n</tr>\n</table>\n</form>\n";
	
}

closecontent();

opencontent("Current News Items");

echo "<form>\n";
echo "<table cellpadding='5' cellspacing='5' style='text-align: center; margin-left: auto; margin-right: auto; text-align: center; border: 1px solid #fff; width: 65%;'>\n";
echo "<tr style='background: #222;'>\n";
echo "<td>News Items</td>\n";
echo "</tr>\n";

$news = mysql_query("SELECT * FROM news ORDER BY id DESC");

if (mysql_num_rows($news) > 0) {

	while ($item = mysql_fetch_array($news)) {

		echo "<tr>\n";
		echo "<td>".$item['title']." [<a href='news.php?edit=".$item['id']."'>Edit</a>] [<a href='news.php?delete=".$item['id']."'>Delete</a>]</td>\n";
		echo "</tr>\n";

	}
	
} else {

	echo "<tr>\n<td colspan='2'>No existing news items.</td>\n</tr>\n";

}

echo "</table>\n</form>\n";

closecontent();

require_once THEME."footer.php";

?>