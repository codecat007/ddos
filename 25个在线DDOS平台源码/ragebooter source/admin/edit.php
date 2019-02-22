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
<title><?php echo $title_prefix; ?>Edit User</title>
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
                <h3>Edit User</h3>
            </div>
            <div class="clear"></div>
        </div>
    </div>
    
    <div class="line"></div>
    

    
    <!-- Main content wrapper -->
    <div class="wrapper">
       <?php 
	   if (isset($_POST['rBtn']))
	   {
		$sql = $odb -> prepare("DELETE FROM `users` WHERE `ID` = :id");
		$sql -> execute(array(':id' => $id));
		echo '<div class="nNote nSuccess hideit"><p><strong>SUCCESS: </strong>User has been removed redirecting in 2...</p></div><meta http-equiv="REFRESH" content="2;url=manage.php">';
	   }
	   if (isset($_POST['updateBtn']))
	   {
		$update = false;
		$errors = array();
		if ($username!= $_POST['username'])
		{
			if (ctype_alnum($_POST['username']) && strlen($_POST['username']) >= 4 && strlen($_POST['username']) <= 15)
			{
				$SQL = $odb -> prepare("UPDATE `users` SET `username` = :username WHERE `ID` = :id");
				$SQL -> execute(array(':username' => $_POST['username'], ':id' => $id));
				$update = true;
				$username = $_POST['username'];
			}
			else
			{
				$errors[] = 'Username has to be 4-15 characters in length and alphanumeric';
			}
		}
		if (!empty($_POST['password']))
		{
			$SQL = $odb -> prepare("UPDATE `users` SET `password` = :password WHERE `ID` = :id");
			$SQL -> execute(array(':password' => SHA1($_POST['password']), ':id' => $id));
			$update = true;
			$password = SHA1($_POST['password']);
		}
		if ($email != $_POST['email'])
		{
			if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
			{
				$SQL = $odb -> prepare("UPDATE `users` SET `email` = :email WHERE `ID` = :id");
				$SQL -> execute(array(':email' => $_POST['email'], ':id' => $id));
				$update = true;
				$email = $_POST['email'];
			}
			else
			{
				$errors[] = 'Email is invalid';
			}
		}
		if ($rank != $_POST['rank'])
		{
			$SQL = $odb -> prepare("UPDATE `users` SET `rank` = :rank WHERE `ID` = :id");
			$SQL -> execute(array(':rank' => $_POST['rank'], ':id' => $id));
			$update = true;
			$rank = $_POST['rank'];
		}
		if ($membership != $_POST['plan'])
		{
			if ($_POST['plan'] == 0)
			{
				$SQL = $odb -> prepare("UPDATE `users` SET `expire` = '0', `membership` = '0' WHERE `ID` = :id");
				$SQL -> execute(array(':id' => $id));
				$update = true;
				$membership = $_POST['plan'];
			}
			else
			{
				$getPlanInfo = $odb -> prepare("SELECT `unit`,`length` FROM `plans` WHERE `ID` = :plan");
				$getPlanInfo -> execute(array(':plan' => $_POST['plan']));
				$plan = $getPlanInfo -> fetch(PDO::FETCH_ASSOC);
				$unit = $plan['unit'];
				$length = $plan['length'];
				$newExpire = strtotime("+{$length} {$unit}");
				$updateSQL = $odb -> prepare("UPDATE `users` SET `expire` = :expire, `membership` = :plan WHERE `id` = :id");
				$updateSQL -> execute(array(':expire' => $newExpire, ':plan' => $_POST['plan'], ':id' => $id));
				$update = true;
				$membership = $_POST['plan'];
			}
		}
		if ($status != $_POST['status'])
		{
			$SQL = $odb -> prepare("UPDATE `users` SET `status` = :status WHERE `ID` = :id");
			$SQL -> execute(array(':status' => $_POST['status'], ':id' => $id));
			$update = true;
			$status = $_POST['status'];
		}
		if ($update == true)
		{
			echo '<div class="nNote nSuccess hideit"><p><strong>SUCCESS: </strong>Updated</p></div>';
		}
		else
		{
			echo '<div class="nNote nWarning hideit"><p><strong>UPDATE: </strong>Nothing updated</p></div>';
		}
		if (!empty($errors))
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
                    <div class="title"><img src="../images/icons/dark/list.png" alt="" class="titleIcon" /><h6>Edit User</h6></div>
                    <div class="formRow">
                        <label>Username</label>
                        <div class="formRight"><input name="username" type="text" value="<?php echo $username;?>" /></div>
                        <div class="clear"></div>
                    </div>
                    <div class="formRow">
                        <label for="labelFor">Password</label>
                        <div class="formRight"><input name="password" type="text" input type="text" value="" /></div>
                        <div class="clear"></div>
                    </div>
                    <div class="formRow">
                        <label>Email</label>
                        <div class="formRight"><input name="email" type="text" value="<?php echo htmlentities($email);?>" /></div>
                        <div class="clear"></div>
                    </div>
                    <div class="formRow">
                        <label>Rank</label>
                        <div class="formRight">
                            <select name="rank" >
							<?php
							function selectedR($check, $rank)
							{
								if ($check == $rank)
								{
									return 'selected="selected"';
								}
							}
							?>
                                <option value="0" <?php echo selectedR(0, $rank); ?> >User</option>
                                <option value="1" <?php echo selectedR(1, $rank); ?> >Admin</option>
                            </select>           
                        </div>             
                        <div class="clear"></div>
                    </div>
                    <div class="formRow">
                        <label>Membership</label>
                        <div class="formRight">
                            <select name="plan" >
							<option value="0">No Membership</option>
							<?php 
								$SQLGetMembership = $odb -> query("SELECT * FROM `plans`");
								while($memberships = $SQLGetMembership -> fetch(PDO::FETCH_ASSOC))
								{
									$mi = $memberships['ID'];
									$mn = $memberships['name'];
									$selectedM = ($mi == $membership) ? 'selected="selected"' : '';
									echo '<option value="'.$mi.'" '.$selectedM.'>'.$mn.'</option>';
								}
							?>
                            </select>           
                        </div>             
                        <div class="clear"></div>
                    </div>
                    <div class="formRow">
                        <label>Status</label>
                        <div class="formRight">
                            <select name="status" >
							<?php
							function selectedS($check, $rank)
							{
								if ($check == $rank)
								{
									return 'selected="selected"';
								}
							}
							?>
                                <option value="0" <?php echo selectedS(0, $status); ?>>Active</option>
                                <option value="1" <?php echo selectedS(1, $status); ?>>Banned</option>
                            </select>           
                        </div>             
                        <div class="clear"></div>
                    </div>
					<div class="formRow">
						<input type="submit" value="Update" name="updateBtn" class="dblueB logMeIn" />
						</form>
						<form action="" method="post" class="form"><input type="submit" value="Remove User" style="float:left;" name="rBtn" class="dredB logMeIn" /></form>
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
