<?php
	session_start();
	include('config.php');

	
	mysql_connect(DB_HOST, DB_USER, DB_PASS) or die(mysql_error());
	mysql_select_db(DATABASE) or die(mysql_error());	

	
	$user = mysql_fetch_assoc(mysql_query("SELECT * FROM users WHERE username = '" . $_SESSION['username'] . "'"));
		
		
	// If logged in, sign into MySQL
	if(loggedin() == FALSE || $user['membership'] == 0){
		if($user['group'] != 1)
		{
			header("Location: index.php");
			exit();
		}
		
	}
	
	$errors = 0;
	$errorText = array();
	
	// If form submitted
	if($_POST)
	{
		// If Skype Request
		if($_POST['skypename'])
		{
			$skype = TRUE;
	
		} else {
			$skype = FALSE;
			
			// If Boot Request
			if($_POST['mboot'] != 'STOP')
			{
				if($_POST['ip'] == '' || $_POST['port'] = '')
				{
					$errors = 1;
					array_push($errorText, 'Fill In All Fields');
				} else {
					// Validate IP
					if(!filter_var($_POST['ip'], FILTER_VALIDATE_IP))
					{
						$errors = 1;
						array_push($errorText, 'Invalid IP Address!');
					}
				}
			}
		}
	}
?>
<html>
<head>
<title>QuickBooter Leading booter in the market</title>

	<meta charset="utf-8">
	<meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">

	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0" name="viewport">
	<meta content="yes" name="apple-mobile-web-app-capable">
	
	<!-- IMPORTANT: If you need to update one of the CSS files, you must upgrade the version both in the file name and in the line bellow -->
<link rel="stylesheet" type="text/css" media="all" href="css/skeleton-v1.1.css" />
<link rel="stylesheet" type="text/css" media="all" href="css/flexslider-v1.8.css" />
<link rel="stylesheet" type="text/css" media="all" href="css/main-r6.css" />
<link rel="stylesheet" type="text/css" media="all" href="css/media-queries-r6.css" />
<link rel="stylesheet" type="text/css" media="all" href="css/sprites-r6.css" />
<link rel="stylesheet" type="text/css" media="all" href="css/theme-default-r6.css" />
<link rel="stylesheet" type="text/css" media="all" href="css/styles.css" />
	<link type="text/css" rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:400,600,400italic">

	<link href="images/favicon.ico" rel="shortcut icon">
	<link href="images/apple-touch-icon.png" rel="apple-touch-icon">
	<link href="images/apple-touch-icon-72x72.png" sizes="72x72" rel="apple-touch-icon">
	<link href="images/apple-touch-icon-114x114.png" sizes="114x114" rel="apple-touch-icon">
    
<script type="text/javascript" src="js/slides.min.jquery.js"></script>
<script type="text/javascript" src="js/jquery-1.7.1.min.js"></script>
<script type="text/javascript" src="js/slides.jquery.js"></script>
   
    
        <link href="css/styles.css" rel="stylesheet">
	
	<style type="text/css" media="screen">

	</style>
	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js"></script>
	<script src="js/slides.min.jquery.js"></script>
	<script type="text/javascript">
	function showValue(newValue)
	{
		document.getElementById("range_power").innerHTML=newValue;
	}
	
	function showValue2(newValue)
	{
		document.getElementById("range_time").innerHTML=newValue;
	}
	</script>
	

<!--End of Zopim Live Chat Script-->
</head>
<body>
<!--Start of Zopim Live Chat Script-->

<div class="dark" role="main" id="main">

<header class="dark">
	<div class="container">
		<h1 class="logo one-third column alpha">
			<a href="/">
				<img class="scale-with-grid" alt="Spark" src="images/logo.png" style="position:relative; top:30px;" width="400" height="40">
				<img class="scale-with-grid mobile-only" alt="Spark" src="images/logo-mobile-white.png"><!-- Alternative image for mobile devices -->
			</a>
		</h1>

		<nav class="menu two-thirds column omega">
			<?php tabs() ?>
		</nav>
	</div><!-- .container -->

	<div class="bottom-gradient">
		<span class="left"></span>
		<span class="center"></span>
		<span class="right"></span>
	</div>	
</header>


<article id="home_modified" >
	<div class="container" >
	<centeR>
		<div class="row box dark light" style="width: 425px">
			<div class="seven columns">
  
	
		<div class="bottom-gradient between-rows">
			<span class="left"></span>
			<span class="center"></span>
			<span class="right"></span>
		</div>
		
		<div class="row" >
			
				<h4>Boot</h4>
				<br>
				<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" id="boot" name="boot">
					<p>IP Address / Port<br>
					<input type="text" id="ip" maxlength="15" name="ip" style="width:200px; height: 30px;" class="round full-width-input" autofocus="" />
					<input type="text" value="80" id="port" name="port"  maxlength="5" style="width:50px; height: 30px;" class="round full-width-input" autofocus="" /></p>
					
					<p><span id="range_time"><?php echo DEFAULT_BOOTTIME; ?></span> Seconds<br>
					<input type="range" style="width: 200px;" id="time" name="time" min="<?php echo LOWEST_BOOTTIME; ?>" onchange="showValue2(this.value)" max="<?php echo maxBoot($user['group'], $user['membership']) ?>" value="<?php echo DEFAULT_BOOTTIME; ?>" /></p>
					
					
					<p><span id="range_power"><?php echo DEFAULT_POWER; ?></span>% Power<br>
					<input type="range" style="width: 200px;" id="power" name="power" min="0" onchange="showValue(this.value)" max="100" value="<?php echo DEFAULT_POWER; ?>" /></p>
					
					
					
					<p><input type="submit" id="mboot" name="mboot" class="button round blue image-right ic-right-arrow" value="BOOT" />
					
					<input type="submit" id="mboot" name="mboot" class="button round blue image-right ic-right-arrow" value="STOP" /></p>
					<?php
						// If form post
						if($_POST && $skype == FALSE){
							// If errors
							if($errors == 1)
							{
								echo '<p>';
								// Display errors to user
								foreach($errorText as $error)
								{
									echo '<font color="red">' . $error . '</font><br>';
								}
								echo '</p>';
							} else {
								// Request End/Start
								if($_POST['mboot'] != 'STOP')
								{
									if($_POST['time'] > maxBoot($user['group'], $user['membership']))
									{
										echo '<p><font color="red">You Cannot Boot Above Your Max!</font></p>';
									} else {
										// No errors, display success message
										echo '<p><font color="green">Boot Request Successfully Sent At ' . $_POST['power'] . '% Power!</font></p>';
									}
								} else {
									// No errors, display success message
									echo '<p><font color="red">Boot Request Has Been Stopped!</font></p>';
								}
							}
						}
					?>
					<hr>
					<br>
						<p>
						Skype Resolver<br>
						<input type="text" id="skypename"  name="skypename" style="width:200px; height: 30px;" class="round full-width-input" autofocus="" />
						<br><input type="submit" id="mskype" name="mskype" class="button round blue image-right ic-right-arrow" value="RESOLVE" />
						</p>
					</form>
					<?php
						if($skype == TRUE)
						{
							// Execute Skype Code
							echo 'Skype IP: {IP HERE}';
						}
					?>
		</div>
		
		
	</div>
	
</article>
</center>


<article class="dark" id="contact_modified">
	<div class="container">	
	
		

</body></html>