<?php
if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');
  
  class Membership
  {
	  private $mTable = "memberships";
	  private $pTable = "payments";
	  private $gTable = "gateways";
	  

      /**
       * Membership::__construct()
       * 
       * @return
       */
      function __construct()
      {
		  

      }

      /**
       * Membership::getMemberships()
       * 
       * @return
       */
      public function getMemberships()
      {
          global $db;
          $sql = "SELECT * FROM ".$this->mTable." ORDER BY price";
          $row = $db->fetch_all($sql);
          
          return ($row) ? $row : 0;
      }

      /**
       * Membership::getMembershipListFrontEnd()
       * 
       * @return
       */
      public function getMembershipListFrontEnd()
      {
          global $db;
          $sql = "SELECT * FROM ".$this->mTable." WHERE private = 0 AND active = 1 ORDER BY price";
          $row = $db->fetch_all($sql);
          
          return ($row) ? $row : 0;
      }
	  
	  /**
	   * Membership::processMembership()
	   * 
	   * @return
	   */
	  public function processMembership()
	  {
		  global $db, $core;
		  if (empty($_POST['title']))
			  $core->msgs['title'] = 'Please enter Membership Title!';
		  
		  if (empty($_POST['price']))
			  $core->msgs['price'] = 'Please enter valid Price!';

		  if (empty($_POST['days']))
			  $core->msgs['days'] = 'Please Enter membership period!';

		  if (!is_numeric($_POST['days']))
			  $core->msgs['days'] = 'Membership period must be numeric value!';
			  			  			  		  
		  if (empty($core->msgs)) {
			  $data = array(
					  'title' => sanitize($_POST['title']), 
					  'price' => floatval($_POST['price']),
					  'days' => intval($_POST['days']),
					  'period' => sanitize($_POST['period']),
					  'trial' => intval($_POST['trial']),
					  'recurring' => intval($_POST['recurring']),
					  'private' => intval($_POST['private']),
					  'description' => sanitize($_POST['description']),
					  'active' => intval($_POST['active'])
			  );

			  if ($data['trial'] == 1) {
				  $trial['trial'] = "DEFAULT(trial)";
				  $db->update($this->mTable, $trial);
			  }
			  
			  ($core->id) ? $db->update($this->mTable, $data, "id='" . (int)$core->id . "'") : $db->insert($this->mTable, $data);
			  $message = ($core->id) ? '<span>Success!</span>Membership updated successfully!' : '<span>Success!</span>Membership added successfully!';
			  
			  ($db->affected()) ? $core->msgOk($message) :  $core->msgAlert('<span>Alert!</span>Nothing to process.');
		  } else
			  print $core->msgStatus();
	  }

      /**
       * Membership::getMembershipPeriod()
       * 
       * @param bool $sel
       * @return
       */
      public function getMembershipPeriod($sel = false)
	  {
		  $arr = array(
				 'D' => "Days",
				 'W' => "Weeks",
				 'M' => "Months",
				 'Y' => "Years"
		  );
		  
		  $data = '';
		  $data .= '<select name="period" style="width:80px" class="select">';
		  foreach ($arr as $key => $val) {
              if ($key == $sel) {
                  $data .= "<option selected=\"selected\" value=\"" . $key . "\">" . $val . "</option>\n";
              } else
                  $data .= "<option value=\"" . $key . "\">" . $val . "</option>\n";
          }
          unset($val);
		  $data .= "</select>";
          return $data;
      }

      /**
       * Membership::getPeriod()
       * 
       * @param bool $value
       * @return
       */
      public function getPeriod($value)
	  {
		  switch($value) {
			  case "D" :
			  return "Days";
			  break;
			  case "W" :
			  return "Weeks";
			  break;
			  case "M" :
			  return "Months";
			  break;
			  case "Y" :
			  return "Years";
			  break;
		  }

      }

	  /**
	   * Membership::calculateDays()
	   * 
	   * @return
	   */
	  public function calculateDays($period, $days)
	  {
		  global $db;
		  
		  $now = date('Y-m-d H:i:s');
			  switch($period) {
				  case "D" :
				  $diff = $days;
				  break;
				  case "W" :
				  $diff = $days * 7;
				  break; 
				  case "M" :
				  $diff = $days * 30;
				  break;
				  case "Y" :
				  $diff = $days * 365;
				  break;
			  }
			return date("d M Y", strtotime($now . + $diff . " days"));
	  }

	  /**
	   * Membership::getTotalDays()
	   * Used for MoneyBookers
	   * @return
	   */
	  public function getTotalDays($period, $days)
	  {
		  switch($period) {
			  case "D" :
			  $diff = $days;
			  break;
			  case "W" :
			  $diff = $days * 7;
			  break; 
			  case "M" :
			  $diff = $days * 30;
			  break;
			  case "Y" :
			  $diff = $days * 365;
			  break;
		  }
		return $diff;
	  }	  	  	  	  	  
      /**
       * Membership::getPayments()
       * 
       * @param bool $where
       * @param bool $from
       * @return
       */
      public function getPayments($where = false, $from = false)
      {
		  global $db, $core, $pager;
		  
		  require_once(BASEPATH . "lib/class_paginate.php");

          $pager = new Paginator();
          $counter = countEntries($this->pTable);
          $pager->items_total = $counter;
          $pager->default_ipp = $core->perpage;
          $pager->paginate();
          
          if ($counter == 0) {
              $pager->limit = null;
          }
		  
          $clause = ($where) ? " WHERE p.rate_amount LIKE '%" . intval($where) . "%'" : "";

		  if (isset($_GET['sort'])) {
			  list($sort, $order) = explode("-", $_GET['sort']);
			  $sort = sanitize($sort);
			  $order = sanitize($order);
			  if (in_array($sort, array("user_id", "rate_amount", "pp", "date"))) {
				  $ord = ($order == 'DESC') ? " DESC" : " ASC";
				  $sorting = " p." . $sort . $ord;
			  } else {
				  $sorting = " p.date DESC";
			  }
		  } else {
			  $sorting = " p.date DESC";
		  }
		  
          if (isset($_POST['fromdate']) && $_POST['fromdate'] <> "" || isset($from) && $from != '') {
              $enddate = date("Y-m-d");
              $fromdate = (empty($from)) ? $_POST['fromdate'] : $from;
              if (isset($_POST['enddate']) && $_POST['enddate'] <> "") {
                  $enddate = $_POST['enddate'];
              }
              $clause .= " WHERE p.date BETWEEN '" . trim($fromdate) . "' AND '" . trim($enddate) . " 23:59:59'";
          } 
		  
          $sql = "SELECT p.*, p.id as id, u.username, m.title,"
		  . "\n DATE_FORMAT(p.date, '%d. %b. %Y.') as created"
		  . "\n FROM ".$this->pTable." as p"
		  . "\n LEFT JOIN users as u ON u.id = p.user_id" 
		  . "\n LEFT JOIN ".$this->mTable." as m ON m.id = p.membership_id" 
		  . "\n " . $clause . " ORDER BY " . $sorting . $pager->limit;
		   
          $row = $db->fetch_all($sql);
          
		  return ($row) ? $row : 0;
      }
	  
      /**
       * Membership::getPaymentFilter()
       * 
       * @return
       */
      public function getPaymentFilter()
	  {
		  $arr = array(
				 'user_id-ASC' => 'Username &uarr;',
				 'user_id-DESC' => 'Username &darr;',
				 'rate_amount-ASC' => 'Amount &uarr;',
				 'rate_amount-DESC' => 'Amount &darr;',
				 'pp-ASC' => 'Processor &uarr;',
				 'pp-DESC' => 'Processor &darr;',
				 'date-ASC' => 'Payment Date &uarr;',
				 'date-DESC' => 'Payment Date &darr;',
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
	  
      /**
       * Membership::monthlyStats()
       * 
       * @return
       */
      public function monthlyStats()
      {
          global $db, $core;
		  
          $sql = "SELECT id, COUNT(id) as total, SUM(rate_amount) as totalprice" 
		  . "\n FROM ".$this->pTable 
		  . "\n WHERE status = '1'" 
		  . "\n AND date > '" . $core->year . "-" . $core->month . "-01'" 
		  . "\n AND date < '" . $core->year . "-" . $core->month . "-31 23:59:59'";
          
          $row = $db->first($sql);
          
		  return ($row['total'] > 0) ? $row : false;
      }

      /**
       * Membership::yearlyStats()
       * 
       * @return
       */
      public function yearlyStats()
      {
          global $db, $core;
		  
          $sql = "SELECT *, YEAR(date) as year, MONTH(date) as month," 
		  . "\n COUNT(id) as total, SUM(rate_amount) as totalprice" 
		  . "\n FROM ".$this->pTable 
		  . "\n WHERE status = '1'" 
		  . "\n AND YEAR(date) = '" . $core->year . "'" 
		  . "\n GROUP BY year DESC ,month DESC ORDER by date";
          
          $row = $db->fetch_all($sql);
          
          return ($row) ? $row : 0;
      }

      /**
       * Membership::getYearlySummary()
       * 
       * @return
       */
      public function getYearlySummary()
      {
          global $db, $core;
          
          $sql = "SELECT YEAR(date) as year, MONTH(date) as month," 
		  . "\n COUNT(id) as total, SUM(rate_amount) as totalprice" 
		  . "\n FROM ".$this->pTable
		  . "\n WHERE status = '1'" 
		  . "\n AND YEAR(date) = '" . $core->year . "'";
          
          $row = $db->first($sql);
          
          return ($row) ? $row : 0;
      }
	   
      /**
       * Membership::totalIncome()
       * 
       * @return
       */
      public function totalIncome()
      {
          global $db, $core;
          $sql = "SELECT SUM(rate_amount) as totalsale"
		  . "\n FROM ".$this->pTable
		  . "\n WHERE status = '1'";
          $row = $db->first($sql);
          
          $total_income = $core->formatMoney($row['totalsale']);
          
          return $total_income;
      }
  
	  /**
	   * Membership::membershipCron()
	   * 
	   * @param mixed $days
	   * @return
	   */
	  function membershipCron($days)
	  {
		  global $db, $core;
		  
		  $sql = "SELECT u.id, CONCAT(u.fname,' ',u.lname) as name, u.email, u.membership_id, u.trial_used, m.title, m.days," 
		  . "\n DATE_FORMAT(u.mem_expire, '%d %b %Y') as edate" 
		  . "\n FROM users as u" 
		  . "\n LEFT JOIN ".$this->mTable." AS m ON m.id = u.membership_id" 
		  . "\n WHERE u.active = 'y' AND u.membership_id !=0" 
		  . "\n AND TO_DAYS(NOW()) - TO_DAYS(u.mem_expire) = '".(int)$days."'";

		  $listrow = $db->fetch_all($sql);
		  require_once(BASEPATH . "lib/class_mailer.php");
	  
		  if ($listrow) {
			  switch ($days) {
				  case 7:
					  $mailer = $mail->sendMail();
					  $mailer->registerPlugin(new Swift_Plugins_AntiFloodPlugin(100));
					  
					  $trow = $core->getRowById("email_templates", 8);
					  $body = cleanOut($trow['body']);
					  
					  $replacements = array();
					  foreach ($listrow as $cols) {
						  $replacements[$cols['email']] = array('[NAME]' => $cols['name'],'[SITE_NAME]' => $core->site_name,'[URL]' => $core->site_url);
					  }
					  
					  $decorator = new Swift_Plugins_DecoratorPlugin($replacements);
					  $mailer->registerPlugin($decorator);
					  
					  $message = Swift_Message::newInstance()
								->setSubject($trow['subject'])
								->setFrom(array($core->site_email => $core->site_name))
								->setBody($body, 'text/html');
					  
					  foreach ($listrow as $row)
						  $message->addTo($row['email'], $row['name']);
					  unset($row);
					  
					  $numSent = $mailer->batchSend($message);				  
					  break;
					  
				  case 0:
					  $mailer = $mail->sendMail();
					  $mailer->registerPlugin(new Swift_Plugins_AntiFloodPlugin(100));
					  
					  $trow = $core->getRowById("email_templates", 9);
					  $body = cleanOut($trow['body']);
					  
					  $replacements = array();
					  foreach ($listrow as $cols) {
						  $replacements[$cols['email']] = array('[NAME]' => $cols['name'],'[SITE_NAME]' => $core->site_name,'[URL]' => $core->site_url);
					  }
					  
					  $decorator = new Swift_Plugins_DecoratorPlugin($replacements);
					  $mailer->registerPlugin($decorator);
					  
					  $message = Swift_Message::newInstance()
								->setSubject($trow['subject'])
								->setFrom(array($core->site_email => $core->site_name))
								->setBody($body, 'text/html');
					  
					  foreach ($listrow as $row) {
						  $message->addTo($row['email'], $row['name']);
                          $data = array(
								'membership_id' => 0, 
								'mem_expire' => "0000-00-00 00:00:00"
						  );
						  $db->update("users", $data, "id = '".(int)$row['id']."'");	
					  }
					  unset($row);
					  $numSent = $mailer->batchSend($message);	

					  break;
			  }
		  }
	  }

      /**
       * Membership::getGateways()
       * 
       * @return
       */
      public function getGateways($active = false)
      {
          global $db;
		  
		  $where = ($active) ? "WHERE active = '1'" : null ;
          $sql = "SELECT * FROM " . $this->gTable 
		  . "\n " . $where
		  . "\n ORDER BY name";
          $row = $db->fetch_all($sql);
          
          return ($row) ? $row : 0;
      }

	  
	  /**
	   * Membership::processGateway()
	   * 
	   * @return
	   */
	  public function processGateway()
	  {
		  global $db, $core;
		  
		  if (empty($_POST['displayname']))
			  $core->msgs['displayname'] = 'Please Enter Display Gateway Name';

		  if (empty($_POST['extra']))
			  $core->msgs['extra'] = 'Please Enter Valid Email Address';
			  			  		  
		  if (empty($core->msgs)) {
			  $data = array(
					  'displayname' => sanitize($_POST['displayname']), 
					  'extra' => sanitize($_POST['extra']),
					  'extra2' => sanitize($_POST['extra2']),
					  'extra3' => sanitize($_POST['extra3']),
					  'demo' => intval($_POST['demo']),
					  'active' => intval($_POST['active'])
			  );

			  $db->update($this->gTable, $data, "id='" . (int)$core->id . "'");
			  ($db->affected()) ? $core->msgOk('<span>Success!</span>Gateway Configuration Updated Successfully') :  $core->msgAlert('<span>Alert!</span>Nothing to process.');
		  } else
			  print $core->msgStatus();
	  }

	  /**
	   * Membership::processBuilder()
	   * 
	   * @return
	   */
	  public function processBuilder()
	  {
		  global $db, $core, $user;
		  
		  if (empty($_POST['pagename']))
			  $core->msgs['pagename'] = 'Please Enter Valid Page Name';

		  if (empty($_POST['membership_id']))
			  $core->msgs['membership_id'] = 'Please Select at least one membership type';
			  		  		  
		  if (empty($core->msgs)) {
			  $pagename = sanitize($_POST['pagename']);
			  $pagename = preg_replace("/&([a-zA-Z])(uml|acute|grave|circ|tilde|ring),/","",$pagename);
			  $pagename = preg_replace("/[^a-zA-Z0-9_.-]/","",$pagename);
			  $pagename = str_replace(array('---','--'),'-', $pagename);
			  $pagename = str_replace(array('..','.'),'', $pagename);
	
			  $header = intval($_POST['header']);

			  $mids = $_POST['membership_id'];
			  $total = count($mids);
			  $i = 1;
			  if (is_array($mids)) {
				  $midata = '';
				  foreach ($mids as $mid) {
					  if ($i == $total) {
						  $midata .= $mid;
					  } else
						  $midata .= $mid . ",";
					  $i++;
				  }
			  }
			  $mem_id = $midata;
			  
			  $data = "<?php \n" 
			  . "\t/** \n" 
			  . "\t* ".$pagename."\n"
			  . "\n"
			  . "\t* @package Membership Manager Pro\n"
			  . "\t* @author wojoscripts.com\n"
			  . "\t* @copyright 2011\n"
			  . "\t* @version Id: ".$pagename.".php, v2.00 ".date('Y-m-d H:i:s')." gewa Exp $\n"
			  . "\t*/\n"
	
			  . " \n" 
			  . "\t define(\"_VALID_PHP\", true); \n"
			  . "\t require_once(\"init.php\");\n"
			  . " \n" 
			  . "?>";
			  
			  if($header == 1) {
			   $data .= "" 
			  . " \n" 
			  . " \n" 
			  . " <?php include(\"header.php\");?> \n"
			  . " \n" 
			  . " \n";
			  }

			  $data .= "" 
			  . "\t <?php if(\$user->checkMembership('$mem_id')): ?>\n"
			  . " \n" 
			  . "\t <h1>User has valid membership, you can display your protected content here</h1>.\n"
			  . " \n" 
			  . "\t <?php else: ?>\n"
			  . " \n" 
			  . "\t <h1>User membership is't not valid. Show your custom error message here</h1>\n"
			  . " \n" 
			  . "\t <?php endif; ?>\n"
			  . "";

			  if($header == 1) {
			   $data .= "" 
			  . " \n" 
			  . " \n" 
			  . " <?php include(\"footer.php\");?> \n"
			  . " \n" 
			  . " \n";
			  }
			  
			  $pagefile = UPLOADS . $pagename . '.php';
			  if (is_writable(UPLOADS)) {
				  $handle = fopen($pagefile, 'w');
				  fwrite($handle, $data);
				  fclose($handle);
				  $core->msgOk('<span>Success!</span>Page ' . $pagename . ' created successfully!');
			  } else {
				  $core->msgError('<span>Error!</span>There was an error creating ' . $pagename . ' Make sure your uploads directory is writable!');
			  }

		  } else
			  print $core->msgStatus();
	  }

	  	  	  	  
      /**
       * Membership::verifyTxnId()
       * 
       * @param mixed $txn_id
       * @return
       */
      public function verifyTxnId($txn_id)
      {
          global $db;
          
          $sql = $db->query("SELECT id" 
				. "\n FROM ".$this->pTable."" 
				. "\n WHERE txn_id = '" . sanitize($txn_id) . "'" 
				. "\n LIMIT 1");
		  		
          if ($db->numrows($sql) > 0)
              return false;
          else
              return true;
      }
  }
?>