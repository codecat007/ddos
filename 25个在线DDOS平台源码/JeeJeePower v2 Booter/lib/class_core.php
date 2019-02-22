<?php
if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');
  
  class Core
  {
      
	  public $msgs = array();
	  public $showMsg;
	  private $sTable = "settings";
	  public $action = null;
	  public $id = null;
	  public $do = null;
      public $year = null;
      public $month = null;
      public $day = null;
	  
	  
      /**
       * Core::__construct()
       * 
       * @return
       */
      function __construct()
      {
          $this->getSettings();
		  $this->getAction();
		  $this->getDo();
		  $this->getId();
		  
          $this->year = (get('year')) ? get('year') : strftime('%Y');
          $this->month = (get('month')) ? get('month') : strftime('%m');
          $this->day = (get('day')) ? get('day') : strftime('%d');
          
          return mktime(0, 0, 0, $this->month, $this->day, $this->year);
      }

	  /**
	   * Core::getId()
	   * 
	   * @return
	   */
	  private function getId()
	  {
	  	  global $DEBUG;
		  if (isset($_GET['id'])) {
			  $_GET['id'] = sanitize($_GET['id'],6,true);
			  $id = (is_numeric($_GET['id']) && $_GET['id'] > -1) ? intval($_GET['id']) : false;
		  
			  if ($id) {
				  return $this->id = $id;
			  } else {
				  if($DEBUG)
				  	$this->error("You have selected an Invalid Id","Core::getId()");
			  }
		  }
	  }
	        
      /**
       * Core::getSettings()
       *
       * @return
       */
      private function getSettings()
      {
          global $db;
          $sql = "SELECT * FROM " . $this->sTable;
          $row = $db->first($sql);
          
          $this->site_name = $row['site_name'];
          $this->site_url = $row['site_url'];
		  $this->site_email = $row['site_email'];
		  $this->perpage = $row['user_perpage'];
		  $this->backup = $row['backup'];
		  $this->thumb_w = $row['thumb_w'];
		  $this->thumb_h = $row['thumb_h'];
		  $this->reg_allowed = $row['reg_allowed'];
		  $this->user_limit = $row['user_limit'];
		  $this->reg_verify = $row['reg_verify'];
		  $this->notify_admin = $row['notify_admin'];
		  $this->auto_verify = $row['auto_verify'];
		  $this->currency = $row['currency'];
		  $this->cur_symbol = $row['cur_symbol'];
		  $this->mailer = $row['mailer'];
		  $this->smtp_host = $row['smtp_host'];
		  $this->smtp_user = $row['smtp_user'];
		  $this->smtp_pass = $row['smtp_pass'];
		  $this->smtp_port = $row['smtp_port'];
		  $this->version = $row['version'];

      }

      /**
       * Core::processConfig()
       * 
       * @return
       */
	  public function processConfig()
	  {
		  global $db;
		  
		  if (empty($_POST['site_name']))
			  $this->msgs['site_name'] = "Please enter Website Name!";
		  
		  if (empty($_POST['site_url']))
			  $this->msgs['site_url'] = "Please enter Website Url!";
		  
		  if (empty($_POST['site_email']))
			  $this->msgs['site_email'] = "Please enter valid Website Email address!";
		  
		  if (empty($_POST['thumb_w']))
			  $this->msgs['thumb_w'] = "Please enter Thumbnail Width!";
		  
		  if (empty($_POST['thumb_h']))
			  $this->msgs['thumb_h'] = "Please enter Thumbnail Height!";

		  if (empty($_POST['currency']))
			  $this->msgs['currency'] = _CG_CURRENCY_R;
			  
		  if ($_POST['mailer'] == "SMTP") {
			  if (empty($_POST['smtp_host']))
				  $this->msgs['smtp_host'] = 'Please Enter Valid SMTP Host!';
			  if (empty($_POST['smtp_user']))
				  $this->msgs['smtp_user'] = 'Please Enter Valid SMTP Username!';
			  if (empty($_POST['smtp_pass']))
				  $this->msgs['smtp_pass'] = 'Please Enter Valid SMTP Password!';
			  if (empty($_POST['smtp_port']))
				  $this->msgs['smtp_port'] = 'Please Enter Valid SMTP Port!';
		  }
		  
		  if (empty($this->msgs)) {
			  $data = array(
					  'site_name' => sanitize($_POST['site_name']), 
					  'site_url' => sanitize($_POST['site_url']),
					  'site_email' => sanitize($_POST['site_email']),
					  'reg_allowed' => intval($_POST['reg_allowed']),
					  'user_limit' => intval($_POST['user_limit']),
					  'reg_verify' => intval($_POST['reg_verify']),
					  'notify_admin' => intval($_POST['notify_admin']),
					  'auto_verify' => intval($_POST['auto_verify']),
					  'user_perpage' => intval($_POST['user_perpage']),
					  'thumb_w' => intval($_POST['thumb_w']),
					  'thumb_h' => intval($_POST['thumb_h']),
					  'currency' => sanitize($_POST['currency']),
					  'cur_symbol' => sanitize($_POST['cur_symbol']),
					  'mailer' => sanitize($_POST['mailer']),
					  'smtp_host' => sanitize($_POST['smtp_host']),
					  'smtp_user' => sanitize($_POST['smtp_user']),
					  'smtp_pass' => sanitize($_POST['smtp_pass']),
					  'smtp_port' => intval($_POST['smtp_port'])

			  );
			  
			  $db->update($this->sTable, $data);
			  ($db->affected()) ? $this->msgOk("<span>Success!</span>System Configuration updated successfully!") : $this->msgAlert("<span>Alert!</span>Nothing to process.");
		  } else
			  print $this->msgStatus();
	  }

	  /**
	   * Core::processNewsletter()
	   * 
	   * @return
	   */
	  public function processNewsletter()
	  {
		  global $db;
		  
		  if (empty($_POST['subject']))
			  $this->msgs['subject'] = "Please Enter Newsletter Subject";
		  
		  if (empty($_POST['body']))
			  $this->msgs['body'] = "Please Enter Email Message!";
		  
		  if (empty($this->msgs)) {
				  $to = sanitize($_POST['recipient']);
				  $subject = sanitize($_POST['subject']);
				  $body = cleanOut($_POST['body']);
				  $numSent = false;

			  switch ($to) {
				  case "all":
					  require_once(BASEPATH . "lib/class_mailer.php");
					  $mailer = $mail->sendMail();
					  $mailer->registerPlugin(new Swift_Plugins_AntiFloodPlugin(100));
					  
					  $sql = "SELECT email, CONCAT(fname,' ',lname) as name FROM users WHERE id != 1";
					  $userrow = $db->fetch_all($sql);
					  
					  $replacements = array();
					  if($userrow) {
						  foreach ($userrow as $cols) {
							  $replacements[$cols['email']] = array('[NAME]' => $cols['name'],'[SITE_NAME]' => $this->site_name,'[URL]' => $this->site_url);
						  }
						  
						  $decorator = new Swift_Plugins_DecoratorPlugin($replacements);
						  $mailer->registerPlugin($decorator);
						  
						  $message = Swift_Message::newInstance()
									->setSubject($subject)
									->setFrom(array($this->site_email => $this->site_name))
									->setBody($body, 'text/html');
						  
						  foreach ($userrow as $row)
							  $message->addTo($row['email'], $row['name']);
						  unset($row);
						  
						  $numSent = $mailer->batchSend($message);
					  }
					  break;
					  
				  case "newsletter":
					  require_once(BASEPATH . "lib/class_mailer.php");
					  $mailer = $mail->sendMail();
					  $mailer->registerPlugin(new Swift_Plugins_AntiFloodPlugin(100));
					  
					  $sql = "SELECT email, CONCAT(fname,' ',lname) as name FROM users WHERE newsletter = '1' AND id != 1";
					  $userrow = $db->fetch_all($sql);
					  
					  $replacements = array();
					  if($userrow) {
						  foreach ($userrow as $cols) {
							  $replacements[$cols['email']] = array('[NAME]' => $cols['name'],'[SITE_NAME]' => $this->site_name,'[URL]' => $this->site_url);
						  }
						  
						  $decorator = new Swift_Plugins_DecoratorPlugin($replacements);
						  $mailer->registerPlugin($decorator);
						  
						  $message = Swift_Message::newInstance()
									->setSubject($subject)
									->setFrom(array($this->site_email => $this->site_name))
									->setBody($body, 'text/html');
						  
						  foreach ($userrow as $row)
							  $message->addTo($row['email'], $row['name']);
						  unset($row);
						  
						  $numSent = $mailer->batchSend($message);
					  }
					  break;

				  case "free":
					  require_once(BASEPATH . "lib/class_mailer.php");
					  $mailer = $mail->sendMail();
					  $mailer->registerPlugin(new Swift_Plugins_AntiFloodPlugin(100));
					  
					  $sql = "SELECT email,CONCAT(fname,' ',lname) as name FROM users WHERE membership_id = 0 AND id != 1";
					  $userrow = $db->fetch_all($sql);
					  
					  $replacements = array();
					  if($userrow) {
						  foreach ($userrow as $cols) {
							  $replacements[$cols['email']] = array('[NAME]' => $cols['name'],'[SITE_NAME]' => $this->site_name,'[URL]' => $this->site_url);
						  }
						  
						  $decorator = new Swift_Plugins_DecoratorPlugin($replacements);
						  $mailer->registerPlugin($decorator);
						  
						  $message = Swift_Message::newInstance()
									->setSubject($subject)
									->setFrom(array($this->site_email => $this->site_name))
									->setBody($body, 'text/html');
						  
						  foreach ($userrow as $row)
							  $message->addTo($row['email'], $row['name']);
						  unset($row);
						  
						  $numSent = $mailer->batchSend($message);
					  }
					  break;

				  case "paid":
					  require_once(BASEPATH . "lib/class_mailer.php");
					  $mailer = $mail->sendMail();
					  $mailer->registerPlugin(new Swift_Plugins_AntiFloodPlugin(100));
					  
					  $sql = "SELECT email, CONCAT(fname,' ',lname) as name FROM users WHERE membership_id <> 0 AND id != 1";
					  $userrow = $db->fetch_all($sql);
					  
					  $replacements = array();
					  if($userrow) {
						  foreach ($userrow as $cols) {
							  $replacements[$cols['email']] = array('[NAME]' => $cols['name'],'[SITE_NAME]' => $this->site_name,'[URL]' => $this->site_url);
						  }
						  
						  $decorator = new Swift_Plugins_DecoratorPlugin($replacements);
						  $mailer->registerPlugin($decorator);
						  
						  $message = Swift_Message::newInstance()
									->setSubject($subject)
									->setFrom(array($this->site_email => $this->site_name))
									->setBody($body, 'text/html');
						  
						  foreach ($userrow as $row)
							  $message->addTo($row['email'], $row['name']);
						  unset($row);
						  
						  $numSent = $mailer->batchSend($message);
					  }
					  break;
					  				  	  
				  default:
					  require_once(BASEPATH . "lib/class_mailer.php");
					  $mailer = $mail->sendMail();	
					  			  
					  $row = $db->first("SELECT email, CONCAT(fname,' ',lname) as name FROM users WHERE email LIKE '%" . sanitize($to) . "%'");
					  if($row) {
						  $newbody = str_replace(array('[NAME]', '[SITE_NAME]', '[URL]'), 
						  array($row['name'], $this->site_name, $this->site_url), $body);
	
						  $message = Swift_Message::newInstance()
									->setSubject($subject)
									->setTo(array($to => $row['name']))
									->setFrom(array($this->site_email => $this->site_name))
									->setBody($newbody, 'text/html');
						  
						  $numSent = $mailer->send($message);
					  }
					  break;
			  }

			  ($numSent) ? $this->msgOk("<span>Success!</span>All Email(s) have been sent successfully!") :  $this->msgAlert("<span>Error!</span>Some of the emails could not be sent!");

		  } else
			  print $this->msgStatus();
	  }

      /**
       * Core::getEmailTemplates()
       * 
       * @return
       */
      public function getEmailTemplates()
      {
          global $db;
          $sql = "SELECT * FROM email_templates ORDER BY name ASC";
          $row = $db->fetch_all($sql);
          
          return ($row) ? $row : 0;
      }

	  /**
	   * Core:::processEmailTemplate()
	   * 
	   * @return
	   */
	  public function processEmailTemplate()
	  {
		  global $db;
		  
		  if (empty($_POST['name']))
			  $this->msgs['name'] = "Please Enter Template Title!";
		  
		  if (empty($_POST['subject']))
			  $this->msgs['subject'] = "Please Enter Email Subject!";

		  if (empty($_POST['body']))
			  $this->msgs['body'] = "Template Content is required!";
			  		  
		  if (empty($this->msgs)) {
			  $data = array(
					  'name' => sanitize($_POST['name']), 
					  'subject' => sanitize($_POST['subject']),
					  'body' => $_POST['body'],
					  'help' => $_POST['help']
			  );

			  $db->update("email_templates", $data, "id='" . (int)$this->id . "'");
			  ($db->affected()) ? $this->msgOk("<span>Success!</span>Email Template Updated Successfully") :  $this->msgAlert("<span>Alert!</span>Nothing to process.");
		  } else
			  print $this->msgStatus();
	  }

      /**
       * Core::getNews()
       * 
       * @return
       */
      public function getNews()
      {
          global $db;
          $sql = "SELECT *, DATE_FORMAT(created, '%d. %b. %Y') as cdate FROM news ORDER BY title ASC";
          $row = $db->fetch_all($sql);
          
          return ($row) ? $row : 0;
      }

      /**
       * Core::renderNews()
       * 
       * @return
       */
      public function renderNews()
      {
          global $db;
          $sql = "SELECT *, DATE_FORMAT(created, '%d. %b. %Y') as cdate FROM news WHERE active = 1";
          $row = $db->first($sql);
          
          return ($row) ? $row : 0;
      }
	  
	  /**
	   * Content::processNews()
	   * 
	   * @return
	   */
	  public function processNews()
	  {
		  global $db;
		  
		  if (empty($_POST['title']))
			  $this->msgs['title'] = 'Please Enter News Title';

		  if (empty($_POST['body']))
			  $this->msgs['body'] = 'Please Enter News Content';
			  		  
		  if (empty($_POST['created']))
			  $this->msgs['created'] = 'Please Enter Valid Date';
		  
		  if (empty($this->msgs)) {
			  $data = array(
				  'title' => sanitize($_POST['title']), 
				  'author' => sanitize($_POST['author']), 
				  'body' => sanitize($_POST['body']),
				  'created' => sanitize($_POST['created']),
				  'active' => intval($_POST['active'])
			  );

			  if ($data['active'] == 1) {
				  $news['active'] = "DEFAULT(active)";
				  $db->update("news", $news);
			  }
			  
			  ($this->id) ? $db->update("news", $data, "id='" . (int)$this->id . "'") : $db->insert("news", $data);
			  $message = ($this->id) ? '<span>Success!</span>News item updated successfully!' : '<span>Success!</span>News item added successfully!';
			  
			  ($db->affected()) ? $this->msgOk($message) :  $this->msgAlert('<span>Alert!</span>Nothing to process.');
		  } else
			  print $this->msgStatus();
	  }
	  	  
      /**
       * Core::monthList()
       * 
       * @return
       */ 	  
      public function monthList()
	  {
		  $selected = is_null(get('month')) ? strftime('%m') : get('month');
		  
		  $arr = array(
				'01' => "Jan",
				'02' => "Feb",
				'03' => "Mar",
				'04' => "Apr",
				'05' => "May",
				'06' => "Jun",
				'07' => "Jul",
				'08' => "Aug",
				'09' => "Sep",
				'10' => "Oct",
				'11' => "Nov",
				'12' => "Dec"
		  );
		  
		  $monthlist = '';
		  foreach ($arr as $key => $val) {
			  $monthlist .= "<option value=\"$key\"";
			  $monthlist .= ($key == $selected) ? ' selected="selected"' : '';
			  $monthlist .= ">$val</option>\n";
          }
          unset($val);
          return $monthlist;
      }

      /**
       * Core::yearList()
	   *
       * @param mixed $start_year
       * @param mixed $end_year
       * @return
       */
	  function yearList($start_year, $end_year)
	  {
		  $selected = is_null(get('year')) ? date('Y') : get('year');
		  $r = range($start_year, $end_year);
		  
		  $select = '';
		  foreach ($r as $year) {
			  $select .= "<option value=\"$year\"";
			  $select .= ($year == $selected) ? ' selected="selected"' : '';
			  $select .= ">$year</option>\n";
		  }
		  return $select;
	  }
	  	  
      /**
       * Core::monthlyStats()
       * 
       * @return
       */ 	  
      public function monthlyStats()
	  {
          global $db;
          $sql = "SELECT id, COUNT(id) as total" 
		  . "\n FROM users" 
		  . "\n WHERE created > '" . $this->year . "-" . $this->month . "-01'" 
		  . "\n AND created < '" . $this->year . "-" . $this->month . "-31 23:59:59'";
          
          $row = $db->first($sql);
          
		  return ($row['total'] > 0) ? $row : false;
      }
	  
      /**
       * Core::getStats()
       * 
       * @return
       */ 	  
      public function getStats()
	  {
          global $db;
          $sql = "SELECT id, COUNT(id) as total, DAY(created) as day FROM users" 
		  . "\n WHERE YEAR(created) = '" . $this->year . "'"
		  . "\n AND MONTH(created) = '" . $this->month . "' GROUP BY DATE(created)"; 
          
          $row = $db->fetch_all($sql);
          
          return ($row) ? $row : 0;
      }

	  /**
	   * Core::formatMoney()
	   * 
	   * @param mixed $amount
	   * @return
	   */
	  function formatMoney($amount)
	  {
		  return ($amount == 0) ? "FREE" : $this->cur_symbol . number_format($amount, 2, '.', ',') . $this->currency;
	  }
	  				  
      /**
       * getRowById()
       * 
       * @param mixed $table
       * @param mixed $id
       * @param bool $and
       * @param bool $is_admin
       * @return
       */
      public function getRowById($table, $id, $and = false, $is_admin = true)
      {
          global $db;
		  $id = sanitize($id, 8, true);
		  if ($and) {
			  $sql = "SELECT * FROM " . (string)$table . " WHERE id = '" . $db->escape((int)$id) . "' AND " . $db->escape($and) . "";
		  } else
			  $sql = "SELECT * FROM " . (string)$table . " WHERE id = '" . $db->escape((int)$id) . "'";
		  
          $row = $db->first($sql);
          
		  if ($row) {
			  return $row;
		  } else {
			  if ($is_admin)
				  $this->error("You have selected an Invalid Id - #".$id, "Core::getRowById()");
		  }
	  }

      /**
       * Core::msgAlert()
       * 
	   * @param mixed $msg
	   * @param bool $fader
	   * @param bool $altholder
       * @return
       */	  
	  public function msgAlert($msg, $fader = true, $altholder = false)
	  {
		$this->showMsg = "<div class=\"msgAlert\">" . $msg . "</div>";
		if ($fader == true)
		  $this->showMsg .= "<script type=\"text/javascript\"> 
		  // <![CDATA[
		  $(document).ready(function() {       
			setTimeout(function() {       
			  $(\".msgAlert\").customFadeOut(\"slow\",    
			  function() {       
				$(\".msgAlert\").remove();  
			  });
			},
			4000);
		  });
		  // ]]>
		  </script>";	
		  
		  print ($altholder) ? '<div id="alt-msgholder">'.$this->showMsg.'</div>' : $this->showMsg;
	  }

      /**
       * Core::msgOk()
       * 
	   * @param mixed $msg
	   * @param bool $fader
	   * @param bool $altholder
       * @return
       */	  
	  public function msgOk($msg, $fader = true, $altholder = false)
	  {
		$this->showMsg = "<div class=\"msgOk\">" . $msg . "</div>";
		if ($fader == true)
		  $this->showMsg .= "<script type=\"text/javascript\"> 
		  // <![CDATA[
		  $(document).ready(function() {       
			setTimeout(function() {       
			  $(\".msgOk\").customFadeOut(\"slow\",    
			  function() {       
				$(\".msgOk\").remove();  
			  });
			},
			4000);
		  });
		  // ]]>
		  </script>";	
		  
		  print ($altholder) ? '<div id="alt-msgholder">'.$this->showMsg.'</div>' : $this->showMsg;
	  }

      /**
       * Core::msgError()
       * 
	   * @param mixed $msg
	   * @param bool $fader
	   * @param bool $altholder
       * @return
       */	  
	  public function msgError($msg, $fader = true, $altholder = false)
	  {
		$this->showMsg = "<div class=\"msgError\">" . $msg . "</div>";
		if ($fader == true)
		  $this->showMsg .= "<script type=\"text/javascript\"> 
		  // <![CDATA[
		  $(document).ready(function() {       
			setTimeout(function() {       
			  $(\".msgError\").customFadeOut(\"slow\",    
			  function() {       
				$(\".msgError\").remove();  
			  });
			},
			4000);
		  });
		  // ]]>
		  </script>";	
	  
		  print ($altholder) ? '<div id="alt-msgholder">'.$this->showMsg.'</div>' : $this->showMsg;
	  } 	


	  /**
	   * msgInfo()
	   * 
	   * @param mixed $msg
	   * @param bool $fader
	   * @param bool $altholder
	   * @return
	   */
	  public function msgInfo($msg, $fader = true, $altholder = false)
	  {
		$this->showMsg = "<div class=\"msgInfo\">" . $msg . "</div>";
		if ($fader == true)
		  $this->showMsg .= "<script type=\"text/javascript\"> 
		  // <![CDATA[
		  $(document).ready(function() {       
			setTimeout(function() {       
			  $(\".msgInfo\").customFadeOut(\"slow\",    
			  function() {       
				$(\".msgInfo\").remove();  
			  });
			},
			4000);
		  });
		  // ]]>
		  </script>";
	  
		  print ($altholder) ? '<div id="alt-msgholder">'.$this->showMsg.'</div>' : $this->showMsg;
	  }
	    
      /**
       * Core::msgStatus()
       * 
       * @return
       */
	  public function msgStatus()
	  {
		  $this->showMsg = "<div class=\"msgError\"><span>Error!</span>An error occurred while processing request:<ul class=\"error\">";
		  foreach ($this->msgs as $msg) {
			  $this->showMsg .= "<li>" . $msg . "</li>\n";
		  }
		  $this->showMsg .= "</ul></div>";
		  
		  return $this->showMsg;
	  }	  

	  /**
	   * doForm()
	   * 
	   * @param mixed $data
	   * @param string $url
	   * @param integer $reset
	   * @param integer $clear
	   * @param string $form_id
	   * @param string $msgholder
	   * @return
	   */  
	  public function doForm($data, $url = "controller.php", $reset = 0, $clear = 0, $form_id = "admin_form", $msgholder = "msgholder")
	  {
		  $display ='
		  <script type="text/javascript">
		  // <![CDATA[
			  $(document).ready(function () {
				  var options = {
					  target: "#' . $msgholder . '",
					  beforeSubmit:  showLoader,
					  success: showResponse,
					  url: "' . $url . '",
					  resetForm : ' . $reset . ',
					  clearForm : ' . $clear . ',
					  data: {
						  ' .$data . ': 1
					  }
				  };
				  $("#' . $form_id . '").ajaxForm(options);
			  });
			  
			  function showLoader() {
				  $("#loader").fadeIn(200);
			  }
		  
			  function hideLoader() {
				  $("#loader").fadeOut(200);
			  };	
			  		  
			  function showResponse(msg) {
				  hideLoader();
				  $(this).html(msg);
				  $("html, body").animate({
					  scrollTop: 0
				  }, 600);
			  }
			  ';
          $display .='
		  // ]]>
		  </script>';
		  
		  print $display;
	  }
	  
      /**
       * Core::error()
       * 
	   * @param mixed $msg
	   * @param mixed $source
       * @return
       */
      public function error($msg, $source)
      {

          $the_error = "<div class=\"msgError\">";
          $the_error .= "<span>System ERROR!</span><br />";
          $the_error .= "DB Error: ".$msg." <br /> More Information: <br />";
          $the_error .= "<ul>";
          $the_error .= "<li> Date : " . date("F j, Y, g:i a") . "</li>";
		  $the_error .= "<li> Function: " . $source . "</li>";
          $the_error .= "<li> Script: " . $_SERVER['REQUEST_URI'] . "</li>";
		  $the_error .= "<li>&lsaquo; <a href=\"javascript:history.go(-1)\"><strong>Go Back to previous page</strong></a></li>";
          $the_error .= '</ul>';
          $the_error .= '</div>';
          print $the_error;
          die();
      }
  
      /**
       * Core::getAction()
       * 
       * @return
       */
	  private function getAction()
	  {
		  if (isset($_GET['action'])) {
			  $action = ((string)$_GET['action']) ? (string)$_GET['action'] : false;
			  $action = sanitize($action);
			  
			  if ($action == false) {
				  $this->error("You have selected an Invalid Action Method","Core::getAction()");
			  } else
				  return $this->action = $action;
		  }
	  }
  
      /**
       * Core::getDo()
       * 
       * @return
       */
	  private function getDo()
	  {
		  if (isset($_GET['do'])) {
			  $do = ((string)$_GET['do']) ? (string)$_GET['do'] : false;
			  $do = sanitize($do);
			  
			  if ($do == false) {
				  $this->error("You have selected an Invalid Do Method","Core::getDo()");
			  } else
				  return $this->do = $do;
		  }
	  }
  }
?>