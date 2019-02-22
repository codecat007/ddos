<?php
define("_VALID_PHP", true); 
require_once("init.php");
?> 
<?php include("header.php");?> 
 
 
	 <?php if($user->checkMembership('6,7,8,9,10')): ?>
<script src="assets/jquery-1.4.4.min.js" type="text/javascript"></script>
<script type="text/javascript">
function hub()
	{
	if (window.XMLHttpRequest)
	  {
	  xmlhttp=new XMLHttpRequest();
	  }
	else
	  {
	  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	  }
	xmlhttp.onreadystatechange=function()
	  {
	  if (xmlhttp.readyState==4 && xmlhttp.status==200)
	    {
	    document.getElementById("sent").innerHTML = "Request has been sent to all shells.";
	    }
	  }
	xmlhttp.open("GET","autoboot.php?time="+document.getElementById('time').value;
	xmlhttp.send();
}
</script>
 <script>
for(var i=0;i<2;i++)
setTimeout("foo('"+i+"')",(2-i)*500);
function foo(n){
document.getElementById('btn').value=n;
if(n==0){
document.getElementById('btn').value='Create Link';
document.getElementById('btn').disabled=false;
}
}
</script>
<center><div class="box">
<h1>Timed Attacks</h1>
<p class="info">This feature is still under development. Sorry.</p>
<center>
<table cellspacing="0" cellpadding="0" class="box">

      <tbody>
    <b>Timed Attack Settings</b> <br>Please enter the amount of time to boot the person and the ip / port to boot on<br />    
		Coming soon!
    </br>
      </tbody>

    </p>
<center>
  </p>
<form action="hub.php" method="post">
		  &nbsp;
		  </p>
                 </form>
<p id="sent"></p>
<script type="text/javascript">
function handleKeyPress(e,form){
	var key=e.keyCode || e.which;
	if (key==13){
		hub();
	}
}
function handleEnterPress(e,form){
	var key=e.keyCode || e.which;
	if (key==13){
		getip();
	}
}
</script>
<?php

?>
</center>
</center>
<?php endif; ?>
 
 <?php include("footer.php");?> 
 
 
