<?php

require_once "../core.php";

if (!isAdmin) redirect(BASE.'index.php');

require_once THEME."header.php";
require_once ADMIN_THEME."nav.php";

$sitename = isset($_POST['sitename']) ? htmlentities($_POST['sitename']) : "";
$intro = isset($_POST['intro']) ? htmlentities(nl2br($_POST['intro'])) : "";
$terms = isset($_POST['terms']) ? htmlentities(nl2br($_POST['terms'])) : "";
$percentage = isset($_POST['percentage']) ? htmlentities($_POST['percentage']) : "15";
$adminpercentage = isset($_POST['adminpercentage']) ? htmlentities($_POST['adminpercentage']) : "50";
$logourl = isset($_POST['logourl']) ? htmlentities($_POST['logourl']) : "";
$theme = isset($_POST['theme']) ? htmlentities(strtolower($_POST['theme'])) : "";
$waittime = isset($_POST['waittime']) ? htmlentities($_POST['waittime']) : "100";
$pmwaittime = isset($_POST['pmwaittime']) ? htmlentities($_POST['pmwaittime']) : "30";
$maxpms = isset($_POST['maxpms']) ? htmlentities($_POST['maxpms']) : "100";
$maxtime = isset($_POST['maxtime']) ? htmlentities($_POST['maxtime']) : "120";
$crawlable = isset($_POST['crawlable']) ? htmlentities($_POST['crawlable']) : "0";

opencontent("Site Settings");

echo "<form action='' method='post'>\n";
echo "<center>\n";

if (isset($_POST['submit'])) {

	$errors = "";
	
	if ($sitename == "")
		$errors .= "You must enter a site name.<br />\n";

	if ($theme == "")
		$errors .= "You must select a default theme.<br />\n";

	if ($errors == "") {
	
		if ($logourl == "") $logourl = "images/logo.png";
	
		$update = mysql_query("UPDATE settings SET sitename = '".$sitename."', intro = '".$intro."', terms = '".$terms."', logourl = '".$logourl."', percentage = ".$percentage.", adminpercentage = ".$adminpercentage.", theme = '".$theme."', waittime = ".$waittime.", pmwaittime = ".$pmwaittime.", maxpms = ".$maxpms.", maxtime = ".$maxtime.", crawlable = ".$crawlable." LIMIT 1") or die(mysql_error());
		echo "<span style='color: #00cc00;'>Site settings have been updated.</span>\n<br /><br />\n";
	
		if ($theme != $settings['theme']) {
			
			echo "Your theme has been changed. The page will reload in 3 seconds...<br /><br />\n";
			jsredirect('settings.php', 3);
			
		} elseif ($logourl != $settings['logourl']) {
			
			echo "Your logo has been changed. The page will reload in 3 seconds...<br /><br />\n";
			jsredirect('settings.php', 3);
			
		}
	
	} else {
		echo "<span style='color: red;'>".$errors."<br />\n</span>\n";	
	}
	
} else {
	echo "Use the form below to edit the site settings.<br /><br />\n";
}

$settings = mysql_fetch_array(mysql_query("SELECT * FROM settings LIMIT 1"));

echo "</center>\n";
echo "<table cellpadding='5' cellspacing='5'>\n<tr>\n";
echo "<td>Site Name</td>\n";
echo "<td><input type='text' name='sitename' value='".$settings['sitename']."' /></td>\n";
echo "</tr>\n<tr>\n";
echo "<td>Intro<br />(HTML allowed)</td>\n";
echo "<td><textarea name='intro' style='width: 90%; height: 65px;'>".preg_replace('/\&lt\;br \/\&gt\;/', '', $settings['intro'])."</textarea></td>\n";
echo "</tr>\n<tr>\n";
echo "<td>Terms Of Service<br />(HTML allowed)</td>\n";
echo "<td><textarea name='terms' style='width: 90%; height: 65px;'>".preg_replace('/\&lt\;br \/\&gt\;/', '', $settings['terms'])."</textarea></td>\n";
echo "</tr>\n<tr>\n";
echo "<td>Logo Image Location</td>\n";
echo "<td><input type='text' name='logourl' value='".$settings['logourl']."' /></td>\n";
echo "</tr>\n<tr>\n";
echo "<td>Percent Of Shells To Allocate</td>\n";
echo "<td><input type='text' name='percentage' value='".$settings['percentage']."' /></td>\n";
echo "</tr>\n<tr>\n";
echo "<td>Admin Percent Of Shells To Allocate</td>\n";
echo "<td><input type='text' name='adminpercentage' value='".$settings['adminpercentage']."' /></td>\n";
echo "</tr>\n<tr>\n";
echo "<td>Time Between Boots (seconds)</td>\n";
echo "<td><input type='text' name='waittime' value='".$settings['waittime']."' /></td>\n";
echo "</tr>\n<tr>\n";
echo "<td>Time Between Private Messages (seconds)</td>\n";
echo "<td><input type='text' name='pmwaittime' value='".$settings['pmwaittime']."' /></td>\n";
echo "</tr>\n<tr>\n";
echo "<td>Max Private Messages</td>\n";
echo "<td><input type='text' name='maxpms' value='".$settings['maxpms']."' /></td>\n";
echo "</tr>\n<tr>\n";
echo "<td>Max Boot Time (seconds)</td>\n";
echo "<td><input type='text' name='maxtime' value='".$settings['maxtime']."' /></td>\n";
echo "</tr>\n<tr>\n";
echo "<td>Site Theme</td>\n";
echo "<td>\n<select name='theme'>\n";
echo "<option value='Blue'>Blue</option>\n";

if ($handle = opendir(BASE.'css')) {

	while (false !== ($file = readdir($handle))) {

		if ($file != "." && $file != ".." && $file != "index.php" && $file != "blue.css") {

			$file = preg_replace('/\.css/', '', $file);
			$selected = "";
			
			if ($file == $settings['theme']) $selected = " selected='selected'";
        	echo "<option value='".$file."'".$selected.">".ucfirst($file)."</option>\n";

		}
		
	}

    closedir($handle);

}

echo "</td>\n";
echo "</tr>\n<tr>\n";
echo "<td>Indexable By Google</td>\n";
echo "<td>\n<select name='crawlable'>\n";

if ($settings['crawlable'] == "0") {

	echo "<option value='0' selected='selected'>Not Indexed</option>\n";
	echo "<option value='1'>Indexed</option>\n";

} else {

	echo "<option value='0'>Not Indexed</option>\n";
	echo "<option value='1' selected='selected'>Indexed</option>\n";

}

echo "<select>\n</td>\n";
echo "</tr>\n<tr>\n";
echo "<td></td>\n";
echo "<td><input type='submit' name='submit' value='Update Settings' /></td>\n</tr>\n";
echo "</table>\n";
echo "</form>\n";

closecontent();

require_once THEME."footer.php";

?>