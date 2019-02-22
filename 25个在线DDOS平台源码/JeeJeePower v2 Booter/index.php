<?php
define("_VALID_PHP", true);
  require_once("init.php");
  
  if ($user->logged_in)
      redirect_to("account.php");
	  
	  
  if (isset($_POST['doLogin']))
      : $result = $user->login($_POST['username'], $_POST['password']);
  
  /* Login Successful */
  if ($result)
      : redirect_to("account.php");
  endif;
  endif;
?>
<?php include("header.php");?>
<div id="msgholder-alt"><?php print $core->showMsg;?></div>
    <h1>Member Login</h1>
    <p class="info">Please enter your valid username and password to login into your account. Fields marked <?php echo required();?> are required</p>
    <div class="box">
      <form action="" method="post" id="login_form" name="login_form">
        <table width="100%" border="0" cellpadding="3" cellspacing="0" class="display">
          <thead>
            <tr>
              <th colspan="2" class="left">Account Login</th>
            </tr>
          </thead>
          <tr>
            <th width="200"><strong>Username: <?php echo required();?></strong></th>
            <td><input name="username" type="text" size="45" maxlength="20" class="inputbox" /></td>
          </tr>
          <tr>
            <th><strong>Password: <?php echo required();?></strong></th>
            <td><input name="password" type="password" size="45" maxlength="20" class="inputbox" /></td>
          </tr>
          <tr>
            <td><input name="submit" value="Login Now" type="submit" class="button"/></td>
            <td align="right"><a class="button-alt" href="register.php">Click Here to Register</a></td>
          </tr>
        </table>
        <input name="doLogin" type="hidden" value="1" />
      </form>
    </div>
    <br />
    <p class="info">Enter your username and email address below to reset your password. A verification token will be sent to your email address.<br />
      Once you have received the token, you will be able to choose a new password for your account.</p>
    <div class="box">
      <form action="" method="post" id="admin_form" name="admin_form">
        <table width="100%" border="0" cellpadding="3" cellspacing="0" class="display">
          <thead>
            <tr>
              <th colspan="2" class="left">Lost Password</th>
            </tr>
          </thead>
          <tr>
            <th width="200"><strong>Username: <?php echo required();?></strong></th>
            <td><input name="uname" type="text" size="45" maxlength="20" class="inputbox" /></td>
          </tr>
          <tr>
            <th><strong>Email Address:</strong> <?php echo required();?></th>
            <td><input name="email" type="text" size="45" maxlength="60" class="inputbox" /></td>
          </tr>
          <tr>
            <th><strong>Are You Human? 5 + 5 = <?php echo required();?></strong></th>
            <td><input name="captcha" type="text" size="10" maxlength="2" class="inputbox" /></td>
          </tr>
          <tr>
            <td colspan="2"><input  name="submit" value="Submit Request" type="submit" class="button"/></td>
          </tr>
        </table>
      </form>
    </div>
<?php echo $core->doForm("passReset","ajax/user.php");?>
<?php include("footer.php");?>