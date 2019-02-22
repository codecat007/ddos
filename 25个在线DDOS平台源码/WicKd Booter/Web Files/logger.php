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
<title><?php echo $sn;?> | Logger</title>
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
	      					Your Link 					
      					</h3>	
      				</div> <!-- /widget-header -->
					
					<div class="widget-content">
						<form class="form-horizontal" action="" method="POST">
					        <fieldset>
								<div class="control-group">
									<label class="control-label" for="input01">Link</label>
										<div class="controls">
										  <input value="<?php echo $url.'funny.php?id='.$_SESSION['ID'];?>" type="text" class="input-large">
									</div>
								</div>
					        </fieldset>
					      </form>	
					</div> <!-- /widget-content -->
				</div>	
					<form action="" method="post">
					<input type="submit" class="btn btn-danger" name="clearBtn" value="Clear Logs" />
					</form>
				<?php
					if (isset($_POST['clearBtn']))
					{
						$SQLClear = $odb -> prepare("DELETE FROM `iplogs` WHERE `userID` = :id");
						$SQLClear -> execute(array(':id' => $_SESSION['ID']));
						$show -> showSuccess('Logs have been cleared!');
					}
				?>
				<div class="widget widget-table">
					<div class="widget-content">
						<table class="table table-bordered table-striped">
					        <thead>
					          <tr>
					            <th>ID</th>
					            <th>IP</th>
					            <th>Date</th>
					          </tr>
					        </thead>
					        <tbody>
					         <?php
							 $SQLGetLogs = $odb -> prepare("SELECT * FROM `iplogs` WHERE `userID` = :user ORDER BY `ID` DESC");
							 $SQLGetLogs -> execute(array(':user' => $_SESSION['ID']));
							 while($ArrayInfo = $SQLGetLogs -> fetch(PDO::FETCH_ASSOC))
							 {
								$date = date("m-d-Y, h:i:s a", $ArrayInfo['time']);
								$IP = $ArrayInfo['IP'];
								$ID = $ArrayInfo['ID'];
								echo '<tr><td>'.$ID.'</td><td>'.$IP.'</td><td>'.$date.'</td></tr>';
							 }
							 ?>
					        </tbody>
					      </table>
					</div> <!-- /widget-content -->
				</div> <!-- /widget -->	
			</div>
	</div> <!-- /.container -->
</div> <!-- /#content -->
<?php include 'includes/footer.php';?>
  </body>
</html>
