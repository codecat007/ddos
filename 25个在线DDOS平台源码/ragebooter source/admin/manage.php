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
<title><?php echo $title_prefix; ?>Manage Users</title>
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
                <h3>Users</h3>
            </div>
            <div class="clear"></div>
        </div>
    </div>
    
    <div class="line"></div>
    

    
    <!-- Main content wrapper -->
    <div class="wrapper">
       
        <div class="widget">
            <div class="title"><img src="../images/icons/dark/full2.png" alt="" class="titleIcon" /><h6>Users</h6></div>                          
            <table cellpadding="0" cellspacing="0" border="0" class="display dTable">
            <thead>
            <tr>
            <th>Username</th>
            <th>Email</th>
            <th>Rank</th>
            <th>Edit</th>
            </tr>
            </thead>
            <tbody>
			<?php 
			$SQLGetUsers = $odb -> query("SELECT * FROM `users` ORDER BY `ID` DESC");
			while ($getInfo = $SQLGetUsers -> fetch(PDO::FETCH_ASSOC))
			{
				$id = $getInfo['ID'];
				$user = $getInfo['username'];
				$email = $getInfo['email'];
				$rank = ($getInfo['rank'] == 1) ? 'Admin' : 'Member';
				echo '<tr class="gradeA"><td>'.$user.'</td><td>'.$email.'</td><td>'.$rank.'</td><td width="50px"><a href="edit.php?id='.$id.'"><button class="dblueB logMeIn">Edit</button></a></td></tr>';
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
