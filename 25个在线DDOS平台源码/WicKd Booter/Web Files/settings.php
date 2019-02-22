<?php
include 'config.php';
include 'includes/functions.php';
if (!$user -> loggedIn())
{
	header('location: login.php');
	die();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title><?php echo $sn;?> | Settings</title>
<?php include 'includes/css.php'; ?>
</head>
<body>
 	
  	
<?php include 'includes/header.php';?>

<div id="content">
		
	<div class="container">
		
		<div class="row">
			
			<?php include 'includes/stats.php';?>
			<div class="span9">
				<div id="horizontal" class="widget widget-form">
	      			
	      			<div class="widget-header">	      				
	      				<h3>
	      					<i class="icon-pencil"></i>
	      					Update Password     					
      					</h3>	
      				</div> <!-- /widget-header -->
					
					<div class="widget-content">
						<?php
						if(isset($_POST['updateBtn']))
						{
							$cpassword = $_POST['cpassword'];
							$npassword = $_POST['npassword'];
							$rpassword = $_POST['rpassword'];
							if (empty($cpassword) || empty($npassword) || empty($rpassword))
							{
								$show -> showError('Please fill in all fields');
							}
							else if($npassword != $rpassword)
							{
								$show -> showError('New passwords did not match');
							}
							else
							{
								$SQLCheckPassword = $odb -> prepare("SELECT COUNT(*) FROM `users` WHERE `ID` = :id AND `password` = :password LIMIT 1");
								$SQLCheckPassword -> execute(array(':id' => $_SESSION['ID'], ':password' => hash('SHA512', $cpassword)));
								$SQLPasswordCount = $SQLCheckPassword -> fetchColumn(0);
								if ($SQLPasswordCount == 1)
								{
									$SQLUpdatePass = $odb -> prepare("UPDATE `users` SET `password` = :password WHERE `ID` = :id LIMIT 1");
									$SQLUpdatePass -> execute(array(':password' => hash('SHA512', $npassword), ':id' => $_SESSION['ID']));
									$show -> showSuccess('Updated');
								}
								else
								{
									$show -> showError('Current Password was invalid');
								}
							}
						}
						?>
						<form class="form-horizontal" action="" method="POST">
					        <fieldset>
								<div class="control-group">
									<label class="control-label" for="input01">Current Password</label>
										<div class="controls">
										  <input type="password" class="input-large" id="cpassword" name="cpassword">
										  <p class="help-block">Your current Password</p>
										</div>
								</div>
								<div class="control-group">
									<label class="control-label" for="input01">New Password</label>
										<div class="controls">
										  <input type="password" class="input-large" id="npassword" name="npassword">
										  <p class="help-block">Your new password</p>
										</div>
								</div>
								<div class="control-group">
									<label class="control-label" for="input01">Repeat Password</label>
										<div class="controls">
										  <input type="password" class="input-large" id="rpassword" name="rpassword">
										  <p class="help-block">Repeat your new password</p>
										</div>
								</div>
								<div class="form-actions">
									<input type="submit" name="updateBtn" class="btn btn-primary btn-large" value="Update">
								</div>
					        </fieldset>
					      </form>	
					</div> <!-- /widget-content -->
						
				</div>	
			</div>
		</div> <!-- /.container -->
	</div> <!-- /#content -->
</div>
<?php include 'includes/footer.php';?>
  </body>
</html>