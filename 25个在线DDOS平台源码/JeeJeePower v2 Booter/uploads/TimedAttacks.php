<?php 
	/** 
	* TimedAttacks

	* @package Membership Manager Pro
	* @author wojoscripts.com
	* @copyright 2011
	* @version Id: TimedAttacks.php, v2.00 2012-09-05 23:57:23 gewa Exp $
	*/
 
	 define("_VALID_PHP", true); 
	 require_once("init.php");
 
?> 
 
 <?php include("header.php");?> 
 
 
	 <?php if($user->checkMembership('15')): ?>
 
	 <h1>User has valid membership, you can display your protected content here</h1>.
 
	 <?php else: ?>
 
	 <h1>User membership is't not valid. Show your custom error message here</h1>
 
	 <?php endif; ?>
 
 
 <?php include("footer.php");?> 
 
 
