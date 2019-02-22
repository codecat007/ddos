<?php
define("_VALID_PHP", true);
  require_once("../init.php");
?>
<?php
  /* Registration */
  if (isset($_POST['doRegister']))
      : if (intval($_POST['doRegister']) == 0 || empty($_POST['doRegister']))
      : redirect_to("../register.php");
  endif;
  $user->register();
  endif;
?>
<?php
  /* Password Reset */
  if (isset($_POST['passReset']))
      : if (intval($_POST['passReset']) == 0 || empty($_POST['passReset']))
      : redirect_to("../login.php");
  endif;
  $user->passReset();
  endif;
?>
<?php
  /* Account Acctivation */
  if (isset($_POST['accActivate']))
      : if (intval($_POST['accActivate']) == 0 || empty($_POST['accActivate']))
      : redirect_to("../login.php?action=activate");
  endif;
  $user->activateUser();
  endif;
?>
<?php
  /* Check Username */
  if (isset($_POST['checkUsername'])): 
  
  $username = trim(strtolower($_POST['checkUsername']));
  $username = $db->escape($username);
  
  $sql = "SELECT username FROM users WHERE username = '".$username."' LIMIT 1";
  $result = $db->query($sql);
  $num = $db->numrows($result);
  
  echo $num;
  
  endif;
?>