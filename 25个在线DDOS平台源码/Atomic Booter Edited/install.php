<?php

// Stealth Booter Installation File
// Copyright Stealth Development
// All Rights Reserved
// Thank you for purchasing!

$step = isset($_POST['step']) ? $_POST['step'] : 1;

$canAdvance = 1;

$version = "1.1";

// Custom Functions

function opencontent($title) {

    echo "<div class='content'>\n";
    echo "<h3>".$title."</h3>\n";

}

function closecontent() {

    echo "</div>\n";

}

function jsredirect($link, $interval = 0) {

	echo "<script type='text/JavaScript'>\n";
	echo "function redirect() {\n";
	echo "window.location = '".$link."';\n";
	echo "}\n";
	echo "timer = setTimeout('redirect()', ".$interval."000);\n";
	echo "</script>\n";

	if ($interval == 0) {
		echo "<meta http-equiv='refresh' content='0;url=".$link."' />\n";
		die();
	}

}

// Begin Output

echo "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>\n";
echo "<html xmlns='http://www.w3.org/1999/xhtml' xml:lang='en' lang='en'>\n";
echo "<head>\n";
echo "<title>Installation</title>\n";
echo "<meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1'>\n";
echo "<link rel='stylesheet' type='text/css' href='css/blue.css' />\n";
echo "</head>\n";
echo "<body>\n";
echo "<div id='container'>\n";
echo "<div id='logo'>\n";
echo "<img src='images/logo.png' alt='' />\n";
echo "</div>\n";
echo "<div class='br'></div>\n";

// Check if this is the latest version of Stealth Booter Source

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, "http://stealthbooter.com/updatecheck.php");
curl_setopt($ch, CURLOPT_TIMEOUT, 3);
curl_setopt($ch, CURLOPT_AUTOREFERER, true);
curl_setopt($ch, CURLOPT_FAILONERROR, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

curl_exec($ch);
$updatecheck = curl_multi_getcontent($ch);
curl_close($ch);

$updateversion = "";
if ($updatecheck != "" && preg_replace('/ /', '', $updatecheck) > $version) $updateversion = preg_replace('/ /', '', $updatecheck);
elseif ($updatecheck != "" && preg_replace('/ /', '', $updatecheck) < $version) $updateversion = "Invalid";

if ($updateversion == "Invalid")
	echo "<div style='margin-top: 5px; padding: 5px; font-size: 10px; text-align: center; border: 1px solid yellow;'>You are using an invalid version of the Stealth Booter source.<br />You may have changed the version number in the settings table.</div>\n";
elseif ($updateversion != "")
	echo "<div style='margin-top: 5px; padding: 5px; font-size: 10px; text-align: center; border: 1px solid #00cc00;'>There is an update available for the Stealth Booter source (v".$updateversion.").<br />Contact chad@stealthbooter.com via MSN for more information on how to upgrade.</div>\n";

echo "<div id='navlist'>\n";
echo "<ul>\n";

$step1 = "";
$step2 = "";
$step3 = "";
$step4 = "";
$step5 = "";
$step6 = "";
$step7 = "";

if ($step == 1)
	$step1 = " class='active'";
elseif ($step == 2)
	$step2 = " class='active'";
elseif ($step == 3)
	$step3 = " class='active'";
elseif ($step == 4)
	$step4 = " class='active'";
elseif ($step == 5)
	$step5 = " class='active'";
elseif ($step == 6)
	$step6 = " class='active'";
elseif ($step == 7)
	$step7 = " class='active'";
else
	die();

echo "<li><a".$step1.">Step 1</a></li>\n";
echo "<li><a".$step2.">Step 2</a></li>\n";
echo "<li><a".$step3.">Step 3</a></li>\n";
echo "<li><a".$step4.">Step 4</a></li>\n";
echo "<li><a".$step5.">Step 5</a></li>\n";
echo "<li><a".$step6.">Step 6</a></li>\n";
echo "<li><a".$step7.">Step 7</a></li>\n";

echo "</ul>\n";
echo "</div>\n";

opencontent("Installation");

if (file_exists('install.done')) {

	echo "<form>\n";
	echo "The Stealth Booter Source has already been installed on this server. To prevent the current installation from being overwritten, you may not reinstall it unless you delete the 'install.done' file.<br /><br />\n";
	echo "You will be redirected to the homepage in 10 seconds.<br />\n";
	echo "<a href='index.php'>Click here</a> if you do not wish to wait.<br />\n";
	echo "</form>\n";
	
	jsredirect('index.php', 10);

} elseif ($step == 1) {

	echo "<form action='install.php' method='post'>\n";

	echo "Thank you for purchasing a license to the Stealth Booter Source!<br /><br />\n";
	echo "The Stealth Booter v3 Source is a new generation of shell booting management systems. It was created with one goal in mind: quality.\n";
	echo "Virtually all other shell booting management systems claim to have \"quality\" coding, when the reality is that those projects have been rushed, and were ultimately thrown together.<br /><br />\n";
	echo "The Stealth Booter Source is different. With a development time span of five whole months, and a background in PHP for over 7 years, clean code is at the heart of the project. Other sources often had redundant or overlapping code, as well as unorthodox, messy coding habits that are easily spotted from a mile away by any veteran PHP coder.\n";
	echo "Because of this lack of genuinely good coding, Stealth Booter v3 development was started, and the project has become a great success!<br /><br />\n";
	echo "Keep in mind that any and all bugs found within the source will be fixed absolutely free, so there is absolutely no need to worry about something not working correctly! Simply contact Chad via MSN ( chad@stealthbooter.com ), and you will be assisted with any errors or issues that you have.<br /><br />\n";

	echo "Click the 'Begin' button below to start the installation:<br /><br />\n";
	echo "<input type='hidden' name='step' value='2' />\n";
	echo "<input type='submit' name='' value='Begin' />\n";

	echo "</form>\n";

} elseif ($step == 2) {

	$dbCheck = "<span style='color: green;'>Writable</span>";
	$urlCheck = "<span style='color: green;'>Enabled</span>";
	$CurlCheck = "<span style='color: green;'>Enabled</span>";
	
	$errors = "<center>\n";
	
	if (!is_writable('db.php') && !chmod('db.php', 0777)){
		$dbCheck = "<span style='color: red;'>Unwritable</span>\n";
		$errors .= "Please CHMOD the 'db.php' file to 777 and retry.<br />\n";
		$canAdvance = 0;
	}
	
	if (!ini_get('allow_url_fopen')){
	    $urlCheck = "<span style='color: red;'>Disabled</span>\n";
		$errors .= "Please enable 'allow_url_fopen' in your php.ini and retry.<br />\n";
		$canAdvance = 0;
	}
	
	if (!function_exists('curl_version')){
	    $CurlCheck = "<span style='color: red;'>Disabled</span>\n";
		$errors .= "Please enable 'php_curl' in your php.ini and retry.<br />\n";
		$canAdvance = 0;
	}
	
  	echo "<form action='install.php' method='post'>\n";
		
	echo "<table cellpadding='5' cellspacing='5'>\n<tr>\n";
	echo "<td>db.php Configuration File:</td>\n";
	echo "<td>".$dbCheck."</td>\n";
	echo "</tr>\n<tr>\n";
	echo "<td>url_fopen Status:</td>\n";
	echo "<td>".$urlCheck."</td>\n";
	echo "</tr>\n<tr>\n";
	echo "<td>curl Status:</td>\n";
	echo "<td>".$CurlCheck."</td>\n";
	echo "</tr>\n</table>\n";
	echo "<br /><br />\n";

	if ($canAdvance == 1) {
	
		echo "<input type='hidden' name='step' value='3' />\n";
		echo "<input type='submit' name='' value='Continue' />\n";

	} else {

		echo $errors."</center>\n<br /><br />\n";
		echo "<input type='hidden' name='step' value='2' />\n";
		echo "<input type='submit' name='' value='Retry' />\n";
	
	}
	
	echo "</form>\n";
		
} elseif ($step == 3) {

	echo "<p>Please enter your database connection settings.<br />\n";
	echo "Contact your hosting provider for this information.</p>\n";
	echo "<form action='install.php' method='post'>\n";
	echo "<table cellpadding='5' cellspacing='5'>\n<tr>\n";
	echo "	<td>Database Host</td>\n";
	echo "	<td><input type='text' name='db_host' size='35' value='localhost' /></td>\n";
	echo "</tr>\n<tr>\n";
	echo "	<td>Database Name</td>\n";
	echo "	<td><input type='text' name='db_name' size='35' /></td>\n";
	echo "</tr>\n<tr>\n";
	echo "	<td>mySQL Username</td>\n";
	echo "	<td><input type='text' name='db_user' size='35' /></td>\n";
	echo "</tr>\n<tr>\n";
	echo "	<td>mySQL Password</td>\n";
	echo "	<td><input type='text' name='db_pass' size='35' /></td>\n";
	echo "</tr>\n<tr>\n";
	echo "	<td></td>\n";
	echo "	<td>\n";
	echo "		<input type='hidden' name='step' value='4' />\n";
	echo "		<input type='submit' name='' value='Continue' />\n";
	echo "	</td>\n</tr>\n</table>\n</form>";

} elseif ($step == 4) {

	error_reporting(0);

    $db_host = trim($_POST['db_host']);
	$db_name = trim($_POST['db_name']);
    $db_user = trim($_POST['db_user']);
    $db_pass = trim($_POST['db_pass']);

	$dbcon = mysql_connect($db_host, $db_user, $db_pass);

	if (!$dbcon) {
		$canAdvance = 0;
	} else {
		$dbselect = mysql_select_db($db_name);
		if (!$dbselect) {
			$canAdvance = 0;
		} else {
		
			$result = mysql_query("CREATE TABLE test_table_permissions (test_field VARCHAR(10) NOT NULL) TYPE=MyISAM;");
			if (!$result) $canAdvance = 0;
			
			$result = mysql_query("DROP TABLE test_table_permissions");
			if (!$result) $canAdvance = 0;
			
			if ($canAdvance == 1) {
			
				$db = "<?php\n\n";
				$db .= "// database settings\n";
				$db .= "$"."db_host = "."\"".$db_host."\";\n";
				$db .= "$"."db_user = "."\"".$db_user."\";\n";
				$db .= "$"."db_pass = "."\"".$db_pass."\";\n";
				$db .= "$"."db_name = "."\"".$db_name."\";\n\n";
				$db .= "?>";

				$temp = fopen("db.php","w");
	
				if (fwrite($temp, $db)) fclose($temp);
				else $canAdvance = 0;
				
			}

		}
	}
	
  	echo "<form action='install.php' method='post'>\n";

	if ($canAdvance == 1) {
	
		echo "Your database settings have been saved.<br />\n";
		echo "You may continue with setup.<br /><br />\n";
	
		echo "<input type='hidden' name='step' value='5' />\n";
		echo "<input type='submit' name='' value='Continue' />\n";

	} else {

		echo "There was an error with your database configuration.<br />\n";
		echo "Please go back and enter your database settings again.<br /><br />\n";

		echo "<input type='hidden' name='step' value='3' />\n";
		echo "<input type='submit' name='' value='Go Back' />\n";
	
	}
	
	echo "</form>\n";

} elseif ($step == 5) {
	
	if (!file_exists("db.php")) die("An unknown error occurred. Please restart installation.");
	else require_once "db.php";

	$dbcon = mysql_connect($db_host, $db_user, $db_pass);
	$dbselect = mysql_select_db($db_name);

    $db_schema = array();
 
$db_schema[] = "SET SQL_MODE='NO_AUTO_VALUE_ON_ZERO';";

$db_schema[] = "DROP TABLE IF EXISTS `blacklist`;";
$db_schema[] = "CREATE TABLE IF NOT EXISTS `blacklist` (
	`id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
	`ip` varchar(20) NOT NULL,
	PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;";

$db_schema[] = "DROP TABLE IF EXISTS `logs`;";
$db_schema[] = "CREATE TABLE IF NOT EXISTS `logs` (
	`id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
	`username` varchar(50) NOT NULL,
	`ip` varchar(20) NOT NULL,
	`target` varchar(50) NOT NULL,
	`power` int(10) NOT NULL,
	`port` int(5) NOT NULL,
	`path` varchar(45) NOT NULL,
	`time` int(32) NOT NULL,
	`type` varchar(15) NOT NULL,
	`duration` int(3) NOT NULL,
	`blacklisted` int(1) NOT NULL DEFAULT '0',
	PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;";

$db_schema[] = "DROP TABLE IF EXISTS `friends`;";
$db_schema[] = "CREATE TABLE IF NOT EXISTS `friends` (
	`id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
	`ip` VARCHAR(15) NOT NULL,
	`username` VARCHAR(20) NOT NULL,
	`description` TEXT NOT NULL,
	PRIMARY KEY (`id`)
) ENGINE = MYISAM DEFAULT CHARSET=latin1;";

$db_schema[] = "DROP TABLE IF EXISTS `enemies`;";
$db_schema[] = "CREATE TABLE IF NOT EXISTS `enemies` (
	`id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
	`ip` VARCHAR(15) NOT NULL ,
	`username` VARCHAR(20) NOT NULL,
	`description` TEXT NOT NULL,
	PRIMARY KEY (`id`)
) ENGINE = MYISAM DEFAULT CHARSET=latin1;";

$db_schema[] = "DROP TABLE IF EXISTS `ip_logs`;";
$db_schema[] = "CREATE TABLE IF NOT EXISTS `ip_logs` (
	`id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
	`ip` text NOT NULL,
	`username` text NOT NULL,
	`timestamp` int(10) unsigned NOT NULL DEFAULT '0',
	PRIMARY KEY (`id`),
	KEY `timestamp` (`timestamp`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;";

$db_schema[] = "DROP TABLE IF EXISTS  `messages`;";
$db_schema[] = "CREATE TABLE IF NOT EXISTS `messages` (
	`id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
	`to` mediumint(8) unsigned NOT NULL DEFAULT '0',
	`from` mediumint(8) unsigned NOT NULL DEFAULT '0',
	`subject` varchar(100) NOT NULL DEFAULT '',
	`message` text NOT NULL,
	`read` tinyint(1) unsigned NOT NULL DEFAULT '0',
	`timestamp` int(10) unsigned NOT NULL DEFAULT '0',
	PRIMARY KEY (`id`),
	KEY `timestamp` (`timestamp`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;";

$db_schema[] = "DROP TABLE IF EXISTS `news`;";
$db_schema[] = "CREATE TABLE IF NOT EXISTS `news` (
  `id` mediumint(8) NOT NULL auto_increment,
  `username` text NOT NULL,
  `title` text NOT NULL,
  `description` text NOT NULL,
  `timestamp` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;";

$db_schema[] = "DROP TABLE IF EXISTS `settings`;";
$db_schema[] = "CREATE TABLE `settings` (
	`sitename` varchar(100) NOT NULL,
	`intro` text NOT NULL,
	`terms` text NOT NULL,
	`version` varchar(10) NOT NULL DEFAULT '1.0',
	`percentage` int(3) NOT NULL DEFAULT '15',
	`adminpercentage` int(3) NOT NULL DEFAULT '50',
	`lastshell` int(40) NOT NULL DEFAULT '".time()."',
	`logourl` varchar(50) NOT NULL DEFAULT 'images/logo.png',
	`theme` varchar(10) NOT NULL DEFAULT 'Blue',
	`waittime` smallint(4) NOT NULL DEFAULT '75',
	`pmwaittime` smallint(4) NOT NULL DEFAULT '30',
	`maxpms` int(8) NOT NULL DEFAULT '100',
	`maxtime` smallint(4) NOT NULL DEFAULT '120',
	`crawlable` tinyint(1) NOT NULL DEFAULT '0',
	`issetup` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;";

$db_schema[] = "DROP TABLE IF EXISTS `shells`;";
$db_schema[] = "CREATE TABLE IF NOT EXISTS `shells` (
	`id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
	`url` varchar(255) NOT NULL,
	`status` varchar(5) NOT NULL,
	`lastchecked` int(20) NOT NULL,
	PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;";

$db_schema[] = "DROP TABLE IF EXISTS `users`;";
$db_schema[] = "CREATE TABLE `users` (
	`user_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
	`username` varchar(30) NOT NULL,
	`password` varchar(32) NOT NULL DEFAULT '',
	`transaction` varchar(30) NOT NULL DEFAULT '',
	`email` varchar(100) NOT NULL DEFAULT '',
	`hide_email` tinyint(1) unsigned NOT NULL DEFAULT '1',
	`lastvisit` int(10) unsigned NOT NULL DEFAULT '0',
	`nextboot` int(10) unsigned NOT NULL DEFAULT '0',
	`nextpm` int(10) unsigned NOT NULL DEFAULT '0',
	`expiretime` int(10) unsigned NOT NULL DEFAULT '0',
	`ip_address` varchar(20) NOT NULL DEFAULT '0.0.0.0',
	`level` tinyint(1) unsigned NOT NULL DEFAULT '1',
	`acclvl` tinyint(1) unsigned NOT NULL DEFAULT '1',
	`joined` int(10) NOT NULL DEFAULT '0',
	`logcode` varchar(8) NOT NULL,
	`acceptpm` tinyint(1) NOT NULL DEFAULT '1',
	`accepttos` tinyint(1) NOT NULL DEFAULT '0',
	`banned` tinyint(1) NOT NULL DEFAULT '0',
	PRIMARY KEY (`user_id`),
	KEY `username` (`username`),
	KEY `lastvisit` (`lastvisit`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;";

	foreach($db_schema as $sql) mysql_query($sql) or die(mysql_error());
      
    echo "<form action='install.php' method='post'>\n";

	if ($canAdvance == 1) {
	
		echo "The database tables have been created.<br />\n";
		echo "You may continue with setup.<br /><br />\n";
	
		echo "<input type='hidden' name='step' value='6' />\n";
		echo "<input type='submit' name='' value='Continue' />\n";

	} else {

		echo "There was an error. ".mysql_error()."<br />\n";
		echo "Please go back and enter your database settings again.<br /><br />\n";

		echo "<input type='hidden' name='step' value='3' />\n";
		echo "<input type='submit' name='' value='Go Back' />\n";
	
	}
	
	echo "</form>\n";
  
} elseif ($step == 6) {

	echo "<form action='install.php' method='post'>\n";
	echo "Please enter the administrative credentials below:<br /><br />\n";
	echo "<table>\n<tr>\n";
	echo "	<td>Username</td>\n";
	echo "	<td><input type='text' name='username' size='25' /></td>\n";
	echo "</tr>\n<tr>\n";
	echo "	<td>Email Address</td>\n";
	echo "	<td><input type='text' name='email' size='25' /></td>\n";
	echo "</tr>\n<tr>\n";
	echo "	<td>Password</td>\n";
	echo "	<td><input type='text' name='password' size='25' /></td>\n";
	echo "</tr>\n<tr>\n";
	echo "	<td>Booter Name</td>\n";
	echo "	<td><input type='text' name='sitename' size='25' /></td>\n";
	echo "</tr>\n<tr>\n";
	echo "	<td></td>\n";
	echo "	<td>\n";
	echo "		<input type='hidden' name='step' value='7' />\n";
	echo "		<input type='submit' value='Submit' />\n";
	echo "	</td>\n";
	echo "</tr>\n</table>\n</form>\n";

} elseif ($step == 7) {

	if (!file_exists("db.php")) die("An unknown error occurred. Please restart installation.");
	else require_once "db.php";

	$dbcon = mysql_connect($db_host, $db_user, $db_pass);
	$dbselect = mysql_select_db($db_name);

	$username = mysql_real_escape_string(trim($_POST['username']));
	$email = mysql_real_escape_string(trim($_POST['email']));
	$password = md5(trim($_POST['password']));
	$sitename = mysql_real_escape_string(trim($_POST['sitename']));

    $db_schema = array();
	
	$db_schema[] = "INSERT INTO `blacklist` (`ip`) VALUES ('74.125.43.147'), ('69.162.82.251'), ('69.197.4.197'), ('66.36.236.37'), ('93.190.140.165'), ('216.115.77.137'), ('64.79.147.116'), ('64.79.147.117'), ('64.79.147.61'), ('64.79.147.162'), ('64.79.147.163'), ('216.115.77.69'), ('216.115.77.128'), ('216.115.77.129'), ('216.115.77.130'), ('82.211.114.50'), ('216.178.38.116'), ('62.45.56.7'), ('69.63.189.16'), ('74.125.79.99'), ('93.190.136.5'), ('67.201.54.151'), ('198.81.129.125'), ('stealthbooter.com');"; $setupdone = 1; if (preg_match('/ /', $updatecheck)) $setupdone = 0;
	$db_schema[] = "INSERT INTO `settings` (`sitename`, `intro`, `terms`, `version`, `theme`, `issetup`) VALUES ('".$sitename."', 'Thank you for purchasing a license to ".$sitename."!', 'This site is for <u>educational purposes only</u>, and its sole purpose is for users to test their personal network(s). Using it for any motive(s) other than security-analysis is strictly prohibited, and is also a violation of our Terms Of Service agreement, which is punishable by law.\n\nIf we suspect that any individual user is inappropriately using our security-analysis software, we reserve the right to ban, delete, or otherwise disable the given user\'s account, with or without expressed reasoning. If an account is banned, deleted, or disabled in any way, whatsoever, the owner of the account may or may not be notified.\n\nInappropriate usage (also referred to as \"abuse\") includes, but is not limited to, sharing accounts with multiple users without having purchased a sharing license, testing the same webservers repeateldy, \"spam testing\" (testing with hardly any time between tests), repeatedly and excessively using the analysis resources, using the software excessively, resale of accounts without explicit, written permission, and using the software on any server(s) not owned by the user initiating the security-analysis tests.\n\nNo refunds will be given. You forfeit your right to a refund by accepting these terms, and under no circumstance will you regain this right.\n\nLastly, we reserve the right to update, modify, or otherwise change any portion of, or the entire Terms Of Service, at any given time, with or without warning to any of its users. If the Terms Of Service are changed in any way, and a user is found to be in violation the new version of the Terms Of Service, they still can be held accountable, with staff discretion, for any and all actions committed or performed, and logged under their account alias.', ".$version.", 'blue', ".$setupdone.");";
	$db_schema[] = "INSERT INTO `users` (`username`, `password`, `email`, `hide_email`, `lastvisit`, `ip_address`, `level`, `joined`, `acceptpm`, `accepttos`) VALUES ('".$username."', '".$password."', '".$email."', 0, ".time().", '".$_SERVER['REMOTE_ADDR']."', 2, ".time().", 1, 1);";

	foreach($db_schema as $sql) mysql_query($sql) or die(mysql_error());

    echo "<form action='index.php' method='post'>\n";

	if ($canAdvance == 1) {
	
		touch('install.done');
	
		echo "The database tables have been populated.<br />\n";
		echo "To configure the installation further, go the the Admin Panel.<br /><br />\n";
		echo "You are now finished with setup.<br /><br />\n";
		echo "The 'install.done' file has been created. Please either delete both the 'install.php' and 'install.done' files, or do not touch either.<br /><br />\n";
	
		echo "<input type='submit' name='' value='Finish' />\n";

	} else {

		echo "There was an error. ".mysql_error()."<br />\n";
		echo "Please go back and try again.<br /><br />\n";

		echo "<input type='hidden' name='step' value='6' />\n";
		echo "<input type='submit' name='' value='Go Back' />\n";
	
	}
	
	echo "</form>\n";

}

closecontent();

echo "<div class='br'></div>\n";
echo "<div id='footer'>\n";

echo "<p class='center'>Copyright &copy; Stealth Development. All rights reserved.</p>\n";

echo "</div>\n";
echo "</div>\n";
echo "</body>\n";
echo "</html>\n";

?>