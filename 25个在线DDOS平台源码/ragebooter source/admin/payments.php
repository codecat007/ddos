<?php
ob_start();
require_once '../includes/db.php';
require_once '../includes/init.php';
if (!($user -> LoggedIn()))
{
	header('location: ../login.php');
	die();
}
if (!($user -> notBanned($odb)))
{
	header('location: login.php');
	die();
}
if (!($user -> isAdmin($odb)))
{
	die('You are not admin.');
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Fibre | Payments</title>
<?php include '../includes/cssAdmin.php';?>
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
                <h3>Payments</h3>
            </div>
            <div class="clear"></div>
        </div>
    </div>
    
    <div class="line"></div>
    

    
    <!-- Main content wrapper -->
    <div class="wrapper">
		<?php 
		if (isset($_POST['clearBtn']))
		{
			$SQL = $odb -> query("TRUNCATE `payments`");
			echo '<div class="nNote nSuccess hideit"><p><strong>SUCCESS: </strong>Payments have been cleared</p></div>';
		}
		?>
        <div class="widget">
          <div class="title"><img src="../images/icons/dark/frames.png" alt="" class="titleIcon" /><h6>Payments</h6><form action = "" method="post" class="form">
		  <input type="submit" style="margin-top: 4px; margin-right:4px;" value="Clear Logs" name="clearBtn" class="dblueB logMeIn" />
		  </form></div>
            <table cellpadding="0" cellspacing="0" width="100%" class="sTable">
                <thead>
                    <tr>
						<td>User</td>
                        <td>Plan</td>
						<td>Email</td>
						<td>Transaction ID</td>
						<td>Amount</td>
						<td>Date</td>
                    </tr>
                </thead>
                <tbody>
				<?php
				$SQLGetLogs = $odb -> query("SELECT `payments`.* , `plans`.`name` AS `planname`, `users`.`username` FROM `payments` LEFT JOIN `plans` ON `payments`.`plan` = `plans`.`ID` LEFT JOIN `users` ON `payments`.`user` = `users`.`ID` ORDER BY `ID` DESC");
				while($getInfo = $SQLGetLogs -> fetch(PDO::FETCH_ASSOC))
				{
					$user = $getInfo['username'];
					$plan = $getInfo['planname'];
					$email = $getInfo['email'];
					$tid = $getInfo['tid'];
					$amount = $getInfo['paid'];
					$date = date("m-d-Y, h:i:s a" ,$getInfo['date']);
					echo '<tr><td><center>'.$user.'</center></td><td><center>'.$plan.'</center></td><td><center>'.$email.'</center></td><td><center>'.$tid.'</center></td><td><center>$'.$amount.'</center></td><td><center>'.$date.'</center></td></tr>';
				}
					
				?>
                </tbody>
            </table>
        </div>
            
    </div>
    <!-- Footer line -->
    <?php include '../footer.php';?>

</div>

<div class="clear"></div>
</body>

</html>
