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
$localuser = $row['username'];

include("_top.php"); 

if (isset($_POST['Submit'])){
	if (!filter_var($_POST['friendip'], FILTER_VALIDATE_IP)){
		echo "The entered IP address is invalid.";
	}else{
		$addFriendIP = $_POST['friendip'];
		$addFriendNote = mysql_real_escape_string($_POST['friendnotes']);
		$friendSQL = "INSERT INTO friends (ip,notes,friend)VALUES ('$addFriendIP','$addFriendNote','$localuser')";
		mysql_query($friendSQL) or die(mysql_error());
		echo "Successfully added " . $addFriendIP . " to your friend list.";
	}
}

if(isset($_POST['delete'])){
	$checkbox=$_POST['checkbox'];
	for($i=0;$i<count($checkbox);$i++){
		$del_id = $checkbox[$i];
		$sql = "SELECT * FROM friends where id='$del_id'";
		$query = mysql_query($sql);
		$friendInfo = mysql_fetch_array($query, MYSQL_ASSOC);
		if ($friendInfo['friend'] == $localuser){
			$sql = "DELETE FROM friends WHERE id='$del_id'";
			$result = mysql_query($sql);
		}
	}
	echo 'Selected friends have been deleted.';
}
?>

<form name="friendlist" action="" method="post">
<table width="50%" class="table" align="center">
  <tr>
    <td colspan="2" align="center" valign="middle" class="head"><div align="left"><strong>Add New Friend:</strong></div></td>
  </tr>
  <tr>
    <td width="23%" align="right" class="cell" valign="middle"><strong>IP Address</strong></td>
    <td width="35%" valign="middle" class="cell" align="left"><input class="entryfield" name="friendip" type="text" id="friendip"></td>
  </tr>
  <tr>
    <td width="23%" align="right" class="cell" valign="middle"><strong>Notes</strong></td>
    <td width="35%" valign="middle" class="cell" align="left"><input class="entryfield" name="friendnotes" type="text" id="friendnotes"></td>
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

      <td width="10%"><div align="center" class="head"><strong>Select</strong></div></td>

      <td width="25%"><div align="center" class="head"><strong>IP Address</strong></div></td>

      <td width="65%"><div align="center" class="head"><strong>Notes</strong></div></td>	  
      </tr>

    <?php

$query="SELECT * FROM friends WHERE friend='$localuser'";
$result=mysql_query($query);

while($row=mysql_fetch_array($result, MYSQL_ASSOC)){

$friendip = $row['ip'];
$friendnotes = $row['notes'];

?>

    <tr>

      <td class="cell"><div align="center">

        <input name="checkbox[]" type="checkbox" id="checkbox[]" value="<? echo $row['id']; ?>">

      </div></td>

      <td class="cell"><?php echo $row['ip'];?></td>

      <td class="cell"><?php echo stripslashes($row['notes']);?></td>
	  
      </tr>

	<?	} ?>

    <tr>
      <td colspan="3" class="cell">

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



  <tr><td height="14" colspan="3" >&nbsp;</td>

  </tr>

</body>

</html>

