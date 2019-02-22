<?php
	session_start();
	include('config.php');
	
	// If logged in, sign into MySQL
	if(loggedin() == TRUE){
		mysql_connect(DB_HOST, DB_USER, DB_PASS) or die(mysql_error());
		mysql_select_db(DATABASE) or die(mysql_error());
	}

	
?>
<html>
<head>
<title>QuickBooter Leading booter in the market</title>

	<meta charset="utf-8">
	<meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">

	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0" name="viewport">
	<meta content="yes" name="apple-mobile-web-app-capable">
	
	<!-- IMPORTANT: If you need to update one of the CSS files, you must upgrade the version both in the file name and in the line bellow -->
<link rel="stylesheet" type="text/css" media="all" href="css/skeleton-v1.1.css" />
<link rel="stylesheet" type="text/css" media="all" href="css/flexslider-v1.8.css" />
<link rel="stylesheet" type="text/css" media="all" href="css/main-r6.css" />
<link rel="stylesheet" type="text/css" media="all" href="css/media-queries-r6.css" />
<link rel="stylesheet" type="text/css" media="all" href="css/sprites-r6.css" />
<link rel="stylesheet" type="text/css" media="all" href="css/theme-default-r6.css" />
<link rel="stylesheet" type="text/css" media="all" href="css/styles.css" />
	<link type="text/css" rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:400,600,400italic">

	<link href="images/favicon.ico" rel="shortcut icon">
	<link href="images/apple-touch-icon.png" rel="apple-touch-icon">
	<link href="images/apple-touch-icon-72x72.png" sizes="72x72" rel="apple-touch-icon">
	<link href="images/apple-touch-icon-114x114.png" sizes="114x114" rel="apple-touch-icon">
    
<script type="text/javascript" src="js/slides.min.jquery.js"></script>
<script type="text/javascript" src="js/jquery-1.7.1.min.js"></script>
<script type="text/javascript" src="js/slides.jquery.js"></script>
   
    
        <link href="css/styles.css" rel="stylesheet">
	
	<style type="text/css" media="screen">

	</style>
	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js"></script>
	<script src="js/slides.min.jquery.js"></script>
	
	<script>
		$(function(){
			$('#slides').slides({
				preload: true
			});
		});
	</script>

	<!-- Allow IE to render HTML5 -->
	<!--[if lt IE 9]>
		<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]--><script type="text/javascript">
window.$zopim||(function(d,s){var z=$zopim=function(c){z._.push(c)},$=z.s=
d.createElement(s),e=d.getElementsByTagName(s)[0];z.set=function(o){z.set.
_.push(o)};z._=[];z.set._=[];$.async=!0;$.setAttribute('charset','utf-8');
$.src='//cdn.zopim.com/?alJ7EF8DXbUu8CkJHhRe9wS800lTqkyy';z.t=+new Date;$.
type='text/javascript';e.parentNode.insertBefore($,e)})(document,'script');
</script>
<!--End of Zopim Live Chat Script-->
</head>
<body>
<!--Start of Zopim Live Chat Script-->

<div class="dark" role="main" id="main">

<header class="dark">
	<div class="container">
		<h1 class="logo one-third column alpha">
			<a href="/">
				<img class="scale-with-grid" alt="Spark" src="images/logo.png" style="position:relative; top:30px;" width="400" height="40">
				<img class="scale-with-grid mobile-only" alt="Spark" src="images/logo-mobile-white.png"><!-- Alternative image for mobile devices -->
			</a>
		</h1>

		<nav class="menu two-thirds column omega">
			<?php tabs() ?>
		</nav>
	</div><!-- .container -->

	<div class="bottom-gradient">
		<span class="left"></span>
		<span class="center"></span>
		<span class="right"></span>
	</div>	
</header>




	<div class="container" >
	
		<div class="sixteen columns titleset">
			<h2 class="remove-bottom">Pricing</h2>
			<h6 class="subheader">QuickBooter Pricing</h6>
		</div>
	

		<div class="one-third column box light featured" style="width: 100%;">
			<div class="headset price clearfix">
				<img class="large-icons icon-shopcart" alt="" src="images/empty.gif">
				<h4>Booter Memberships</h4>
			</div>
			<div class="bottom-gradient add-top add-bottom">
				<span class="left"></span>
				<span class="center"></span>
				<span class="right"></span>
			</div>
			
			
			<table width="50%" border="1" style="color:#fff; font-size: 100%; text-align: center;">
		  <tr>
			<td style="text-align: left;">Item/Feature</td>
			<td>Bronze</td>
			<td>Iron</td>
			<td>Silver</td>
			<td>Gold</td>
			<td>Platinum</td>
			<td>Extreme</td>
		  </tr>
		  <tr>
			<td style="text-align: left;">Price</td>
			<td>$5/m</td>
			<td>$5/m</td>
			<td>$5/m</td>
			<td>$5/m</td>
			<td>$5/m</td>
			<td>$5/m</td>
		  </tr>
		  <tr>
			<td style="text-align: left;">Boot Time</td>
			<td>200</td>
			<td>200</td>
			<td>200</td>
			<td>200</td>
			<td>200</td>
			<td>200</td>
		  </tr>
		  <tr>
			<td style="text-align: left;">UDP</td>
			<td>X</td>
			<td>X</td>
			<td>X</td>
			<td>X</td>
			<td>X</td>
			<td>X</td>
		  </tr>
		  <tr>
			<td style="text-align: left;">SSYN</td>
			<td>X</td>
			<td>X</td>
			<td>X</td>
			<td>X</td>
			<td>X</td>
			<td>X</td>
		  </tr>
		  <tr>
			<td style="text-align: left;">More Stuff</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>X</td>
			<td>X</td>
			<td>X</td>
			<td>X</td>
		  </tr>
		  <tr>
			<td style="text-align: left;">More Stuff</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>X</td>
			<td>X</td>
			<td>X</td>
		  </tr>
		  <tr>
			<td style="text-align: left;">More Stuff</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>X</td>
			<td>X</td>
		  </tr>
		  <tr>
			<td style="text-align: left;">More Stuff</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>X</td>
		  </tr>
		  <tr>
			<td style="text-align: left;">Purchase</td>
			<td>Buy</td>
			<td>Buy</td>
			<td>Buy</td>
			<td>Buy</td>
			<td>Buy</td>
			<td>Buy</td>
		  </tr>
		</table>




		
		</div><!-- .columns -->
	</div>

<article class="dark" id="contact_modified">
	<div class="container">	
	
		

</body></html>