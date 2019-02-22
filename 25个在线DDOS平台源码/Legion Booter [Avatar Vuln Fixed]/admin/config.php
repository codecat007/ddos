<?php
if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');
?>
<h1><img src="../images/config-lrg.png" alt="" />System Configuration</h1>
<p class="info">Here you can update your system configuration. Fields marked <?php echo required();?> are required.</p>
<form action="" method="post" id="admin_form" name="admin_form">
  <table cellpadding="0" cellspacing="0" class="forms">
    <thead>
      <tr>
        <th colspan="2" class="left">Update System Configuration</th>
      </tr>
    </thead>
    <tfoot>
      <tr>
        <td colspan="2"><input type="submit" name="submit" class="button" value="Update Configuration" /></td>
      </tr>
    </tfoot>
    <tbody>
    <tr>
      <th width="200">Website Name: <?php echo required();?></th>
      <td><input name="site_name" type="text" class="inputbox required" value="<?php echo $core->site_name;?>" size="55"/>
        <?php echo tooltip("The name of your web site, which is displayed in various locations across your site,<br />including email and newsletter notifications");?></td>
    </tr>
    <tr>
      <th>Website Url: <?php echo required();?></th>
      <td><input name="site_url" type="text" class="inputbox required" value="<?php echo $core->site_url;?>" size="55" />
        <?php echo tooltip("Insert full URL WITHOUT any trailing slash  (e.g. http://www.yourdomain.com)");?></td>
    </tr>
    <tr>
      <th>Website Email: <?php echo required();?></th>
      <td><input name="site_email" type="text" class="inputbox required" value="<?php echo $core->site_email;?>" size="55" />
        <?php echo tooltip("This is the main email notices will be sent to. It is also used as the from 'email'<br />when emailing other automatic emails");?></td>
    </tr>
    <tr>
      <th>Items Per Page:</th>
      <td><input name="user_perpage" type="text" class="inputbox" value="<?php echo $core->perpage;?>" size="5" />
        <?php echo tooltip("Default number of items used for pagination");?></td>
    </tr>
    <tr>
      <th>Thumb Width/Height: <?php echo required();?></th>
      <td><input name="thumb_w" type="text" class="inputbox" value="<?php echo $core->thumb_w;?>" size="5"/>
        /
        <input name="thumb_h" type="text" class="inputbox" value="<?php echo $core->thumb_h;?>" size="5"/>
        <?php echo tooltip("Default thumbnail Width/Height, in px used for resizing avatars.");?></td>
    </tr>
    <tr>
      <th>Registration Verification:</th>
      <td><span class="input-out">
        <label for="reg_verify-1">Yes</label>
        <input name="reg_verify" type="radio" id="reg_verify-1"  value="1" <?php getChecked($core->reg_verify, 1); ?> />
        <label for="reg_verify-2">No</label>
        <input name="reg_verify" type="radio" id="reg_verify-2" value="0" <?php getChecked($core->reg_verify, 0); ?> />
        <?php echo tooltip("If Yes users will need to confirm their email address and go through activation process.");?></span></td>
    </tr>
    <tr>
      <th>Auto Registration:</th>
      <td><span class="input-out">
        <label for="auto_verify-1">Yes</label>
        <input name="auto_verify" type="radio" id="auto_verify-1"  value="1" <?php getChecked($core->auto_verify, 1); ?> />
        <label for="auto_verify-2">No</label>
        <input name="auto_verify" type="radio" id="auto_verify-2" value="0" <?php getChecked($core->auto_verify, 0); ?> />
        <?php echo tooltip("If Yes, once registration process is completed users will be able to login.<br />If No Admin will need to manually activate each account.");?></span></td>
    </tr>
    <tr>
      <th>Allow Registration:</th>
      <td><span class="input-out">Yes
        <input name="reg_allowed" type="radio" id="reg_allowed-1"  value="1" <?php getChecked($core->reg_allowed, 1); ?> />
        No
        <input name="reg_allowed" type="radio" id="reg_allowed-2" value="0" <?php getChecked($core->reg_allowed, 0); ?> />
        <?php echo tooltip("Enable/Disable User Registration");?></span></td>
    </tr>
    <tr>
      <th>Registration Notification:</th>
      <td><span class="input-out">
        <label for="notify_admin-1">Yes</label>
        <input name="notify_admin" type="radio" id="notify_admin-1"  value="1" <?php getChecked($core->notify_admin, 1); ?> />
        <label for="notify_admin-2">No</label>
        <input name="notify_admin" type="radio" id="notify_admin-2" value="0" <?php getChecked($core->notify_admin, 0); ?> />
        <?php echo tooltip("Receive notification upon each new user registration.");?></span></td>
    </tr>
    <tr>
      <th>User Limit:</th>
      <td><input name="user_limit" type="text" class="inputbox" value="<?php echo $core->user_limit;?>" size="5"/>
        <?php echo tooltip("Limit number of users that are allowed to register 0 = Unlimited.");?></td>
    </tr>
    <tr>
      <th>Default Currency: <?php echo required();?></th>
      <td><input name="currency" type="text" class="inputbox" value="<?php echo $core->currency;?>"  size="5"/>
        <?php echo tooltip('Enter your currency such as CAD, USD, EUR.');?></td>
    </tr>
    <tr>
      <th>Currency Symbol:</th>
      <td><input name="cur_symbol" type="text" class="inputbox" value="<?php echo $core->cur_symbol;?>" size="5"/>
        <?php echo tooltip('Enter your currency symbol such as $, &euro;, &pound;.');?></td>
    </tr>
    <tr>
      <th>Default Mailer:</th>
      <td><select class="select" name="mailer" id="mailerchange" style="width:150px">
          <option value="PHP"<?php if ($core->mailer == "PHP") echo "selected=\"selected\"";?>>PHP Mailer</option>
          <option value="SMTP"<?php if ($core->mailer == "SMTP") echo "selected=\"selected\"";?>>SMTP Mailer</option>
        </select>
        <?php echo tooltip('Use PHP Mailer or SMTP protocol for sending emails');?></td>
    </tr>
    <tr class="showsmtp">
      <th>SMTP Hostname:</th>
      <td><input name="smtp_host" type="text" class="inputbox" value="<?php echo $core->smtp_host;?>" size="55" />
        <?php echo tooltip('Specify main SMTP server. E.g.:(mail.yourserver.com)');?></td>
    </tr>
    <tr class="showsmtp">
      <th>SMTP Username:</th>
      <td><input name="smtp_user" type="text" class="inputbox" value="<?php echo $core->smtp_user;?>" size="55" /></td>
    </tr>
    <tr class="showsmtp">
      <th>SMTP Password:</th>
      <td><input name="smtp_pass" type="text" class="inputbox" value="<?php echo $core->smtp_pass;?>" size="55"/></td>
    </tr>
    <tr class="showsmtp">
      <th>SMTP Port:</th>
      <td><input name="smtp_port" type="text" class="inputbox" value="<?php echo $core->smtp_port;?>" size="5" />
        <?php echo tooltip('Mail server port ( Can be 25, 26. 456 for GMAIL. 587 for Yahoo ). Ask your host if uncertain.');?></td>
    </tr>
    </tbody>
  </table>
</form>
<script type="text/javascript">
// <![CDATA[
$(document).ready(function () {
	var res2 = '<?php echo $core->mailer;?>';
		(res2 == "SMTP" ) ? $('.showsmtp').fadeIn().show() : $('.showsmtp').hide();
    $('#mailerchange').change(function () {
		var res = $("#mailerchange option:selected").val();
		(res == "SMTP" ) ? $('.showsmtp').fadeIn().show() : $('.showsmtp').hide();
    });
});
// ]]>
</script>
<?php echo $core->doForm("processConfig");?> 