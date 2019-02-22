<?php
	//Start session
	session_start();
	include('includes/db.php');
	//Unset the variable SESS_MEMBER_ID stored in session
	unset($_SESSION['SESS_MEMBER_ID']);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>roy</title>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">

<link href="includes/style.css" rel="stylesheet" type="text/css">
<script type="text/JavaScript">
<!--



function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}
//-->
</script>
<script>
function validateme()
{

	if(document.frmcontadd.name.value=="")
	{
		alert("Name is required");
		document.frmcontadd.name.focus();
		return false;
	}
	if(document.frmcontadd.email.value=="")
	{
		alert("Email is required");
		document.frmcontadd.email.focus();
		return false;
	}
		if(document.frmcontadd.phone.value=="")
	{
		alert("Phone Number is required");
		document.frmcontadd.phone.focus();
		return false;
	}
}
</script>
<style type="text/css">
<!--
.style4 {
	font-size: 14px;
	font-weight: bold;
	color: #CC0000;
}
.style5:hover {
	font-size: 12px;
	font-weight: bold;
	text-decoration:underline;
	color: #CC0000;
}
.style3 {
	color: #660000;
	font-weight: bold;
	font-size: 18px;
}
.style5 {
	color: #FFFFFF;
	font-weight: bold;
	font-size: 16px;
}
-->
</style>
</head>
<body>
You have successfully logged out.
<meta http-equiv="REFRESH" content="3;url=index.php">
</body>
</html>

