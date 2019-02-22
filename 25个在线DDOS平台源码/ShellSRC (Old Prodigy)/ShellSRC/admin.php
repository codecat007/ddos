<?php 
include 'myaccount.php';

if(!checkAdmin()) {
header("Location: login.php");
exit();
}

$page_limit = 10; 


$host  = $_SERVER['HTTP_HOST'];
$host_upper = strtoupper($host);
$login_path = @ereg_replace('admin','',dirname($_SERVER['PHP_SELF']));
$path   = rtrim($login_path, '/\\');

// filter GET values
foreach($_GET as $key => $value) {
	$get[$key] = filter($value);
}

foreach($_POST as $key => $value) {
	$post[$key] = filter($value);
}

if($post['doBan'] == 'Ban') {

if(!empty($_POST['u'])) {
	foreach ($_POST['u'] as $uid) {
		$id = filter($uid);
		mysql_query("update users set banned='1' where id='$id' and `user_name` <> 'admin'");
	}
 }
 $ret = $_SERVER['PHP_SELF'] . '?'.$_POST['query_str'];;
 
 header("Location: $ret");
 exit();
}

if($_POST['doUnban'] == 'Unban') {

if(!empty($_POST['u'])) {
	foreach ($_POST['u'] as $uid) {
		$id = filter($uid);
		mysql_query("update users set banned='0' where id='$id'");
	}
 }
 $ret = $_SERVER['PHP_SELF'] . '?'.$_POST['query_str'];;
 
 header("Location: $ret");
 exit();
}

if($_POST['doDelete'] == 'Delete') {

if(!empty($_POST['u'])) {
	foreach ($_POST['u'] as $uid) {
		$id = filter($uid);
		mysql_query("delete from users where id='$id' and `user_name` <> 'admin'");
	}
 }
 $ret = $_SERVER['PHP_SELF'] . '?'.$_POST['query_str'];;
 
 header("Location: $ret");
 exit();
}

if($_POST['doApprove'] == 'Approve') {

if(!empty($_POST['u'])) {
	foreach ($_POST['u'] as $uid) {
		$id = filter($uid);
		mysql_query("update users set approved='1' where id='$id'");
		
	list($to_email) = mysql_fetch_row(mysql_query("select user_email from users where id='$uid'"));	
	 
	}
 }
 
 $ret = $_SERVER['PHP_SELF'] . '?'.$_POST['query_str'];	 
 header("Location: $ret");
 exit();
}

$rs_all = mysql_query("select count(*) as total_all from users") or die(mysql_error());
$rs_active = mysql_query("select count(*) as total_active from users where approved='1'") or die(mysql_error());
$rs_total_pending = mysql_query("select count(*) as tot from users where approved='0'");						   

list($total_pending) = mysql_fetch_row($rs_total_pending);
list($all) = mysql_fetch_row($rs_all);
list($active) = mysql_fetch_row($rs_active);


?>

<head>
<script language="JavaScript" type="text/javascript" src="js/jquery-1.3.2.min.js"></script>
</head>
<div class="content">
      <table width="80%" border="1" cellpadding="5" cellspacing="0" class="myaccount">
        <tr>
          <td><center>Total users: <?php echo $all;?></td>
          <td><center>Active users: <?php echo $active; ?></td>
          <td><center>Pending users: <?php echo $total_pending; ?></td>
        </tr>
      </table>
      <p>
	  
	  
	  <?php
if (isset($_GET['action'])) {
  if ($_GET['action'] == "newuser") {

?>

<hr>

      <h2><font color="#cccccc">Create A New User</font></h2>
      <table width="80%" border="0" cellpadding="5" cellspacing="2">
        <tr>
          <td><form name="form1" method="post" action="admin.php">
              <p>User ID 
                <input name="user_name" type="text" id="user_name">
                (Type the username)</p>
              <p>Email 
                <input name="user_email" type="text" id="user_email">
              </p>
              <p>User Level 
                <select name="user_level" id="user_level">
                  <option value="1">Normal User</option>
                  <option value="5">Administrator</option>
                </select>
              </p>
              <p>Password 
                <input name="pwd" type="text" id="pwd">
                (if empty a password will be auto generated)</p>
              <p> 
                <input name="send" type="checkbox" id="send" value="1" checked>
                Send Email</p>
              <p> 
                <input name="doSubmit" type="submit" id="doSubmit" value="Create">
              </p>
            </form>
            <p>**All created users will be approved by default.</p></td>
        </tr>
      </table>
	  
	  <hr>
	  
	  <?php
	    }
} 
	  ?>
	  
	  
	  <?php 
	  if(!empty($msg)) {
	  echo $msg[0];
	  }
	  ?></p>

	  <h2><font color="#cccccc">Search</font></h2>
      <table width="80%" border="0" align="center" cellpadding="10" cellspacing="0" >
        <tr>
          <td><form name="form1" method="get" action="admin.php">
              <p align="center">Search 
                <input name="q" type="text" id="q" size="40">
                <br>
                [Type email or user name] </p>
              <p align="center"> 
                <input type="radio" name="qoption" value="pending">
                Pending users 
                <input type="radio" name="qoption" value="recent">
                Recently registered 
                <input type="radio" name="qoption" value="banned">
                Banned users <br>
                <br>
                [You can leave search blank to if you use above options]</p>
              <p align="center"> 
                <input name="doSearch" type="submit" id="doSearch2" value="Search">
              </p>
              </form></td>
        </tr>
      </table>
	  <hr>
      <p>
        <?php if ($get['doSearch'] == 'Search') {
	  $cond = '';
	  if($get['qoption'] == 'pending') {
	  $cond = "where `approved`='0' order by date desc";
	  }
	  if($get['qoption'] == 'recent') {
	  $cond = "order by date desc";
	  }
	  if($get['qoption'] == 'banned') {
	  $cond = "where `banned`='1' order by date desc";
	  }
	  
	  if($get['q'] == '') { 
	  $sql = "select * from users $cond"; 
	  } 
	  else { 
	  $sql = "select * from users where `user_email` = '$_REQUEST[q]' or `user_name`='$_REQUEST[q]' ";
	  }

	  
	  $rs_total = mysql_query($sql) or die(mysql_error());
	  $total = mysql_num_rows($rs_total);
	  
	  if (!isset($_GET['page']) )
		{ $start=0; } else
		{ $start = ($_GET['page'] - 1) * $page_limit; }
	  
	  $rs_results = mysql_query($sql . " limit $start,$page_limit") or die(mysql_error());
	  $total_pages = ceil($total/$page_limit);
	  
	  ?>
	  
	  
      <p>Approve -&gt; A notification email will be sent to user notifying activation.<br>
        Ban -&gt; No notification email will be sent to the user. 
      <p><strong>*Note: </strong>Once the user is banned, he/she will never be 
        able to register new account with same email address. 
      <p align="right"> 
        <?php 
	  
	  // outputting the pages
		if ($total > $page_limit)
		{
		echo "<div><strong>Pages:</strong> ";
		$i = 0;
		while ($i < $page_limit)
		{
		
		
		$page_no = $i+1;
		$qstr = ereg_replace("&page=[0-9]+","",$_SERVER['QUERY_STRING']);
		echo "<a href=\"admin.php?$qstr&page=$page_no\">$page_no</a> ";
		$i++;
		}
		echo "</div>";
		}  ?>
		</p>
		<form name "searchform" action="admin.php" method="post">
        <table width="100%" border="0" align="center" cellpadding="2" cellspacing="0">
          <tr bgcolor="#666633"> 
            <td width="4%"><strong>ID</strong></td>
            <td> <strong>Date</strong></td>
            <td><div align="center"><strong>User Name</strong></div></td>
            <td width="24%"><strong>Email</strong></td>
            <td width="10%"><strong>Approval</strong></td>
            <td width="10%"> <strong>Banned</strong></td>
            <td width="25%">&nbsp;</td>
          </tr>
          <tr> 
            <td>&nbsp;</td>
            <td width="10%">&nbsp;</td>
            <td width="17%"><div align="center"></div></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <?php while ($rrows = mysql_fetch_array($rs_results)) {?>
          <tr> 
            <td><input name="u[]" type="checkbox" value="<?php echo $rrows['id']; ?>" id="u[]"></td>
            <td><?php echo $rrows['date']; ?></td>
            <td> <div align="center"><?php echo $rrows['user_name'];?></div></td>
            <td><?php echo $rrows['user_email']; ?></td>
            <td> <span id="approve<?php echo $rrows['id']; ?>"> 
              <?php if(!$rrows['approved']) { echo "Pending"; } else {echo "Active"; }?>
              </span> </td>
            <td><span id="ban<?php echo $rrows['id']; ?>"> 
              <?php if(!$rrows['banned']) { echo "no"; } else {echo "yes"; }?>
              </span> </td>
            <td> <font size="2"><a href="javascript:void(0);" onclick='$.get("do.php",{ cmd: "approve", id: "<?php echo $rrows['id']; ?>" } ,function(data){ $("#approve<?php echo $rrows['id']; ?>").html(data); });'>Approve</a> 
              <a href="javascript:void(0);" onclick='$.get("do.php",{ cmd: "ban", id: "<?php echo $rrows['id']; ?>" } ,function(data){ $("#ban<?php echo $rrows['id']; ?>").html(data); });'>Ban</a> 
              <a href="javascript:void(0);" onclick='$.get("do.php",{ cmd: "unban", id: "<?php echo $rrows['id']; ?>" } ,function(data){ $("#ban<?php echo $rrows['id']; ?>").html(data); });'>Unban</a> 
              <a href="javascript:void(0);" onclick='$("#edit<?php echo $rrows['id'];?>").show("slow");'>Edit</a> 
              </font> </td>
          </tr>
          <tr> 
            <td colspan="7">
			
			<div style="display:none;font: normal 11px arial; padding:10px; background: #e6f3f9" id="edit<?php echo $rrows['id']; ?>">
			
			<input type="hidden" name="id<?php echo $rrows['id']; ?>" id="id<?php echo $rrows['id']; ?>" value="<?php echo $rrows['id']; ?>">
			User Name: <input name="user_name<?php echo $rrows['id']; ?>" id="user_name<?php echo $rrows['id']; ?>" type="text" size="10" value="<?php echo $rrows['user_name']; ?>" >
			User Email:<input id="user_email<?php echo $rrows['id']; ?>" name="user_email<?php echo $rrows['id']; ?>" type="text" size="20" value="<?php echo $rrows['user_email']; ?>" >
			Level: <input id="user_level<?php echo $rrows['id']; ?>" name="user_level<?php echo $rrows['id']; ?>" type="text" size="5" value="<?php echo $rrows['user_level']; ?>" > 1->user,5->admin
			<br><br>New Password: <input id="pass<?php echo $rrows['id']; ?>" name="pass<?php echo $rrows['id']; ?>" type="text" size="20" value="" > (leave blank)
			<input name="doSave" type="button" id="doSave" value="Save" 
			onclick='$.get("do.php",{ cmd: "edit", pass:$("input#pass<?php echo $rrows['id']; ?>").val(),user_level:$("input#user_level<?php echo $rrows['id']; ?>").val(),user_email:$("input#user_email<?php echo $rrows['id']; ?>").val(),user_name: $("input#user_name<?php echo $rrows['id']; ?>").val(),id: $("input#id<?php echo $rrows['id']; ?>").val() } ,function(data){ $("#msg<?php echo $rrows['id']; ?>").html(data); });'> 
			<a  onclick='$("#edit<?php echo $rrows['id'];?>").hide();' href="javascript:void(0);">close</a>
		 
		  <div style="color:red" id="msg<?php echo $rrows['id']; ?>" name="msg<?php echo $rrows['id']; ?>"></div>
		  </div>
		  
		  </td>
          </tr>
          <?php } ?>
        </table>
	    <p><br>
          <input name="doApprove" type="submit" id="doApprove" value="Approve">
          <input name="doBan" type="submit" id="doBan" value="Ban">
          <input name="doUnban" type="submit" id="doUnban" value="Unban">
          <input name="doDelete" type="submit" id="doDelete" value="Delete">
          <input name="query_str" type="hidden" id="query_str" value="<?php echo $_SERVER['QUERY_STRING']; ?>">
          <strong>Note:</strong> If you delete the user can register again, instead 
          ban the user. </p>
        <p><strong>Edit Users:</strong> To change email, user name or password, 
          you have to delete user first and create new one with same email and 
          user name.</p>
      </form>
	  
	  <?php } ?>
      &nbsp;</p>
	  <?php
	  if($_POST['doSubmit'] == 'Create')
{
$rs_dup = mysql_query("select count(*) as total from users where user_name='$post[user_name]' OR user_email='$post[user_email]'") or die(mysql_error());
list($dups) = mysql_fetch_row($rs_dup);

if($dups > 0) {
	die("The user name or email already exists in the system");
	}

if(!empty($_POST['pwd'])) {
  $pwd = $post['pwd'];	
  $hash = PwdHash($post['pwd']);
 }  
 else
 {
  $pwd = GenPwd();
  $hash = PwdHash($pwd);
  
 }
 
mysql_query("INSERT INTO users (`user_name`,`user_email`,`pwd`,`approved`,`date`,`user_level`)
			 VALUES ('$post[user_name]','$post[user_email]','$hash','1',now(),'$post[user_level]')
			 ") or die(mysql_error()); 



$message = 
"Thank you for registering with us. Here are your login details...\n
User Email: $post[user_email] \n
Passwd: $pwd \n

*****LOGIN LINK*****\n
http://$host$path/login.php

Thank You

Administrator
$host_upper
______________________________________________________
THIS IS AN AUTOMATED RESPONSE. 
***DO NOT RESPOND TO THIS EMAIL****
";

if($_POST['send'] == '1') {

	mail($post['user_email'], "Login Details", $message,
    "From: \"Member Registration\" <auto-reply@$host>\r\n" .
     "X-Mailer: PHP/" . phpversion()); 
 }
echo "<div class=\"msg\">User created with password $pwd....done.</div>"; 
}

	  ?>
	  


    <td width="12%">&nbsp;</td>
  </tr>
</table>

<?php 
include 'footer.php';
?>