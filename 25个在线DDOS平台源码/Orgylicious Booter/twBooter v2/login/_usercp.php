<?php
		//Start session
	session_start();
	//Check whether the session variable
	//SESS_MEMBER_ID is present or not
	include('includes/db.php');
	if(!isset($_SESSION['SESS_MEMBER_ID']) || (trim($_SESSION['SESS_MEMBER_ID'])=='')) {
		header("location: index.php");
		exit();
}

$query = "SELECT * FROM users WHERE id={$_SESSION['SESS_MEMBER_ID']}";
$result = mysql_query($query);
$row = mysql_fetch_array($result, MYSQL_ASSOC);

$staff = $row['staff'];
$bootallowed = $row['nextboot'];
$bootuser = $row['username'];
$password = $row['password'];
$months = $row['months'];
if ($months == 'lifetime'){
	$nextpay = 'Never';
}else{
	$nextpay = date('d M Y H:i:s', $row['months']);
}
$timenow = time();
$nextboot = $bootallowed - $timenow;
if ($nextboot < 0){
	$nextboot = 'Now';
}else{
	$nextboot = $nextboot . ' seconds';
}
	
include("_top.php");
include_once('includes/db.php');

?>
<title>twBooter - User Control Panel</title>

<form name="control" action="" method="post">
<table width="35%" align="center" class="table">
  <tr>
    <td colspan="2" align="center" class="head" valign="middle"><strong>User Control Panel</strong></td>
  </tr>
  <tr>
    <td colspan="1" class="cell" align="right" valign="middle"><strong>Username:</strong></td>
    <td colspan="1" class="cell" align="left" valign="middle"><strong><?php echo $bootuser; ?></strong></td>
  </tr>  
  <tr>
    <td colspan="1" class="cell" align="right" valign="middle"><strong>Next boot:</strong></td>
	<td colspan="1" class="cell" align="left" valign="middle"><strong><?php echo $nextboot; ?></strong></td>
  </tr>
  <tr>
    <td width="60%" class="cell" align="right" valign="middle"><strong>Next Payment Due:</strong></td>
	<td width="40%" class="cell" valign="middle" align="left"><? echo $nextpay; ?></td>	
  </tr>
</table></form>
<p><br>
  
  </p>

 <form name="booter" action="" method="post">
<table width="45%" align="center" class="table">
  <tr>
    <td colspan="2" class="head" align="center" valign="middle"><strong>Change Password: 
	<?php 
if (isset($_POST['change'])) {
	if (!empty($_POST['prevpass'])){
		if (!empty($_POST['newpass'])){
			if (!empty($_POST['newpass2'])){
				$prevpass = md5($_POST['prevpass']);
				$newpass = md5($_POST['newpass']);
				$newpass2 = md5($_POST['newpass2']);
				if ($prevpass == $password){
					if ($newpass == $newpass2){
						mysql_query("UPDATE users SET password='$newpass' WHERE username='$bootuser'") OR DIE(mysql_error());
						echo 'Password changed successfully.';
					}else{
						echo 'The two new passwords didn\'t match.';
					}
				}else{
					echo 'Current password is incorrect.';
				}
			}else{
				echo 'You didn\'t confirm your new password.';
			}
		}else{
			echo 'You didn\'t enter a new password.';
		}
	}else{
		echo 'You didn\'t enter your current password.';
	}
}else{
	echo '';
}
?>	
	
	
	</strong></td>
  </tr>
  <tr>
    <td colspan="1" align="right" class="cell" valign="middle">Current Password:</td>
	<td width="50%" class="cell" valign="middle" align="center"><input size="42" class="entryfield" name="prevpass" type="password" id="oldpass"></td>	
  </tr>
  <tr>
    <td colspan="1" align="right" class="cell" valign="middle">New Password:</td>
	<td width="50%" class="cell" valign="middle" align="center"><input size="42" class="entryfield" name="newpass" type="password" id="newpass"></td>	
  </tr>
  <tr>
    <td colspan="1" align="right" class="cell" valign="middle">Confirm New Password:</td>
	<td width="50%" class="cell" valign="middle" align="center"><input size="42" class="entryfield" name="newpass2" type="password" id="newpass2"></td>	
  </tr>
  <tr>
	<td colspan="2" class="cell" valign="right" align="right"><input type="submit" name="change" class="button" value="Change Password"></td>
  </tr>
  </table></form>
  
  <p><br>
  
  </p>