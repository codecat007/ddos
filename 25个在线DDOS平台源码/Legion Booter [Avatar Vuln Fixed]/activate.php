<?php
define("_VALID_PHP", true);
  require_once("init.php");
  
  if ($user->logged_in)
      redirect_to("account.php");
?>
<?php include("header.php");?>
    <h1>Account Activation</h1>
    <p class="info">Here you can activate your account. Please enter your email address and activation code received.</p>
    <div class="box">
      <form action="" method="post" id="admin_form" name="admin_form">
        <table width="100%" border="0" cellpadding="3" cellspacing="0" class="display">
          <thead>
            <tr>
              <th colspan="2" class="left">Activate Your Account</th>
            </tr>
          </thead>
          <tr>
            <th width="200"><strong>Email Address: <?php echo required();?></strong></th>
            <td><input name="email" type="text" size="45" maxlength="40" class="inputbox" /></td>
          </tr>
          <tr>
            <th><strong>Activation Token: <?php echo required();?></strong></th>
            <td><input name="token" type="text" size="45" maxlength="40" class="inputbox" /></td>
          </tr>
          <tr>
            <td><input name="submit" value="Activate Account" type="submit" class="button"/></td>
            <td align="right"><a class="button-alt" href="index.php">Back to login</a></td>
          </tr>
        </table>
      </form>
    </div>
<?php echo $core->doForm("accActivate","ajax/user.php");?>
<?php include("footer.php");?>