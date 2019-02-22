<?php
ob_start();
include '../config.php';
include '../includes/functions.php';
if (!$user -> loggedIn())
{
	header('location: login.php');
	die();
}
if (!$user -> isAdmin())
{
	header('location: ../index.php');
	die();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title><?php echo $sn;?> | API</title>
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
					if (isset($_POST['updateBtn']))
					{
						$SQLUpdate = $odb -> prepare("UPDATE `settings` SET `API` = :api LIMIT 1");
						$SQLUpdate -> execute(array(':api' => $_POST['api']));
						$show -> showSuccess('API Link Updated');
					}
					$SQLGetAPI = $odb -> query("SELECT `API` FROM `settings` LIMIT 1");
					$APILink = $SQLGetAPI -> fetchColumn(0);
					?>
						<form class="form-horizontal" action="" method="POST">
					        <fieldset>
								<div class="control-group">
									<label class="control-label" for="input01">API Link</label>
										<div class="controls">
										  <input type="text" value="<?php echo $APILink?>" class="input-large" name="api">
										  <p class="help-block">API Link Format: http://example.com/ddos.php?host=[host]&port=[port]&time=[time]</p>
									</div>
								</div>
								<div class="form-actions">
									<input type="submit" name="updateBtn" class="btn btn-primary btn-large" value="Update" />
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
