<?php
	session_start();
	include('config.php');

	// If logged in, sign into MySQL
	if(loggedin() == FALSE){
		header("Location: login.php");
		exit();
	}
	
	
		mysql_connect(DB_HOST, DB_USER, DB_PASS) or die(mysql_error());
		mysql_select_db(DATABASE) or die(mysql_error());	

		
		$user = mysql_fetch_assoc(mysql_query("SELECT * FROM users WHERE username = '" . $_SESSION['username'] . "'"));
		
		
		$errors = 0;
		$errorText = array();
		
		if($_POST){
			$password = $_POST['password'];
		
			
			
			if($user['email'] != $_POST['email'])
			{
				mysql_query("UPDATE `users` SET `email` = '" . $_POST['email'] . "' WHERE `username` = '" . $_SESSION['username'] . "'") or die(mysql_error());
			}
			
			if($_POST['password'])
			{
				
				if($_POST['password'] == $_POST['confirm-password'])
				{
					if(strlen($password) < 4 || strlen($password) > 100)
					{
						$errors = 1;
						array_push($errorText, "Your password cannot be smaller than 4 characters");
					} else {
						mysql_query("UPDATE `users` SET `password` = '" . md5($_POST['password']) . "' WHERE `username` = '" . $_SESSION['username'] . "'") or die(mysql_error());
					}
				} else {
					$errors = 1;
					array_push($errorText, "You're Confirmation Password Doesn't Match");
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


<article id="home_modified">
	<div class="container">
		<div class="row box dark light">
			<div class="seven columns">
            
		
            
            
				<!--
                 <div class="welcome-container">
				<h1>QuickBooter</h1>
				<p>Designed with the latest scripts and most advanced techniques, this booter website offers amazing quality services!</p>
				<p class="hide-for-mobile">The booter focuses on usability, it offers enterprise-level features, design quality,
					technical implementation, compatibility, accessibility and performance.
				</p>
				<a class="button call-to-action animate" href="#pricing_modified">Buy now</a>
				</div>
			</div>
			
			<div class="nine columns">
				<div class="flexslider">
					<ul class="slides">
						<li style="width: 100%; float: left; margin-right: -100%; display: list-item;"><img src="images/slides/performance.jpg" alt=""></li>
						<li style="width: 100%; float: left; margin-right: -100%; display: none;"><img src="images/slides/crossbrowser.jpg" alt=""></li>
						<li style="width: 100%; float: left; margin-right: -100%; display: none;"><img src="images/slides/html5.jpg" alt=""></li>
					</ul>
                    </div>
		</div>
		
		<div class="row">
			<div class="one-third column headset">
				<img class="large-icons icon-menu" alt="" src="images/empty.gif">
				<h4>Feature</h4>
				<p>Go Ahead, Add A Description</a></p>
			</div>

			<div class="one-third column headset">
				<img class="large-icons icon-layers" alt="" src="images/empty.gif">
				<h4>Responsive Grid Layout</h4>
				<p>Go Ahead, Resize This Page</p>
			</div>

			<div class="one-third column headset">
				<img class="large-icons icon-resize" alt="" src="images/empty.gif">
				<h4>Browser History</h4>
				<p>Go Ahead, Try The Back Button</p>
			</div>
		</div><!-- .row -->
	
		<div class="bottom-gradient between-rows">
			<span class="left"></span>
			<span class="center"></span>
			<span class="right"></span>
		</div>
		
		<div class="row">
			<div class="two-thirds column">
				<h4><?php echo $user['username']; ?>'s UserCP</h4>
			
				<?php
				
				if($_POST)
				{
					if($errors == 1)
					{
						foreach($errorText as $error)
						{
							echo $error . '<br>';
						}
					} else {
						echo 'Details Successfully Updated<br><br>';
	
					}
				}
				echo '<br>';
				?>
				<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" id="login-form" name="login-form">
					<p><label for="email" style="text-align:left;">New Email</label>
					<input value="<?php echo $user['email']; ?>" type="text" id="email" name="email" style="width:250px; height: 30px;" class="round full-width-input" autofocus="" /></p>
	
					<p><label for="password" style="text-align:left;">New Password</label>
					<input type="password" id="password" name="password" style="width:250px; height: 30px;" class="round full-width-input" autofocus="" />
					
					<p><label for="confirm-password" style="text-align:left;">Confirm New Password</label>
					<input type="password" id="confirm-password" name="confirm-password" style="width:250px; height: 30px;" class="round full-width-input" autofocus="" /></p>
					
					<p><label for="group" style="text-align:left;">Group</label>
					<input value="<?php echo userGroup($user['group']); ?>" readonly="readonly" type="text" id="group" name="group" style="width:250px; height: 30px;" class="round full-width-input" autofocus="" /></p>
					
					<p><label for="membership" style="text-align:left;">Membership</label>
					<input value="<?php echo userMembership($user['membership']); ?>" readonly="readonly" type="text" id="membership" name="membership" style="width:250px; height: 30px;" class="round full-width-input" autofocus="" /></p>
					<?php
						if($user['membership'] != 0)
						{
							echo '<p><label for="expire_date" style="text-align:left;">Expiration Date</label>
							<input value="' . userExpire($user['expire_date']) .  '" readonly="readonly" type="text" id="membership" name="membership" style="width:250px; height: 30px;" class="round full-width-input" autofocus="" /></p>';
						}
					?>
					
					<p><input type="submit" class="button round blue image-right ic-right-arrow" value="UPDATE" /></p>
					</form>
			<div class="one-third column">
				
			</div><!-- .columns -->
		</div><!-- .row -->
	
		
	</div><!-- .container -->
</article>


<article class="dark" id="contact_modified">
	<div class="container">	
	
		

</body></html>