<?php
ob_start();
require_once 'includes/db.php';
require_once 'includes/init.php';
if (!($user -> LoggedIn()))
{
	header('location: login.php');
	die();
}
if (!($user->hasMembership($odb)))
{
	header('location: purchase.php');
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
<title><?php echo $title_prefix; ?>DDoS Hub</title>
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
                <h3>HUB</h3>
            </div>
            <div class="clear"></div>
        </div>
    </div>
    
    <div class="line"></div>
    

    
    <!-- Main content wrapper -->
    <div class="wrapper">
        <!-- Form -->
		<?php
		if (isset($_POST['attackBtn']))
		{
			$host = $_POST['host'];
			$port = intval($_POST['port']);
			$time = intval($_POST['time']);
			$method = $_POST['method'];
			$errors = array();
			if (empty($host) || empty($time) || empty($port) || empty($method))
			{
				$errors[] = 'Please verify all fields';
			}
			if (!filter_var($host, FILTER_VALIDATE_IP))
			{
				$errors[] = 'Host is invalid';
			}
			$allowedMethods = array('UDP', 'SSYN');
			if (!in_array($method, $allowedMethods))
			{
				$errors[] = 'Method is invalid';
			}
			$SQLCheckBlacklist = $odb -> prepare("SELECT COUNT(*) FROM `blacklist` WHERE `IP` = :host");
			$SQLCheckBlacklist -> execute(array(':host' => $host));
			$countBlacklist = $SQLCheckBlacklist -> fetchColumn(0);
			if ($countBlacklist > 0)
			{
				$errors[] = 'IP was blacklisted by an admin';
			}
			if (empty($errors))
			{
				$checkRunningSQL = $odb -> prepare("SELECT COUNT(*) FROM `logs` WHERE `user` = :username  AND `time` + `date` > UNIX_TIMESTAMP()");
				$checkRunningSQL -> execute(array(':username' => $_SESSION['username']));
				$countRunning = $checkRunningSQL -> fetchColumn(0);
				if ($countRunning == 0)
				{
					$SQLGetTime = $odb -> prepare("SELECT `plans`.`mbt` FROM `plans` LEFT JOIN `users` ON `users`.`membership` = `plans`.`ID` WHERE `users`.`ID` = :id");
					$SQLGetTime -> execute(array(':id' => $_SESSION['ID']));
					$maxTime = $SQLGetTime -> fetchColumn(0);
					if (!($time > $maxTime))
					{
						$insertLogSQL = $odb -> prepare("INSERT INTO `logs` VALUES(:user, :ip, :port, :time, :method, UNIX_TIMESTAMP())");
						$insertLogSQL -> execute(array(':user' => $_SESSION['username'], ':ip' => $host, ':port' => $port, ':time' => $time, ':method' => $method));
						echo '<div class="nNote nSuccess hideit"><p><strong>SUCCESS: </strong>Attack has been sent to '.$host.':'.$port.' for '.$time.' seconds using '.$method.'</p></div>';
					}
					else
					{
						echo '<div class="nNote nFailure hideit"><p><strong>ERROR: </strong>Your max boot time is '.$maxTime.'</p></div>';
					}
				}
				else
				{
					echo '<div class="nNote nFailure hideit"><p><strong>ERROR: </strong>You currently have a boot running.  Please wait for it to be over.</p></div>';
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
		?>
        <form action="" class="form" method="POST">
            <fieldset>
                <div class="widget">
                    <div class="title"><img src="images/icons/dark/list.png" alt="" class="titleIcon" /><h6>DDoS Tool</h6></div>
                    <div class="formRow">
                        <label>Host</label>
                        <div class="formRight"><input type="text" maxlength = "15" name="host" /></div>
                        <div class="clear"></div>
                    </div>
                    <div class="formRow">
                        <label for="labelFor">Port</label>
                        <div class="formRight"><input type="text" name="port" value="" /></div>
                        <div class="clear"></div>
                    </div>
					<div class="formRow">
                        <label for="labelFor">Time</label>
                        <div class="formRight"><input type="text" name="time" value="" /></div>
                        <div class="clear"></div>
                    </div>
                    <div class="formRow">
                        <label>Method</label>
                        <div class="formRight">
                        	<input type="radio" name="method" id="method1" value="UDP" /><label for="method1">UDP</label>
                            <input type="radio" name="method" id="method2" value="SSYN" /><label for="method2">SSYN</label>
                        </div><div class="clear"></div>
                    </div>
					<div class="formRow">
						<input type="submit" value="DDoS" name="attackBtn" class="dblueB logMeIn" />
						<div class="clear"></div>
                    </div>
                </div>
            </fieldset>
        </form> 
		<?php 
		$resolved = '';
		$domain = '';
		if (isset($_POST['resolveBtn']))
		{
			$domain = $_POST['domain'];
			$resolved = gethostbyname($domain);
		}
		?>
		<form action="" class="form" method="POST">
            <fieldset>
                <div class="widget">
                    <div class="title"><img src="images/icons/dark/list.png" alt="" class="titleIcon" /><h6>Host To IP</h6></div>
                    <div class="formRow">
                        <label>Domain Name</label>
                        <div class="formRight"><input type="text" name="domain" value="<?php echo $domain; ?>"/></div>
                        <div class="clear"></div>
                    </div>
					<div class="formRow">
						<?php echo $resolved;?>
						<input type="submit" value="Resolve" name="resolveBtn" class="dblueB logMeIn" />
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
