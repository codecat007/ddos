<?php 
/**
 * Main.php
 *
 * This is an example of the main page of a website. Here
 * users will be able to login. However, like on most sites
 * the login form doesn't just have to be on the main page,
 * but re-appear on subsequent pages, depending on whether
 * the user http://file-manager.000webhost.com/index.phphas
 * logged in or not.
 *
 * Written by: Xbl Blue
 * Last Updated: March 2, 2011
 */
include("core/session.php");
?>

<html>
<body>
<link href="include/login.css" rel="stylesheet" type="text/css" />


<?php 
/**
 * User has already logged in, so display relavent links, including
 * a link to the admin center if the user is an administrator.
 */
if($session->logged_in){
?>
		<center>
                    <img alt=""  src="images/logo.png" /><br><br>
		</center>
<?php
   echo "Welcome back <b>$session->username</b>. <br><br>"
       ."[<a href=\"user/userinfo.php?user=$session->username\">My Account</a>] &nbsp;&nbsp;"
       ."[<a href=\"user/useredit.php\">Edit Account</a>] &nbsp;&nbsp;";
   if($session->isAdmin()){
      echo "[<a href=\"admin/admin.php\">Admin Center</a>] &nbsp;&nbsp;";
      echo "[<a href=\"user/register.php\">Register An Account</a>] &nbsp;&nbsp;";
   }
    echo "[<a href=\"hit.php\">DDoS</a>] &nbsp;&nbsp;";
    echo "[<a href=\"JavaScript:newPopup('include/shoutbox/index.php');\">Shoutbox</a>] &nbsp;&nbsp";
    echo "[<a href=\"core/process.php\">Logout</a>]";
?>
<title>PhantaC Main Menu</title>
<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>

<script type="text/javascript">
// Popup window code
function newPopup(url) {
	popupWindow = window.open(
		url,'popUpWindow','height=350,width=500,left=10,top=10,resizable=no,scrollbars=yes,toolbar=no,menubar=no,location=no,directories=no,status=yes')
}
</script>

<?php
include("include/footer.php");
} else {
Header("Location: index.php");
}
?>

</body>
</html>
