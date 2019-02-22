<?php
ob_start();
include '../config.php';
include '../includes/functions.php';
if (!$user -> loggedIn())
{
	header('location: ../login.php');
	die();
}
if (!$user -> isAdmin())
{
	header('location: ../index.php');
	die();
}
if (!isset($_GET['id']))
{
	header('location: users.php');
	die();
}
$ID = intval($_GET['id']);
function selected($value, $compare)
{
	if ($compare == $value)
	{
		echo ' selected="selected"';
	}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title><?php echo $sn;?> | Edit</title>
<?php include '../includes/css.php'; ?>
</head>
<body>
<?php include '../includes/header.php';?>
<div id="content">
	<div class="container">
		<div class="row">
			<?php include '../includes/stats.php';?>
			<div class="span9">
				<div id="horizontal" class="widget widget-form">
	      			<div class="widget-header">	      				
	      				<h3>
	      					<i class="icon-pencil"></i>
	      					Edit User    					
      					</h3>	
      				</div> <!-- /widget-header -->
					<div class="widget-content">
						<?php
						if (isset($_POST['action']))
						{
							if ($_POST['action'] == 'Update')
							{
								$SQLUpdate = $odb -> prepare("UPDATE `users` SET `status` = :status, `rank` = :rank, `mbt` = :mbt, `expire` = :expire WHERE `ID` = :id");
								$SQLUpdate -> execute(array(':status' => $_POST['status'], ':rank' => $_POST['rank'], ':mbt' => intval($_POST['mbt']), ':expire' => strtotime("{$_POST['day']} {$_POST['month']} {$_POST['year']}"), ':id' => $ID));
								if (!empty($_POST['password']))
								{
									$SQLUpdatePassword = $odb -> prepare("UPDATE `users` SET `password` = :password WHERE `ID` = :id");
									$SQLUpdatePassword -> execute(array(':password' => hash('SHA512', $_POST['password']), ':id' => $ID));
								}
								$show -> showSuccess('User Updated');
							}
							else if ($_POST['action'] == 'Delete User')
							{
								$SQLDelete = $odb -> prepare("DELETE FROM `users` WHERE `ID` = :id");
								$SQLDelete -> execute(array(':id' => $ID));
								header('location: users.php');
							}
						}
						$SQLGetInfo = $odb -> prepare("SELECT * FROM `users` WHERE `ID` = :id");
						$SQLGetInfo -> execute(array(':id' => $ID));
						$ArrayInfo = $SQLGetInfo -> fetch(PDO::FETCH_ASSOC);
						$currentUsername = $ArrayInfo['username'];
						$currentStatus = $ArrayInfo['status'];
						$currentRank = $ArrayInfo['rank'];
						$currentMbt = $ArrayInfo['mbt'];
						$currentExpire = $ArrayInfo['expire'];
						?>
						<form class="form-horizontal" action="" method="POST">
					        <fieldset>
								<div class="control-group">
									<label class="control-label" for="input01">Username</label>
										<div class="controls">
										  <input type="text" value="<?php echo $currentUsername?>" class="input-large" name="username" readonly="readonly">
										  <p class="help-block">User Username</p>
										</div>
								</div>
								<div class="control-group">
									<label class="control-label" for="input01">Password</label>
									<div class="controls">
									  <input type="text" class="input-large" name="password">
									  <p class="help-block">New User Password</p>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label" for="input01">Max Boot Time</label>
									<div class="controls">
									  <input type="text" class="input-large" value="<?php echo $currentMbt?>" name="mbt">
									  <p class="help-block">Max Boot Time</p>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label" for="input01">Status</label>
									<div class="controls">
										<select name="status">
										<option value="0"<?php selected(0, $currentStatus); ?>>Active</option>
										<option value="1"<?php selected(1, $currentStatus); ?>>Banned</option>
										</select>
										<p class="help-block">User Status</p>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label" for="input01">Rank</label>
									<div class="controls">
										<select name="rank">
										<option value="0"<?php selected(0, $currentRank); ?>>Member</option>
										<option value="1"<?php selected(1, $currentRank); ?>>Admin</option>
										</select>
										<p class="help-block">User Rank</p>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label" for="input01">Expire</label>
									<div class="controls">
										Day:<br /> <select name="day">
										<?php
										for ($i = 1; $i <= 31; $i++)
										{
											$selected = (date('d', $currentExpire) == $i) ? ' selected="selected"' : '';
											echo '<option value="'.$i.'"'.$selected.'>'.$i.'</option>';
										}
										?>
										</select><br />
										Month: <br /><select name="month">
										<?php
										$month_names = array("January","February","March","April","May","June","July","August","September","October","November","December");
										foreach ($month_names as $month)
										{
											$selected = (date('F', $currentExpire) == $month) ? ' selected="selected"' : '';
											echo '<option value="'.$month.'"'.$selected.'>'.$month.'</option>';
										}
										?>
										</select><br />
										Year: <br /><select name="year">
										<?php
										for ($i = 2012; $i <= 2015; $i++)
										{
											$selected = (date('Y', $currentExpire) == $i) ? ' selected="selected"' : '';
											echo '<option value="'.$i.'"'.$selected.'>'.$i.'</option>';
										}
										?>
										</select>
										<p class="help-block">Account Expire</p>
									</div>
								</div>
								<div class="form-actions">
									<input type="submit" name="action" class="btn btn-primary btn-large" value="Update" />
									<input type="submit" name="action" class="btn btn-danger btn-large" value="Delete User" />
								</div>
					        </fieldset>
					      </form>	
					</div> <!-- /widget-content -->
						
				</div>	
			</div>
		</div>
	</div> <!-- /.container -->
</div> <!-- /#content -->
<?php include '../includes/footer.php';?>
  </body>
</html>
