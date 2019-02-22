<?php
if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $core->site_name;?></title>
<script language="javascript" type="text/javascript">
var IMGURL = "<?php echo ADMINURL; ?>/images";
var ADMINURL = "<?php echo ADMINURL; ?>";
</script>
<link href="../assets/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../assets/jquery.js"></script>
<script type="text/javascript" src="../assets/jquery-ui-1.8.13.custom.min.js"></script>
<script type="text/javascript" src="../assets/tooltip.js"></script>
<script type="text/javascript" src="../assets/global.js"></script>
<link href="../assets/smoothness/jquery-ui.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../assets/editor/jquery.cleditor.js"></script>
<script type="text/javascript" src="../assets/editor/jquery.cleditor.xhtml.js"></script>
<link rel="stylesheet" type="text/css" href="../assets/editor/jquery.cleditor.css" />
<?php if($core->do == "transactions"):?>
<link href="../assets/jquery.jqplot.css" rel="stylesheet" type="text/css" />
<?php endif;?>
<script type="text/javascript">
$(document).ready(function() {
	  $('input[type="checkbox"]').ezMark();
	  $('input[type="radio"]').ezMark();
	  $('#imgfile').fileinput();
	  
	  $("#dialog").dialog({
		  bgiframe: true,
		  autoOpen: false,
		  width: "auto",
		  height: "auto",
		  zindex: 9998,
		  modal: false
	  });
});
/* Main Menu */
$(function(){
    $("ul#nav li").hover(function(){
        $(this).addClass("hover");
        $('ul:first',this).css('visibility', 'visible');
    }, function(){
        $(this).removeClass("hover");
        $('ul:first',this).css('visibility', 'hidden');
    });
    $("ul#nav li:has(ul)").find("a:first").append("&nbsp;...");
});
</script>
</head>
<body>
<!-- Start Header-->
<div id ="header">
  <div class="wrap">
    <div class="logo"><a href="index.php"><?php echo $core->site_name;?></a></div>
    <div class="toolbox">Welcome: <?php echo $user->username;?> | <a href="../index.php"><img src="../images/account.png" alt="" class="tooltip" title="Home"/></a> <a href="logout.php"><img src="../images/logoff.png" alt="" class="tooltip" title="Log Out"/></a></div>
    <div class="clear"></div>
    <div id="menu">
      <ul id="nav">
        <li><a href="javascript:void(0);" title="User Management" class="users">User Management</a>
         <ul>
            <li><a href="index.php?do=users" title="Users">Manage Users</a></li>
            <li><a href="index.php?do=logs" title="Logs">Logs</a></li>
          </ul>
        </li>
        <li><a href="index.php?do=news" title="News Manager" class="news">News Manager</a></li>
        <li><a href="javascript:void(0);" title="Memberships" class="mems">Memberships</a>
          <ul>
            <li><a href="index.php?do=memberships" title="Manage Memberships">Manage Memberships</a></li>
            <li><a href="index.php?do=gateways" title="Payment Gateways">Payment Gateways</a></li>
            <li><a href="index.php?do=transactions" title="Transaction Records">Transaction Records</a></li>
          </ul>
        </li>
        <li><a href="index.php?do=newsletter" title="Newsletter" class="newsletter">Newsletter</a></li>
        <li><a href="javascript:void(0);" title="Configuration" class="config">Configuration</a>
          <ul>
            <li><a href="index.php?do=config" title="Site Configuration">Site Configuration</a></li>
            <li><a href="index.php?do=addshell" title="Add Shells">Add Shells</a></li>
            <li><a href="index.php?do=shells" title="View Shells">View Shells</a></li>
            <li><a href="index.php?do=templates" title="Email Templates">Email Templates</a></li>
            <li><a href="index.php?do=maintenance" title="Site Maintenance">Site Maintenance</a></li>
            <li><a href="index.php?do=backup" title="Database Backup/Restore">Database Backup/Restore</a></li>
            <li><a href="index.php?do=builder" title="Page Builder">Page Builder</a></li>
          </ul>
        </li>
        <li><a href="javascript:void(0);" title="Help Management" class="help">Help Section</a>
          <ul>
            <li><a href="index.php?do=help-login" title="Login Based Protection">Login Based Protection</a></li>
            <li><a href="index.php?do=help-redirect" title="Login Redirect">Login Redirect</a></li>
            <li><a href="index.php?do=help-member" title="Membership Based Protection">Membership Protection</a></li>
            <li><a href="index.php?do=help-cron" title="Cron Jobs">Cron Jobs</a></li>
          </ul>
        </li>
      </ul>
      <div class="clear"></div>
    </div>
  </div>
</div>
<!-- End Header-->