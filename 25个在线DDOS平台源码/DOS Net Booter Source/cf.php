<?php
session_start();
require_once "config.php";
if(!$_SESSION['source'])
{
header("Location: index.php");
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

    <title><?php echo $site_title; ?></title>
    
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
    <meta http-equiv="cleartype" content="on" /> 
    
    <!--[if lt IE 8]>
	<script src="http://ie7-js.googlecode.com/svn/version/2.1(beta4)/IE8.js"></script>
    <![endif]-->

    <link rel="stylesheet" href="css/framework.css"/>
    <link rel="stylesheet" href="css/style.css"/>
    <link rel="stylesheet" href="css/ui/jquery.ui.base.css"/>
    <link rel="stylesheet" href="css/theme/darkblue.css" id="themesheet"/>
	<!--[if IE 7]>
	<link rel="stylesheet" href="css/destroy-ie6-ie7.css"/>
    <![endif]-->  
	<!--[if gt IE 7]>
	<link rel="stylesheet" href="css/ie.css"/>
    <![endif]-->
    
    <link rel="shortcut icon" href="images/favicons/favicon.ico" />

    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
    <script>!window.jQuery && document.write('<script src="js/jquery-1.7.2.min.js"><\/script>')</script>
    <script src="http://code.jquery.com/ui/1.8.22/jquery-ui.min.js"></script>
    <script>!window.jQueryUI && document.write('<script src="js/jquery-ui-1.8.22.min.js"><\/script>')</script>
    <script src="js/jquery.ui.touch-punch.min.js"></script>
    <script src="js/jquery.mousewheel.min.js"></script>
	<script src="js/jquery.ui.spinner.js"></script>            
    <script src="js/tipsy.js"></script>                       
    <script src="js/treeview.js"></script>                      
    <script src="js/fullcalendar.min.js"></script>               
    <script src="js/selectToUISlider.jQuery.js"></script>       
    <script src="js/jquery.contextMenu.js"></script>            
    <script src="js/elfinder.min.js"></script>                  
    <script src="js/autogrow-textarea.js"></script>              
    <script src="js/textarearesizer.min.js"></script>
    <script src="wysiwyghtml5/parser_rules/advanced.js"></script>
	<script src="wysiwyghtml5/dist/wysihtml5-0.3.0.js"></script>                    
    <script src="js/jquery.colorbox-min.js"></script>
    <script src="js/jquery.dataTables.min.js"></script>
    <script src="js/jquery.maskedinput-1.3.min.js"></script> 
    <script src="js/json2.js"></script>
    <script src="audiojs/audiojs/audio.min.js"></script> 
    <script src="js/e_styleswitcher.1.0.min.js"></script>                 
    <script src="js/main.js"></script>
    
    <!-- // HTML5/CSS3 support // -->

    <script src="js/modernizr.min.js"></script>
                
</head>
<body class="layout_fluid layout_responsive"> 
  
	<div id="container">
    
        <!-- MAIN HEADER -->
                
        <header id="header">
        	<div id="header-border">
                <div id="header-inner">
                
                    <div class="left">
                        <a href="index.php" id="logo"><?php echo $site_title; ?></a>
                    </div><!-- End .left -->
                    
                    <div class="right">
                        
                    </div><!-- End .right --> 
                    
                </div><!-- End #header-border --> 
            </div><!-- End #header-inner -->  
                
		</header><!-- End #header -->
        
        <!-- CONTENT -->
                 
        <div id="content">
            <div id="content-border">
            
                <!-- CONTENT HEADER -->
                
                <header id="content-header">
                    <div class="left">
                    	<a href="javascript:void(0);" id="toggle-mainmenu" class="button-icon tip-s" title="Toggle Main Menu"><span class="arrow-up-10 plix-10"></span></a>
                        
                        <!-- main search form -->
                        <form method="post" id="mainsearch">
                            <input type="text" placeholder="Live search..." name="" autocomplete="off"/>
                            <input type="submit" value="" />
                        </form>
                    </div><!-- End .left --> 
                    <div class="right">
                    	<!-- sidebar switch -->
                    	<a href="javascript:void(0);" id="toggle-sidebar" class="button-icon tip-s" title="Switch Main Menu"><span class="arrow-left-10 plix-10"></span></a>
                        
                        <!-- breadcrumbs -->
                        <nav id="main-breadcrumbs">
                            <ul>
                                <li class="bc-tab-first">
                                    <a href="index.php">Home</a>
                                </li>
                                <li class="bc-tab-last">Dashboard</li>
                            </ul>          
                        </nav>
                        
                        <!-- demo dialog button -->
                        <a href="javascript:void(0);" id="open-main-dialog" class="button-text-icon tip-w" title="Some tooltip pointing right"><span class="fullscreen-10 plix-10"></span> Credits</a>
                        
                        <!-- the main page dialog -->
                        <div id="main-page-dialog" title="Notice" style="display:none">
                        <img src="images/jquery-ui-logo.png" alt="" class="dummy-img-dialog"/>
								Powered by KoolSource v1
						</div>
                        
                        <span class="preloader"></span>
                        
                        <!-- widgets controls -->
                        <div id="widgets-controls">
                            <span class="preloader"></span>                       
                            <div class="icon-group"> 
                                <a href="javascript:void(0);" class="changeto-grid selected tip-s" title="Show grid"><span class="grid-10 plix-10"></span></a>
                                <span></span>
                                <a href="javascript:void(0);" class="changeto-rows tip-s" title="Show rows"><span class="rows-10 plix-10"></span></a>
                            </div>
                            
                            <!-- widgets management switch -->
                            <a href="javascript:void(0);" class="button-icon tip-s" title="Manage widgets" id="powerwidget-panel-switch"><span class="settings-10 plix-10"></span></a>
                        </div>
                    </div><!-- End .right -->                
                
				</header><!-- End #content-header --> 
                                
                <div id="content-inner">
                    
                    <!-- SIDEBAR -->
                    
                    <aside>
                    
                    	<!-- SIDEBAR PROFILE -->
                        
                    	<div id="sidebar-profile">
                            <div id="main-avatar">
                            	<span class="indicator">0</span>
                                <img src="images/avatar.jpg" alt=""/>
                            </div>
                            <div id="profile-info">
                                <div>
                                    <a href="#"><b><?php echo $_SESSION['source']; ?></b></a>
                                    <a href="logout.php">Logout</a>
                                </div>
                            </div>
                        </div>
                        
                        <!-- MAIN MENU -->
                        
                        <nav id="main-menu">
                            <ul>
                                <li class="page-active"><a href="index.php"><span class="home-16 plix-16"></span> Dashboard</a></li>
                                <li class="no-mobile"><a href="hub.php"><span class="note-16 plix-16"></span> Boot</a></li>
                                <li><a href="cf.php"><span class="cells-16 plix-16"></span> Cloudflare Resolver</a></li>
                                <li><a href="logout.php"><span class="layout3-16 plix-16"></span> Logout</a></li>
                            </ul>
                        </nav>                    
                    </aside>
                    
                    <!-- sidebar meta stats -->
                    <div id="sidebar-meta">
                    	<div id="sidebar-meta-inner">
                        	<div>
                                <p class="left">Boot time limit</p> 
                                <p class="right"><?php echo $_SESSION['max']; ?></p>
                            </div>
                            <div class="pbar">
                               <span style="width:100%"></span>                            
                            </div>
                        	<div>
                                <p class="left">Expires</p> 
                                <p class="right"><?php echo $_SESSION['expires']; ?></p>
                            </div>
                            <div class="pbar">
                               <span style="width:100%"></span>                            
                            </div>
                        </div>  
                    </div> 
                     
                    <!-- CONTENT -->
                    
					<div id="content-main">
                        <div id="content-main-inner">
                        
                           
                            <div class="page-header">
                                <h2>CF</h2>
                                <span class="page-helper">v1.0</span>
                                <p>Cloudflare Resolver</p>
                            </div>
                            
                                <div class="spacer-20"><!-- spacer 20px --></div>
                                <div class="g_1">
                                    <p style="text-align:justify">
										<?php
										if(isset($_POST['domain'])){
											$domain = $_POST['domain'];
											$lookupArr = array("mail.", "ssl.", "cdn.", "direct.", "direct-connect.", "cpanel.", "ftp.");
											$full = "";
											foreach ($lookupArr as $lookupKey){
												$result = gethostbyname($lookupKey.$domain);
												if ($result == $lookupKey.$domain)
												{
													$full = $full.$lookupKey.$domain.": Nothing found<br>";
												}else{
													$full = $full.$lookupKey.$domain.": ".$result."<br>";
												}
											}
										}
										else
										{
											?>
											<form action="cf.php" method="POST">
											Domain: <input type="text" name="domain" placeholder="website domain here"><br><input type="submit" name="submit" value="Resolve">
											</form>
											<?php
										}
										?>
									</p>
									</div></div></div>
                            
                            <!-- End grid -->
                            
                       </div><!-- End #content-main-inner --> 
                    </div><!-- End #content-main --> 
                </div><!-- End #content-inner --> 
                
                <!-- CONTENT FOOTER -->
                
                <footer id="content-footer">
                    <div class="left">
						<div class="left">
                               <a href="javascript:void(0);" class="button-icon tip-s" title="Some action">
                                  <span class="folder-10 plix-10"></span>
                              </a>                                                        
                              <a href="javascript:void(0);" class="button-icon tip-s" title="Some action">
                                  <span class="pencil-10 plix-10"></span>
                              </a>
                          </div><!-- End .left -->
                          <div class="right">
                              <a href="javascript:void(0);" class="button-icon tip-s" title="Some action">
                                  <span class="refresh-10 plix-10"></span>
                              </a> 
                          </div> <!-- End .right --> 
                    </div><!-- End .left --> 
                    <div class="right">
                    	<div class="left">
                    	Copyright © 2012 <?php echo $site_title; ?>
                        </div><!-- End .left -->
                        <div class="right">
                        	<div class="theme-version">Powered by KoolSource</div>
                        </div><!-- End .right -->
                    </div><!-- End .right -->                
                </footer><!-- End #content-footer -->                 
            </div><!-- End #content-border --> 
        </div><!-- End #content --> 
            
    </div><!-- End #container -->
    
    <!-- scroll to top link -->
    <div id="scrolltotop"><span></span></div> 
    
</body>
</html>