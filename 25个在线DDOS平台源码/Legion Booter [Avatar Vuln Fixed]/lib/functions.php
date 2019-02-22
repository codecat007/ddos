<?php
if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');
  
  /**
   * redirect_to()
   * 
   * @param mixed $location
   * @return
   */
  function redirect_to($location)
  {
      if (!headers_sent()) {
          header('Location: ' . $location);
		  exit;
	  } else
          echo '<script type="text/javascript">';
          echo 'window.location.href="' . $location . '";';
          echo '</script>';
          echo '<noscript>';
          echo '<meta http-equiv="refresh" content="0;url=' . $location . '" />';
          echo '</noscript>';
  }
  
  /**
   * countEntries()
   * 
   * @param mixed $table
   * @param string $where
   * @param string $what
   * @return
   */
  function countEntries($table, $where = '', $what = '')
  {
      global $db;
      if (!empty($where) && isset($what)) {
          $q = "SELECT COUNT(*) FROM " . $table . "  WHERE " . $where . " = '" . $what . "' LIMIT 1";
      } else
          $q = "SELECT COUNT(*) FROM " . $table . " LIMIT 1";
      
      $record = $db->query($q);
      $total = $db->fetchrow($record);
      return $total[0];
  }
  
  /**
   * getChecked()
   * 
   * @param mixed $row
   * @param mixed $status
   * @return
   */
  function getChecked($row, $status)
  {
      if ($row == $status) {
          echo "checked=\"checked\"";
      }
  }
  
  /**
   * post()
   * 
   * @param mixed $var
   * @return
   */
  function post($var)
  {
      if (isset($_POST[$var]))
          return $_POST[$var];
  }
  
  /**
   * get()
   * 
   * @param mixed $var
   * @return
   */
  function get($var)
  {
      if (isset($_GET[$var]))
          return $_GET[$var];
  }
  
  /**
   * sanitize()
   * 
   * @param mixed $string
   * @param bool $trim
   * @return
   */
  function sanitize($string, $trim = false, $int = false, $str = false)
  {
      $string = filter_var($string, FILTER_SANITIZE_STRING);
      $string = trim($string);
      $string = stripslashes($string);
      $string = strip_tags($string);
      $string = str_replace(array('‘', '’', '“', '”'), array("'", "'", '"', '"'), $string);
      
	  if ($trim)
          $string = substr($string, 0, $trim);
      if ($int)
		  $string = preg_replace("/[^0-9\s]/", "", $string);
      if ($str)
		  $string = preg_replace("/[^a-zA-Z\s]/", "", $string);
		  
      return $string;
  }
    
  /**
   * getValue()
   * 
   * @param mixed $stwhatring
   * @param mixed $table
   * @param mixed $where
   * @return
   */
  function getValue($what, $table, $where)
  {
      global $db;
      $sql = "SELECT $what FROM $table WHERE $where";
      $row = $db->first($sql);
      return $row[$what];
  }  
  
  /**
   * tooltip()
   * 
   * @param mixed $tip
   * @return
   */
  function tooltip($tip)
  {
      return '<img src="'.SITEURL.'/images/tooltip.png" alt="Tip" class="tooltip" title="' . $tip . '" />';
  }
  
  /**
   * required()
   * 
   * @return
   */
  function required()
  {
      return '<img src="'.SITEURL.'//images/required.png" alt="Required Field" class="tooltip" title="Required Field" />';
  }

  /**
   * cleanOut()
   * 
   * @param mixed $text
   * @return
   */
  function cleanOut($text) {
	 $text =  strtr($text, array('\r\n' => "", '\r' => "", '\n' => ""));
	 $text = html_entity_decode($text, ENT_QUOTES, 'UTF-8');
	 $text = str_replace('<br>', '<br />', $text);
	 return stripslashes($text);
  }
    

  /**
   * isAdmin()
   * 
   * @param mixed $userlevel
   * @return
   */
  function isAdmin($userlevel)
  {
	  switch ($userlevel) {
		  case 9:
		     $display = '<img src="'.SITEURL.'/images/superadmin.png" alt="" class="tooltip" title="Super Admin"/>';
			 break;

		  case 7:
		     $display = '<img src="'.SITEURL.'/images/level7.png" alt="" class="tooltip" title="User Level 7"/>';
			 break;

		  case 6:
		     $display = '<img src="'.SITEURL.'/images/level6.png" alt="" class="tooltip" title="User Level 6"/>';
			 break;

		  case 5:
		     $display = '<img src="'.SITEURL.'/images/level5.png" alt="" class="tooltip" title="User Level 5"/>';
			 break;
			 
		  case 4:
		     $display = '<img src="'.SITEURL.'/images/level4.png" alt="" class="tooltip" title="User Level 4"/>';
			 break;		  

		  case 3:
		     $display = '<img src="'.SITEURL.'/images/level6.png" alt="" class="tooltip" title="User Level 3"/>';
			 break;

		  case 2:
		     $display = '<img src="'.SITEURL.'/images/level5.png" alt="" class="tooltip" title="User Level 2"/>';
			 break;
			 
		  case 1:
		     $display = '<img src="'.SITEURL.'/images/user.png" alt="" class="tooltip" title="User"/>';
			 break;			  
	  }

      return $display;;
  }

  /**
   * userStatus()
   * 
   * @param mixed $id
   * @return
   */
  function userStatus($status)
  {
	  switch ($status) {
		  case "y":
			  $display = '<img src="'.SITEURL.'/images/u_active.png" alt="" class="tooltip" title="User Active"/>';
			  break;
			  
		  case "n":
			  $display = '<img src="'.SITEURL.'/images/u_inactive.png" alt="" class="tooltip" title="User Inactive"/>';
			  break;
			  
		  case "t":
			  $display = '<img src="'.SITEURL.'/images/u_pending.png" alt="" class="tooltip" title="User Pending"/>';
			  break;
			  
		  case "b":
			  $display = '<img src="'.SITEURL.'/images/u_banned.png" alt="" class="tooltip" title="User Banned"/>';
			  break;
	  }
	  
      return $display;;
  }

  /**
   * isActive()
   * 
   * @param mixed $id
   * @return
   */
  function isActive($id)
  {
	  if ($id == 1) {
		  $display = '<img src="'.SITEURL.'/images/yes.png" alt="" class="tooltip img-wrap2" title="Active"/>';
	  } else {
		  $display = '<img src="'.SITEURL.'/images/no.png" alt="" class="tooltip img-wrap2" title="Inactive"/>';
	  }

      return $display;;
  }
  
  /**
   * barHeight()
   * 
   * @param mixed $total
   * @return
   */ 
  function barHeight($total)
  {
      switch ($total) {
          case ($total <= 10):
              print 10;
              break;
          case ($total >= 10 && $total <= 50):
              print 20;
              break;
          case ($total >= 50 && $total <= 100):
              print 30;
              break;
          case ($total >= 100 && $total <= 200):
              print 40;
              break;
          case ($total >= 200 && $total <= 300):
              print 50;
              break;
          case ($total >= 300 && $total <= 500):
              print 60;
              break;
          case ($total >= 500 && $total <= 700):
              print 70;
              break;
          case ($total >= 700 && $total <= 900):
              print 80;
              break;
          case ($total >= 900 && $total <= 1000):
              print 90;
              break;
          case ($total >= 1000 && $total > 3000):
              print 99;
              break;
      }
  }
  
  /**
   * randName()
   * 
   * @return
   */ 
  function randName() {
	  $code = '';
	  for($x = 0; $x<6; $x++) {
		  $code .= '-'.substr(strtoupper(sha1(rand(0,999999999999999))),2,6);
	  }
	  $code = substr($code,1);
	  return $code;
  }
?>