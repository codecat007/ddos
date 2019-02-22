<?php
define("_VALID_PHP", true);
  require_once("init.php");
  
  if (!$user->logged_in)
      redirect_to("index.php");
	  
  $row = $user->getUserData();
  $mrow = $user->getUserMembership();
  $gatelist = $member->getGateways(true);
  $listpackrow = $member->getMembershipListFrontEnd();
?>
<?php include("header.php");?>
    <span id="avatar"><?php echo ($row['avatar']) ? '<img src="'.UPLOADURL . $row['avatar'].'" alt=""/>' : '<img src="'.UPLOADURL.'blank.png" alt=""/>';?></span>
    <h1>Manage Your Account</h1>
    <p class="info">Here you can make changes to your profile...</p>
    <div class="box">
      <form action="" method="post" id="admin_form" name="admin_form" enctype="multipart/form-data">
        <table border="0" cellpadding="3" cellspacing="0" class="display">
          <thead>
            <tr>
              <th colspan="2" class="left">User Account Edit</th>
            </tr>
          </thead>
          <tr>
            <th width="180"><strong>Username:</strong></th>
            <td><input name="username" type="text" disabled="disabled" class="inputbox" value="<?php echo $row['username'];?>" size="45" /></td>
          </tr>
          <tr>
            <th><strong>Password:</strong></th>
            <td><input name="password" type="password"  class="inputbox" size="45" />
              &nbsp;&nbsp; <?php echo tooltip('Leave it empty unless changing the password');?></td>
          </tr>
          <tr>
            <th><strong>Email Address: <?php echo required();?></strong></th>
            <td><input name="email" type="text" class="inputbox" value="<?php echo $row['email'];?>" size="45" maxlength="40" /></td>
          </tr>
          <tr>
            <th><strong>First Name:</strong> <?php echo required();?></th>
            <td><input name="fname" type="text" class="inputbox" value="<?php echo $row['fname'];?>" size="45" /></td>
          </tr>
          <tr>
            <th><strong>Last Name:</strong> <?php echo required();?></th>
            <td><input name="lname" type="text" class="inputbox" value="<?php echo $row['lname'];?>" size="45" /></td>
          </tr>
          <tr>
            <th><strong>Newsletter Subscriber:</strong></th>
            <td><span class="input-out">
              <label for="newsletter-1">Yes</label>
              <input name="newsletter" type="radio" id="newsletter-1" value="1" <?php getChecked($row['active'], 1); ?>/>
              <label for="newsletter-2">No</label>
              <input name="newsletter" type="radio" id="newsletter-2" value="0" <?php getChecked($row['active'], 0); ?> />
              </span></td>
          </tr>
          <tr>
            <th><strong>Date Registered:</strong></th>
            <td><span class="input-out"><?php echo $row['cdate'];?></span></td>
          </tr>
          <tr>
            <th><strong>Last Login:</strong></th>
            <td><span class="input-out"><?php echo $row['ldate'];?></span></td>
          </tr>
          <tr>
            <td colspan="2"><input name="doupdate" type="submit" value="Update Profile"  class="button"/></td>
          </tr>
        </table>
      </form>
    </div>
    <br />
    <div class="box">
      <table border="0" cellpadding="3" cellspacing="0" class="display">
        <thead>
          <tr>
            <th colspan="2" class="left">Select Your Membership</th>
          </tr>
        </thead>
        <tr>
          <th width="200"><strong>Membership Title:</strong></th>
          <?php foreach ($listpackrow as $prow):?>
          <td class="center" style="color:#09F"><strong><?php echo $prow['title'];?></strong></td>
          <?php endforeach;?>
        </tr>
        <tr>
          <th><strong>Membership Price:</strong></th>
          <?php foreach ($listpackrow as $prow):?>
          <td class="center" style="color:#09F"><?php echo $core->formatMoney($prow['price']);?></td>
          <?php endforeach;?>
        </tr>
        <tr>
          <th><strong>Membership Period:</strong></th>
          <?php foreach ($listpackrow as $prow):?>
          <td class="center" style="color:#09F"><?php echo $prow['days'] . ' ' .$member->getPeriod($prow['period']);?></td>
          <?php endforeach;?>
        </tr>
        <tr>
          <th><strong>Recurring Payment:</strong></th>
          <?php foreach ($listpackrow as $prow):?>
          <td class="center" style="color:#09F"><?php echo ($prow['recurring']) ? 'Yes' : 'No';?></td>
          <?php endforeach;?>
        </tr>
        <tr>
          <th valign="top"><strong>Membership Description:</strong></th>
          <?php foreach ($listpackrow as $prow):?>
          <td class="center"><span style="font-size:11px"><?php echo $prow['description'];?></span></td>
          <?php endforeach;?>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <?php foreach ($listpackrow as $prow):?>
          <td class="center"><?php if($prow['price'] == 0):?>
            <a href="javascript:void(0);" class="add-cart" id="item_<?php echo $prow['id'].':FREE';?>"> <img src="images/activate.png" alt="" class="tooltip" title="Activate Membership"/> </a>
            <?php else:?>
            <?php if($gatelist):?>
            <?php foreach($gatelist as $grow):?>
            <?php if ($grow['active']):?>
            <a href="javascript:void(0);" class="add-cart" id="item_<?php echo $prow['id'].':'.$grow['id'];?>"> <img src="<?php echo SITEURL.'/gateways/'.$grow['dir'].'/'.$grow['displayname'].'.png';?>" alt="" class="tooltip" title="<?php echo $grow['displayname'];?>"/> </a>
            <?php endif;?>
            <?php endforeach;?>
            <?php endif;?>
            <?php endif;?></td>
          <?php endforeach;?>
        </tr>
      </table>
    </div>
    <div id="show-result"></div>
    <br />
    <div class="box">
      <table class="utility">
        <tr>
          <td><strong>Current Membership</strong></td>
          <td><strong>Valid Until</strong></td>
        </tr>
        <?php if($row['membership_id'] == 0) :?>
        <tr>
          <td>No Membership</td>
          <td>--/--</td>
        </tr>
        <?php else:?>
        <tr>
          <td style="color:#09F" class="border"><strong> <?php echo $mrow['title'];?> </strong></td>
          <td style="color:#09F" class="border"><strong> <?php echo $mrow['expiry'];?> </strong></td>
        </tr>
        <?php endif;?>
      </table>
    </div>
    <?php echo $core->doForm("processUser","ajax/controller.php");?> 
<script type="text/javascript">
// <![CDATA[
$(document).ready(function () {
    $("a.add-cart").live("click", function () {
        $.ajax({
            type: "POST",
            url: "ajax/controller.php",
            data: 'addtocart=' + $(this).attr('id').replace('item_', ''),
            success: function (msg) {
                $("#show-result").html(msg);

            }
        });
        return false;
    });
});
// ]]>
</script>
    <?php include("footer.php");?>