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

include("_top.php");

if (isset($_GET['user'])){
	$lookupuser = $_GET['user'];
	$sql = "SELECT * FROM users WHERE username='$lookupuser'";
	$result = mysql_query($sql);
	$count = mysql_num_rows($result);
}

if ((!isset($_GET['user'])) OR ($count < 1)){
	$sql = "SELECT * FROM users";
	$result = mysql_query($sql);
	
	?>

	<table width="50%" class="table" align="center">
		<tr>
			<td colspan="1" align="left" valign="middle" class="head"><div align="left"><strong>Username:</strong></div></td>
		</tr>
		<?php
		while($row=mysql_fetch_array($result, MYSQL_ASSOC)){
			?>
			<tr>
				<td class="cell"><? echo "<a href=\"_view.php?user=" . $row['username'] . "\">" . $row['username'] . "</a>";?></td>
			</tr>
			<?php
		}
		?>
	</table>
	<?php
}

if ((isset($_GET['user'])) AND ($count > 0)){
	$sql = "SELECT * FROM users WHERE username='$lookupuser'";
	$result = mysql_query($sql);
	$row = mysql_fetch_array($result);
	
	$lastactive = $row['lastactive'];
	$ipsused = explode("-", $row['loginip']);
	$time = time();
	$lasttime = $time - $lastactive;
	if ($lasttime < 300) {
		$online = '<font color="green">Online</font>';
	}else if (($lasttime > 300) AND ($lasttime < 600)) {
		$online = '<font color="yellow">Idle</font>';
	}else{
		$online = '<font color="red">Offline</font>';
	}
	if ($row['months'] == lifetime){
		$monthspaid = "Never";
	}else{
		$monthspaid = date('d M Y H:i:s', $row['months']);
	}
	if (isset($_POST['addmonths'])){
		if (!empty($_POST['months'])){
			if (is_numeric($_POST['months'])){
				$monthstoadd = $_POST['months'];
				if ($monthstoadd < 1){
					mysql_query("UPDATE users SET months='lifetime' WHERE username='$lookupuser'");
					echo "Successfully set " . $lookupuser . " to lifetime";
				}elseif ($monthstoadd > 0){
					$monthstoadd = $monthstoadd*2592000;
					mysql_query("UPDATE users SET months=months+'$monthstoadd' WHERE username='$lookupuser'");
					echo "Successfully added " . $_POST['months'] . " months to " . $lookupuser . "'s paid time.";
				}else{
					echo "Error.";
				}
			}else{
				echo "Months need to be numeric. If you're trying to set lifetime, use 0.";
			}
		}else{
			echo "You didn't enter anything.";
		}
	}
	?>
	<table width="50%" class="table" align="center">
		<tr>
			<td colspan="2" align="left" valign="middle" class="head"><div align="left"><strong>Stats for User: <? echo $lookupuser; ?></strong></div></td>
		</tr>
		<tr>
			<td colspan="1" align="right" valign="middle" class="cell"><div align="left"><strong>Status:</strong></td>
			<td colspan="1" align="left" valign="middle" class="cell"><div align="left"><?php echo $row['active']; ?></td>
		</tr>
		<tr>
			<td colspan="1" align="right" valign="middle" class="cell"><div align="left"><strong>Next Payment Due:</strong></td>
			<td colspan="1" align="left" valign="middle" class="cell"><div align="left"><?php echo $monthspaid; ?></td>
		</tr>
		<tr>
			<td colspan="1" align="right" valign="middle" class="cell"><div align="left"><strong>Activity:</strong></td>
			<td colspan="1" align="left" valign="middle" class="cell"><div align="left"><?php echo $online; ?></td>
		</tr>
		<tr>
			<td colspan="1" align="right" valign="middle" class="cell"><div align="left"><strong>Add Months:</strong></td>
			<form name="addmonths" action="" method="post">
			<td colspan="1" align="left" valign="middle" class="cell"><div align="left"><input class="entryfield" name="months" type="text" id="months">&nbsp;<input class="button" type="submit" name="addmonths" value="Submit"></td>
			</form>
		</tr>
	</table>
	
	<p><br>
  
	</p>
	
	<table width="50%" class="table" align="center">
		<tr>
			<td colspan="2" align="left" valign="middle" class="head"><div align="left"><strong>Logs</strong></div></td>
		</tr>
		<tr>
			<td colspan="1" align="center" valign="middle" class="cell"><div align="center"><? echo "<a href=\"_logs.php?user=" . $row['username'] . "\">View Logs</a>";?></div></td>
			<td colspan="1" align="center" valign="middle" class="cell"><div align="center"><? echo "<a href=\"_badlogs.php?user=" . $row['username'] . "\">View Bad Logs</a>";?></div></td>
		</tr>
	</table>
	
	<p><br>
  
	</p>
	
	<table width="50%" class="table" align="center">
		<tr>
			<td colspan="1" align="left" valign="middle" class="head"><div align="left"><strong>IP</strong></div></td>
			<td colspan="1" align="left" valign="middle" class="head"><div align="left"><strong>City<strong></div></td>
		</tr>
		<?php
		foreach ($ipsused as $ipused){
			$apiipurl = 'http://ipinfodb.com/ip_query.php?ip=' . $ipused . '&timezone=false';
			$page = @file_get_contents($apiipurl);
			$city = "/<City>(.*)<\/City>/U";
			$country = "/<CountryName>(.*)<\/CountryName>/U";
			$region = "/<RegionName>(.*)<\/RegionName>/U";
			preg_match($city, $page, $citymatch);
			preg_match($country, $page, $countrymatch);
			preg_match($region, $page, $regionmatch);
			if (empty($citymatch[1])){
				$citymatch[1] = "Unknown";
			}
			if (empty($countrymatch[1])){
				$countrymatch[1] = "Unknown";
			}
			if (empty($regionmatch[1])){
				$regionmatch[1] = "Unknown";
			}
			$match = $citymatch[1] . ', ' . $regionmatch[1] . ', ' . $countrymatch[1];
			?>
			<tr>
				<td colspan="1" align="left" valign="middle" class="cell"><div align="left"><strong><?php echo $ipused; ?></strong></div></td>
				<td colspan="1" align="left" valign="middle" class="cell"><div align="left"><strong><?php echo $match; ?></strong></div></td>
			</tr>
		<?php
		}
		?>
	</table>
<?php
}
?>