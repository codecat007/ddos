<?php
if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');

  class Mailer
  {
	  
      private $mailer;
      private $smtp_host;
      private $smtp_user;
      private $smtp_pass;
      private $smtp_port;
	  
	  
      /**
       * Mailer::__construct()
       * 
       * @return
       */
      function __construct()
      {
          global $core;
          
          $this->mailer = $core->mailer;
          $this->smtp_host = $core->smtp_host;
          $this->smtp_user = $core->smtp_user;
          $this->smtp_pass = $core->smtp_pass;
          $this->smtp_port = $core->smtp_port;
      }
	  
      /**
       * Mailer::sendMail()
       * 
	   * Sends a various messages to users
       * @return
       */
	  function sendMail()
	  {
		  require_once(BASEPATH . 'lib/swift/swift_required.php');
		  
          if ($this->mailer == "SMTP") {
              $transport = Swift_SmtpTransport::newInstance($this->smtp_host, $this->smtp_port)
						  ->setUsername($this->smtp_user)
						  ->setPassword($this->smtp_pass);
          } else
              $transport = Swift_MailTransport::newInstance();
          
          return Swift_Mailer::newInstance($transport);
	  }
	  
  }
  $mail = new Mailer();
?>