<?php

define('DB_HOST', 'localhost');
define('DB_USER', 'username');
define('DB_PASS', 'passowrd');
define('DATABASE', 'database');

/* PayPal Information */
define('PAYPAL_EMAIL', 'boulefredreda@hotmail.com');
define('PP_CURRENCY', 'USD');
define('PP_LOCATION', 'US');
define('PP_RETURN', 'http://www.edgeforce.net/files/php/quickbooter/update.php');


// Membership 1
define('PP_NAME_1', 'QuickBooter 1M Bronze');
define('PP_AMOUNT_1', '5');
define('BOOTTIME_1', '120');


// Membership 2
define('PP_NAME_2', 'QuickBooter 1M Silver');
define('PP_AMOUNT_2', '15');
define('BOOTTIME_2', '600');


// Membership 3
define('PP_NAME_3', 'QuickBooter 1M Gold');
define('PP_AMOUNT_3', '35');
define('BOOTTIME_3', '1200');





define('DEFAULT_POWER', 75);
define('DEFAULT_BOOTTIME', 120);
define('LOWEST_BOOTTIME', 0);
	

	function maxBoot($group, $membership)
	{
	
	
		if($group != 1)
		{
			if($membership == 1){ return BOOTTIME_1; }
			if($membership == 2){ return BOOTTIME_2; }
			if($membership == 3){ return BOOTTIME_3; }
		} else {
			return 9999;
		}
		
		
	}
	
	
		if(loggedin() == TRUE)
		{
			mysql_connect(DB_HOST, DB_USER, DB_PASS) or die(mysql_error());
			mysql_select_db(DATABASE) or die(mysql_error());	
			
			$user = mysql_fetch_assoc(mysql_query("SELECT * FROM users WHERE username='" . $_SESSION['username'] . "'"));
			
			if($user['expire_date'] >= time())
			{
				mysql_query("UPDATE `users` SET membership='0' WHERE `member_id` = '" . $_SESSION['member_id'] . "'")
				or die(file_put_contents('error_log4.txt', mysql_error()));
			} 
		}
	
	
	// Match Group # w/ Group Names
	function userGroup($group)
	{
		if($group == 1){ return 'Administrator'; }
		if($group == 2){ return 'Member'; }
		if($group == 3){ return 'Banned'; }
	}
	
	
	// Has Member Paid?
	function userMembership($membership)
	{
		// If No Membership
		if($membership == 0){ 
			return 'Unpaid'; 
		} else {
			// Membership
			return 'Paid';
		}
		
	}
	
	
	// User Expiration Date
	function userExpire($date)
	{
		if($date != 0)
		{
			return date("m/d/y", $date);
		} else {
			return 'Unlimited';
		}
	}


	
	// Set Page Session for login
	ini_set('session.cookie_httponly', true);
	
	
	// If IP doesn't match on Session
	if(isset($_SESSION['last_ip']) == false){
		$_SESSION['last_ip'] = $_SERVER['REMOTE_ADDR'];
	}
	
	
	// If user is banned and not on banned page
	if($_SESSION['group'] == 3 && strpos($_SERVER['REQUEST_URI'], 'banned.php') == FALSE)
	{
		header("Location: banned.php");
	} 

	
	// If IP doens't match, end session
	// Session Security
	if($_SESSION['last_ip'] !== $_SERVER['REMOTE_ADDR']){
		session_unset();
		session_destroy();
	}
	
	
	// Check if Session is Logged In
	function loggedin(){
		// If username on Session Exists
		if(isset($_SESSION['username'])){
			$login = TRUE;
		} else {
			$login = FALSE;
		}
		
		return $login;
	}

	
	// Decide which tabs to display
	function tabs()
	{
		// If logged in, access mysql
					mysql_connect(DB_HOST, DB_USER, DB_PASS) or die(mysql_error());
			mysql_select_db(DATABASE) or die(mysql_error());	
			
			$user = mysql_fetch_assoc(mysql_query("SELECT * FROM users WHERE username='" . $_SESSION['username'] . "'"));
			
		
		
		echo '<ul>';
		
		
		if($user['group'])
		{
			// Not Banned?
			if($user['group'] != 3)
			{
				echo '<li><a href="index.php#pricing_modified" class="">Pricing<br><span>plans and options</span></a></li>';
				if($user['group'] == 1 || $user['group'] == 2)
				{
					if($user['membership'] != 0 || $user['group'] == 1)
					{
						echo '<li><a href="booter.php" class="">Boot<br><span>Access booter</span></a></li>';
					}
					echo '<li><a href="usercp.php" class="">UserCP<br><span>' . $_SESSION['username'] . '</span></a></li>';

				}
				
				if(isset($user['group']))
				{
					echo '<li><a href="logout.php" class="">Logout<br><span>Account Logout</span></a></li>';
				}
			}
		} else {
		
			echo '<li><a href="index.php#pricing_modified" class="">Pricing<br><span>plans and options</span></a></li>';
			echo '<li><a href="index.php#features_modified" class="">Features<br><span>limitless possibilities</span></a></li>';
			echo '<li><a href="login.php" class="">Login<br><span>access the booter</span></a></li>';
			echo '<li><a href="tos.php" class="">Register<br><span>Sign up</span></a></li>';
		}
		
		echo '</ul>';
		
	}

?>