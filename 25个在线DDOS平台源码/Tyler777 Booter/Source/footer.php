<?php
$file = basename(__FILE__);
if(eregi($file,$_SERVER['REQUEST_URI'])) {
    die("Sorry but you cannot access this file directly for security reasons.");
}
?>
<div id="footer">
			<div id="footer-content">

			<center>

         <font color="#ffffff"><strong>Users Online:</strong></font> <font color="#CCCCCC"><?php
$onlineusers = mysql_query("select user_name from users where status = 1") or exit(mysql_error());
while($onlineuser = mysql_fetch_assoc($onlineusers)){
    echo $onlineuser['user_name'].", ";
}
?></font><br><br>
			Copyright &copy; 2010 - 2011, Vengeance Booter. Coded by Tyler777&trade;<br />
			<p style="text-align: center;">There are currently <span style="color: lime; font-weight: bold;"><?php echo $shellsOnline; ?></span> shells online. The time is now <font color="#000000"><strong><?php $date = date("h:i:s A", time()); echo $date; ?></strong></font>.</p>
			</center>
			</div>
		</div>
	</div>
