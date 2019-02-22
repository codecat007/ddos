<?php
define("_VALID_PHP", true);
  require_once("../init.php");
?>
<?php
  if ($user->is_Admin())
      redirect_to("index.php");
	  
  if (isset($_POST['submit']))
      : $result = $user->login($_POST['username'], $_POST['password']);
  //Login successful 
  if ($result)
      : redirect_to("index.php");
  endif;
  endif;

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $core->site_name;?></title>
<link href="../assets/login.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../assets/jquery.js"></script>
<script type="text/javascript" src="../assets/jquery-ui-1.8.13.custom.min.js"></script>
</head>
<body>
<div id="content">
  <h1><?php echo $core->site_name;?> - Admin Panel</h1>
  <form id="admin_form" name="admin_form" method="post" action="">
    <label>Username:</label>
      <input name="username" type="text" class="inputbox" id="user"  size="25" />
    <label>Password:</label>
      <input name="password" type="password" class="inputbox" id="password"  size="25" />
    <div style="text-align:right; margin-top:20px; margin-right:5px">
      <input name="submit" type="submit" value="LOGIN" class="button"/>
    </div>
  </form>
</div>
<div id="footer">Copyright &copy;<?php echo date('Y').' '.$core->site_name;?></div>
<div id="message-box"><?php print $core->showMsg;?></div>
</body>
</html>