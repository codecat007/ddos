<?php
/**
 * UserInfo.php
 *
 * This page is for users to view their account information
 * with a link added for them to edit the information.
 *
 * Written by: Xbl Blue
 * Last Updated: March 2, 2011
 */
ini_set('display_errors', '0');     # don't show any errors...
error_reporting(E_ALL | E_STRICT);  # ...but do log them
#if php < 5 remove init_set and error reporting.

include("../core/session.php");
if($session->logged_in){
?>

<html>
<title>PhantaC User Info Panel</title>
<link href="../include/login.css" rel="stylesheet" type="text/css" />
<body>
<?php
/* Requested Username error checking */
$req_user = trim($_GET['user']);
if(!$req_user || strlen($req_user) == 0 ||
   !eregi("^([0-9a-z])+$", $req_user) ||
   !$database->usernameTaken($req_user)){
   die("Username not registered");
}

/* Logged in user viewing own account */
if(strcmp($session->username,$req_user) == 0){
   echo "<h1>My Account</h1>";
}
/* Visitor not viewing own account */
else{
   echo "<h1>User Info</h1>";
}

/* Display requested user information */
$req_user_info = $database->getUserInfo($req_user);

/* Username */
echo "<b>Username: ".$req_user_info['username']."</b><br>";

/* Email */
echo "<b>Email:</b> ".$req_user_info['email']."<br>";

/* Private Message */

//echo "<b>Private Message:</b>";
?>

   <!-- START OF Private Messaging form 
<div class="interactContainers" id= "private_message">
    <form action="javascript:sendPM();" name="pmForm" id ="pmForm" method="POST">
        <font size="+1">Sending Private Message to <strong><em><?php echo $req_user_info['username'] ?> </em></strong></font><br/><br/>
        Subject:
        <input name="pmSubject" id="pmSubject" type="text" maxlength="64" style="width:98%;"/>
        Message:
        <textarea name="pmTextArea" id="pmTextAread" rows="8" style="width:98%;"</textarea>
        <input name="pm_sender_id" id="pm_sender_id" type="hidden" value="<?php echo $session->userid; ?>"/>
        <input name="pm_sender_name" id="pm_sender_name" type="hidden" value="<?php echo $session->username; ?>"/>
        <input name="pm_rec_id" id="pm_rec_id" type="hidden" value="<?php echo $req_user_info['userid']; ?>"/>
        <input name="pm_rec_name" id="pm_rec_name" type="hidden" value="<?php echo $req_user_info['username']; ?>"/>
        <input name="pmWipit" id="pmWipit" type="hidden" value="<?php echo $thisRandNumb; ?>"/>
        <span id="PMStatus" style="color:#F00"></span>
        <br/><input name="pmSubmit" type="submit" value="Submit"/> or <a href="#" onclick="return false" onmousedown="javascript:toggleInteractioonContainers('private_message');">Close</a>
    </form>
</div>
   -->
   
  <?php


/**
 * Note: when you add your own fields to the users table
 * to hold more information, like homepage, location, etc.
 * they can be easily accessed by the user info array.
 *
 * $session->user_info['location']; (for logged in users)
 *
 * ..and for this page,
 *
 * $req_user_info['location']; (for any user)
 */

/* If logged in user viewing own account, give link to edit */
if(strcmp($session->username,$req_user) == 0){
   echo "<br><a href=\"useredit.php\">Edit Account Information</a><br>";
}

/* Link back to main */
echo "<br>Back To [<a href=\"../index.php\">Main</a>]<br>";
?>

</body>
</html>
<?php
} else {
Header("Location: ../index.php");
}
?>