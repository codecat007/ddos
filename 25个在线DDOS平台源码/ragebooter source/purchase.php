<?php
ob_start();
require_once 'includes/db.php';
require_once 'includes/init.php';
if (!($user -> LoggedIn()))
{
	header('location: login.php');
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
<title><?php echo $title_prefix; ?>Purchase</title>
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
                <h3>Purchase</h3>
            </div>
            <div class="clear"></div>
        </div>
    </div>
    
    <div class="line"></div>
    

    
    <!-- Main content wrapper -->
    <div class="wrapper">
		<div class="widgets"><center>
		<?php
                        $newssql = $odb -> query("SELECT * FROM `plans` ORDER BY `price` ASC");
                        while($row = $newssql ->fetch())
                        {
				echo '<div class="widget" style="width: 275px; display:inline-block; clear: none; margin-right: 20px;">';
                                echo "<div class=\"title\"><h6>{$row['name']}</h6></div>";
				echo "<center><div style=\"width: 225px;\"><br />
<span class=\"left\"><b>Price:</b></span><span class=\"right\">\${$row['price']}</span><br />
<span class=\"left\"><b>Length:</b></span><span class=\"right\">{$row['length']} {$row['unit']}</span><br />
<span class=\"left\"><b>Max Boot Time:</b></span><span class=\"right\">{$row['mbt']} Seconds</span><br />
<center><b>Description:</b><br />{$row['description']}<br />
<a href=\"order.php?id={$row['ID']}\" title=\"\" class=\"wButton bluewB ml15 m10\"><span>Buy Now!</span></a></center>
</div></center>";
			echo "</div>";
                        }
                ?>
	<div class="clear"></div>
	</center></div>
    </div>
    <!-- Footer line -->
    <?php include 'footer.php';?>

</div>

<div class="clear"></div>
</body>

</html>
