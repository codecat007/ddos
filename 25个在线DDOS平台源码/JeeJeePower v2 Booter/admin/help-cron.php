<?php
if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');
?>
<h1><img src="../images/help-lrg.png" alt="" />Help Section &rsaquo; Cron Jobs</h1>
<p class="info">Here you can find instructions on how to protect your pages based on user level, login state etc...</p>
<h2>Setting up cron jobs</h2>
<div class="box">Membership Manager Pro is equipped with cron job utility.</div>
<br />
<div class="box">By default there are two files inside /cron/ directory <strong>cron_job0days.php</strong> and <strong>cron_job7days.php</strong><br />
  <strong>cron_job0days.php</strong> will automatically send emails to all users whose membership had expired at the present day, while <strong>cron_job7days.php</strong> will send emails to all users whose membership is about to expire within 7 days.</div>
<br />
<div class="box"> <strong>1</strong>. Each hosting company might have different way of setting cron jobs. Here will give you few examples: <br />
  <ul>
    <li><strong> For CPanel - </strong> http://www.siteground.com/tutorials/cpanel/cron_jobs.htm</li>
    <li><strong>For Plesk Pnel -</strong> http://www.hosting.com/support/plesk/crontab</li>
  </ul>
</div>
<br />
<div class="box"><strong>2</strong>. If your hosting panel it's not covered here you can always ask your hosting provider.</div>
<br />
<div class="box"> <strong>3.</strong> <strong>cron_job0days.php</strong> and <strong>cron_job7days.php</strong> files should be set up to run every day at midnight</div>
<br />
<div class="box"><strong>4.</strong> <em>Don't forget to modify template files for sending reminders. <a href="index.php?do=templates&action=edit&id=8">Membership Expire 7 days</a> and <a href="index.php?do=templates&action=edit&id=9">Membership Expired Today</a></em> </div>