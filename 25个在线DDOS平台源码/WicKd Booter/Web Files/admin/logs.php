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
<title><?php echo $sn;?> | Logs</title>
<?php include '../includes/css.php'; ?>
</head>
<body>
<?php include '../includes/header.php';?>
<div id="content">
	<div class="container">
		<div class="row">
			<?php include '../includes/stats.php';?>
			<div class="span9">
					<form action="" method="post">
					<input type="submit" class="btn btn-danger" name="clearBtn" value="Clear Logs" />
					</form>
				<?php
					if (isset($_POST['clearBtn']))
					{
						$SQLClear = $odb -> query("TRUNCATE `logs`");
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
								<th>Port</th>
								<th>Time</th>
					            <th>Date</th>
					          </tr>
					        </thead>
					        <tbody>
					         <?php
							 $SQLGetLogs = $odb -> query("SELECT * FROM `logs` ORDER BY `ID` DESC");
							 while($ArrayInfo = $SQLGetLogs -> fetch(PDO::FETCH_ASSOC))
							 {
								$date = date("m-d-Y, h:i:s a", $ArrayInfo['date']);
								$port = $ArrayInfo['port'];
								$time = $ArrayInfo['time'];
								$IP = $ArrayInfo['ip'];
								$ID = $ArrayInfo['ID'];
								echo '<tr><td>'.$ID.'</td><td>'.$IP.'</td><td>'.$port.'</td><td>'.$time.'</td><td>'.$date.'</td></tr>';
							 }
							 ?>
					        </tbody>
					      </table>
					</div> <!-- /widget-content -->
				</div> <!-- /widget -->	
			</div>
	</div> <!-- /.container -->
</div> <!-- /#content -->
<?php include '../includes/footer.php';?>
  </body>
</html>
