<?php
define("_VALID_PHP", true);
  
  require_once("../init.php");
?>
<?php
  if ($user->logged_in)
      $user->logout();
	  
  redirect_to("login.php");
?>