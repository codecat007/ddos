<?php
if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');
?>
<?php error_reporting(E_ALL);

  // Magic Quotes Fix
  if (ini_get('magic_quotes_gpc')) {
      function clean($data)
      {
          if (is_array($data)) {
              foreach ($data as $key => $value) {
                  $data[clean($key)] = clean($value);
              }
          } else {
              $data = stripslashes($data);
          }
          
          return $data;
      }
      
      $_GET = clean($_GET);
      $_POST = clean($_POST);
      $_COOKIE = clean($_COOKIE);
  }
  
  $BASEPATH = str_replace("init.php", "", realpath(__FILE__));
  
  define("BASEPATH", $BASEPATH);
  
  $configFile = BASEPATH . "lib/config.ini.php";
  if (file_exists($configFile)) {
      require_once($configFile);
  } else {
      header("Location: setup/");
  }
  
  require_once(BASEPATH . "lib/class_db.php");
  $db = new Database(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE);
  $db->connect();
  
  include(BASEPATH . "lib/headerRefresh.php");
  require_once(BASEPATH . "lib/class_filter.php");
  $request = new Filter();

  //Include Functions
  require_once(BASEPATH . "lib/functions.php");
  
  //StartUser Class 
  require_once(BASEPATH . "lib/class_user.php");
  $user = new Users();

  //Start Core Class 
  require_once(BASEPATH . "lib/class_core.php");
  $core = new Core();

  //Load Membership Class
  require_once(BASEPATH . "lib/class_membership.php");
  $member = new Membership();
   
  define("SITEURL", $core->site_url);
  define("ADMINURL", $core->site_url."/admin");
  define("UPLOADS", BASEPATH."uploads/");
  define("UPLOADURL", SITEURL."/uploads/");
?>