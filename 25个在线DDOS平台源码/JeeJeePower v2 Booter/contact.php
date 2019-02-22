<?php
define("_VALID_PHP", true);
  require_once("init.php");
?>
<?php include("header.php");?>
    <h1>Contact Request</h1>
    <div id="fullform">
      <div class="box">
        <form action="" method="post" id="admin_form" name="admin_form">
          <table width="100%" border="0" cellpadding="3" cellspacing="0" class="display">
            <thead>
              <tr>
                <th colspan="2" class="left">Contact Us</th>
              </tr>
            </thead>
            <tr>
              <th width="200"><strong>Your Name: <?php echo required();?></strong></th>
              <td><span class="inputwrap">
                <input name="name" id="name" class="inputbox" size="45" value="<?php if ($user->logged_in) echo $user->name;?>" type="text" style="width:300px"/>
                </span></td>
            </tr>
            <tr>
              <th><strong>
                <label for="email">Email Address: <?php echo required();?></label>
                </strong></th>
              <td><span class="inputwrap">
                <input name="email" id="email" class="inputbox" size="45" value="<?php if ($user->logged_in) echo $user->email;?>" type="text" style="width:300px"/>
                </span></td>
            </tr>
            <tr>
              <th><strong>Subject:</strong></th>
              <td><span class="inputwrap">
                <select name="subject" class="select" style="width:310px">
                  <option value="">--- What's on your mind? ---</option>
                  <option value="Compliment">Compliment</option>
                  <option value="Criticism">Criticism</option>
                  <option value="Suggestion">Suggestion</option>
                  <option value="Advertise">Advertise</option>
                  <option value="Support">Support</option>
                  <option value="Other">Other</option>
                </select>
                </span></td>
            </tr>
            <tr>
              <th><strong>Your Message: <?php echo required();?></strong></th>
              <td><span class="inputwrap">
                <textarea name="message" cols="55" rows="8" class="inputbox" style="height: 100px; width: 300px;"></textarea>
                </span></td>
            </tr>
            <tr>
              <th><strong>Are You Human? 3 + 5 =: <?php echo required();?></strong></th>
              <td><span class="inputwrap">
                <input name="code" type="text" class="inputbox" id="code" size="5" maxlength="1" />
                </span></td>
            </tr>
            <tr>
              <td colspan="2"><input id="submit" name="submit" class="button shadow" value="Submit Inquiry" type="submit" /></td>
            </tr>
          </table>
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
	  $("#admin_form").submit(function () {
		  var str = $(this).serialize();
		  showLoader();
		  $.ajax({
			  type: "POST",
			  url: "ajax/sendmail.php",
			  data: str,
			  success: function (msg) {
				  $("#msgholder").ajaxComplete(function(event, request, settings) {
				  if(msg  == 1) {
					  hideLoader();
					  result = '<div class="msgOk"><span>Thank you!<\/span>Your message has been sent successfully<\/div>';
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
<?php include("footer.php");?>