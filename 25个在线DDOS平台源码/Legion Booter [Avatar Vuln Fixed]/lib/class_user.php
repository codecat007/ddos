<?php
if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');

  class Users
  {
	  private $uTable = "users";
	  public $logged_in = null;
	  public $uid = 0;
	  public $userid = 0;
      public $username;
	  public $email;
	  public $name;
	  public $membership_id = 0;
      public $userlevel;
	  private $lastlogin = "NOW()";
      

      /**
       * Users::__construct()
       * 
       * @return
       */
      function __construct()
      {
		  $this->getUserId();
		  $this->startSession();
      }

	  /**
	   * Users::getUserId()
	   * 
	   * @return
	   */
	  private function getUserId()
	  {
	  	  global $core;
		  if (isset($_GET['userid'])) {
			  $userid = (is_numeric($_GET['userid']) && $_GET['userid'] > -1) ? intval($_GET['userid']) : false;
			  $userid = sanitize($userid);
			  
			  if ($userid == false) {
				  $core->error("You have selected an Invalid Userid","Users::getUserId()");
			  } else
				  return $this->userid = $userid;
		  }
	  }  

      /**
       * Users::startSession()
       * 
       * @return
       */
      private function startSession()
      {
		session_start();
		$this->logged_in = $this->loginCheck();
		
		if (!$this->logged_in) {
			$this->username = $_SESSION['username'] = "Guest";
			$this->userlevel = 0;
		}
      }

	  /**
	   * Users::loginCheck()
	   * 
	   * @return
	   */
	  private function loginCheck()
	  {
          if (isset($_SESSION['username']) && $_SESSION['username'] != "Guest") {
              
              $row = $this->getUserInfo($_SESSION['username']);
			  $this->uid = $row['id'];
              $this->username = $row['username'];
			  $this->email = $row['email'];
			  $this->name = $row['fname'].' '.$row['lname'];
              $this->userlevel = $row['userlevel'];
			  $this->membership_id = $row['membership_id'];
              return true;
          } else {
              return false;
          }  
	  }

	  /**
	   * Users::is_Admin()
	   * 
	   * @return
	   */
	  public function is_Admin()
	  {
		  return($this->userlevel == 9);
	  
	  }	

	  /**
	   * Users::login()
	   * 
	   * @param mixed $username
	   * @param mixed $pass
	   * @return
	   */
	  public function login($username, $pass)
	  {
		  global $db, $core;

		  if ($username == "" && $pass == "") {
			  $core->msgs['username'] = 'Please enter valid username and password.';
		  } else {
			  $status = $this->checkStatus($username, $pass);
			  
			  switch ($status) {
				  case 0:
					  $core->msgs['username'] = 'Login and/or password did not match to the database.';
					  break;
					  
				  case 1:
					  $core->msgs['username'] = 'Your account has been banned.';
					  break;
					  
				  case 2:
					  $core->msgs['username'] = 'Your account it\'s not activated.';
					  break;
					  
				  case 3:
					  $core->msgs['username'] = 'You need to verify your email address.';
					  break;
			  }
		  }
		  if (empty($core->msgs) && $status == 5) {
			  $row = $this->getUserInfo($username);
			  $this->uid = $_SESSION['userid'] = $row['id'];
			  $this->username = $_SESSION['username'] = $row['username'];
			  $this->email = $_SESSION['email'] = $row['email'];
			  $this->name = $_SESSION['userlevel'] = $row['userlevel'];
			  $this->userlevel = $_SESSION['userlevel'] = $row['userlevel'];
			  $this->membership_id = $_SESSION['membership_id'] = $row['membership_id'];

			  $data = array(
					'lastlogin' => $this->lastlogin, 
					'lastip' => sanitize($_SERVER['REMOTE_ADDR'])
			  );
			  $db->update($this->uTable, $data, "username='" . $this->username . "'");
			  if(!$this->validateMembership()) {
				$data = array(
					  'membership_id' => 0, 
					  'mem_expire' => "0000-00-00 00:00:00"
				);
				$db->update($this->uTable, $data, "username='" . $this->username . "'");
			  }
				  
			  return true;
		  } else
			  $core->msgStatus();
	  }

      /**
       * Users::logout()
       * 
       * @return
       */
      public function logout()
      {
          unset($_SESSION['username']);
		  unset($_SESSION['email']);
		  unset($_SESSION['name']);
		  unset($_SESSION['membership_id']);
          unset($_SESSION['userid']);
          session_destroy();
		  session_regenerate_id();
          
          $this->logged_in = false;
          $this->username = "Guest";
          $this->userlevel = 0;
      }

	  /**
	   * Users::getUserInfo()
	   * 
	   * @param mixed $username
	   * @return
	   */
	  private function getUserInfo($username)
	  {
		  global $db;
		  $username = sanitize($username);
		  $username = $db->escape($username);
		  
		  $sql = "SELECT * FROM " . $this->uTable . " WHERE username = '" . $username . "'";
		  $row = $db->first($sql);
		  if (!$username)
			  return false;
		  
		  return ($row) ? $row : 0;
	  }

	  /**
	   * Users::checkStatus()
	   * 
	   * @param mixed $username
	   * @param mixed $pass
	   * @return
	   */
	  public function checkStatus($username, $pass)
	  {
		  global $db;
		  
		  $username = sanitize($username);
		  $username = $db->escape($username);
		  $pass = sanitize($pass);
		  
          $sql = "SELECT password, active FROM " . $this->uTable
		  . "\n WHERE username = '".$username."'";
          $result = $db->query($sql);
          
		  if ($db->numrows($result) == 0)
			  return 0;
			  
		  $row = $db->fetch($result);
		  $entered_pass = sha1($pass);
		  
		  switch ($row['active']) {
			  case "b":
				  return 1;
				  break;
				  
			  case "n":
				  return 2;
				  break;
				  
			  case "t":
				  return 3;
				  break;
				  
			  case "y" && $entered_pass == $row['password']:
				  return 5;
				  break;
		  }
	  }

	  /**
	   * Users::getUsers()
	   * 
	   * @param bool $from
	   * @return
	   */
	  public function getUsers($from = false)
	  {
		  global $db, $pager, $core;
		  
		  require_once(BASEPATH . "lib/class_paginate.php");
          $pager = new Paginator();
		  
          $counter = countEntries($this->uTable);
          $pager->items_total = $counter;
          $pager->default_ipp = $core->perpage;
          $pager->paginate();
          
          if ($counter == 0) {
              $pager->limit = null;
          }

		  if (isset($_GET['sort'])) {
			  list($sort, $order) = explode("-", $_GET['sort']);
			  $sort = sanitize($sort);
			  $order = sanitize($order);
			  if (in_array($sort, array("username", "fname", "lname", "email", "created"))) {
				  $ord = ($order == 'DESC') ? " DESC" : " ASC";
				  $sorting = " u." . $sort . $ord;
			  } else {
				  $sorting = " u.created DESC";
			  }
		  } else {
			  $sorting = " u.created DESC";
		  }
		  
		  $clause = (isset($clause)) ? $clause : null;
		  
          if (isset($_POST['fromdate']) && $_POST['fromdate'] <> "" || isset($from) && $from != '') {
              $enddate = date("Y-m-d");
              $fromdate = (empty($from)) ? $_POST['fromdate'] : $from;
              if (isset($_POST['enddate']) && $_POST['enddate'] <> "") {
                  $enddate = $_POST['enddate'];
              }
              $clause .= " WHERE u.created BETWEEN '" . trim($fromdate) . "' AND '" . trim($enddate) . " 23:59:59'";
          } 
		  
          $sql = "SELECT u.*, CONCAT(u.fname,' ',u.lname) as name, m.title, m.id as mid,"
		  . "\n DATE_FORMAT(u.created, '%d. %b. %Y.') as cdate,"
		  . "\n DATE_FORMAT(u.lastlogin, '%d. %b. %Y.') as adate"
		  . "\n FROM " . $this->uTable . " as u"
		  . "\n LEFT JOIN memberships as m ON m.id = u.membership_id" 
		  . "\n " . $clause
		  . "\n ORDER BY " . $sorting . $pager->limit;
          $row = $db->fetch_all($sql);
          
		  return ($row) ? $row : 0;
	  }

	  /**
	   * Users::processUser()
	   * 
	   * @return
	   */
	  public function processUser()
	  {
		  global $db, $core;

		  if (!$this->userid) {
			  if (empty($_POST['username']))
				  $core->msgs['username'] = 'Please Enter Valid Username';
			  
			  if ($value = $this->usernameExists($_POST['username'])) {
				  if ($value == 1)
					  $core->msgs['username'] = 'Username Is Too Short (less Than 4 Characters Long).';
				  if ($value == 2)
					  $core->msgs['username'] = 'Invalid Characters Found In Username.';
				  if ($value == 3)
					  $core->msgs['username'] = 'Sorry, This Username Is Already Taken';
			  }
		  }

		  if (empty($_POST['fname']))
			  $core->msgs['fname'] = 'Please Enter First Name';
			  
		  if (empty($_POST['lname']))
			  $core->msgs['lname'] = 'Please Enter Last Name';
			  
		  if (!$this->userid) {
			  if (empty($_POST['password']))
				  $core->msgs['password'] = 'Please Enter Valid Password.';
		  }

		  if (empty($_POST['email']))
			  $core->msgs['email'] = 'Please Enter Valid Email Address';
		  if (!$this->userid) {
			  if ($this->emailExists($_POST['email']))
				  $core->msgs['email'] = 'Entered Email Address Is Already In Use.';
		  }
		  if (!$this->isValidEmail($_POST['email']))
			  $core->msgs['email'] = 'Entered Email Address Is Not Valid.';

		  if (empty($core->msgs)) {
			  
			  $data = array(
				  'username' => sanitize($_POST['username']), 
				  'email' => sanitize($_POST['email']), 
				  'lname' => sanitize($_POST['lname']), 
				  'fname' => sanitize($_POST['fname']), 
				  'membership_id' => intval($_POST['membership_id']),
				  'mem_expire' => $this->calculateDays($_POST['membership_id']),
				  'newsletter' => intval($_POST['newsletter']),
				  'userlevel' => intval($_POST['userlevel']), 
				  'active' => sanitize($_POST['active'])
			  );

			  if (!$this->userid)
				  $data['created'] = "NOW()";
				   
			  if ($this->userid)
				  $userrow = $core->getRowById($this->uTable, $this->userid);
			  
			  if ($_POST['password'] != "") {
				  $data['password'] = sha1($_POST['password']);
			  } else {
				  $data['password'] = $userrow['password'];
			  }

			  // Start Avatar Upload
			  include(BASEPATH . "lib/class_imageUpload.php");
			  include(BASEPATH . "lib/class_imageResize.php");

			  $newName = "IMG_" . randName();
			  $ext = substr($_FILES['avatar']['name'], strrpos($_FILES['avatar']['name'], '.') + 1);
			  $name = $newName.".".strtolower($ext);
		
			  $als = new Upload();
			  $als->File = $_FILES['avatar'];
			  $als->method = 1;
			  $als->SavePath = UPLOADS;
			  $als->NewWidth = $core->thumb_w;
			  $als->NewHeight = $core->thumb_h;
			  $als->NewName  = $newName;
			  $als->OverWrite = true;
			  $err = $als->UploadFile();

			  if ($this->userid) {
				  $avatar = getValue("avatar",$this->uTable,"id = '".$this->userid."'");
				  if (!empty($_FILES['avatar']['name'])) {
					  if ($avatar) {
						  @unlink($als->SavePath . $avatar);
					  }
					  $data['avatar'] = $name;
				  } else {
					  $data['avatar'] = $avatar;
				  }
			  } else {
				  if (!empty($_FILES['avatar']['name'])) 
				  $data['avatar'] = $name;
			  }
			  
			  if (count($err) > 0 and is_array($err)) {
				  foreach ($err as $key => $val) {
					  $core->msgError($val, false);
				  }
			  }
				  
			  ($this->userid) ? $db->update($this->uTable, $data, "id='" . (int)$this->userid . "'") : $db->insert($this->uTable, $data);
			  $message = ($this->userid) ? '<span>Success!</span>User updated successfully!' : '<span>Success!</span>User added successfully!';

			  if ($db->affected()) {
				  $core->msgOk($message);
				  
				  if (isset($_POST['notify']) && intval($_POST['notify']) == 1) {
					  
					  require_once(BASEPATH . "lib/class_mailer.php");
					  $mailer = $mail->sendMail();	
								  
					  $row = $core->getRowById("email_templates", 3);
					  
					  $body = str_replace(array('[USERNAME]', '[PASSWORD]', '[NAME]', '[SITE_NAME]', '[URL]'), 
					  array($data['username'], $_POST['password'], $data['fname'].' '.$data['lname'], $core->site_name, $core->site_url), $row['body']);
			
					  $message = Swift_Message::newInstance()
								->setSubject($row['subject'])
								->setTo(array($data['email'] => $data['fname'].' '.$data['lname']))
								->setFrom(array($core->site_email => $core->site_name))
								->setBody(cleanOut($body), 'text/html');
								
					   $mailer->send($message);
				  }
			  } else
				  $core->msgAlert('<span>Alert!</span>Nothing to process.');
		  } else
			  print $core->msgStatus();
	  } 

	  /**
	   * Users::updateProfile()
	   * 
	   * @return
	   */
	  public function updateProfile()
	  {
		  global $db, $core;

		  if (empty($_POST['fname']))
			  $core->msgs['fname'] = 'Please Enter First Name';
			  
		  if (empty($_POST['lname']))
			  $core->msgs['lname'] = 'Please Enter Last Name';

		  if (empty($_POST['email']))
			  $core->msgs['email'] = 'Please Enter Valid Email Address';

		  if (!$this->isValidEmail($_POST['email']))
			  $core->msgs['email'] = 'Entered Email Address Is Not Valid.';

		  if (empty($core->msgs)) {
			  
			  $data = array(
				  'email' => sanitize($_POST['email']), 
				  'lname' => sanitize($_POST['lname']), 
				  'fname' => sanitize($_POST['fname']), 
				  'newsletter' => intval($_POST['newsletter'])
			  );
				   
			  $userpass = getValue("password", $this->uTable, "id = '".$this->uid."'");
			  
			  if ($_POST['password'] != "") {
				  $data['password'] = sha1($_POST['password']);
			  } else
				  $data['password'] = $userpass;

			  // Start Avatar Upload
			  include(BASEPATH . "lib/class_imageUpload.php");
			  include(BASEPATH . "lib/class_imageResize.php");

			  $newName = "IMG_" . randName();
			  $ext = substr($_FILES['avatar']['name'], strrpos($_FILES['avatar']['name'], '.') + 1);
			  $name = $newName.".".strtolower($ext);
		
			  $als = new Upload();
			  $als->File = $_FILES['avatar'];
			  $als->method = 1;
			  $als->SavePath = UPLOADS;
			  $als->NewWidth = $core->thumb_w;
			  $als->NewHeight = $core->thumb_h;
			  $als->NewName  = $newName;
			  $als->OverWrite = true;
			  $err = $als->UploadFile();

				  $avatar = getValue("avatar",$this->uTable,"id = '".$this->uid."'");
				  if (!empty($_FILES['avatar']['name'])) {
					  if ($avatar) {
						  @unlink($als->SavePath . $avatar);
					  }
					  $data['avatar'] = $name;
				  } else {
					  $data['avatar'] = $avatar;
				  }
			  
			  if (count($err) > 0 and is_array($err)) {
				  foreach ($err as $key => $val) {
					  $core->msgError($val, false);
				  }
			  }
			  
			  $db->update($this->uTable, $data, "id='" . (int)$this->uid . "'");

			  ($db->affected()) ? $core->msgOk('<span>Success!</span> You have successfully updated your profile.') : $core->msgAlert('<span>Alert!</span>Nothing to process.');
		  } else
			  print $core->msgStatus();
	  } 

      /**
       * User::register()
       * 
       * @return
       */
	  public function register()
	  {
		  global $db, $core;
		  
		  if (empty($_POST['username']))
			  $core->msgs['username'] = 'Please Enter Valid Username';
		  
		  if ($value = $this->usernameExists($_POST['username'])) {
			  if ($value == 1)
				  $core->msgs['username'] = 'Username Is Too Short (less Than 4 Characters Long).';
			  if ($value == 2)
				  $core->msgs['username'] = 'Invalid Characters Found In Username.';
			  if ($value == 3)
				  $core->msgs['username'] = 'Sorry, This Username Is Already Taken';
		  }

		  if (empty($_POST['fname']))
			  $core->msgs['fname'] = 'Please Enter First Name';
			  
		  if (empty($_POST['lname']))
			  $core->msgs['lname'] = 'Please Enter Last Name';
			  
		  if (empty($_POST['pass']))
			  $this->msgs['pass'] = 'Please Enter Valid Password.';
		  
		  if (strlen($_POST['pass']) < 6)
			  $core->msgs['pass'] = 'Password is too short (less than 6 characters long)';
		  elseif (!preg_match("/^([0-9a-z])+$/i", ($_POST['pass'] = trim($_POST['pass']))))
			  $core->msgs['pass'] = 'Password entered is not alphanumeric.';
		  elseif ($_POST['pass'] != $_POST['pass2'])
			  $core->msgs['pass'] = 'Your password did not match the confirmed password!.';
		  
		  if (empty($_POST['email']))
			  $core->msgs['email'] = 'Please Enter Valid Email Address';
		  
		  if ($this->emailExists($_POST['email']))
			  $core->msgs['email'] = 'Entered Email Address Is Already In Use.';
		  
		  if (!$this->isValidEmail($_POST['email']))
			  $core->msgs['email'] = 'Entered Email Address Is Not Valid.';
			  		  
		  if ((int)empty($_POST['captcha']))
			  $core->msgs['captcha'] = 'Please enter the total amount.';
		  
		  if ($_POST['captcha'] != "9")
			  $core->msgs['captcha'] = 'Entered total amount is incorrect.';
		  
		  if (empty($core->msgs)) {

			  $token = ($core->reg_verify == 1) ? $this->generateRandID() : 0;
			  $pass = sanitize($_POST['pass']);
			  
			  if($core->reg_verify == 1) {
				  $active = "t";
			  } elseif($core->auto_verify == 0) {
				  $active = "n";
			  } else {
				  $active = "y";
			  }
				  
			  $data = array(
					  'username' => sanitize($_POST['username']), 
					  'password' => sha1($_POST['pass']),
					  'email' => sanitize($_POST['email']), 
					  'fname' => sanitize($_POST['fname']),
					  'lname' => sanitize($_POST['lname']),
					  'token' => $token,
					  'active' => $active, 
					  'created' => "NOW()"
			  );
			  
			  $db->insert($this->uTable, $data);
		
			  require_once(BASEPATH . "lib/class_mailer.php");
			  
			  if ($core->reg_verify == 1) {
				  $actlink = $core->site_url . "/activate.php";
				  $row = $core->getRowById("email_templates", 1);
				  
				  $body = str_replace(
						array('[NAME]', '[USERNAME]', '[PASSWORD]', '[TOKEN]', '[EMAIL]', '[URL]', '[LINK]', '[SITE_NAME]'), 
						array($data['fname'].' '.$data['lname'], $data['username'], $_POST['pass'], $token, $data['email'], $core->site_url, $actlink, $core->site_name), $row['body']
						);
						
				 $newbody = cleanOut($body);	
					 
				  $mailer = $mail->sendMail();
				  $message = Swift_Message::newInstance()
							->setSubject($row['subject'])
							->setTo(array($data['email'] => $data['username']))
							->setFrom(array($core->site_email => $core->site_name))
							->setBody($newbody, 'text/html');
							
				 $mailer->send($message);
				 
			  } elseif ($core->auto_verify == 0) {
				  $row = $core->getRowById("email_templates", 14);
				  
				  $body = str_replace(
						array('[NAME]', '[USERNAME]', '[PASSWORD]', '[URL]', '[SITE_NAME]'), 
						array($data['fname'].' '.$data['lname'], $data['username'], $_POST['pass'], $core->site_url, $core->site_name), $row['body']
						);
						
				 $newbody = cleanOut($body);	

				  $mailer = $mail->sendMail();
				  $message = Swift_Message::newInstance()
							->setSubject($row['subject'])
							->setTo(array($data['email'] => $data['username']))
							->setFrom(array($core->site_email => $core->site_name))
							->setBody($newbody, 'text/html');
							
				 $mailer->send($message); 
				  
			  } else {
				  $row = $core->getRowById("email_templates", 7);
				  
				  $body = str_replace(
						array('[NAME]', '[USERNAME]', '[PASSWORD]', '[URL]', '[SITE_NAME]'), 
						array($data['fname'].' '.$data['lname'], $data['username'], $_POST['pass'], $core->site_url, $core->site_name), $row['body']
						);
						
				 $newbody = cleanOut($body);	

				  $mailer = $mail->sendMail();
				  $message = Swift_Message::newInstance()
							->setSubject($row['subject'])
							->setTo(array($data['email'] => $data['username']))
							->setFrom(array($core->site_email => $core->site_name))
							->setBody($newbody, 'text/html');
							
				 $mailer->send($message);

			  }
			  if($core->notify_admin) {
				$arow = $core->getRowById("email_templates", 13);
  
					$abody = str_replace(
						  array('[USERNAME]', '[EMAIL]', '[NAME]', '[IP]'), 
						  array($data['username'], $data['email'], $data['fname'].' '.$data['lname'], $_SERVER['REMOTE_ADDR']), $arow['body']
						  );
						  
				   $anewbody = cleanOut($abody);	
  
					$amailer = $mail->sendMail();
					$amessage = Swift_Message::newInstance()
							  ->setSubject($arow['subject'])
							  ->setTo(array($core->site_email => $core->site_name))
							  ->setFrom(array($core->site_email => $core->site_name))
							  ->setBody($anewbody, 'text/html');
							  
				   $amailer->send($amessage);
			  }
			  
			  ($db->affected() && $mailer) ?  print "OK" : $core->msgError('<span>Error!</span>There was an error during registration process. Please contact the administrator...',false);
		  } else
			  print $core->msgStatus();
	  } 
	  
      /**
       * User::passReset()
       * 
       * @return
       */
	  public function passReset()
	  {
		  global $db, $core;
		  
		  if (empty($_POST['uname']))
			  $core->msgs['uname'] = 'Please Enter Valid Username';
		  
		  $uname = $this->usernameExists($_POST['uname']);
		  if (strlen($_POST['uname']) < 4 || strlen($_POST['uname']) > 30 || !preg_match("/^([0-9a-z])+$/i", $_POST['uname']) || $uname != 3)
			  $core->msgs['uname'] = 'We are sorry, selected username does not exist in our database';

		  if (empty($_POST['email']))
			  $core->msgs['email'] = 'Please Enter Valid Email Address';

		  if (!$this->emailExists($_POST['email']))
			  $core->msgs['uname'] = 'Entered Email Address Does Not Exists.';
			    
		  if (empty($_POST['captcha']))
			  $core->msgs['captcha'] = 'Please enter the total amount';
		  
		  if ($_POST['captcha'] != "10")
			  $core->msgs['captcha'] = 'Entered total amount is incorrect';
		  
		  if (empty($core->msgs)) {
			  
              $user = $this->getUserInfo($_POST['uname']);
			  $randpass = $this->getUniqueCode(12);
			  $newpass = sha1($randpass);
			  
			  $data['password'] = $newpass;
			  
			  $db->update($this->uTable, $data, "username = '" . $user['username'] . "'");
		  
			  require_once(BASEPATH . "lib/class_mailer.php");
			  $row = $core->getRowById("email_templates", 2);
			  
			  $body = str_replace(
					array('[USERNAME]', '[PASSWORD]', '[URL]', '[LINK]', '[IP]', '[SITE_NAME]'), 
					array($user['username'], $randpass, $core->site_url, $core->site_url, $_SERVER['REMOTE_ADDR'], $core->site_name), $row['body']
					);
					
			  $newbody = cleanOut($body);

			  $mailer = $mail->sendMail();
			  $message = Swift_Message::newInstance()
						->setSubject($row['subject'])
						->setTo(array($user['email'] => $user['username']))
						->setFrom(array($core->site_email => $core->site_name))
						->setBody($newbody, 'text/html');
						
			  ($db->affected() && $mailer->send($message)) ? $core->msgOk('<span>Success!</span>You have successfully changed your password. Please check your email for further info!',false) : $core->msgError('<span>Error!</span>There was an error during the process. Please contact the administrator.',false);

		  } else
			  print $core->msgStatus();
	  }
	  
      /**
       * User::activateUser()
       * 
       * @return
       */
	  public function activateUser()
	  {
		  global $db, $core;
		  
		  if (empty($_POST['email']))
			  $core->msgs['email'] = 'Please Enter Valid Email Address';
		  
		  if (!$this->emailExists($_POST['email']))
			  $core->msgs['email'] = 'Entered Email Address Does Not Exists.';
		  
		  if (empty($_POST['token']))
			  $core->msgs['token'] = 'The token code is not valid';
		  
		  if (!$this->validateToken($_POST['token']))
			  $core->msgs['token'] = 'This account has been already activated!';
		  
		  if (empty($core->msgs)) {
			  $email = sanitize($_POST['email']);
			  $token = sanitize($_POST['token']);
			  $message = ($core->auto_verify == 1) ? '<span>Success!</span>You have successfully activated your account!' : '<span>Success!</span>Your account is now active. However you still need to wait for administrative approval.';
			  
			  $data = array(
					'token' => 0, 
					'active' => ($core->auto_verify) ? "y" : "n"
			  );
			  
			  $db->update($this->uTable, $data, "email = '" . $email . "' AND token = '" . $token . "'");
			  ($db->affected()) ? $core->msgOk($message,false) : $core->msgError('<span>Error!</span>There was an error during the activation process. Please contact the administrator.',false);
		  } else
			  print $core->msgStatus();
	  }

	  /**
	   * Users::getUserData()
	   * 
	   * @return
	   */
	  public function getUserData()
	  {
		  global $db, $core;
		  
		  $sql = "SELECT *, DATE_FORMAT(created, '%a. %d, %M %Y') as cdate,"
		  . "\n DATE_FORMAT(lastlogin, '%a. %d, %M %Y') as ldate"
		  . "\n FROM " . $this->uTable
		  . "\n WHERE id = '" . $this->uid . "'";
		  $row = $db->first($sql);

		  return ($row) ? $row : 0;
	  }

	  /**
	   * Users::getUserMembership()
	   * 
	   * @return
	   */
	  public function getUserMembership()
	  {
		  global $db, $core;
		  		  
          $sql = "SELECT u.*, m.title,"
		  . "\n DATE_FORMAT(u.mem_expire, '%d. %b. %Y.') as expiry"
		  . "\n FROM " . $this->uTable . " as u"
		  . "\n LEFT JOIN memberships as m ON m.id = u.membership_id" 
		  . "\n WHERE u.id = '" . $this->uid . "'";
          $row = $db->first($sql);
          
		  return ($row) ? $row : 0;
	  }

	  /**
	   * Users::calculateDays()
	   * 
	   * @return
	   */
	  public function calculateDays($membership_id)
	  {
		  global $db;
		  
		  $now = date('Y-m-d H:i:s');
		  $row = $db->first("SELECT days, period FROM memberships WHERE id = '" . (int)$membership_id . "'");
		  if($row) {
			  switch($row['period']) {
				  case "D" :
				  $diff = $row['days'];
				  break;
				  case "W" :
				  $diff = $row['days'] * 7;
				  break; 
				  case "M" :
				  $diff = $row['days'] * 30;
				  break;
				  case "Y" :
				  $diff = $row['days'] * 365;
				  break;
			  }
			$expire = date("Y-m-d H:i:s", strtotime($now . + $diff . " days"));
		  } else {
			$expire = "0000-00-00 00:00:00";
		  }
		  return $expire;
	  }

      /**
       * User::trialUsed()
       * 
       * @return
       */
     public function trialUsed()
      {
          global $db;

          $sql = "SELECT trial_used" 
		  . "\n FROM ".$this->uTable 
		  . "\n WHERE id ='" . $this->uid . "'" 
		  . "\n LIMIT 1";
          $row = $db->first($sql);
		  
		  return ($row['trial_used'] == 1) ? true : false;
      }

	  /**
	   * Users::validateMembership()
	   * 
	   * @return
	   */
	  public function validateMembership()
	  {
		  global $db;
		  
		  $sql = "SELECT mem_expire" 
		  . "\n FROM " . $this->uTable
		  . "\n WHERE id = '" . $this->uid . "'" 
		  . "\n AND TO_DAYS(mem_expire) > TO_DAYS(NOW())";
		  $row = $db->first($sql);
		  
		  return ($row) ? $row : 0;
	  }

	  /**
	   * Users::checkMembership()
	   * 
	   * @param string $memids
	   * @return
	   */
	  public function checkMembership($memids)
	  {
		  global $db;
		  
		  $m_arr = explode(",", $memids);
		  reset($m_arr);
		  
		  if ($this->logged_in and $this->validateMembership() and in_array($this->membership_id, $m_arr)) {
			  return true;
		  } else
			  return false;
	  }
	  	  	  	  	  	  	  	  
	  /**
	   * Users::usernameExists()
	   * 
	   * @param mixed $username
	   * @return
	   */
	  private function usernameExists($username)
	  {
		  global $db;
		  
		  $username = sanitize($username);
		  if (strlen($db->escape($username)) < 4)
			  return 1;
		  
		  $alpha_num = str_replace(" ", "", $username);
		  if (!ctype_alnum($alpha_num))
			  return 2;
		  
		  $sql = $db->query("SELECT username" 
		  . "\n FROM users" 
		  . "\n WHERE username = '" . $username . "'" 
		  . "\n LIMIT 1");
		  
		  $count = $db->numrows($sql);
		  
		  return ($count > 0) ? 3 : false;
	  }  	
	  
	  /**
	   * User::emailExists()
	   * 
	   * @param mixed $email
	   * @return
	   */
	  private function emailExists($email)
	  {
		  global $db;
		  
		  $sql = $db->query("SELECT email" 
		  . "\n FROM users" 
		  . "\n WHERE email = '" . sanitize($email) . "'" 
		  . "\n LIMIT 1");
		  
		  if ($db->numrows($sql) == 1) {
			  return true;
		  } else
			  return false;
	  }
	  
	  /**
	   * User::isValidEmail()
	   * 
	   * @param mixed $email
	   * @return
	   */
	  private function isValidEmail($email)
	  {
		  if (function_exists('filter_var')) {
			  if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
				  return true;
			  } else
				  return false;
		  } else
			  return preg_match('/^[a-zA-Z0-9._+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/', $email);
	  } 	

      /**
       * User::validateToken()
       * 
       * @param mixed $token
       * @return
       */
     private function validateToken($token)
      {
          global $db;
          $token = sanitize($token,40);
          $sql = "SELECT token" 
		  . "\n FROM ".$this->uTable 
		  . "\n WHERE token ='" . $db->escape($token) . "'" 
		  . "\n LIMIT 1";
          $result = $db->query($sql);
          
          if ($db->numrows($result))
              return true;
      }
	  
	  /**
	   * Users::getUniqueCode()
	   * 
	   * @param string $length
	   * @return
	   */
	  private function getUniqueCode($length = "")
	  {
		  $code = sha1(uniqid(rand(), true));
		  if ($length != "") {
			  return substr($code, 0, $length);
		  } else
			  return $code;
	  }

	  /**
	   * Users::generateRandID()
	   * 
	   * @return
	   */
	  private function generateRandID()
	  {
		  return sha1($this->getUniqueCode(24));
	  }

	  /**
	   * Users::levelCheck()
	   * 
	   * @param string $levels
	   * @return
	   */
	  public function levelCheck($levels)
	  {
		  global $db;
		  $m_arr = explode(",", $levels);
		  reset($m_arr);
		  
		  if ($this->logged_in and in_array($this->userlevel, $m_arr))
		  return true;
	  }
	  
      /**
       * Users::getUserLevels()
       * 
       * @return
       */
      public function getUserLevels($level = false)
	  {
		  $arr = array(
				 9 => 'Super Admin',
				 1 => 'Registered User',
				 2 => 'User Level 2',
				 3 => 'User Level 3',
				 4 => 'User Level 4',
				 5 => 'User Level 5',
				 6 => 'User Level 6',
				 7 => 'User Level 7'
		  );
		  
		  $list = '';
		  foreach ($arr as $key => $val) {
				  if ($key == $level) {
					  $list .= "<option selected=\"selected\" value=\"$key\">$val</option>\n";
				  } else
					  $list .= "<option value=\"$key\">$val</option>\n";
		  }
		  unset($val);
		  return $list;
	  } 
	  	  	  
      /**
       * Users::getUserFilter()
       * 
       * @return
       */
      public function getUserFilter()
	  {
		  $arr = array(
				 'username-ASC' => 'Username &uarr;',
				 'username-DESC' => 'Username & &darr;',
				 'fname-ASC' => 'First Name &uarr;',
				 'fname-DESC' => 'First Name &darr;',
				 'lname-ASC' => 'Last Name &uarr;',
				 'lname-DESC' => 'Last Name &darr;',
				 'email-ASC' => 'Email Address &uarr;',
				 'email-DESC' => 'Email Address &darr;',
				 'created-ASC' => 'Registered &uarr;',
				 'created-DESC' => 'Registered &darr;',
		  );
		  
		  $filter = '';
		  foreach ($arr as $key => $val) {
				  if ($key == get('sort')) {
					  $filter .= "<option selected=\"selected\" value=\"$key\">$val</option>\n";
				  } else
					  $filter .= "<option value=\"$key\">$val</option>\n";
		  }
		  unset($val);
		  return $filter;
	  } 	  	  	  	   
  }
?>