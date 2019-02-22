<?php
require 'includes/db.php';
require 'includes/init.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;" />
<title><?php echo $title_prefix; ?>Login</title>
<link href="css/main.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.min.js"></script>

<script type="text/javascript" src="js/plugins/spinner/ui.spinner.js"></script>
<script type="text/javascript" src="js/plugins/spinner/jquery.mousewheel.js"></script>

<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>

<script type="text/javascript" src="js/plugins/charts/excanvas.min.js"></script>
<script type="text/javascript" src="js/plugins/charts/jquery.sparkline.min.js"></script>

<script type="text/javascript" src="js/plugins/forms/uniform.js"></script>
<script type="text/javascript" src="js/plugins/forms/jquery.cleditor.js"></script>
<script type="text/javascript" src="js/plugins/forms/jquery.validationEngine-en.js"></script>
<script type="text/javascript" src="js/plugins/forms/jquery.validationEngine.js"></script>
<script type="text/javascript" src="js/plugins/forms/jquery.tagsinput.min.js"></script>
<script type="text/javascript" src="js/plugins/forms/autogrowtextarea.js"></script>
<script type="text/javascript" src="js/plugins/forms/jquery.maskedinput.min.js"></script>
<script type="text/javascript" src="js/plugins/forms/jquery.dualListBox.js"></script>
<script type="text/javascript" src="js/plugins/forms/jquery.inputlimiter.min.js"></script>
<script type="text/javascript" src="js/plugins/forms/chosen.jquery.min.js"></script>

<script type="text/javascript" src="js/plugins/wizard/jquery.form.js"></script>
<script type="text/javascript" src="js/plugins/wizard/jquery.validate.min.js"></script>
<script type="text/javascript" src="js/plugins/wizard/jquery.form.wizard.js"></script>

<script type="text/javascript" src="js/plugins/uploader/plupload.js"></script>
<script type="text/javascript" src="js/plugins/uploader/plupload.html5.js"></script>
<script type="text/javascript" src="js/plugins/uploader/plupload.html4.js"></script>
<script type="text/javascript" src="js/plugins/uploader/jquery.plupload.queue.js"></script>

<script type="text/javascript" src="js/plugins/tables/datatable.js"></script>
<script type="text/javascript" src="js/plugins/tables/tablesort.min.js"></script>
<script type="text/javascript" src="js/plugins/tables/resizable.min.js"></script>

<script type="text/javascript" src="js/plugins/ui/jquery.tipsy.js"></script>
<script type="text/javascript" src="js/plugins/ui/jquery.collapsible.min.js"></script>
<script type="text/javascript" src="js/plugins/ui/jquery.prettyPhoto.js"></script>
<script type="text/javascript" src="js/plugins/ui/jquery.progress.js"></script>
<script type="text/javascript" src="js/plugins/ui/jquery.timeentry.min.js"></script>
<script type="text/javascript" src="js/plugins/ui/jquery.colorpicker.js"></script>
<script type="text/javascript" src="js/plugins/ui/jquery.jgrowl.js"></script>
<script type="text/javascript" src="js/plugins/ui/jquery.breadcrumbs.js"></script>
<script type="text/javascript" src="js/plugins/ui/jquery.sourcerer.js"></script>

<script type="text/javascript" src="js/plugins/calendar.min.js"></script>
<script type="text/javascript" src="js/plugins/elfinder.min.js"></script>

<script type="text/javascript" src="js/custom.js"></script>

</head>

<body class="nobg loginPage">


<!-- Top fixed navigation -->


<!-- Main content wrapper -->
<div class="loginWrapper">
<div class="loginLogo"><img src="images/loginLogo.png" alt="" /></div>
<div style="width:340px;">
<?php
if (!($user -> LoggedIn()))
{
	if (isset($_POST['loginBtn']))
	{
		$username = $_POST['username'];
		$password = $_POST['password'];
		$errors = array();
		if (!ctype_alnum($username) || strlen($username) < 4 || strlen($username) > 15)
		{
			$errors[] = 'Username Must Be  Alphanumberic And 4-15 characters in length';
		}
		
		if (empty($username) || empty($password))
		{
			$errors[] = 'Please fill in all fields';
		}
		
		if (empty($errors))
		{
			$SQLCheckLogin = $odb -> prepare("SELECT COUNT(*) FROM `users` WHERE `username` = :username AND `password` = :password");
			$SQLCheckLogin -> execute(array(':username' => $username, ':password' => SHA1($password)));
			$countLogin = $SQLCheckLogin -> fetchColumn(0);
			if ($countLogin == 1)
			{
				$SQLGetInfo = $odb -> prepare("SELECT `username`, `ID` FROM `users` WHERE `username` = :username AND `password` = :password");
				$SQLGetInfo -> execute(array(':username' => $username, ':password' => SHA1($password)));
				$userInfo = $SQLGetInfo -> fetch(PDO::FETCH_ASSOC);
				if ($userInfo['status'] == 0)
				{
					$_SESSION['username'] = $userInfo['username'];
					$_SESSION['ID'] = $userInfo['ID'];
					echo '<div class="nNote nSuccess hideit"><p><strong>SUCCESS: </strong>Login Successful.  Redirecting....</p></div><meta http-equiv="refresh" content="3;url=index.php">';
				}
				else
				{
					echo '<div class="nNote nFailure hideit"><p><strong>ERROR: </strong>Your user was banned</p></div>';
				}
			}
			else
			{
				echo '<div class="nNote nFailure hideit"><p><strong>ERROR: </strong>Login Failed</p></div>';
			}
		}
		else
		{
			echo '<div class="nNote nFailure hideit"><p><strong>ERROR:</strong><br />';
			foreach($errors as $error)
			{
				echo '-'.$error.'<br />';
			}
			echo '</div>';
		}
	}
}
else
{
	header('location: index.php');
}
?>
</div>
<div class="widget">
<div class="title"><img src="images/icons/dark/files.png" alt="" class="titleIcon" /><h6>Login</h6></div>
<form action="" id="validate" class="form" method="POST">
<fieldset>
<div class="formRow">
<label for="login">Username:</label>
<div class="loginInput"><input type="text" name="username" class="validate[required]" id="username" /></div>
<div class="clear"></div>
</div>

<div class="formRow">
<label for="pass">Password:</label>
<div class="loginInput"><input type="password" name="password" class="validate[required]" id="password" /></div>
<div class="clear"></div>
</div>

<div class="loginControl">
<input type="submit" value="Login" name="loginBtn" class="dblueB logMeIn" style="float: left;" />
<a href="register.php"><input type="button" value="Register" class="dblueB logMeIn" /></a>
<div class="clear"></div>
</div>
</fieldset>
</form>
</div>
</div>
</body>
</html>
