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
	die('You are not admin');
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo $title_prefix; ?>Gateway</title>
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
                <h3>News</h3>
            </div>
            <div class="clear"></div>
        </div>
    </div>
    
    <div class="line"></div>
    

    
    <!-- Main content wrapper -->
    <div class="wrapper">
       
        <!-- Form -->
		<?php
		if (isset($_POST['changeBtn']))
		{
			$paypalemail = $_POST['paypalemail'];
			$errors = array();
			if (empty($paypalemail))
			{
				$errors[] = 'Please verify all fields';
			}
			if (empty($errors))
			{
				$SQLinsert = $odb -> prepare("UPDATE `gateway` SET `email` = :newemail");
				$SQLinsert -> execute(array(':newemail' => $paypalemail));
				echo '<div class="nNote nSuccess hideit"><p><strong>SUCCESS: </strong>Gateway Changed!</p></div>';
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
                    <div class="title"><img src="../images/icons/dark/list.png" alt="" class="titleIcon" /><h6>Gateway Config:</h6></div>
                    <div class="formRow">
                        <label>Paypal Email</label>
                        <div class="formRight"><input type="text" name="paypalemail" maxlength="255" value="<?php $sql = $odb->query("SELECT `email` FROM `gateway` LIMIT 1"); echo $sql->fetchColumn(0); ?>" /></div>
                        <div class="clear"></div>
                    </div>
					<div class="formRow">
						<input type="submit" value="Change" name="changeBtn" class="dblueB logMeIn" />
						 <div class="clear"></div>
                    </div>
                </div>
            </fieldset>
		</form>
    </div>
    <!-- Footer line -->
    <?php include '../footer.php';?>

</div>

<div class="clear"></div>
</body>

</html>
