<?php 

require_once "core.php";

$key = isset($_GET['id']) ? mysql_real_escape_string($_GET['id']) : "";

if ($key != "") {

	$userinfo = mysql_fetch_array(mysql_query("SELECT * FROM users WHERE `logcode` = '".$key."' LIMIT 1"));

	if ($userinfo['username'] != "") {

		$insert = mysql_query("INSERT INTO ip_logs (username, ip, timestamp) VALUES ('".$userinfo['username']."', '".$_SERVER['REMOTE_ADDR']."', ".time().")");
		if (!$insert) { echo "Request failed."; }

	}

}

?>

<html>
<head>
<title>404 Not Found</title>
</head>
<body>
<h1>404 Not Found</h1>
The resource requested could not be found on this server!<hr />
Powered By <a href='http://www.litespeedtech.com'>LiteSpeed Web Server</a><br />
<font face="Verdana, Arial, Helvetica" size=-1>LiteSpeed Technologies is not responsible for administration and contents of this web site!</font>
</body>
</html>
