<?php

include("config.php");

$footer = "";

if(!isset($_SESSION['username'])) {
	header("Location: index.php");
}

switch ($_POST['form_type']) {
	case "notepad_form":
		$text = str_replace("\r\n","RSAEFJASFESFJAFJSEAFSJE",$_POST['notepad']);
		$text = mysql_real_escape_string($text);
		mysql_query("UPDATE `users` SET `notepad` = '$text' WHERE `id` = '" . $_SESSION['id'] . "';") or die(mysql_error());
		$_SESSION['notepad'] = $text;
		$footer = "<div style='text-align:center; font-weight:bold; font-family:Arial, Helvetica, sans-serif; font-size:18px; color:#FFF; width:100%; height:25px; padding-top:6px; background-color:#006600; position:absolute; bottom:0px;'>NotePad Saved!</div><br />";
	break;
	case "logout_form":
		logout();
	break;
}
		
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo BOOTER_NAME . " - NotePad"; ?></title>
<link rel="stylesheet" href="style.css" type="text/css" media="screen" /> 
</head>
<body>
<center>
<div id="top">

<img class="logo" src="logo.png" />

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

<center><span class="heading_2">Personal NotePad</span></center><br />

<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" id="notepad_form">
<input type="hidden" name="form_type" value="notepad_form" />
<table border="0" cellpadding="0" cellspacing="0" align="center"><tr><td>
<textarea type="input" style="height:300px; width:570px; resize:none; font-size:16px; background-color:#EEE;" name="notepad"><?php echo stripslashes(stripslashes(str_replace("RSAEFJASFESFJAFJSEAFSJE","\r\n",$_SESSION['notepad']))); ?></textarea>
</td></tr>
<tr><td><div id="blank" style="height:5px;"> </div></td></tr>
<tr><td><div style="float:right;"><a href="javascript:document.getElementById('notepad_form').submit();" style="text-decoration:none;"><div id="button">Save</div></a></div></td></tr>
</table>
</form>

<br />
</div>
</div>

<div id="footer"><?php echo footer(); ?></div>

</div>
</center>

<?php echo $footer; ?>

</body>
</html>