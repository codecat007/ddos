<?php
ob_start();
require_once '../includes/db.php';
require_once '../includes/init.php';
if (!($user -> LoggedIn()))
{
	header('location: ../login.php');
	die();
}
if (!($user -> isAdmin($odb)))
{
	die('You are not admin');
}
if (!($user -> notBanned($odb)))
{
	header('location: login.php');
	die();
}
if (!isset($_GET['id']))
{
	die('No ID Selected');
}
$id = $_GET['id'];
$SQLGetInfo = $odb -> prepare("SELECT * FROM `users` WHERE `ID` = :id LIMIT 1");
$SQLGetInfo -> execute(array(':id' => $_GET['id']));
$userInfo = $SQLGetInfo -> fetch(PDO::FETCH_ASSOC);
$username = $userInfo['username'];
$password = $userInfo['password'];
$email = $userInfo['email'];
$rank = $userInfo['rank'];
$membership = $userInfo['membership'];
$status = $userInfo['status'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo $title_prefix; ?> Add Shells</title>
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
                <h3>Add Shells</h3>
            </div>
            <div class="clear"></div>
        </div>
    </div>
    
    <div class="line"></div>
    

    
    <!-- Main content wrapper -->
    <div class="wrapper">
                    <div class="formRow">
                        <label>Shells</label>
                        <div class="formRight">
                            <?php if(isset($_POST['Submit'])) {
		$hosts = explode("\r\n", $_POST['url']);
		$values = array();
		foreach ($hosts as $host) 
		$values[] .= "('" . mysql_real_escape_string($host) . "')";
		$query = "INSERT INTO shells (url) VALUES " . implode(',', $values);
		$result = mysql_query($query) or die("mysql error " . mysql_error() . " in query $query");
		echo mysql_error();
		echo 'Added shells.';
	} ?>
				<form action="addshells.php" method="POST" class="valid">
								<textarea name="url" cols="80" rows="10"></textarea>
                        </div>             
                        <div class="clear"></div>
                    </div>
					<div class="formRow">
						<input type="submit" value="Update" name="Submit" class="dblueB logMeIn" />
						</form>
						<div class="clear"></div>
                    </div>
                    
                </div>
            </fieldset>
		
    </div>
    <!-- Footer line -->
    <?php include '../footer.php';?>

</div>

<div class="clear"></div>
</body>

</html>
