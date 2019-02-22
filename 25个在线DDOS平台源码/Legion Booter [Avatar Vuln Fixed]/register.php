<?php
define("_VALID_PHP", true);
  require_once("init.php");

  if ($user->logged_in)
      redirect_to("account.php");
	  
   $numusers = countEntries("users");
?>
<?php include("header.php");?>
    <?php if(!$core->reg_allowed):?>
    <div class="msgInfo"><span>Info!</span>We are sorry, at this point we do not accept any more registrations</div>
    <?php elseif($core->user_limit !=0 and $core->user_limit == $numusers):?>
    <div class="msgInfo"><span>Info!</span>We are sorry, maximum number of registered users have been reached.</div>
    <?php else:?>
    <h1>User Registration</h1>
    <p class="info">Please fill out the form below to become registered member. Fields marked <?php echo required();?> are required.</p>
    <div class="box">
      <div id="fullform">
        <form action="" method="post" name="user_form" id="user_form">
          <table width="100%" border="0" cellpadding="3" cellspacing="0" class="display">
            <thead>
              <tr>
                <th colspan="2" class="left"><h3>Create Account</h3></th>
              </tr>
            </thead>
            <tr>
              <th width="250"><strong>Username: <?php echo required();?></strong></th>
              <td><span id="getusername">
                <input name="username" type="text" class="inputbox"  id="username" size="45" />
                <img src="images/yes.png" alt="" id="yes" style="display:none" class="tooltip" title="Username Available" /> <img src="images/delete.png" alt="" id="no" style="display:none" class="tooltip" title="Username Not Available" /> </span></td>
            </tr>
            <tr>
              <th><strong>Password: <?php echo required();?></strong></th>
              <td><input name="pass" type="password" class="inputbox"  size="45" />
                &nbsp; <?php echo tooltip('Password must be at least 6 characters long.');?></td>
            </tr>
            <tr>
              <th><strong>Repeat Password: <?php echo required();?></strong></th>
              <td><input name="pass2" type="password" class="inputbox"  size="45" /></td>
            </tr>
            <tr>
              <th><strong>Email Address:</strong> <?php echo required();?></th>
              <td><input name="email" type="text" class="inputbox"  value="<?php echo post('email');?>" size="45" /></td>
            </tr>
            <tr>
              <th><strong>First Name:</strong> <?php echo required();?></th>
              <td><input name="fname" type="text" class="inputbox" size="45" value="<?php echo post('fname');?>" /></td>
            </tr>
            <tr>
              <th><strong>Last Name:</strong> <?php echo required();?></th>
              <td><input name="lname" type="text" class="inputbox" size="45" value="<?php echo post('lname');?>" /></td>
            </tr>
            <tr>
              <th><strong>Are You Human? 5 + 4 =</strong> <?php echo required();?></th>
              <td><input name="captcha" type="text" class="inputbox" size="10" maxlength="2"/></td>
            </tr>
            <tr>
              <td><input class="button" name="submit" value="Register Account" type="submit" /></td>
              <td align="right"><a class="button-alt" href="index.php">Back to login</a></td>
            </tr>
          </table>
          <input name="doRegister" type="hidden" value="1" />
        </form>
      </div>
    </div>
<script type="text/javascript">
  // <![CDATA[
  function showLoader() {
	  $("#loader").fadeIn(200);
  }

  function hideLoader() {
	  $("#loader").fadeOut(200);
  };
  $(document).ready(function() {
	  $("#user_form").submit(function () {
		  var str = $(this).serialize();
		  showLoader();
		  $.ajax({
			  type: "POST",
			  url: "ajax/user.php",
			  data: str,
			  success: function (msg) {
				  $("#msgholder").ajaxComplete(function(event, request, settings) {
				  if(msg  == 'OK') {
					  hideLoader();
					  result = '<div class="msgOk"><span>Success!<\/span>You have successfully registered. Please check your email for further information!<\/div>';
				  $("#fullform").hide();
				  } else {
					  hideLoader();
				      result = msg;
				  }
				 $(this).html(result);
					  });
				  }
			  });
		  return false;
	  });
  });
  // ]]>
  </script>
    <?php endif;?>
    <!-- Full Layout /--> 
    <script type="text/javascript">
// <![CDATA[
$(document).ready(function() {
	$('#username').keyup(username_check);
});
function username_check() {
	var username = $('#username').val();
	if (username == "" || username.length < 4) {
		$('#yes').hide();
	} else {
		$.ajax({
			type: "POST",
			url: "ajax/user.php",
			data: 'checkUsername=' + username,
			cache: false,
			success: function(response) {
				if (response == 1) {
					$('#yes').hide();
					$('#no').fadeIn();
				} else {
					$('#no').hide();
					$('#yes').fadeIn();
				}

			}
		});
	}
}
// ]]>
</script>
<?php include("footer.php");?>