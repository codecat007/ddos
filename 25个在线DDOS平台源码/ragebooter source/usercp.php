<?php
ob_start();
require_once 'includes/db.php';
require_once 'includes/init.php';
if (!($user -> LoggedIn()))
{
	header('location: login.php');
	die();
}
if (!($user -> notBanned($odb)))
{
	header('location: login.php');
	die();
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>UserCP</title>
<?php include 'includes/css.php';?>
</head>
<body>
<?php
include 'sidebar.php';
?>
<!-- Right side -->
<div id="rightSide">
<?php include 'header.php';?>
    
    

    
    <!-- Title area -->
    <div class="titleArea">
        <div class="wrapper">
            <div class="pageTitle">
                <h3>UserCP</h3>
            </div>
            <div class="clear"></div>
        </div>
    </div>
    
    <div class="line"></div>
    

    
    <!-- Main content wrapper -->
    <div class="wrapper">
        <?php 
		if (isset($_POST['updatePassBtn']))
		{
			$cpassword = $_POST['cpassword'];
			$npassword = $_POST['npassword'];
			$rpassword = $_POST['rpassword'];
			if (!empty($cpassword) && !empty($npassword) && !empty($rpassword))
			{
				if ($npassword == $rpassword)
				{
					$SQLCheckCurrent = $odb -> prepare("SELECT COUNT(*) FROM `users` WHERE `username` = :username AND `password` = :password");
					$SQLCheckCurrent -> execute(array(':username' => $_SESSION['username'], ':password' => SHA1($cpassword)));
					$countCurrent = $SQLCheckCurrent -> fetchColumn(0);
					if ($countCurrent == 1)
					{
						$SQLUpdate = $odb -> prepare("UPDATE `users` SET `password` = :password WHERE `username` = :username AND `ID` = :id");
						$SQLUpdate -> execute(array(':password' => SHA1($npassword),':username' => $_SESSION['username'], ':id' => $_SESSION['ID']));
						echo '<div class="nNote nSuccess hideit"><p><strong>SUCCESS: </strong>Password Has Been Updated</p></div>';
					}
					else
					{
						echo '<div class="nNote nFailure hideit"><p><strong>FAILURE: </strong>Current Password is incorrect.</p></div>';
					}
				}
				else
				{
					echo '<div class="nNote nFailure hideit"><p><strong>FAILURE: </strong>New Passwords Did Not Match.</p></div>';
				}
			}
			else
			{
				echo '<div class="nNote nFailure hideit"><p><strong>FAILURE: </strong>Please fill in all fields</p></div>';
			}
		}
		?>
        <!-- Form -->
        <form action="" class="form" method="POST">
            <fieldset>
                <div class="widget">
                    <div class="title"><img src="images/icons/dark/list.png" alt="" class="titleIcon" /><h6>Change Password</h6></div>
                    <div class="formRow">
                        <label>Current Password:</label>
                        <div class="formRight"><input type="password" name="cpassword" /></div>
                        <div class="clear"></div>
                    </div>
                    <div class="formRow">
                        <label for="labelFor">New Password</label>
                        <div class="formRight"><input type="password" name="npassword" value="" /></div>
                        <div class="clear"></div>
                    </div>
                    <div class="formRow">
                        <label>Repeat Password</label>
                        <div class="formRight"><input type="password" name="rpassword" value="" /></div>
                        <div class="clear"></div>
                    </div>
					<div class="formRow">
						<input type="submit" value="Update" name="updatePassBtn" class="dblueB logMeIn" />
						<div class="clear"></div>
                    </div>
                </div>
            </fieldset>
        </form>
		        <?php 
		if (isset($_POST['updateEmailBtn']))
		{
			$cpassword = $_POST['cpassword'];
			$nemail = $_POST['nemail'];
			if (!empty($cpassword) && !empty($nemail))
			{
				if (filter_var($nemail, FILTER_VALIDATE_EMAIL))
				{
					$SQLCheckCurrent = $odb -> prepare("SELECT COUNT(*) FROM `users` WHERE `username` = :username AND `password` = :password");
					$SQLCheckCurrent -> execute(array(':username' => $_SESSION['username'], ':password' => SHA1($cpassword)));
					$countCurrent = $SQLCheckCurrent -> fetchColumn(0);
					if ($countCurrent == 1)
					{
						$SQLUpdate = $odb -> prepare("UPDATE `users` SET `email` = :email WHERE `username` = :username AND `ID` = :id");
						$SQLUpdate -> execute(array(':email' => $nemail,':username' => $_SESSION['username'], ':id' => $_SESSION['ID']));
						echo '<div class="nNote nSuccess hideit"><p><strong>SUCCESS: </strong>Email Has Been Updated</p></div>';
					}
					else
					{
						echo '<div class="nNote nFailure hideit"><p><strong>FAILURE: </strong>Current Password is Incorrect.</p></div>';
					}
				}
				else
				{
					echo '<div class="nNote nFailure hideit"><p><strong>FAILURE: </strong>Email is not valid</p></div>';
				}
			}
			else
			{
				echo '<div class="nNote nFailure hideit"><p><strong>FAILURE: </strong>Please fill in all fields</p></div>';
			}
		}
		?>
		<form action="" class="form" method="POST">
            <fieldset>
                <div class="widget">
                    <div class="title"><img src="images/icons/dark/list.png" alt="" class="titleIcon" /><h6>Change Email</h6></div>
                    <div class="formRow">
                        <label>Current Password:</label>
                        <div class="formRight"><input type="password" name="cpassword" value="" /></div>
                        <div class="clear"></div>
                    </div>
                    <div class="formRow">
                        <label for="labelFor">New Email:</label>
                        <div class="formRight"><input type="text" name="nemail" value="" /></div>
                        <div class="clear"></div>
                    </div>
					<div class="formRow">
						<input type="submit" value="Update" name="updateEmailBtn" class="dblueB logMeIn" />
						<div class="clear"></div>
                    </div>
                </div>
            </fieldset>
        </form>
            
    </div>
    <!-- Footer line -->
    <?php include 'footer.php';?>

</div>

<div class="clear"></div>
</body>

</html>