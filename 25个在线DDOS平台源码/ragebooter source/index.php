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
<title><?php echo $title_prefix; ?>Dashboard</title>
<?php include 'includes/css.php';?>
<style type="text/css">
.right {
        float: right;
}
.left {
        float: left;
}
</style>
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
                <h3>Dashboard</h3>
            </div>
            <div class="clear"></div>
        </div>
    </div>
    
    <div class="line"></div>
    
    <!-- Page statistics and control buttons area -->
    <div class="statsRow">
        <div class="wrapper">
        	<div class="controlB">
            	<ul>
                	<li><a title=""><span style="font-size: 2em;">3</span><span>Servers Online</span></a></li>
               		<li><a title=""><span style="font-size: 2em;"><?php echo $stats -> totalBoots($odb); ?></span><span>Total Boots</span></a></li>
			<li><a title=""><span style="font-size: 2em;"><?php echo $stats -> totalBootsForUser($odb, $_SESSION['username']); ?></span><span>Users Total Boots</span></a></li>
			<li><a title=""><span style="font-size: 2em;"><?php echo $stats -> totalUsers($odb); ?></span><span>Total Users</span></a></li>
			<li><a title=""><span style="font-size: 2em;"><?php echo $stats -> runningBoots($odb); ?></span><span>Boots Running</span></a></li>
                </ul>
                <div class="clear"></div>
            </div>
        </div>
    </div>
    
    <div class="line"></div>
    
    <!-- Main content wrapper -->
    <div class="wrapper">
    <div class="twoOne"><div class="widget">
            <ul class="tabs">
		<?php
			$newssql = $odb -> query("SELECT `ID`,`title` FROM `news` ORDER BY `date` DESC LIMIT 5");
			while($row = $newssql ->fetch())
			{
				echo "<li><a href=\"#tab".$row['ID']."\">".$row['title']."</a></li>";
			}
		?>	
            </ul>

            <div class="tab_container">
                <?php
                        $newssql = $odb -> query("SELECT `ID`,`detail`,`date` FROM `news` ORDER BY `date` DESC LIMIT 5");
                        while($row = $newssql ->fetch())
                        {
                                echo "<div id=\"tab".$row['ID']."\" class=\"tab_content\">".$row['detail']."<br /><br /><b>On ".date("m-d-Y" ,$row['date'])."</b></div>";
                        }
                ?>
            </div>
            <div class="clear"></div>
        </div></div>
	<div class="oneThree"><div class="widget">
                	<div class="title"><h6>Membership Info</h6></div>
			<center><div style="width: 90%;"><br />
			<?php
			$plansql = $odb -> prepare("SELECT `users`.`expire`, `plans`.`name`, `plans`.`mbt` FROM `users`, `plans` WHERE `plans`.`ID` = `users`.`membership` AND `users`.`ID` = :id");
			$plansql -> execute(array(":id" => $_SESSION['ID']));
			$row = $plansql -> fetch(); ?>
			<span class="left"><b>Name:</b></span><span class="right"><?php echo $row['name']; ?></span><br />
			<span class="left"><b>Expire:</b></span><span class="right"><?php echo date("m-d-Y, h:i:s a", $row['expire']); ?></span><br />
			<span class="left"><b>Max Boot Time:</b></span><span class="right"><?php echo $row['mbt']; ?></span><br />
                </div></center><br /></div></div>
    </div>
    
    <!-- Footer line -->
    <?php include 'footer.php';?>

</div>

<div class="clear"></div>
</body>

</html>
