<?php 
	/** 
	* Configuration

	* @package The Custom Source
	* @author customsource.co.uk
	* @copyright 2011
	* @version Id: config.ini.php, v2.00 2011-04-20 10:12:05 gewa Exp $
	*/
 
	 if (!defined("_VALID_PHP")) 
     die('Direct access to this location is not allowed.');
 
	/** 
	* Database Constants - these constants refer to 
	* the database configuration settings. 
	*/
	 define('DB_SERVER', 'localhost'); 
	 define('DB_USER', 'root'); 
	 define('DB_PASS', ''); 
	 define('DB_DATABASE', 'boot');
 
	/** 
	* Show MySql Errors. 
	* Not recomended for live site. true/false 
	*/
	$DEBUG = false; 
?>