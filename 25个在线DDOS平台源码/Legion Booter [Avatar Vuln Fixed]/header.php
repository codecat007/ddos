<?php
if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');
	  
	  $news = $core->renderNews();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $core->site_name;?></title>
<script language="javascript" type="text/javascript">
var SITEURL = "<?php echo SITEURL; ?>";
</script>
<link href="assets/front.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="assets/jquery.js"></script>
<script type="text/javascript" src="assets/jquery-ui-1.8.13.custom.min.js"></script>
<script type="text/javascript" src="assets/global.js"></script>
<script type="text/javascript" src="assets/tooltip.js"></script>
<link href="assets/smoothness/jquery-ui.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
$(document).ready(function() {
	  $('input[type="checkbox"]').ezMark();
	  $('input[type="radio"]').ezMark();
	  $('#imgfile').fileinput();
	  
    $("#news").hide();
    $("#shownews").click(function () {
      $("#news").toggle('slide',500);
    });

});
</script>
</head>
<body>
<div id="usermenu">
<a href="index.php"><img src="images/home.png" alt="" class="tooltip" title="Home" /></a>
<?php if($user->is_Admin()):?>
<a href="admin/index.php"><img src="images/admin.png" alt="" class="tooltip" title="Admin Panel" /></a>
<?php endif;?>
<?php if($user->logged_in):?>
  <a href="contact.php"><img src="images/mailsend.png" alt="" class="tooltip" title="Contact Us" /></a>
  <a href="hub.php"><img src="images/www.gif" alt="" class="tooltip" title="The Hub" /></a>
  <a href="down.php"><img src="images/down.png" alt="" class="tooltip" title="Down or Not" /></a>
 <a href="logout.php"><img src="images/log-off.png" alt="" class="tooltip" title="Log Off" /></a> 
  <?php else:?>
<a href="plans.php"><img src="images/memberships.png" alt="" class="tooltip" title="Membersips" /></a>
<?php endif;?>
</div>
<?php if($news):?>
<div id="news-slide"><img src="images/latest-news.png" alt="" id="shownews"/>
  <div id="news"> <?php echo $news['cdate'].' <strong>'.$news['title'].'</strong>';?> <?php echo cleanOut($news['body']);?> </div>
</div>
<?php endif;?>
<div class="wrap">
<div id="msgholder"></div>
  <div id="content">
    <span id="loader" style="display:none"></span> 