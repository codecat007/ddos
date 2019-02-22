<?php
	session_start();
	include('config.php');
	
	if(loggedin() == TRUE){
		header("Location: index.php");
		exit();
	}
	
	if ($_POST){
	
		mysql_connect(DB_HOST, DB_USER, DB_PASS) or die(mysql_error());
		mysql_select_db(DATABASE) or die(mysql_error());		
		
		$username = $_POST['username'];
		$password = $_POST['password'];
	
				
		$errors = 0;
		$errorText = array();

		
		if($username && $password){
			$user = mysql_query("SELECT * FROM users WHERE username='" . $username . "'");
			
			// Database Check
			while ($row = mysql_fetch_assoc($user)){
				$db_password = $row['password'];
				$db_memberid = $row['member_id'];
				$db_username = $row['username'];
				$db_group = $row['group'];
				$db_membership = $row['membership'];
			}
				
			// Check if password matches
			if(strtolower(md5($password)) == strtolower($db_password)){
				$loginchk = TRUE;
			} else {
				$loginchk = FALSE;
			}
					
			// Direct info's!
			if($loginchk == TRUE){
				$_SESSION['member_id'] = $db_memberid;
				$_SESSION['username'] = $db_username;
				$_SESSION['group'] = $db_group;
				$_SESSION['membership'] = $db_membership;
				header("Location: index.php");
				exit;
			} else {
				$errors = 1;
				array_push($errorText, "Your Username/Password was incorrect.");
			}
		} else {
			$errors = 1;
			array_push($errorText, "Please fill in ALL the required fields.");
		}
	
					
	}
		
		
?>



<head>
<title>Login Page</title><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta charset="utf-8" />
<title>SimpleAdmin - Login to CMS</title><!-- Stylesheets -->
<link href="http://fonts.googleapis.com/css?family=Droid+Sans:400,700" rel="stylesheet" />
<link rel="stylesheet" href="style.css" /><!-- Optimize for mobile devices -->
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
</head>
<body><!-- TOP BAR -->
<div id="top-bar">
<div class="page-full-width"><a href="javascript:history.go(-1)" class="round button dark ic-left-arrow image-left ">Go Back&nbsp;</a></div> <!-- end full-width --> </div> <!-- end top-bar --><!-- HEADER -->
<div id="header">
<div class="page-full-width cf">
<div id="login-intro" class="fl">
<h1>Login to qb</h1>
<h5>Enter your credentials below</h5></div> <!-- login-intro --><!-- Change this image to your own company's logo --><!-- The logo will automatically be resized to 39px height. --><a href="" class="fr"><img src="logo.png" alt="EasyBooter" /></a></div> <!-- end full-width --> </div> <!-- end header --><!-- MAIN CONTENT -->
<div id="content">


<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" id="login-form" name="login-form">
		<p><label for="username">username</label>
		<input type="text" id="username" name="username" class="round full-width-input" autofocus="" /></p>
		
		<p><label for="password">password</label>
		<input type="password" name="password" class="round full-width-input" autofocus="" /></p>
		
		<input type="submit" class="button round blue image-right ic-right-arrow" value="LOG IN" />

</br>
<br>
<?php
if($errors == 1)
{
	foreach($errorText as $error)
	{
		echo "<font size='2'>" . $error . '</font><br>';
	}
	echo '<br>';
}
?>
<div class="information-box round">Need An Account? Register <a href="register.php">HERE</a></div></form></div> <!-- end content --><!-- FOOTER -->
<div id="footer">
<p>&copy; Copyright 2012 QuickBooter. All rights reserved.</p>
<p><strong>Quickbooter</strong></p></div> <!-- end footer -->
</body>
<body><!--Start of Zopim Live Chat Script-->
<script type="text/javascript">
window.$zopim||(function(d,s){var z=$zopim=function(c){z._.push(c)},$=z.s=
d.createElement(s),e=d.getElementsByTagName(s)[0];z.set=function(o){z.set.
_.push(o)};z._=[];z.set._=[];$.async=!0;$.setAttribute('charset','utf-8');
$.src='//cdn.zopim.com/?alJ7EF8DXbUu8CkJHhRe9wS800lTqkyy';z.t=+new Date;$.
type='text/javascript';e.parentNode.insertBefore($,e)})(document,'script');
</script><!--End of Zopim Live Chat Script-->
</body>
</html>