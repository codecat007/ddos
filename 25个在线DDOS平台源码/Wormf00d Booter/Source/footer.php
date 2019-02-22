<?php
$file = basename(__FILE__);
if(eregi($file,$_SERVER['REQUEST_URI'])) {
    die("Sorry but you cannot access this file directly for security reasons.");
}
?>

<div id="footer">
			<div id="footer-content">
			<center>
			wormf00d - Copyright &copy; 2010 - 2011, Project Genocide. Coded by Prodigy&trade; and xhtmlphp&trade; <br />
			<p style="text-align: center;">There are currently <span style="color: lime; font-weight: bold;"><?php echo $shellsOnline; ?></span> shells online. The time is now <font color="#666666"><strong><?php $date = date("h:i:s A", time()); echo $date; ?></strong></font>.</p>
			</center>
			</div>
		</div>
	</div>
