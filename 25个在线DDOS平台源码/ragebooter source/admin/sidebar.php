<?php
if (!defined('DIRECT'))
{
	die('Direct access not allowed.');
}
?>
<div id="leftSide">
    <div class="logo"><a href="../index.php"><center><h2>Fibre Booter</h2></center><!--<img src="images/logo.png" alt="" />--></a></div>
    
    <div class="sidebarSep mt0"></div>
    
    <!-- Left navigation -->
    <ul id="menu" class="nav">
	<?php
	if ($user -> hasMembership($odb))
	{
	?>
        <li class="dash"><a href="../index.php" title=""><span>Dashboard</span></a></li>
		<li class="tables"><a href="../hub.php" title="" ><span>HUB</span></a></li>
        <li class="forms"><a href="../fe.php" title="" ><span>Friends And Enemy</span></a></li>
        <li class="widgets"><a href="../skype.php" title=""><span>Skype Resolver</span></a></li>
        <li class="files"><a href="../cloudflare.php" title=""><span>Cloudflare Resolver</span></a></li>
		<li class="forms"><a href="../iplogger.php" title="" ><span>IP Logger</span></a></li>
		<li class="widgets"><a href="../geo.php" title=""><span>Geolocation</span></a></li>
	<?php
	}
	?>
        <li class="typo"><a href="../purchase.php" title="" ><span>Purchase</span></a></li>
		<?php
		if ($user -> isAdmin($odb))
		{
		
		?>
		<li class="ui"><a title="" class="exp"><span>Admin</span></a>
		    <ul class="sub">
				<li><a href="logs.php" title="">Full Logs</a></li>
				<li><a href="blacklist.php" title="">Blacklist</a></li>
				<li><a href="news.php" title="">News</a></li>
                <li><a href="manage.php" title="">Manage Users</a></li>
                <li><a href="plans.php" title="">Plans</a></li>
                <li class="last"><a href="gateway.php" title="">Gateway</a></li>
				<li class="last"><a href="payments.php" title="">Payments</a></li>
            </ul>
		</li>
		<?php
		}
		?>
    </ul>
</div>
