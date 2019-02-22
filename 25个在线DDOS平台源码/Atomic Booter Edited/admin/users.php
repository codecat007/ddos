<?php

require_once "../core.php";

if (!isAdmin) redirect(BASE.'index.php');

require_once THEME."header.php";
require_once ADMIN_THEME."nav.php";

$page = isset($_GET['page']) ? mysql_real_escape_string($_GET['page']) : "";
$perpage = isset($_GET['perpage']) ? mysql_real_escape_string($_GET['perpage']) : "100";

$username = isset($_POST['username']) ? mysql_real_escape_string(trim($_POST['username'])) : "";
$password = isset($_POST['password']) ? trim($_POST['password']) : "";
$transaction = isset($_POST['transaction']) ? mysql_real_escape_string($_POST['transaction']) : "";
$email = isset($_POST['email']) ? mysql_real_escape_string(trim($_POST['email'])) : "";
$months = isset($_POST['months']) ? mysql_real_escape_string($_POST['months']) : "";
$level = isset($_POST['level']) ? mysql_real_escape_string($_POST['level']) : "";

opencontent("Create New User");

echo "<form action='users.php' method='post'>\n";
echo "<center>\n";

if (isset($_POST['Submit'])) {

	$check_user = mysql_query("SELECT * FROM users WHERE username='".$username."' LIMIT 1") or die(mysql_error());
	
	$errors = "";
	
	if (mysql_num_rows($check_user) == "1")
		$errors .= "This user is already in the database.<br />\n";

	if ($username == "")
		$errors .= "Please specify a username.<br />\n";
		
	if ($level != 1 && $level != 2)
		$errors .= "Please specify a valid account level.<br />\n";

	if ($email == "")
		$errors .= "Please specify a paypal email address.<br />\n";
	
	if (!is_numeric($_POST['months'])) {
		$errors .= "Please specify a valid number of months.<br />\n";
	}
	
	if ($errors == "") {
	
		if ($password == "")
			$password = substr(md5(time()), 0, 8);

	$expiretime = "0";
	
	if ($months != "0")
		$expiretime = time() + ($months * 2592000);
	
	$insert = mysql_query("INSERT INTO users (username, password, transaction, email, level, expiretime, joined)
		VALUES ('".$username."','".md5($password)."', '".$transaction."', '".$email."', ".$level.", '".$expiretime."', ".time().")") or die(mysql_error());
	echo "Successfully added <b>".$username."</b> to the database with the password: <b>".$password."</b><br /><br />\n";

	} else {
	
		echo "<span style='color: red;'>".$errors."<br /></span>\n";
	
	}

}

echo "</center>\n";
echo "<table cellpadding='5' cellspacing='5'>\n<tr>\n";
echo "<td>Username</td>\n";
echo "<td><input type='text' name='username' /></td>\n";
echo "</tr>\n<tr>\n";
echo "<td>Password (blank for random)</td>\n";
echo "<td><input type='text' name='password' /></td>\n";
echo "</tr>\n<tr>\n";
echo "<td>Transaction ID</td>\n";
echo "<td><input type='text' name='transaction' /></td>\n";
echo "</tr>\n<tr>\n";
echo "<td>Paypal Email</td>\n";
echo "<td><input type='text' name='email' /></td>\n";
echo "</tr>\n<tr>\n";
echo "<td>Paid Months</td>\n";
echo "<td>\n";
echo "<select name='months'>\n";
echo "<option value='1'>1 Month</option>\n";
echo "<option value='2'>2 Months</option>\n";
echo "<option value='3'>3 Months</option>\n";
echo "<option value='4'>4 Months</option>\n";
echo "<option value='0'>Lifetime</option>\n";
echo "</select>\n";
echo "</td>\n";
echo "</tr>\n<tr>\n";
echo "<td>Account Level</td>\n";
echo "<td>\n";
echo "<select name='level'>\n";
echo "<option value='1'>Customer</option>\n";
echo "<option value='2'>Admin</option>\n";
echo "</select>\n";
echo "</td>\n";
echo "</tr>\n<tr>\n";
echo "<td></td>\n";
echo "<td><input type='submit' name='Submit' value='Create User' /></td>\n";
echo "</tr>\n</table>\n</form>\n";

closecontent();

opencontent("Current Users");

echo "<form action='users.php' method='post' name='usersform'>\n";
echo "<center>\n";

if (isset($_POST['delete'])) {

	$checkbox = $_POST['checkbox'];

	for ($i = 0; $i < count($checkbox); $i++) {

		$todelete = $checkbox[$i];
		$delete = mysql_query("DELETE FROM users WHERE user_id = '".$todelete."' LIMIT 1") or die(mysql_error());

	}
	
	echo "Selected users have been removed.<br /><br />\n";

}

$user_count = mysql_num_rows(mysql_query("SELECT * FROM users"));
$active_count = mysql_num_rows(mysql_query("SELECT * FROM users WHERE banned = 0"));
$deactive_count = mysql_num_rows(mysql_query("SELECT * FROM users WHERE banned = 1"));
$online_count = mysql_num_rows(mysql_query("SELECT * FROM users WHERE ".time()." - lastvisit <= 250"));
$offline_count = mysql_num_rows(mysql_query("SELECT * FROM users WHERE ".time()." - lastvisit > 250"));

echo "<i>Total Users: ".$user_count." - Active Users: ".$active_count." - Banned Users: ".$deactive_count." - Online Users: ".$online_count." - Offline Users: ".$offline_count."</i><br /><br />\n";

if ($page == "") {
	$pagelim = 0;
	$page = 1;
} else { $pagelim = $page * $perpage - $perpage; }

$countlogs = mysql_num_rows(mysql_query("SELECT * FROM logs"));
$pagenum = round($countlogs / $perpage);

for ($i = 1; $i <= $pagenum; $i++) {
	
	if ($i != $page)
		echo "<a href='logs.php?page=".$i."&perpage=".$perpage."'>".$i."</a> ";
	else
		echo $i." ";
		
}

echo "</center>\n";
echo "<table cellpadding='5' cellspacing='5' style='text-align: center; font-size: 9px;'>\n<tr>\n";
echo "<td></td>
      <td>Username</td>
      <td>Level</td>
	  <td>Paypal</td>
      <td>Transaction ID</td>
      <td>Payment Due</td>
	  <td>Status</td>
	  <td>Active</td>
	</tr>";

$whereclause = "";

if ($user != "")
	$whereclause = " WHERE username = '".$user."'";

$user_query = mysql_query("SELECT * FROM users ORDER BY user_id ASC LIMIT ".$pagelim.", ".$perpage) or die(mysql_error());

while ($row = mysql_fetch_array($user_query)){

	if ($row['level'] == 2) $level = "Admin";
	else $level = "Customer";
	
	if ($row['expiretime'] != "0") $expires = showdate($row['expiretime'], "m/j/y g:i");
	else $expires = "Never";
	
	if ($row['lastvisit'] >= time() - 250) $status = "<span style='color: #00cc00;'>Online</span>";
	elseif ($row['lastvisit'] >= time() - 500) $status = "<span style='color: yellow;'>Idle</span>";
	else $status = "<span style='color: red;'>Offline</span>";
	
	if ($row['accepttos'] == 1) $toscheck = "<span style='color: #00cc00;'>Yes</span>";
	else $toscheck = "<span style='color: red;'>No</span>";
	
	echo "<tr>\n";
	echo "<td><input name='checkbox[]' type='checkbox' id='checkbox[]' value='".$row['user_id']."' /></td>\n";
	echo "<td><a href='".BASE."profile.php?id=".$row['user_id']."'>".$row['username']."</a></td>\n";
	echo "<td>".$level."</td>\n";
	echo "<td>".$row['email']."</td>\n";
	echo "<td>".$row['transaction']."</td>\n";
	echo "<td>".$expires."</td>\n";
	echo "<td>".$status."</td>\n";
	echo "<td>".$toscheck."</td>\n";
	echo "</tr>\n";

}

echo "<tr></tr>\n<tr>\n";
echo "<td style='vertical-align: middle;'><input type='checkbox' id='checkall' value='true' onchange=\"selectAllCheckBoxes('usersform', 'checkbox[]');\" /></td>\n";
echo "<td colspan='7' style='text-align: left;'>\n\n";
echo "<input name='delete' type='submit' id='delete' value='Delete' />\n";
echo "</td>\n";
echo "</tr>\n</table>\n";
echo "</form>\n";

echo "<script>

var CheckValue = true;

function selectAllCheckBoxes(FormName, FieldName) {
		

	if(!document.forms[FormName])
		return;

	var objCheckBoxes = document.forms[FormName].elements[FieldName];

	if(!objCheckBoxes)
		return;

	var countCheckBoxes = objCheckBoxes.length;
	
	if(!countCheckBoxes)
		objCheckBoxes.checked = CheckValue;
	else
		for(var i = 0; i < countCheckBoxes; i++)
			objCheckBoxes[i].checked = CheckValue;
			
	if (CheckValue == true)
		CheckValue = false;
	else
		CheckValue = true;

}

</script>";

closecontent();

require_once THEME."footer.php";

?>