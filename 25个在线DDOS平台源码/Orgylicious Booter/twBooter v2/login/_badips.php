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
set_time_limit(0);
ini_set('default_socket_timeout', 20); 

if(isset($_POST['delete'])){

//print_r($_POST);

$checkbox=$_POST['checkbox'];

//exit;

for($i=0;$i<count($checkbox);$i++){

$del_id = $checkbox[$i];

$sql = "DELETE FROM badips WHERE id='$del_id'";

$result = mysql_query($sql);

}
echo 'Selected IP addresses have been removed.';
}

if(isset($_POST['url']))
{
$theurl = trim($_POST['url']);
	$parseURL = parse_url($theurl);
	$ipaddr = gethostbyname($parseURL['host']);
	$hostname = gethostbyaddr($ipaddr);
	
		$sql = "SELECT id FROM badips WHERE ip='".mysql_real_escape_string($ipaddr)."'";
	$query = mysql_query($sql) or die(mysql_error());
	$count = mysql_num_rows($query);
	  
	if($count >= "1"){
	echo "This host is already in the database";
	}else {
			$sql_insert="INSERT INTO badips (host, ip, enteredhost)VALUES ('$hostname', '$ipaddr', '$theurl')";
			mysql_query($sql_insert);
				}
	}

?>





<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>

<title> Penalty Stresser - IP Blacklist Management </title>
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
<table width="50%" align="center" class="table">
  <tr>
    <td colspan="2" align="center" valign="middle" class="head"><div align="left"><strong>Add New:</strong></div></td>
  </tr>
  <tr>
    <td width="10%" class="cell" align="right" valign="middle"><strong>Domain or IP</strong></td>
    <td width="40%" class="cell" valign="middle" align="center"><input class="entryfield" name="url" type="text" value="http://" id="url"></td>
  </tr>
  <tr>
    <td align="right" class="cell" valign="middle">&nbsp;</td>
    <td valign="middle" class="cell" align="right"><i>MUST contain 'http://' for now.</i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input class="button" type="submit" name="Submit" value="Submit"></td>
  </tr>
</table></form>
<p><br>
  
  </p>
<p><br>
  <br>
    
</p>
<div align="center">
  <form name="form1" method="post" action="">

  <table width="73%" class="table">

    <tr>

      <td class="head" width="10"><div align="center"><strong>Select</strong></div></td>
      <td class="head" width="100"><div align="center"><strong>Domain</strong></div></td>
      <td class="head" width="75"><div align="center"><strong>Hostname</strong></div></td>
	  <td class="head" width="70"><div align="center"><strong>IP Address</strong></div></td>

      </tr>

    <?php


$query="SELECT * FROM badips";
$result=mysql_query($query);

while($row=mysql_fetch_array($result, MYSQL_ASSOC)){

?>

    <tr>

      <td class="cell"><div align="center">

        <input name="checkbox[]" type="checkbox" id="checkbox[]" value="<? echo $row['id']; ?>">

      </div></td>
	  <td class="cell"><? echo $row['enteredhost'];?></td>
	  <td class="cell"><? echo $row['host'];?></td>
	  <td class="cell"><? echo $row['ip'];?></td>
	  </tr>

	<?

	}

	?>

    <tr>

      <td class="cell">&nbsp;</td>

      <td class="cell" colspan="4">

        <div align="left">

  <input class="button" name="delete" type="submit" id="delete" value="Delete">

&nbsp;&nbsp;

  <input type="button" class="button" onclick="selectAllCheckBoxes('form1', 'checkbox[]', true);" value="Select All">

&nbsp;&nbsp;

  <input type="button" class="button" onclick="selectAllCheckBoxes('form1', 'checkbox[]', false);" value="Clear All">
     
          </div></td>

    </tr>

  </table>
  </form>

</div>



  <tr><td height="14" colspan="4" class="cell">&nbsp;</td>

  </tr>
  

</body>

</html>




