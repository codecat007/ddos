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

$amount = 20;
	if (isset($_GET['user'])) {
		$userfilter = $_GET['user'];
		$csql = "SELECT * FROM logs WHERE user='$userfilter' ORDER BY id DESC";
		}else{
$csql = "SELECT * FROM logs ORDER BY id DESC"; }
$cres = mysql_query($csql) or die(mysql_error());
$totallogs = mysql_num_rows($cres);

if (empty($_GET['page'])){
$page = 1;
}else {
	if(is_numeric($_GET['page'])){
$page = $_GET['page'];
	}else{
$page = 1;
	}
}

$min = $amount * ( $page - 1 );
$max = $amount;


if (isset($_POST['prune'])) {

	$sql = "DELETE FROM logs WHERE time < now() - interval 1 hour";
	mysql_query($sql);
	
	echo 'Logs removed.';	

	}
	
	if(isset($_POST['delete'])){

//print_r($_POST);

$checkbox=$_POST['checkbox'];

//exit;

for($i=0;$i<count($checkbox);$i++){
$del_id = $checkbox[$i];
$sql = "DELETE FROM logs WHERE id='$del_id'";
$result = mysql_query($sql);

}
echo 'Selected logs were deleted from the database.';
}


?>





<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">

<html>

<head>

<title> Penalty Stresser - Log Management </title>

<META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=ISO-8859-1">

<META NAME="KEYWORDS" CONTENT="">

<META NAME="RATING" CONTENT="GENERAL">

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

  <table width="450" border="0" align="center" cellspacing="0">
  <tr>
    <td width="150" align="left"><?php 
	

	if( $page > 1){
	
	$previouspage = $page - 1;
if (!isset($_GET['user'])) {
echo "<input type=\"button\" onClick=\"window.location='_logs.php?page=".$previouspage."'\" class=\"button\" value=\"Next Page\" onFocus=\"if(this.blur)this.blur()\">";
}else{
echo "<input type=\"button\" onClick=\"window.location='_logs.php?page=".$previouspage."&user=".$_GET['user']."'\" class=\"button\" value=\"Next Page\" onFocus=\"if(this.blue)this.blur()\">";
} 
}
	?></td>
    <td width="150" align="center"><?php 
	
	$numofpages = ceil($totallogs / $amount); 
	echo "Page: " . $page . "/" . $numofpages;
	
	?></td>
    <td width="150" align="right"><?php 
	
if($page < $numofpages){ 
if(empty($_GET['page'])){ $page = "1";}
$pagenext = $page + 1;
if (!isset($_GET['user'])) {
echo "<input type=\"button\" onClick=\"window.location='_logs.php?page=".$pagenext."'\" class=\"button\" value=\"Next Page\" onFocus=\"if(this.blur)this.blur()\">";
}else{
echo "<input type=\"button\" onClick=\"window.location='_logs.php?page=".$pagenext."&user=".$_GET['user']."'\" class=\"button\" value=\"Next Page\" onFocus=\"if(this.blue)this.blur()\">";
} 
}




	?></td>
  </tr>
</table>

<div align="center">
  <form name="form1" method="post" action="">

  <table width="73%" class="table">

    <tr>

      <td class="head" width="52"><div align="center"><strong>Select</strong></div></td>
      <td class="head" width="172"><div align="center"><strong>User</strong></div></td>
      <td class="head" width="172"><div align="center"><strong>User IP</strong></div></td>
	  <td class="head" width="172"><div align="center"><strong>Target</strong></div></td>
	  <td class="head" width="172"><div align="center"><strong>Duration</strong></div></td>
	  <td class="head" width="172"><div align="center"><strong>Shells Used</strong></div></td>
	  <td class="head" width="172"><div align="center"><strong>Time</strong></div></td>

      </tr>

    <?php
	
	if (isset($_GET['user'])) {
		$hwidfilter = $_GET['user'];
		$query="SELECT * FROM logs WHERE user='$userfilter' ORDER BY id DESC LIMIT $min,$max";
		}else{
$query="SELECT * FROM logs ORDER BY id DESC LIMIT $min,$max";
}

$result=mysql_query($query);



$sno=1;

while($row=mysql_fetch_array($result, MYSQL_ASSOC)){

?>

    <tr>

      <td class="cell"><div align="center">

        <input name="checkbox[]" type="checkbox" id="checkbox[]" value="<? echo $row['id']; ?>">

      </div></td>

      <td class="cell"><? echo "<a href=\"_logs.php?user=" . $row['user'] . "\">" . $row['user'] . "</a>";?></td>
      <td class="cell"><? echo $row['ip'];?></td>
	  <td class="cell"><? echo $row['target'];?></td>
	  <td class="cell"><? echo $row['duration'] . ' seconds';?></td>
	  <td class="cell"><? echo $row['shells'] . '%';?></td>
	  <td class="cell"><? echo date("F j, Y, g:i a", $row['time']);?></td>

      </tr>

	<? } ?>

    <tr>

      <td class="cell">&nbsp;</td>

      <td colspan="6" class="cell">

        <div align="left">

  <input class="button" name="delete" type="submit" id="delete" value="Delete">

&nbsp;&nbsp;

  <input class="button" type="button" onclick="selectAllCheckBoxes('form1', 'checkbox[]', true);" value="Select All">

&nbsp;&nbsp;

  <input class="button" type="button" onclick="selectAllCheckBoxes('form1', 'checkbox[]', false);" value="Clear All">
  
&nbsp;&nbsp;

  <input class="button" name="prune" type="submit" id="prune" value="Prune">

          </div></td>

    </tr>

  </table>

  </form>

</div>



  <tr><td height="14" colspan="6" class="cell">&nbsp;</td>

  </tr>
 
  
</body>

</html>


