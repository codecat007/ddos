<?php 
include('config.php');
include('includes/functions.php');
if ($user -> loggedIn())
{
	header('location: index.php');
	die();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title><?php echo $sn; ?> | Login</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">   
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/bootstrap-responsive.css" rel="stylesheet">
    <link href="css/bootstrap-overrides.css" rel="stylesheet">
	<link href="css/ui-lightness/jquery-ui-1.8.21.custom.css" rel="stylesheet">
    <link href="css/slate.css" rel="stylesheet">
	<link href="css/components/signin.css" rel="stylesheet" type="text/css">   
    <script src="js/jquery-1.7.2.min.js"></script>
	<script src="js/jquery-ui-1.8.18.custom.min.js"></script>    
	<script src="js/jquery.ui.touch-punch.min.js"></script>
	<script src="js/bootstrap.js"></script>
	<script src="js/demos/signin.html"></script>
</head>
<body>



<div class="account-container login">
	
	<div class="content clearfix">
		
		<form action="" method="post">
		
			<h1>Sign In</h1>		
			
			<div class="login-fields">
				
				<p>Sign in using your registered account:</p>
				<?php
				if (isset($_POST['loginBtn']))
				{
					$username = $_POST['username'];
					$password = $_POST['password'];
					if (empty($username) || empty($password))
					{
						$show -> showError("Please fill in all fields");
					}
					else if (!ctype_alnum($username))
					{
						$show -> showError('Username has to be alphanumeric');
					}
					else if(strlen($username) < 4 || strlen($username) > 15)
					{
						$show -> showError('Username has to be 4-15 chars');
					}
					else
					{
						$SQLCheckUser = $odb -> prepare("SELECT COUNT(*) FROM `users` WHERE `username` = :user AND `password` = :password LIMIT 1");
						$SQLCheckUser -> execute(array(':user' => $username, ':password' => hash('SHA512', $password)));
						$loginCheck = $SQLCheckUser -> fetchColumn(0);
						if ($loginCheck == 1)
						{
							$SQLCheckBan = $odb -> prepare("SELECT `status` FROM `users` WHERE `username` = :username");
							$SQLCheckBan -> execute(array(':username' => $username));
							$banCheck = $SQLCheckBan -> fetchColumn(0);
							if ($banCheck == 0)
							{
								$SQLCheckExpire = $odb -> prepare("SELECT `expire`, `rank` FROM `users` WHERE `username` = :username");
								$SQLCheckExpire -> execute(array(':username' => $username));
								$ExpireArray = $SQLCheckExpire -> fetch(PDO::FETCH_ASSOC);
								if (($ExpireArray['expire'] > time()) || ($ExpireArray['rank'] == 1))
								{
									$SQLGetID = $odb -> prepare("SELECT `ID` FROM `users` WHERE `username` = :username LIMIT 1");
									$SQLGetID -> execute(array(':username' => $username));
									$_SESSION['username'] = $username;
									$_SESSION['ID'] = $SQLGetID -> fetchColumn(0);
									$show -> showSuccess('Logging In.. <meta http-equiv="refresh" content="2;url=index.php">');
								}
								else
								{
									$show -> showError('Your account has expired');
								}
							}
							else
							{
								$show -> showError('User has been banned');
							}
						}
						else
						{
							$show -> showError('Login did not match');
						}
					}
				}
				?>
				<div class="field">
					<label for="username">Username:</label>
					<input type="text" id="username" name="username" value="" placeholder="Username" class="login username-field" maxlength="15"/>
				</div> <!-- /field -->
				
				<div class="field">
					<label for="password">Password:</label>
					<input type="password" id="password" name="password" value="" placeholder="Password" class="login password-field"/>
				</div> <!-- /password -->
				
			</div> <!-- /login-fields -->
			
			<div class="login-actions">
				
									
				<input type="submit" value="Login" name="loginBtn" class="button btn btn-secondary btn-large" />
				
			</div> <!-- .actions -->
			
		
			
		</form>
		
	</div> <!-- /content -->
	
</div> <!-- /account-container -->

</body>
</html>
