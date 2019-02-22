<?php
define("_VALID_PHP", true);
  require_once("../init.php");
?>
<?php
  //$msgs = array();
  $post = (!empty($_POST)) ? true : false;
  
  if ($post) {
      if ($_POST['name'] == "")
          $core->msgs['name'] = 'Please enter your name';
      
      if ($_POST['code'] == "")
          $core->msgs['code'] = 'Please enter the total amount';
      
      if ($_POST['code'] != "8")
          $core->msgs['code'] = 'Entered total amount is incorrect';
      
      if ($_POST['email'] == "")
          $core->msgs['email'] = 'Please enter your email address';
      
      if (!preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/", $_POST['email']))
          $core->msgs['email'] = 'Entered email address is invalid!';
      
      if ($_POST['message'] == "")
          $core->msgs['message'] = 'Please enter your message';
      
      if (empty($core->msgs)) {
          
          $sender_email = sanitize($_POST['email']);
          $name = sanitize($_POST['name']);
          $message = strip_tags($_POST['message']);
		  $mailsubject = sanitize($_POST['subject']);
		  $ip = sanitize($_SERVER['REMOTE_ADDR']);

		  require_once(BASEPATH . "lib/class_mailer.php");
		  $mailer = $mail->sendMail();	
					  
		  $row = $core->getRowById("email_templates", 10);
		  
		  $body = str_replace(array('[MESSAGE]', '[SENDER]', '[NAME]', '[MAILSUBJECT]', '[IP]', '[SITE_NAME]', '[URL]'), 
		  array($message, $sender_email, $name, $mailsubject, $ip, $core->site_name, $core->site_url), $row['body']);

		  $message = Swift_Message::newInstance()
					->setSubject($row['subject'])
					->setTo(array($core->site_email => $core->site_name))
					->setFrom(array($sender_email => $name))
					->setBody(cleanOut($body), 'text/html');
	
          if($mailer->send($message)) {
			  print 1;
		  }
		  
      } else 
          print $core->msgStatus();
  }
?>