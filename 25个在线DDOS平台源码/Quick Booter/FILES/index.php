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


<article id="home_modified">
	<div class="container">
		<div class="row box dark light">
			<div class="seven columns">
            

<div class="slider" style="position:relative; margin-left:-200px; margin-top:-200px;">
	<div id="slides">
		<div class="slides_container">
			<div class="slide">
				<p><img src="images/head.png" alt="" class="slide-image" style="margin-left:130px; margin-top:70px;"/></p>
			</div>
			<div class="slide">
				<img src="images/slider-02.png" alt="" class="slide-image" />
					
						<h4 style="position:relative; top:100px; left:100px;">I hope you can edit here. <strong>+aDesigns</strong></h4>
						
						<p style="position:relative; top:100px; left:100px;">Let me know if you still require any help.</p>
						
						<p style="position:relative; top:100px; left:100px;"><a href="#"><img src="images/app-store.png" alt="" class="right" /></a></p>
			</div>
			<div class="slide">
					<img src="images/slider-03.png" alt="" class="slide-image"/>
					
					<div style="position:absolute; margin-left:300px; top:70px;">
						<h2><strong>+aDesigns</strong></h2>
						
						<p>Everybit of these can be easily edited.</p>
					</div>
					
					<div style="position:absolute; margin-left:300px; top:150px;">	
						<h2><strong>Mobile Devices</strong></h2>
						
						<p>This booter is fully compatible with mobiles.</p>
						
						<p><a href="pricing.html" class="button">Plans and Pricing</a></p>
					</div>
			</div>
            
		</div>
        			<a href="#" class="prev">&#8249;</a>
					<a href="#" class="next">&#8250;</a>
	</div>
    </div>
		
            
            
				<!--
                 <div class="welcome-container">
				<h1>QuickBooter</h1>
				<p>Designed with the latest scripts and most advanced techniques, this booter website offers amazing quality services!</p>
				<p class="hide-for-mobile">The booter focuses on usability, it offers enterprise-level features, design quality,
					technical implementation, compatibility, accessibility and performance.
				</p>
				<a class="button call-to-action animate" href="#pricing_modified">Buy now</a>
				</div>
			</div>
			
			<div class="nine columns">
				<div class="flexslider">
					<ul class="slides">
						<li style="width: 100%; float: left; margin-right: -100%; display: list-item;"><img src="images/slides/performance.jpg" alt=""></li>
						<li style="width: 100%; float: left; margin-right: -100%; display: none;"><img src="images/slides/crossbrowser.jpg" alt=""></li>
						<li style="width: 100%; float: left; margin-right: -100%; display: none;"><img src="images/slides/html5.jpg" alt=""></li>
					</ul>
                    </div>
		</div>
		
		<div class="row">
			<div class="one-third column headset">
				<img class="large-icons icon-menu" alt="" src="images/empty.gif">
				<h4>Feature</h4>
				<p>Go Ahead, Add A Description</a></p>
			</div>

			<div class="one-third column headset">
				<img class="large-icons icon-layers" alt="" src="images/empty.gif">
				<h4>Responsive Grid Layout</h4>
				<p>Go Ahead, Resize This Page</p>
			</div>

			<div class="one-third column headset">
				<img class="large-icons icon-resize" alt="" src="images/empty.gif">
				<h4>Browser History</h4>
				<p>Go Ahead, Try The Back Button</p>
			</div>
		</div><!-- .row -->
	
		<div class="bottom-gradient between-rows">
			<span class="left"></span>
			<span class="center"></span>
			<span class="right"></span>
		</div>
		
		<div class="row">
			<div class="two-thirds column">
				<h4>Make Use of Tabs</h4>
				<p>Perfect to elegantly sub-categorize your content, these tabs keep full syntax standard, accessibility and natural SEO intact! <span class="hide-for-mobile">The tabs are built from two list elements, take a look at the source code, it's really simple!</span></p>
				<ul class="tabs" style="position:relative; left:300px;">
					<li><a href="#simple" class="active">Simple</a></li>
					<li><a href="#lightweight">Lightweight</a></li>
					<li><a href="#mobileFriendly">Mobile</a></li>
				</ul>

				<ul class="tabs-content">
					<li id="simple" class="active">The tabs are clean and simple unordered-list markup and basic CSS.
						<ul class="square">
							<li>Google Fonts</li>
							<li>Ajax Contact Form</li> 
						</ul>
					</li>
					<li id="lightweight">The tabs are cross-browser, but don't need a ton of hacky CSS or markup.
						<ul class="square">
							<li>Cross-Browser</li>
							<li>Pageload Performance</li> 
						</ul>
					</li>
					<li id="mobileFriendly">Like everything else, the tabs work like a charm even on mobile devices.
						<ul class="square">
							<li>Flexible Grid System</li>
							<li>Gracefull Fallback</li> 
						</ul>
					</li>
				</ul>
				<p class="add-top">The tabs are built from two list elements, take a look at the source code, it's really simple!</p>
			</div><!-- .columns -->
			
			<div class="one-third column">
				
			</div><!-- .columns -->
		</div><!-- .row -->
		
	</div><!-- .container -->
</article>


<article class="dark" id="features_modified">
	<div class="container">	
		<div class="sixteen columns titleset">
			<h2 class="remove-bottom">Features</h2>
			<h6 class="subheader">Elegance, Performance, Full Features. No Compromise</h6>
		</div>

		<div class="row">
			<div class="one-third column headset">
				<img class="large-icons icon-dashboard" alt="" src="images/empty.gif">
				<h3>Built for Performance</h3>
				<p>Techniques like CSS-sprites, asynchronous load and DOM events are intelligently used to improve page-load time and responsiveness.</p>
			</div>

			<div class="one-third column headset">
				<img class="large-icons icon-globe" alt="" src="images/empty.gif">
				<h3>Cross-Browser</h3>
				<p>Fully optimized for all browsers and mobile devices using progressive enhancement with graceful fallback. <strong>It's pixel perfect!</strong></p>
			</div>

			<div class="one-third column headset">
				<img class="large-icons icon-link" alt="" src="images/empty.gif">
				<h3>Bookmarkable URLs</h3>
				<p>This enterprise-level website offers dynamic URL updates,  meaning bookmarkable URLs and a fully functional browser history.</p>
			</div>
		</div><!-- .row -->
		
		<div class="row">
			<div class="one-third column headset">
				<img class="large-icons icon-grid" alt="" src="images/empty.gif">
				<h3>Flexible Layout</h3>
				<p>Based on a lightweight 960 CSS grid and using advanced Media Queries, this website offers a <strong>responsive grid down to mobile</strong>. Go ahead, resize this page!</p>
			</div>

			<div class="one-third column headset">
				<img class="large-icons icon-cloud" alt="" src="images/empty.gif">
				<h3>Smart CDN Fallback</h3>
				<p>Providing CDN-based components results in performance improvement for end-users, 
					and the great part is that there's still a local fallback in case of CDN failure.</p>
			</div>

			<div class="one-third column headset">
				<img class="large-icons icon-cert" alt="" src="images/empty.gif">
				<h3>Accessibility and SEO</h3>
				<p>Making use of the newest W3C standards, HTML5 structure and content-specific tags, we offer not only top accessibility but also natural SEO-oriented enhancements.</p>
			</div>
		</div><!-- .row -->
	</div><!-- container -->
</article>


<article id="pricing_modified">
	<div class="container">
	
		<div class="sixteen columns titleset">
			<h2 class="remove-bottom">Pricing</h2>
			<h6 class="subheader">Our best deal for now</h6>
		</div>
		

		<div class="one-third column box light featured">
			<div class="headset price clearfix">
				<img class="large-icons icon-shopcart" alt="" src="images/empty.gif">
				<h4>Bronze</h4>
				<span><sup>$</sup>5<sub>/mo</sub></span>
			</div>
			<div class="bottom-gradient add-top add-bottom">
				<span class="left"></span>
				<span class="center"></span>
				<span class="right"></span>
			</div>
			<p>This is some information regarding the bronze package.</p>
			<ul class="disc">
				<li>120 Boot Time</li>
				<li>UDP/SSYN</li>
				<li>Skype Resolver</li>
				<li>Power Controller</li>
			</ul>

			<?php
			if(loggedIn() == TRUE)
			{
				
				echo '
				<form action="https://www.paypal.com/cgi-bin/webscr" method="POST">
				<input type="hidden" name="cmd" value="_xclick">
				<input type="hidden" name="business" value="' . PAYPAL_EMAIL . '">
				<input type="hidden" name="item_name" value="' . PP_NAME_1 . '">
				<input type="hidden" name="item_number" value="1">
				<input type="hidden" name="amount" value="' . PP_AMOUNT_1 . '">
				<input type="hidden" name="no_shipping" value="1">
				<input type="hidden" name="no_note" value="1">
				<input type="hidden" name="currency_code" value="' . PP_CURRENCY . '">
				<input type="hidden" name="lc" value="' . PP_LOCATION . '">
				<input type="hidden" name="bn" value="PP-BuyNowBF">
				<input type="hidden" name="return" value="' . PP_RETURN . '">
				<input type="hidden" name="cancel_return" value="http://quickbooter.info/">
				<input type="hidden" name="rm" value="2">
				<input type="hidden" name="notify_url" value="' . PP_RETURN . '">
				<input type="hidden" name="custom" value="' . $_SESSION['member_id'] . '">';
				
			} else {
				echo '<form action="login.php" method="post">';
			}
			?>
			
			<p><input type="submit" class="button featured animate" value="BUY NOW" /></p>
			</form>
		</div><!-- .columns -->

		<div class="one-third column box light featured">
			<div class="headset price clearfix">
				<img class="large-icons icon-shopcart" alt="" src="images/empty.gif">
				<h4>Silver</h4>
				<span><sup>$</sup>15<sub>/mo</sub></span>
			</div>
			<div class="bottom-gradient add-top add-bottom">
				<span class="left"></span>
				<span class="center"></span>
				<span class="right"></span>
			</div>
			<p>This is some information regarding the silver package.</p>
			<ul class="disc">
				<li>600 Boot Time</li>
				<li>UDP/SSYN</li>
				<li>Skype Resolver</li>
				<li>Power Controller</li>
			</ul>
			<?php
			if(loggedIn() == TRUE)
			{
				
				echo '
				<form action="https://www.paypal.com/cgi-bin/webscr" method="POST">
				<input type="hidden" name="cmd" value="_xclick">
				<input type="hidden" name="business" value="' . PAYPAL_EMAIL . '">
				<input type="hidden" name="item_name" value="' . PP_NAME_2 . '">
				<input type="hidden" name="item_number" value="2">
				<input type="hidden" name="amount" value="' . PP_AMOUNT_2 . '">
				<input type="hidden" name="no_shipping" value="1">
				<input type="hidden" name="no_note" value="1">
				<input type="hidden" name="currency_code" value="' . PP_CURRENCY . '">
				<input type="hidden" name="lc" value="' . PP_LOCATION . '">
				<input type="hidden" name="bn" value="PP-BuyNowBF">
				<input type="hidden" name="return" value="' . PP_RETURN . '">
				<input type="hidden" name="cancel_return" value="http://quickbooter.info/">
				<input type="hidden" name="rm" value="2">
				<input type="hidden" name="notify_url" value="' . PP_RETURN . '">
				<input type="hidden" name="custom" value="' . $_SESSION['member_id'] . '">';
				
			} else {
				echo '<form action="login.php" method="post">';
			}
			?>
			
			<p><input type="submit" class="button featured animate" value="BUY NOW" /></p>
			</form>
		</div><!-- .columns -->

		<div class="one-third column box light featured">
			<div class="headset price clearfix">
				<img class="large-icons icon-shopcart" alt="" src="images/empty.gif">
				<h4>Gold</h4>
				<span><sup>$</sup>35<sub>/mo</sub></span>
			</div>
			<div class="bottom-gradient add-top add-bottom">
				<span class="left"></span>
				<span class="center"></span>
				<span class="right"></span>
						</div>
			<p>This is some information regarding the gold package.</p>
			<ul class="disc">
				<li>1,200 Boot Time</li>
				<li>UDP/SSYN</li>
				<li>Skype Resolver</li>
				<li>Power Controller</li>
			</ul>
			<?php
			if(loggedIn() == TRUE)
			{
				
				echo '
				<form action="https://www.paypal.com/cgi-bin/webscr" method="POST">
				<input type="hidden" name="cmd" value="_xclick">
				<input type="hidden" name="business" value="' . PAYPAL_EMAIL . '">
				<input type="hidden" name="item_name" value="' . PP_NAME_3 . '">
				<input type="hidden" name="item_number" value="3">
				<input type="hidden" name="amount" value="' . PP_AMOUNT_3 . '">
				<input type="hidden" name="no_shipping" value="1">
				<input type="hidden" name="no_note" value="1">
				<input type="hidden" name="currency_code" value="' . PP_CURRENCY . '">
				<input type="hidden" name="lc" value="' . PP_LOCATION . '">
				<input type="hidden" name="bn" value="PP-BuyNowBF">
				<input type="hidden" name="return" value="' . PP_RETURN . '">
				<input type="hidden" name="cancel_return" value="http://quickbooter.info/">
				<input type="hidden" name="rm" value="2">
				<input type="hidden" name="notify_url" value="' . PP_RETURN . '">
				<input type="hidden" name="custom" value="' . $_SESSION['member_id'] . '">';
				
			} else {
				echo '<form action="login.php" method="post">';
			}
			?>
			
			<p><input type="submit" class="button featured animate" value="BUY NOW" /></p>
			</form>
			<!-- <a class="button featured animate" href="#contact">Buy now (TEST)</a> -->
		</div><!-- .columns -->

	
		
	</div><!-- container -->
</article>


<article class="dark" id="contact_modified">
	<div class="container">	
	
		

</body></html>