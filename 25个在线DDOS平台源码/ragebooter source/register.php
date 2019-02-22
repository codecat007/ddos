<?php ob_start(); require 'includes/db.php'; require 'includes/init.php'; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;" />
<title><?php echo $title_prefix; ?>Register</title>
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
<div class="loginWrapper" style="margin-top: -184px;">
    <div class="loginLogo"><img src="images/loginLogo.png" alt="" /></div>
	<div style="width:340px;">
	<?php
		if ($user -> LoggedIn())
		{
			header('Location: index.php');
			echo 'balls';
			die();
		}
		
		if (isset($_POST['registerBtn']))
		{
			$username = $_POST['username'];
			$password = $_POST['password'];
			$rpassword = $_POST['rpassword'];
			$email = $_POST['email'];
			$errors = array();
			$checkUsername = $odb -> prepare("SELECT COUNT(*) FROM `users` WHERE `username` = :username");
			$checkUsername -> execute(array(':username' => $username));
			$countUsername = $checkUsername -> fetchColumn(0);
			if ($checkUsername > 0)
			{
				$errors['Username is already taken'];
			}
			if (!ctype_alnum($username) || strlen($username) < 4 || strlen($username) > 15)
			{
				$errors[] = 'Username Must Be  Alphanumberic And 4-15 characters in length';
			}
			if (!filter_var($email, FILTER_VALIDATE_EMAIL))
			{
				$errors[] = 'Email is invalid';
			}
			if (empty($username) || empty($password) || empty($rpassword) || empty($email))
			{
				$errors[] = 'Please fill in all fields';
			}
			if ($password != $rpassword)
			{
				$errors[] = 'Passwords do not match';
			}
			if (empty($errors))
			{
				$insertUser = $odb -> prepare("INSERT INTO `users` VALUES(NULL, :username, :password, :email, 0, 0, 0, 0)");
				$insertUser -> execute(array(':username' => $username, ':password' => SHA1($password), ':email' => $email));
				echo '<div class="nNote nSuccess hideit"><p><strong>SUCCESS: </strong>User has been registered.  Redirecting....</p></div><meta http-equiv="refresh" content="3;url=login.php">';
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
		?>
		</div>
    <div class="widget" style="height: 368px;">
        <div class="title"><img src="images/icons/dark/files.png" alt="" class="titleIcon" /><h6>Register</h6></div>
        <form action="" id="validate" class="form" method="POST">
            <fieldset>
                <div class="formRow">
                    <label for="login">Username:</label>
                    <div class="loginInput"><input type="text" name="username" class="validate[required]" id="username" maxlength="15"/></div>
                    <div class="clear"></div>
                </div>
                
                <div class="formRow">
                    <label for="pass">Password:</label>
                    <div class="loginInput"><input type="password" name="password" class="validate[required]" id="pass" /></div>
                    <div class="clear"></div>
                </div>
				
				<div class="formRow">
                    <label for="pass">Repeat Password:</label>
                    <div class="loginInput"><input type="password" name="rpassword" class="validate[required]" id="rpass" /></div>
                    <div class="clear"></div>
                </div>
				
				<div class="formRow">
                    <label for="pass">Email:</label>
                    <div class="loginInput"><input type="text" name="email" class="validate[required]" id="email" /></div>
                    <div class="clear"></div>
                </div>
                
                <div class="loginControl">
                    <input type="submit" value="Register" class="dblueB logMeIn" name="registerBtn"/>
                    <div class="clear"></div>
                </div>
            </fieldset>
        </form>
    </div>
</div>    

<!-- Footer line -->
</body>
</html>
