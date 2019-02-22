<?php

require_once "core.php";

if (!isMember) redirect('index.php');

require_once THEME."header.php";
require_once THEME."nav.php";

$id = isset($_GET['id']) ? $_GET['id'] : "";
$action = isset($_GET['action']) ? mysql_real_escape_string($_GET['action']) : "";
$folder = isset($_GET['folder']) ? mysql_real_escape_string($_GET['folder']) : "inbox";

if ($id != "" && (!preg_match('/[0-9]*/', $id) || $id < 1)) { header('Location: index.php'); die(); }

$inbox = mysql_query("SELECT * FROM messages WHERE `to` = ".$userinfo['user_id']." ORDER BY timestamp DESC") or die(mysql_error());
$outbox = mysql_query("SELECT * FROM messages WHERE `from` = ".$userinfo['user_id']." ORDER BY timestamp DESC") or die(mysql_error());

$userinbox = mysql_num_rows($inbox);
$useroutbox = mysql_num_rows($outbox);

opencontent("Message System");

echo "<form action='' method='post' id='msgform'>\n";

if ($action == "compose") {

	$to = isset($_REQUEST['to']) ? $_REQUEST['to'] : "";
	$all = isset($_POST['all']) ? $_POST['all'] : "0";
	$subject = isset($_POST['subject']) ? htmlentities($_POST['subject']) : "";
	$message = isset($_POST['message']) ? htmlentities(nl2br($_POST['message'])) : "";
	
	if ($to != "" && (!preg_match('/[0-9]*/', $to) || $to < 1)) redirect('index.php');
	$user_count = mysql_num_rows(mysql_query("SELECT * FROM users")) or die(mysql_error());

	echo "<a href='messages.php'>Back To Inbox</a><br /><br />\n\n";

	if ($user_count == 1) {
	
		echo "<center><span style='color: red;'>You must have more than one user before using the message system.</span></center><br />\n";
	
	} else {
	
		if ($to != "" && ($subject != "" || $message != "")) {
	
			$toinfo = mysql_fetch_array(mysql_query("SELECT * FROM users WHERE `user_id` = ".$to." LIMIT 1"));
			$toinbox = mysql_num_rows(mysql_query("SELECT * FROM messages WHERE `to` = ".$to." ORDER BY timestamp DESC"));
	
			$errors = "";
		
			if ($to == "")
				$errors .= "Please enter a recipient.<br />\n";
			elseif (!isAdmin && $toinfo['acceptpms'] == 0)
				$errors .= "This user does not accept private messages.<br /><br />\n";			
			elseif ((!isAdmin && $toinbox >= $settings['maxpms']) && $settings['maxpms'] > "0" && $all != 1)
				$errors .= "This user's inbox is currently full.<br /><br />\n";
			
			if ($all == "1" && !isAdmin)
				$errors .= "Please enter a valid recipient.<br />\n";
			
			if ($subject == "")
				$errors .= "Please enter a subject.<br />\n";
			
			if ($message == "")
				$errors .= "Please enter a message.<br />\n";
			
			$pmwaittime = $userinfo['nextpm'] - time();
	
			if ($pmwaittime > 0 && !isAdmin)
				$errors .= "You must wait ".$pmwaittime." more seconds.<br />\n";

			if ($errors == "") {
			
				if ($all == 1) {
			
					$user_list = mysql_query("SELECT * FROM users") or die(mysql_error());
				
					while ($sendto = mysql_fetch_array($user_list))
						$send = mysql_query("INSERT INTO messages (`to`, `from`, `subject`, `message`, `timestamp`) VALUES (".$sendto['user_id'].", ".$userinfo['user_id'].", '".$subject."', '".$message."', ".time().")") or die(mysql_error());

					echo "<center><span style='color: #00cc00;'>Sent message to all successfully.</span></center><br />\n";

				} else {
			
					$send = mysql_query("INSERT INTO messages (`to`, `from`, `subject`, `message`, `timestamp`) VALUES (".$to.", ".$userinfo['user_id'].", '".$subject."', '".$message."', ".time().")") or die(mysql_error());
					$update = mysql_query("UPDATE users SET nextpm = ".(time() + $settings['pmwaittime'])." WHERE user_id = ".$userinfo['user_id']." LIMIT 1") or die(mysql_error());
					echo "<center><span style='color: #00cc00;'>Sent message successfully.</span></center><br />\n";

				}
			
			} else {
		
				echo "<center><span style='color: red;'>".$errors."<br /><span></center>\n";
			
				echo "<table cellpadding='5' cellspacing='5'>\n";
				echo "<tr>\n";
				echo "<td>Recipient</td><td>\n";
				echo "<select name='to'>\n";

				if (isAdmin)
					$user_query = mysql_query("SELECT * FROM users WHERE user_id != ".$userinfo['user_id']." ORDER BY username ASC") or die(mysql_error());
				else
					$user_query = mysql_query("SELECT * FROM users WHERE acceptpm = 1 AND user_id != ".$userinfo['user_id']." ORDER BY username ASC") or die(mysql_error());

				while ($user = mysql_fetch_array($user_query)) {
					if ($to == $user['user_id'])
						echo "<option value='".$user['user_id']."' selected='selected'>".$user['username']."</option>\n";
					else
						echo "<option value='".$user['user_id']."'>".$user['username']."</option>\n";
				}
	
				echo "</select>\n";
			
				if (isAdmin) echo "<input type='checkbox' name='all' value='1' /> Send To All\n";
			
				echo "</td>\n";
				echo "</tr>\n";
				echo "<tr>\n";
				echo "<td>Subject</td><td><input type='text' maxlength='75' name='subject' value='".$subject."' style='width: 350px;' /></td>\n";
				echo "</tr>\n";
				echo "<tr>\n";
				echo "<td>Message</td><td><textarea style='width: 350px; height: 200px;' name='message'>".$message."</textarea></td>\n";
				echo "</tr>\n";
				echo "<tr>\n";
				echo "<td></td><td><input type='submit' value='Send Message' /></td>\n";
				echo "</tr>\n";
				echo "</table>\n";
				echo "</form>\n";
		
			}
	
		} else {

			echo "<table cellpadding='5' cellspacing='5'>\n";
			echo "<tr>\n";
			echo "<td>Recipient</td><td>\n";
			echo "<select name='to'>\n";
	
			$user_query = mysql_query("SELECT * FROM users WHERE acceptpm = 1 AND user_id != ".$userinfo['user_id']." ORDER BY username ASC") or die(mysql_error());

				while ($user = mysql_fetch_array($user_query)) {
					if ($to == $user['user_id'])
						echo "<option value='".$user['user_id']."' selected='selected'>".$user['username']."</option>\n";
					else
						echo "<option value='".$user['user_id']."'>".$user['username']."</option>\n";
				}
	
			echo "</select>\n";
		
			if (isAdmin) echo "<input type='checkbox' name='all' value='1' /> Send To All\n";
		
			echo "</td>\n";
			echo "</tr>\n";
			echo "<tr>\n";
			echo "<td>Subject</td><td><input type='text' maxlength='75' name='subject' style='width: 250px;' /></td>\n";
			echo "</tr>\n";
			echo "<tr>\n";
			echo "<td>Message</td><td><textarea style='width: 250px;' name='message'></textarea></td>\n";
			echo "</tr>\n";
			echo "<tr>\n";
			echo "<td></td><td><input type='submit' value='Send Message' /></td>\n";
			echo "</tr>\n";
			echo "</table>\n";
			echo "</form>\n";

		}

	}

} elseif ($action == "read") {

	if ($id == "") jsredirect('index');
	$msg_query = mysql_query("SELECT * FROM messages WHERE id = ".$id." AND `to` = ".$userinfo['user_id']." LIMIT 1") or die(mysql_error());
	
	if (mysql_num_rows($msg_query) == 0) redirect('index.php');

	$update = mysql_query("UPDATE messages SET `read` = 1 WHERE id = ".$id." AND `to` = ".$userinfo['user_id']." LIMIT 1") or die(mysql_error());
	$msg = mysql_fetch_array($msg_query);

	echo "<a href='messages.php'>Back To Inbox</a><br /><br />\n\n";

	echo "<table cellpadding='5' cellspacing='5'>\n";
	echo "<tr>\n";
	echo "<td><i>".$msg['subject']."</i></td>\n";
	echo "</tr>\n<tr>\n";
	echo "<td style='font-size: 10px;'><i><a href='profile.php?id=".$msg['from']."' title='View Profile'>".getuserbyid($msg['from'])."</a></i></td>\n";
	echo "</tr>\n<tr>\n";
	echo "<td><br /><div style='text-align: left; border: 1px solid #ccc; padding: 20px;'>".html_entity_decode($msg['message'])."</div></td>\n";
	echo "</tr>\n";
	echo "</table>\n";
	echo "</form>\n";
	
	closecontent();
	opencontent("Reply");
	
	$newsubject = (!strstr($msg['subject'], "RE: ") ? "RE: " : "").$msg['subject'];
		
	echo "<form action='messages.php?action=compose' method='post'>\n";
	echo "<table cellpadding='5' cellspacing='5'>\n";
	echo "<tr>\n";
	echo "<td>Recipient</td><td>\n";
	echo getuserbyid($msg['from'])." <input type='hidden' name='to' value='".$msg['from']."' />\n";
	echo "</td>\n";
	echo "</tr>\n";
	echo "<tr>\n";
	echo "<td>Subject</td>\n";
	echo "<td>".$newsubject." <input type='hidden' name='subject' value='".$newsubject."' /></td>\n";
	echo "</tr>\n";
	echo "<tr>\n";
	echo "<td>Message</td><td><textarea style='width: 250px;' name='message'></textarea></td>\n";
	echo "</tr>\n";
	echo "<tr>\n";
	echo "<td></td><td><input type='submit' value='Send Message' /></td>\n";
	echo "</tr>\n";
	echo "</table>\n";
	echo "</form>\n";
	
	closecontent();

} else {

	echo "<a href='messages.php?action=compose' title='Compose New Message'>Compose</a> &nbsp;&nbsp; | &nbsp;&nbsp;\n";

	if ($folder == "inbox")
		echo "Inbox [".$userinbox."/".$settings['maxpms']."] - <a href='messages.php?folder=outbox' title='Outbox'>Outbox [".$useroutbox."]</a>\n";
	else
		echo "<a href='messages.php?folder=inbox' title='Inbox'>Inbox [".$userinbox."/".$settings['maxpms']."]</a> - Outbox [".$useroutbox."]\n";

	if (isset($_POST['delete'])) {

		$checkbox = $_POST['checkbox'];

		for ($i = 0; $i < count($checkbox); $i++) {

			$todelete = $checkbox[$i];
			$delete = mysql_query("DELETE FROM messages WHERE id = '".$todelete."' AND `to` = ".$userinfo['user_id']." LIMIT 1") or die(mysql_error());

		}
	
		echo "<br /><br />Selected messages have been deleted.<br /><br />\n";

	} else {

		echo "<table cellpadding='5' cellspacing='5'>\n";
		echo "<tr>\n";
		echo "<td></td>\n";
		echo "<td>Subject</td>\n";

		if ($folder == "inbox")
			echo "<td>From</td>\n";
		else
			echo "<td>To</td>\n";
	
		echo "<td>Time Sent</td>\n";
		echo "</tr>\n";

		if ($folder == "inbox") {

			if ($userinbox == 0) {

				echo "<tr>\n";
				echo "<td colspan='4'>You have not received any messages yet.</td>\n";
				echo "</tr>\n";

			} else {
	
				while ($msg = mysql_fetch_array($inbox)) {

					echo "<tr>\n";
					echo "<td><input name='checkbox[]' type='checkbox' id='checkbox[]' value='".$msg['id']."' /></td>\n";

					if ($msg['read'] == 0)
						echo "<td><a href='messages.php?action=read&id=".$msg['id']."' title='Read Message'>".$msg['subject']."</a></td>\n";
					else
						echo "<td><a href='messages.php?action=read&id=".$msg['id']."' title='Read Message' style='font-weight: normal;'>".$msg['subject']."</a></td>\n";

					echo "<td><a href='profile.php?id=".$msg['from']."' title='View Profile'>".getuserbyid($msg['from'])."</a></td>\n";
					echo "<td>".showdate($msg['timestamp'])."</td>\n";
					echo "</tr>\n";

				}
				
				echo "<tr></tr>\n<tr>\n";
				echo "<td style='vertical-align: middle;'><input type='checkbox' id='checkall' value='true' onchange=\"selectAllCheckBoxes('msgform', 'checkbox[]');\" /></td>\n";
				echo "<td colspan='7' style='text-align: left;'>\n\n";
				echo "<input name='delete' type='submit' id='delete' value='Delete' />\n";
				echo "</td>\n";
				echo "</tr>\n";
		
			}
	
		} else {

			if ($useroutbox == 0) {

				echo "<tr>\n";
				echo "<td colspan='4'>You have not sent any messages yet.</td>\n";
				echo "</tr>\n";

			} else {

				while ($msg = mysql_fetch_array($outbox)) {

					echo "<tr>\n";
					echo "<td></td>\n";
					echo "<td><a href='messages.php?action=read&id=".$msg['id']."' title='Read Message'>".$msg['subject']."</a></td>\n";
					echo "<td><a href='profile.php?id=".$msg['to']."' title='View Profile'>".getuserbyid($msg['to'])."</a></td>\n";
					echo "<td>".showdate($msg['timestamp'])."</td>\n";
					echo "</tr>\n";
		
				}

			}

		}

		echo "</table>\n";
		echo "</form>\n";
		
	}
	
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

}

closecontent();

require_once THEME."footer.php";

?>