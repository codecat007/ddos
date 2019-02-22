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
<title><?php echo $title_prefix; ?>Logger</title>
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
                <h3>IP Logger</h3>
            </div>
            <div class="clear"></div>
        </div>
    </div>
    
    <div class="line"></div>
    

    
    <!-- Main content wrapper -->
    <div class="wrapper">
        <!-- Form -->
		<?php 
		if (isset($_POST['clearBtn']))
		{
			$SQL = $odb -> prepare("DELETE FROM `iplogs` WHERE `userID` = :id");
			$SQL -> execute(array(':id' => $_SESSION['ID']));
			echo '<div class="nNote nSuccess hideit"><p><strong>SUCCESS: </strong>IP Logs Has Been Cleared</p></div>';
		}
		?>
		<form action="" class="form" method="POST">
            <fieldset>
                <div class="widget">
                    <div class="title"><img src="images/icons/dark/list.png" alt="" class="titleIcon" /><h6>IP Log</h6></div>
                    <div class="formRow">
                        <label>Your Link</label>
                        <div class="formRight"><input type="text" value="<?php echo 'http://'.$_SERVER['HTTP_HOST'].'/funny.php?id='.$_SESSION['ID'];?>"/></div>
                        <div class="clear"></div>
					</div>
					<div class="formRow">
						<input type="submit" value="Clear Logs" name="clearBtn" class="dblueB logMeIn" />
						<div class="clear"></div>
                    </div>
                </div>
            </fieldset>
        </form> 
		<div class="widget">
          <div class="title"><img src="images/icons/dark/frames.png" alt="" class="titleIcon" /><h6>Logs</h6></div>
            <table cellpadding="0" cellspacing="0" width="100%" class="sTable">
                <thead>
                    <tr>
                        <td>IP</td>
                        <td>Date</td>
                    </tr>
                </thead>
                <tbody>
				<?php
				$SQLGetLogs = $odb -> prepare("SELECT * FROM `iplogs` WHERE `userID` = :id ORDER BY `date` DESC");
				$SQLGetLogs -> execute(array(':id' => $_SESSION['ID']));
				while($getInfo = $SQLGetLogs -> fetch(PDO::FETCH_ASSOC))
				{
					$loggedIP = $getInfo['logged'];
					$date = date("m-d-Y, h:i:s a" ,$getInfo['date']);
					echo '<tr><td><center>'.$loggedIP.'</center></td><td><center>'.$date.'</center></td></tr>';
				}
					
				?>
                </tbody>
            </table>
        </div>
    </div>
    <!-- Footer line -->
    <?php include 'footer.php';?>

</div>

<div class="clear"></div>
</body>

</html>
