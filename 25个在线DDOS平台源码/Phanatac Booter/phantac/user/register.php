<?php
/**
 * Register.php
 * 
 * Displays the registration form if the user needs to sign-up,
 * or lets the user know, if he's already logged in, that he
 * can't register another name.
 *
 * Written by: Xbl Blue
 * Last Updated: March 2, 2011
 */
include("../core/session.php");
?>

<html>
<title>Registration Page</title>
<link href="../include/login.css" rel="stylesheet" type="text/css" />
<body>

<?php
/**
 * The user is already logged in, not allowed to register.
 */
if($session->logged_in && !$session->isAdmin()){
   echo "<h1>Registered</h1>";
   echo "<p>We're sorry <b>$session->username</b>, but you've already registered. "
       ."<a href=\"index.php\">Main</a>.</p>";
}
/**
 * The user has submitted the registration form and the
 * results have been processed.
 */
else if(isset($_SESSION['regsuccess'])){
   /* Registration was successful */
   if($_SESSION['regsuccess']){
      echo "<h1>Registered!</h1>";
      echo "<p>Thank you <b>".$_SESSION['reguname']."</b>, your information has been added to the database, "
          ."you may now <a href=\"index.php\">log in</a>.</p>";
   }
   /* Registration failed */
   else{
      echo "<h1>Registration Failed</h1>";
      echo "<p>We're sorry, but an error has occurred and your registration for the username <b>".$_SESSION['reguname']."</b>, "
          ."could not be completed.<br>Please try again at a later time.</p>";
   }
   unset($_SESSION['regsuccess']);
   unset($_SESSION['reguname']);
}
/**
 * The user has not filled out the registration form yet.
 * Below is the page with the sign-up form, the names
 * of the input fields are important and should not
 * be changed.
 */
else{
?>
<h1>Register</h1>
<?php
if($form->num_errors > 0){
   echo "<td><font size=\"2\" color=\"#ff0000\">".$form->num_errors." error(s) found</font></td>";
}
?>
<form action="../core/process.php" method="POST">
<table align="center" border="0" cellspacing="0" cellpadding="3">
<tr><td>Username:</td><td><input type="text" name="user" maxlength="30" value="<?php echo $form->value("user"); ?>"></td><td><?php echo $form->error("user"); ?></td></tr>
<tr><td>Password:</td><td><input type="password" name="pass" maxlength="30" value="<?php echo $form->value("pass"); ?>"></td><td><?php echo $form->error("pass"); ?></td></tr>
<tr><td>Email:</td><td><input type="text" name="email" maxlength="50" value="<?php echo $form->value("email"); ?>"></td><td><?php echo $form->error("email"); ?></td></tr>
<tr><td>Code:</td><td><input type="text" name="code" maxlength="50" value="<?php echo $form->value("code"); ?>"></td><td><?php echo $form->error("code"); ?></td></tr>
<tr><td colspan="2" align="right">
<input type="hidden" name="subjoin" value="1">
<input type="submit" value="Join!"></td></tr>
<tr><td colspan="2" align="left"><a href="../index.php">Back to Main</a></td></tr>
</table>
</form>

<?php
}
?>

</body>
</html>
