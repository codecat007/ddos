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
	
if ($staff !== 'admin'){
exit();
}

if (isset($_POST['Submit'])){
	$sql = "SELECT id FROM users WHERE username='".mysql_real_escape_string(trim($_POST['user']))."'";
	$query = mysql_query($sql) or die(mysql_error());
	$count = mysql_num_rows($query);
	  
	if($count >= "1"){
		echo "This user is already in the database";
	}elseif(empty($_POST['user'])) {
		echo 'You didn\'t specify a username';
	}elseif ($_POST['type'] == 'selection') {
		echo 'You didn\'t specify an account type.';
	}elseif (($_POST['type'] !== 'admin') AND ($_POST['type'] !== 'customer')){
		echo 'Invalid account type.';
	}elseif (empty($_POST['trans_id'])) {
		echo 'You forgot to enter a transaction ID.';
	}elseif (empty($_POST['paypal'])) {
		echo 'You forgot to enter their paypal email.';
	}elseif (!is_numeric($_POST['months'])) {
		echo 'Invalid amount of months.';
	}else{
	
	$inputuser = mysql_real_escape_string(trim($_POST['user']));
	$inputtype = mysql_real_escape_string(trim($_POST['type']));
	$inputpass ="";
	for ($digit = 0; $digit < 10; $digit++) {
		$r = rand(0,2);
		if ($r == 0) {
			$cb = rand(65,90);
			$c = chr($cb);
		}else if ($r == 1) {
			$c = rand(0,9);
		}else {
			$cb = rand(97,122);
			$c = chr($cb);
		}
		$inputpass .= $c;
	}
	$dbpass = md5($inputpass);
	
	$transid = mysql_real_escape_string($_POST['trans_id']);
	$paypal = mysql_real_escape_string($_POST['paypal']);
	
	$varmonths = $_POST['months'];
	if ($varmonths == 0) {
		$months = 'lifetime';
	}else{
		$addmonths = $varmonths * 2592000;
		$time = time();
		$months = $time + $addmonths;
	}
	
	
	$sql="INSERT INTO users (username,password,staff,trans_id,paypal,months,active)VALUES ('$inputuser','$dbpass', '$inputtype', '$transid', '$paypal', '$months', 'activated')";
	mysql_query($sql) OR DIE(mysql_error());
	
	echo '<strong>' . $inputuser . '</strong> has been added to the database with the password: <strong>' . $inputpass . '</strong>.';
	}
	}//If Submit isset
	
	if(isset($_POST['delete'])){

$checkbox=$_POST['checkbox'];

//exit;

for($i=0;$i<count($checkbox);$i++){

$del_id = $checkbox[$i];
$sql = "DELETE FROM users WHERE id='$del_id'";
$result = mysql_query($sql);

}
echo 'Selected users have been deleted.';
}

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>

<META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=ISO-8859-1">

<script>

function selectAllCheckBoxes(FormName, FieldName, CheckValue)

{

	if(!document.forms[FormName])

		return;

	var objCheckBoxes = document.forms[FormName].elements[FieldName];

	if(!objCheckBoxes)

		return;

	var countCheckBoxes = objCheckBoxes.length;

	if(!countCheckBoxes)

		objCheckBoxes.checked = CheckValue;

	else

		// set the check value for all check boxes

		for(var i = 0; i < countCheckBoxes; i++)

			objCheckBoxes[i].checked = CheckValue;

}

</script>

</head>

<?php include("_top.php"); ?>
<form name="frmcontadd" action="" method="post">
<table width="50%" class="table" align="center">
  <tr>
    <td colspan="2" align="center" valign="middle" class="head"><div align="left"><strong>Add New:</strong></div></td>
  </tr>
  <tr>
    <td width="23%" align="right" class="cell" valign="middle"><strong>Username</strong></td>
    <td width="35%" valign="middle" class="cell" align="left"><input class="entryfield" name="user" type="text" id="user"></td>
  </tr>
  <tr>
    <td width="23%" align="right" class="cell" valign="middle"><strong>Transaction ID</strong></td>
    <td width="35%" valign="middle" class="cell" align="left"><input class="entryfield" name="trans_id" type="text" id="trans_id"></td>
  </tr>
  <tr>
    <td width="23%" align="right" class="cell" valign="middle"><strong>Paypal Email</strong></td>
    <td width="35%" valign="middle" class="cell" align="left"><input class="entryfield" name="paypal" type="text" id="paypal"></td>
  </tr>
  <tr>
    <td width="23%" align="right" class="cell" valign="middle"><strong>Paid Months (0 for lifetime)</strong></td>
    <td width="35%" valign="middle" class="cell" align="left"><input class="entryfield" name="months" type="text" id="months"></td>
  </tr>
  <tr>
    <td width="23%" align="right" class="cell" valign="middle"><strong>Type</strong></td>
    <td width="35%" valign="middle" class="cell" align="left"><select name="type">
												<option value="customer">Customer</option>
												<option value="admin">Admin</option>
												<option value="selection" selected>Select One...</option>
												</select>
</td>
  </tr>
  <tr>
    <td valign="middle" colspan="2" class="cell" align="left"><input class="button" type="submit" name="Submit" value="Submit"></td>
  </tr>
</table></form>
<p><br>
  
  </p>

<div align="center">
  <form name="form1" method="post" action="">

  <table width="90%" class="table">

    <tr>

      <td width="52"><div align="center" class="head"><strong>Select</strong></div></td>

      <td width="75"><div align="center" class="head"><strong>Username</strong></div></td>

      <td width="75"><div align="center" class="head"><strong>Type</strong></div></td>
	  
	  <td width="75"><div align="center" class="head"><strong>Paypal</strong></div></td>
	  
      <td width="125"><div align="center" class="head"><strong>Transaction ID</strong></div></td>
	  
      <td width="250"><div align="center" class="head"><strong>Payment Due</strong></div></td>
	  
	  <td width="250"><div align="center" class="head"><strong>Online</strong></div></td>

	  <td width="250"><div align="center" class="head"><strong>Status</strong></div></td>
	  
      </tr>

    <?php

$query="SELECT * FROM users";
$result=mysql_query($query);

while($row=mysql_fetch_array($result, MYSQL_ASSOC)){

$lastactive = $row['lastactive'];
$time = time();
$lasttime = $time - $lastactive;
if ($lasttime < 300) {
	$online = '<font color="green">Online</font>';
}else if (($lasttime > 300) AND ($lasttime < 600)) {
	$online = '<font color="yellow">Idle</font>';
}else{
	$online = '<font color="red">Offline</font>';
}

?>

    <tr>

      <td class="cell"><div align="center">
	  

        <input name="checkbox[]" type="checkbox" id="checkbox[]" value="<? echo $row['id']; ?>">

      </div></td>

      <td class="cell"><? echo "<a href=\"_view.php?user=" . $row['username'] . "\">" . $row['username'] . "</a>";?></td>

      <td class="cell"><? echo $row['staff'];?></td>
	  
	  <td class="cell"><? echo $row['paypal'];?></td>
	  
      <td class="cell"><? echo $row['trans_id'];?></td>

	  <?php if ($row['months'] !== 'lifetime'){
	  ?>
		<td class="cell" width="50%"><? echo date('d M Y H:i:s', $row['months']);?></td>
	  <? }else{ ?>
		<td class="cell"><? echo 'Never'; ?></td>
	 <? } ?>
	 
      <td class="cell"><? echo $online;?></td>
	  
      <td class="cell"><? if ($row['active'] == 'activated') { echo '<font color="green">Activated</font>'; }else{ echo '<font color="red">Deactivated</font>'; }?></td>

      </tr>

	<?	} ?>

    <tr>
      <td colspan="8" class="cell">

        <div align="left">

  <input name="delete" class="button" type="submit" id="delete" value="Delete">

&nbsp;&nbsp;

  <input type="button" class="button" onclick="selectAllCheckBoxes('form1', 'checkbox[]', true);" value="Select All">

&nbsp;&nbsp;

  <input type="button" class="button" onclick="selectAllCheckBoxes('form1', 'checkbox[]', false);" value="Clear All">

          </div></td>

    </tr>

  </table>
  </form>

</div>



  <tr><td height="14" colspan="8" >&nbsp;</td>

  </tr>

</body>

</html>
