<?php
if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');
?>
<h1><img src="../images/help-lrg.png" alt="" />Help Section &rsaquo; Membership Based Protection</h1>
<p class="info">Here you can find instructions on how to protect your pages based on user level, login state etc...</p>
<h2>Protecting pages based on user membership</h2>
<div class="box">You can also use an automated page builder from here <a href="index.php?do=builder">Page Builder</a>. First start by creating a new php page that you want to give access to all of your registered users. Let's call this page for the purpose of this tutorial <strong>members_only.php</strong><br />
</div>
<br />
<div class="box"> <strong>1</strong>. At the very beginning of the page start by adding following php code:
  <?php
highlight_string('
<?php
  define("_VALID_PHP", true);
  require_once("init.php");
?>');
?>
  <br />
  Make sure that <strong>init.php</strong> point to correct directory. For example, If your <strong><em>members_only.php</em></strong> page is in the same directory as main script, than no changes are necessary, otherwise you need to enter correct path to your init.php page. Depending where you placed <strong><em>members_only.php</em></strong> page, below or above root directory init.php becomes <strong>../init.php</strong> if below the root or <strong>otherdir/init.php</strong> if above the root.</div>
<br />
<div class="box"> <strong>2</strong>. Now let's add some protection:
  <?php
highlight_string('
<?php
  define("_VALID_PHP", true);
  require_once("init.php");
  
  if (!$user->checkMembership("3,4"))
      redirect_to("login.php");
?>');
?>
  <br />
  The two new lines of code do membership verification. First line checks if user belongs to memberships <strong>3 or 4</strong>, the second one redirects user to login page <strong>login.php</strong>. <em>Note you can find out membership id from  <a href="index.php?do=memberships">Manage Memberships</a> very first column on the left.</em></div>
<br />
<div class="box"> <strong>3</strong>. Now you can continue to add the usual html or php code to your page.</div>
<br />
<div class="box"> <em>In this example we protected single page using membership verification process. If user does not have valid membership in this case 3 or 4 we redirect to login page, otherwise, we let the user view the page.</em> </div><br />
<div class="box"> <strong>4</strong>. Another example would be to show customized error message if user does not have valid membership.
  <?php
highlight_string('
<?php
  define("_VALID_PHP", true);
  require_once("init.php");
?>
  <?php if (!$user->checkMembership("3,4")) : ?>
  
      Your custom error message goes here, such as Sorry you do not have valid membership!!!
	 
  <?php else: ?>
  
      In this section here you would place your content that users with valid membership will be able to see.
	  
  <?php endif;?>
');
?>

</div>
<br />
<div class="box">We only used two memberships in this case 3 and 4. You can add multiple memberships separated by coma such as <strong>$user->checkMembership("2,3,4,5")</strong>. <br />
Or just single user membership <strong>$user->checkMembership("3")</strong></div><br />