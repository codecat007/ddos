<?php
if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');
?>
<h1><img src="../images/help-lrg.png" alt="" />Help Section &rsaquo; Login Protection</h1>
<p class="info">Here you can find instructions on how to protect your pages based on user level, login state etc...</p>
<h2>Protecting pages based on user login</h2>
<div class="box">First start by creating a new php page that you want to give access to all of your registered users.<br />
  Let's call this page for the purpose of this tutorial <strong>reg_only_users.php</strong><br />
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
  Make sure that <strong>init.php</strong> point to correct directory. For example, If your <strong><em>reg_only_users.php</em></strong> page is in the same directory as main script, than no changes are necessary, otherwise you need to enter correct path to your init.php page. Depending where you placed <strong><em>reg_only_users.php</em></strong> page, below or above root directory init.php becomes <strong>../init.php</strong> if below the root or <strong>otherdir/init.php</strong> if above the root.</div>
<br />
<div class="box"> <strong>2</strong>. Now let's add some protection:
  <?php
highlight_string('
<?php
  define("_VALID_PHP", true);
  require_once("init.php");
  
  if (!$user->logged_in)
      redirect_to("login.php");
?>');
?>
  <br />
  The two new lines of code do login verification. First line checks if user is <strong>not logged</strong> in, the second one redirects user to login page <strong>login.php</strong> </div>
<br />
<div class="box"> <strong>3</strong>. Now you can continue to add the usual html or php code to your page.</div>
<br />
<div class="box"> <em>In this example we protected single page using login verification process. If user is not logged in we redirect to login page, otherwise, we let the user view the page.</em> </div>