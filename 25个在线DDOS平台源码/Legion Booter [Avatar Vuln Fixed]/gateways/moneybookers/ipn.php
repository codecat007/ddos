<?php
  /**
   * MoneyBookers IPN
   *
   * @package Membership Manager Pro
   * @author wojoscripts.com
   * @copyright 2010
   * @version $Id: ipn.php,<?php echo  2010-08-10 21:12:05 gewa Exp $
   */
  define("_VALID_PHP", true);
  require_once("../../init.php");
  
  /* only for debuggin purpose. Create logfile.txt and chmot to 0777
   ob_start();
   echo '<pre>';
   print_r($_POST);
   echo '</pre>';
   $logInfo = ob_get_contents();
   ob_end_clean();
   
   $file = fopen('logfile.txt', 'a');
   fwrite($file, $logInfo);
   fclose($file);
   */
  
  /* Check for mandatory fields */
  $r_fields = array(
		'status', 
		'md5sig', 
		'merchant_id', 
		'pay_to_email', 
		'mb_amount', 
		'mb_transaction_id', 
		'currency', 
		'amount', 
		'transaction_id', 
		'pay_from_email', 
		'mb_currency'
  );
  $mb_secret = getValue("extra3", "gateways", "name = 'moneybookers'");
  
  foreach ($r_fields as $f)
      if (!isset($_POST[$f]))
          die();
  
  /* Check for MD5 signature */
  $md5 = strtoupper(md5($_POST['merchant_id'] . $_POST['transaction_id'] . strtoupper(md5($mb_secret)) . $_POST['mb_amount'] . $_POST['mb_currency'] . $_POST['status']));
  if ($md5 != $_POST['md5sig'])
      die();
  
  if (intval($_POST['status']) == 2) {
      $mb_currency = $_POST['mb_currency'];
	  $mc_gross = $_POST['amount'];
	  $txn_id = $_POST['mb_transaction_id'];
	  /*
      $payer_email = $_POST['pay_from_email'];
	  $payer_status = "verified";
	  $receiver_email = $_POST['pay_to_email'];
      $getxn_id = $member->verifyTxnId($txn_id);
	  */
      list($membership_id, $user_id) = explode("_", $_POST['custom']);

      $sql = "SELECT * FROM memberships WHERE id='" . (int)$membership_id . "'";
      $row = $db->first($sql);
      
      $username = getValue("username", "users", "id = " . (int)$user_id);
      
      $data = array(
			'txn_id' => $txn_id, 
			'membership_id' => $row['id'], 
			'user_id' => (int)$user_id, 
			'rate_amount' => (float)$mc_gross, 
			'ip' => $_SERVER['REMOTE_ADDR'], 
			'date' => "NOW()", 
			'pp' => "MoneyBookers", 
			'currency' => sanitize($mb_currency), 
			'status' => 1
	  );
      
      $db->insert("payments", $data);
      
      $udata = array(
			'membership_id' => $row['id'], 
			'mem_expire' => $user->calculateDays($row['id']), 
			'trial_used' => ($row['trial'] == 1) ? 1 : 0
	  );
      
      $db->update("users", $udata, "id='" . (int)$user_id . "'");
      
      /* == Notify Administrator == */
      require_once(BASEPATH . "lib/class_mailer.php");
      $row2 = $core->getRowById("email_templates", 5);
      
      $body = str_replace(array('[USERNAME]', '[ITEMNAME]', '[PRICE]', '[STATUS]', '[PP]'), 
	  array($username, $row['title'], $core->formatMoney($mc_gross), "Completed", "MoneyBookers"), $row2['body']);
      
      $newbody = cleanOut($body);
      
      $mailer = $mail->sendMail();
	  $message = Swift_Message::newInstance()
			  ->setSubject($row2['subject'])
			  ->setTo(array($core->site_email => $core->site_name))
			  ->setFrom(array($core->site_email => $core->site_name))
			  ->setBody($newbody, 'text/html'
	  );
      
      $mailer->send($message);
  } else {
      /* == Failed or Pending Transaction == */
      require_once(BASEPATH . "lib/class_mailer.php");
      $row2 = $core->getRowById("email_templates", 6);
      $itemname = getValue("title", "memberships", "id = " . $membership_id);
      
      $body = str_replace(array('[USERNAME]', '[ITEMNAME]', '[PRICE]', '[STATUS]', '[PP]'), 
	  array($username, $itemname, $core->formatMoney($mc_gross), "Failed", "MoneyBookers"), $row2['body']);
      
      $newbody = cleanOut($body);
      
      $mailer = $mail->sendMail();
	  $message = Swift_Message::newInstance()
			  ->setSubject($row2['subject'])
			  ->setTo(array($core->site_email => $core->site_name))
			  ->setFrom(array($core->site_email => $core->site_name))
			  ->setBody($newbody, 'text/html'
	  );
      
      $mailer->send($message);
  }
?>