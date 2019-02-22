<?php
require("header.php");

if(!checkAdmin()) {
die("<div class=\"box\">
    <h2>Administration Panel &bull; Access Denied</h2>
<div class=\"box-content\">
<p>You are not an administrator.</p>
</div></div>");
exit();
}
?>
<?php if (checkAdmin()); ?>
<head>
<script language="JavaScript" type="text/javascript" src="javascript/jquery-1.3.2.min.js"></script>
</head>
<div class="box">
<h2>Check Shells (CronJob)</h2>
<div class="box-content">
<center>
<b>Update:</b> <a href="shellcounter.php">Click Here</a><br>
</center>
</div>
</div>
<!-- Shell Checker Start-->
<div class="box">
    <h2>Shell Checker</h2>
    <div class="box-content">
        *Note : Checking time will vary depending on the volume of shells that your booter has.<br /><br />
        <div id="result" align="center"><input id="test" type="button" value="Check Shells Now" /></div>
        
        <script>
            $('#test').click( function () {
               $('#result').html('Checking...'); 
               $('#result').load('check.php');
            });
        </script>
    </div>
</div>
<!-- Shell Checker End -->
<div class="box">
<h2>Manage Shells</h2>
<div class="box-content">
<center>
<b>Get Shells:</b> <a href="get.php">Click Here</a><br>
<b>Post Shells:</b> <a href="post.php">Click Here</a><br>
<b>Slowloris Shells:</b> <a href="slowloris.php">Click Here</a><br>
</center>
</div>
</div>

<?php 
include 'footer.php';
?>