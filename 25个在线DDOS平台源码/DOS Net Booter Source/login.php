<?php
session_start(); error_reporting(0);
require_once "config.php";
if($_POST['submit'])
{
	$user = htmlspecialchars($_POST['username']);
	$pass = htmlspecialchars($_POST['password']);
	
	// query DB for results
	$query = mysql_query("SELECT * FROM users");
	
	// while in database
	while($row = mysql_fetch_assoc($query))
	{
		if($user==$row['username']&&$pass==$row['password'])
		{
			$memt = $row['membership_type'];
			$meme = $row['membership_expires'];
			$max = $row['maxboot'];
			$passnew = md5("eNcc".$row['password'].";4==");
			$_SESSION['source']=$user;
			$_SESSION['expires']=$meme;
			$_SESSION['max']=$max;
			$_SESSION['type']=$memt;
			$_SESSION['encpass']=$passnew;
			header("Location: index.php");
		}
	}
}
?>
<!DOCTYPE html>
<!--[if lt IE 7]>  <html class="ie ie6 lte9 lte8 lte7 no-js"> <![endif]-->
<!--[if IE 7]>     <html class="ie ie7 lte9 lte8 lte7 no-js"> <![endif]-->
<!--[if IE 8]>     <html class="ie ie8 lte9 lte8 no-js">      <![endif]-->
<!--[if IE 9]>     <html class="ie ie9 lte9 no-js">           <![endif]-->
<!--[if gt IE 9]>  <html class="no-js">                       <![endif]-->
<!--[if !IE]><!--> <html class="no-js">                       <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

    <title>Login to <?php echo $site_title; ?></title>
    
	<link rel="apple-touch-icon-precomposed" sizes="144x144" href="apple-touch-icon-144x144-precomposed.html">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="images/mobile/apple-touch-icon-114x114.png" />
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="images/mobile/apple-touch-icon-72x72.png" />
    <link rel="apple-touch-icon-precomposed" href="images/mobile/apple-touch-icon.png" />
    <link rel="shortcut icon" href="images/apple-touch-icon.html" />
    <link rel="apple-touch-startup-image" media="(max-device-width: 480px) and not (-webkit-min-device-pixel-ratio: 2)" href="images/mobile/splash-320x460.png" />
    <link rel="apple-touch-startup-image" media="(max-device-width: 480px) and (-webkit-min-device-pixel-ratio: 2)" href="images/mobile/splash-640x920-retina.png" />
    <link rel="apple-touch-startup-image" media="(min-device-width: 768px) and (orientation: portrait)" href="images/mobile/splash-768x1004.png" />
    <link rel="apple-touch-startup-image" media="(min-device-width: 768px) and (orientation: landscape)" href="images/mobile/splash-1024x748.png" />
    <link rel="apple-touch-startup-image" media="(min-device-width: 1536px) and (orientation: portrait)" href="images/mobile/splash-1536x2008-retina.png" />
    <link rel="apple-touch-startup-image" media="(min-device-width: 2048px) and (orientation: landscape)" href="images/mobile/splash-2048x1496-retina.png" />
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="HandheldFriendly" content="true"/>   
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" /> 
    <script src="js/mobiledevices.js"></script>

    <meta name="application-name" content="Elite Admin Skin">
    <meta name="msapplication-tooltip" content="Cross-platform admin skin.">
    <meta name="msapplication-starturl" content="http://themes.creativemilk.net/elite/html/index.html">
    <meta name="msapplication-task" content="name=Home;action-uri=http://themes.creativemilk.net/elite/html/index.html;icon-uri=http://themes.creativemilk.net/elite/html/images/favicons/favicon.ico">
    <meta http-equiv="cleartype" content="on" /> 
    
    <!--[if lt IE 8]>
	<script src="http://ie7-js.googlecode.com/svn/version/2.1(beta4)/IE8.js"></script>
    <![endif]-->
            
    <!-- // Stylesheets // -->

    <!-- Framework -->
    <link rel="stylesheet" href="css/framework.css"/>
    <!-- Core -->
    <link rel="stylesheet" href="css/login.css"/>
    <!-- Styling -->
    <link rel="stylesheet" href="css/theme/darkblue.css" id="themesheet"/>
	<!--[if IE 7]>
	<link rel="stylesheet" href="css/destroy-ie6-ie7.css"/>
    <![endif]-->
    
    <link rel="shortcut icon" href="images/favicons/favicon.ico">
    
    <!-- // jQuery/UI core // -->
    
    <script src="../../ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
    <script>!window.jQuery && document.write('<script src="js/jquery-1.7.2.min.js"><\/script>')</script>
    <script src="../../code.jquery.com/ui/1.8.22/jquery-ui.min.js"></script>
    <script>!window.jQueryUI && document.write('<script src="js/jquery-ui-1.8.22.min.js"><\/script>')</script>
    
    <!-- // Plugins // -->    
                      
    <!-- Touch helper -->  
    <script src="js/jquery.ui.touch-punch.min.js"></script>
    <!-- Tooltip -->               
    <script src="js/tipsy.js"></script>  
    <!-- Stylesheet switcher --> 
    <script src="js/e_styleswitcher.1.0.min.js"></script>      
    <!-- Plugins and custom code -->     
    <script src="js/login.js"></script>  
    
    <!-- // HTML5/CSS3 support // -->

    <script src="js/modernizr.min.js"></script>
                
</head>
<body>  
    <div id="login">
    
    	<!-- Put your logo here -->
    	<div id="logo">
        	<h1><?php echo $site_title; ?></h1>
        </div>
        
        <!-- Show a dialog -->
        <div class="g_1">
            <div class="dialog error">
                <p>A good login page for mobile devices</p>
                <span>x</span>
            </div>
        </div>

        <!-- The main part -->                   
        <div id="login-outher">        
            <div id="login-inner">
                <header>
                    <h2>Login</h2> 
                    <ul class="e-splitmenu" id="login-lang">
                        <li><span>English</span><a href="javascript:void(0);"><img src="images/icons/flags/gb.png" alt=""/></a>
                        
                             <div>
                                <ul>
                                    <li><a href="#"><img src="images/icons/flags/gb.png" alt=""/> English</a></li>
                                </ul>                                      
                            </div>                               

                        </li>
                    </ul>                                 
                </header>
                
                <div id="login-content">
                    <form method="post" action="login.php" id="login-form">
                        <div class="g_1">
                            <label for="field1">Username</label>
                        </div>
                        <div class="g_1">                            
                            <input type="text" name="username" id="field1" tabindex="1" data-validation-type="present"/>
                        </div>
                        
                        <div class="spacer-10"><!-- spacer 20px --></div> 
                        
                        <div class="g_1">
                            <label for="field2">Password</label>
                            <a href="javascript:void(0);" class="forgot-password">Forgot password?</a>
                        </div>
                        <div class="g_1">  
                            <input type="password" name="password" id="field2" tabindex="2" data-validation-type="present"/> 
                        </div>
                        
                        <div class="spacer-20"><!-- spacer 20px --></div> 
                        
                         <div class="g_1">
                            <input type="checkbox" name="" id="field3" tabindex="3"/>
                            <label for="field3">Remember me</label>
                            <input type="submit" value="Login" name="submit" tabindex="4" class="button-text"/>
                            <a href="javascript:void(0);" id="show-password" class="button-icon tip-n" title="Show Password" style="float:right"><span class="info-10 plix-10"></span></a>
                        </div>               
                    </form>
				</div><!-- End #login-content --> 
            </div><!-- End #login-inner -->                                  
        </div><!-- End #login-outher --> 
        
        <!-- place your copyright text here -->
        <footer id="footer">
        	Copyright © 2012
        </footer> 
    </div><!-- End "#login" -->        
</body>
</html>