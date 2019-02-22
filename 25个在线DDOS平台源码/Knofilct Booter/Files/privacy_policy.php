<?php

include("config.php");

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo BOOTER_NAME . " - Privacy Policy"; ?></title>
<link rel="stylesheet" href="style.css" type="text/css" media="screen" /> 
</head>
<body>
<center>
<div id="top">

<img class="logo" src="logo.png" />

</div>

<div id="placeholder">

<div id="footer" style="height:<?php echo PRIVACY_HEIGHT; ?>px;"><br /><br />

<?php echo PRIVACY_POLICY; ?>

<br />
</div>

<div id="footer"><?php echo footer(); ?></div>

</div>
</center>

</body>
</html>