<?php
define("_VALID_PHP", true);
  require_once("../init.php");

  if (!$user->logged_in)
      redirect_to("../index.php");
?>
<?php
  /* Proccess Cart */
  if (isset($_POST['addtocart']))
      : list($membership_id, $gate_id) = explode(":", $_POST['addtocart']);
  
  $row = $core->getRowById("memberships", $membership_id, false, false);
  $row2 = $core->getRowById("gateways", $gate_id, false, false);
  
  if ($row['trial'] && $user->trialUsed()) {
      $core->msgInfo('<span>Info!</span>Sorry, you have already used your trial membership!');
      die();
  }  
  if ($row['price'] == 0.00) {
      $data = array(
			'membership_id' => $row['id'], 
			'mem_expire' => $user->calculateDays($row['id']), 
			'trial_used' => ($row['trial'] == 1) ? 1 : 0
	  );
	  
      $db->update("users", $data, "id='" . (int)$user->uid . "'");
      ($db->affected()) ? $core->msgOk('<span>Success!</span>You have successfully activated ' . $row['title'], false) : $core->msgError('<span>Alert!</span>Nothing to process.');
  } else {
      $form_url = BASEPATH . "gateways/" . $row2['dir'] . "/form.tpl.php";
      ($gate_id != "FREE" && file_exists($form_url)) ? include($form_url) : redirect_to("../account.php");
  }
  
  endif;
?>
<?php
  /* Proccess User */
  if (isset($_POST['processUser']))
      : if (intval($_POST['processUser']) == 0 || empty($_POST['processUser']))
      : redirect_to("../account.php");
  endif;
  $user->updateProfile();
  endif;
?>