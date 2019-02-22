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
<title><?php echo $title_prefix; ?>Skype Resolver</title>
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
                <h3>Skype Resolver</h3>
            </div>
            <div class="clear"></div>
        </div>
    </div>
    
    <div class="line"></div>
    

    
    <!-- Main content wrapper -->
    <div class="wrapper">
        <!-- Form -->
		<?php
		$resolved = '';
		if (isset($_POST['resolveBtn']))
		{
			$name = $_POST['skypeName'];
			$resolved = @file_get_contents("http://momentumapi.info/skype.php?key=Z91x1GHoztbJftg6zvqm&name={$name}");
		}
		?>
		<form class="form" method="POST" action="">
            <fieldset>
                <div class="widget">
                    <div class="title"><img src="images/icons/dark/list.png" alt="" class="titleIcon" /><h6>Skype Resolver</h6></div>
                    <div class="formRow">
                        <label>Skype Name</label>
                        <div class="formRight"><input type="text" name="skypeName" value="<?php echo $name; ?>" id="skypeName"/></div>
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
