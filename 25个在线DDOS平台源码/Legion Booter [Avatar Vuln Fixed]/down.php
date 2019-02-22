<?php 
define("_VALID_PHP", true); 
require_once("init.php");
?> 
 
 <?php include("header.php");?> 
 
 
	 <?php if($user->checkMembership('6,7,8,9,10')): ?>
 
	 <center><iframe src="http://www.isup.me/" name="downornot" scrolling="auto" frameborder="no" align="center" height = "400px" width = "700px">
</iframe>.</center>
 
	 <?php else: ?>
 
	 <h1>User membership is't not valid. Show your custom error message here</h1>
 
	 <?php endif; ?>
 
 
 <?php include("footer.php");?> 
 
 
