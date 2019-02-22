<?php
include '../config.php';
include '../includes/functions.php';
if (!$user -> loggedIn())
{
	header('location: ../login.php');
	die();
}
if (!$user -> isAdmin())
{
	header('../index.php');
	die();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title><?php echo $sn;?> | Users</title>
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
	      					Add User      					
      					</h3>	
      				</div> <!-- /widget-header -->
					<div class="widget-content">
					<?php
					if (isset($_POST['addBtn']))
					{
						if (empty($_POST['username']) || empty($_POST['password']) || empty($_POST['mbt']))
						{
							$show -> showError('Please Fill In All Fields');
						}
						else
						{
							if (!ctype_alnum($_POST['username']) || (strlen($_POST['username']) < 4) || (strlen($_POST['username']) > 15))
							{
								$show -> showError('Username has to be alphanumeric and 4-15 characters in length');
							}
							else
							{
								$SQLCheckUsername = $odb -> prepare("SELECT COUNT(*) FROM `users` WHERE `username` = :username");
								$SQLCheckUsername -> execute(array(':username' => $_POST['username']));
								$usernameCount = $SQLCheckUsername -> fetchColumn(0);
								if ($usernameCount > 0)
								{
									$show -> showError('Username is already taken');
								}
								else
								{
									$SQLAddUser = $odb -> prepare("INSERT INTO `users` VALUES(NULL, :username, :password, 0, 0, :mbt, :expire)");
									$SQLAddUser -> execute(array(':username' => $_POST['username'], ':password' => hash('SHA512', $_POST['password']), ':mbt' => intval($_POST['mbt']), ':expire' => strtotime("{$_POST['day']} {$_POST['month']} {$_POST['year']}")));
									$show -> showSuccess('User has been added');
								}
							}
						}
					}
					?>
						<form class="form-horizontal" action="" method="POST">
							<fieldset>
								<div class="control-group">
									<label class="control-label" for="input01">Username</label>
										<div class="controls">
										  <input type="text" class="input-large" name="username">
										  <p class="help-block">User Username</p>
										</div>
								</div>
								<div class="control-group">
									<label class="control-label" for="input01">Password</label>
										<div class="controls">
										  <input type="text" class="input-large" name="password">
										  <p class="help-block">User Password</p>
										</div>
								</div>
								<div class="control-group">
									<label class="control-label" for="input01">Max Boot Time</label>
										<div class="controls">
										  <input type="text" class="input-large" name="mbt">
										  <p class="help-block">User Max Boot Time</p>
										</div>
								</div>
								<div class="control-group">
									<label class="control-label" for="input01">Expire</label>
									<div class="controls">
										Day:<br /> <select name="day">
										<?php
										for ($i = 1; $i <= 31; $i++)
										{
											echo '<option value="'.$i.'">'.$i.'</option>';
										}
										?>
										</select><br />
										Month: <br /><select name="month">
										<?php
										$month_names = array("January","February","March","April","May","June","July","August","September","October","November","December");
										foreach ($month_names as $month)
										{
											echo '<option value="'.$month.'">'.$month.'</option>';
										}
										?>
										</select><br />
										Year: <br /><select name="year">
										<?php
										for ($i = 2012; $i <= 2015; $i++)
										{
											echo '<option value="'.$i.'">'.$i.'</option>';
										}
										?>
										</select>
										<p class="help-block">Account Expire</p>
									</div>
								</div>
								<div class="form-actions">
									<input value="Add User" name="addBtn" type="submit" class="btn btn-primary btn-large" />
								</div>
					        </fieldset>
					      </form>	
					</div> <!-- /widget-content -->
				</div>
				<div class="widget widget-table">
					<div class="widget-content">
						<table class="table table-bordered table-striped">
					        <thead>
					          <tr>
					            <th>ID</th>
					            <th>Username</th>
								<th>Status</th>
					            <th>Rank</th>
								<th>Edit</th>
					          </tr>
					        </thead>
					        <tbody>
					         <?php
							 $SQLGetLogs = $odb -> query("SELECT * FROM `users` ORDER BY `ID` DESC");
							 while($ArrayInfo = $SQLGetLogs -> fetch(PDO::FETCH_ASSOC))
							 {
								$ID = $ArrayInfo['ID'];
								$username = $ArrayInfo['username'];
								$status = ($ArrayInfo['status'] == 0) ? 'Active' : 'Banned';
								$rank = ($ArrayInfo['rank'] == 0) ? 'Member' : 'Admin';
								echo '<tr><td>'.$ID.'</td><td>'.$username.'</td><td>'.$status.'</td><td>'.$rank.'</td><td><a href="edit.php?id='.$ID.'">Edit</a></td></tr>';
							 }
							 ?>
					        </tbody>
					      </table>
					</div> <!-- /widget-content -->
				</div> <!-- /widget -->	
			</div>
		</div>
	</div> <!-- /.container -->
</div> <!-- /#content -->
<?php include '../includes/footer.php';?>
  </body>
</html>
