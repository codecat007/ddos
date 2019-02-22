<?php
if (!defined('DIRECT'))
{
	die('Direct access not allowed.');
}
?>
<div class="topNav">
	<div class="wrapper">
		<div class="welcome"><a href="#" title=""><img src="images/userPic.png" alt="" /></a><span><?php echo 'Welcome '.$_SESSION['username']; ?></span></div>
		<div class="userNav">
			<ul>
				<li><a href="usercp.php" title=""><img src="images/icons/topnav/settings.png" alt="" /><span>Settings</span></a></li>
				<li><a href="unset.php" title=""><img src="images/icons/topnav/logout.png" alt="" /><span>Logout</span></a></li>
			</ul>
		</div>
		<div class="clear"></div>
	</div>
</div>

<div class="resp">
	<div class="respHead">
		<a href="index.php" title="">RAGE BOOTER<!--<img src="images/loginLogo.png" alt="" />--></a>
	</div>
	
	<div class="cLine"></div>
	<div class="smalldd">
		<span class="goTo">Go To...</span>
		<ul class="smallDropdown">
			<li><a href="index.php" title="">Dashboard</a></li>
			<li><a href="hub.php" title="" >HUB</a></li>
			<li><a href="fe.php" title="" >Friends And Enemy</a></li>
			<li><a href="skype.php" title="">Skype Resolver</a></li>
			<li><a href="cloudflare.php" title="">Cloudflare Resolver</a></li>
			<li><a href="iplogger.php" title="" >IP Logger</a></li>
			<li><a href="geo.php" title="">Geolocation</a></li>
			<li><a href="purchase.php" title="" >Purchase</a></li>
			<li><a href="admin/index.php" title="" class="exp">Admin<strong>6</strong></a>
				<ul >
					<li><a href="admin/logs.php" title="">Full Logs</a></li>
					<li><a href="admin/blacklist.php" title="">Blacklist</a></li>
					<li><a href="admin/news.php" title="">News</a></li>
					<li><a href="admin/manage.php" title="">Manage Users</a></li>
					<li><a href="admin/plans.php" title="">Plans</a></li>
					<li class="last"><a href="admin/gateway.php" title="">Gateway</a></li>
				</ul>
			</li>
		</ul>
	</div>
	<div class="cLine"></div>
</div>
