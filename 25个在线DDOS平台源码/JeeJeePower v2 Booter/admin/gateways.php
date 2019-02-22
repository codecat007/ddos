<?php
if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');
?>
<?php switch($core->action): case "edit": ?>
<?php $row = $core->getRowById("gateways", $core->id);?>
<h1><img src="../images/gate-lrg.png" alt="" />Manage Payment Gateways</h1>
<p class="info">Here you can update your gateway settings. Fields marked <?php echo required();?> are required.</p>
<form action="" method="post" id="admin_form" name="admin_form">
  <table cellpadding="0" cellspacing="0" class="forms">
    <thead>
      <tr>
        <th colspan="2" class="left"><span><a href="javascript:void(0);" onclick="$('#dialog').dialog('open'); return false"><img src="../images/help.png" alt="" class="tooltip" title="Gateway Help"/></a></span>Editing Gateway &rsaquo; <?php echo $row['displayname'];?></th>
      </tr>
    </thead>
    <tfoot>
      <tr>
        <td><input type="submit" name="submit" class="button" value="Update Gateway" /></td>
        <td><a href="index.php?do=gateways" class="button-alt">Cancel</a></td>
      </tr>
    </tfoot>
    <tbody>
      <tr>
        <td width="200">Gateway Name: <?php echo required();?></td>
        <td><input name="displayname" type="text"  class="inputbox" value="<?php echo $row['displayname'];?>" size="55"/></td>
      </tr>
      <tr>
        <td><?php echo $row['extra_txt'];?>: <?php echo required();?></td>
        <td><input name="extra" type="text" class="inputbox" value="<?php echo $row['extra'];?>" size="55"/></td>
      </tr>
      <tr>
        <td><?php echo $row['extra_txt2'];?>:</td>
        <td><input name="extra2" type="text" class="inputbox" value="<?php echo $row['extra2'];?>" size="20"/></td>
      </tr>
      <tr>
        <td><?php echo $row['extra_txt3'];?>:</td>
        <td><input name="extra3" type="text" class="inputbox" value="<?php echo $row['extra3'];?>" size="20"/></td>
      </tr>
      <tr>
        <td>Set Live Mode:</td>
        <td><span class="input-out">
          <label for="demo-1">Yes</label>
          <input name="demo" type="radio" id="demo-1"  value="1" <?php getChecked($row['demo'], 1); ?> />
          No
          <input name="demo" type="radio" id="demo-2" value="0" <?php getChecked($row['demo'], 0); ?> />
          <?php echo tooltip('When in live mode all transactions will be processed in real time');?></span></td>
      </tr>
      <tr>
        <td>Active:</td>
        <td><span class="input-out">
          <label for="active-1">Yes</label>
          <input name="active" type="radio" id="active-1"  value="1" <?php getChecked($row['active'], 1); ?> />
          <label for="active-2">No</label>
          <input name="active" type="radio" id="active-2" value="0" <?php getChecked($row['active'], 0); ?> />
          <?php echo tooltip('Only active gateways will be available for payment methods.');?></span></td>
      </tr>
      <tr>
        <td>IPN Url:</td>
        <td><?php echo SITEURL.'/gateways/'.$row['dir'].'/ipn.php';?></td>
      </tr>
    </tbody>
  </table>
  <input name="id" type="hidden" value="<?php echo $core->id;?>" />
</form>
<div id="dialog" title="<?php echo $row['displayname'];?>"><?php echo ($row['name'] == "paypal") ? '
            <p><a href="http://www.paypal.com/" title="PayPal" rel="nofollow" target="_blank">Click here to setup an account with Paypal</a> </p>
			<p><strong>Gateway Name</strong> - Enter the name of the payment provider here.</p>
			<p><strong>Active</strong> - Select Yes to make this payment provider active. <br />
			If this box is not checked, the payment provider will not show up in the payment provider list during checkout.</p>
			<p><strong>Set Live Mode</strong> - If you would like to test the payment provider settings, please select No. </p>
			<p><strong>Paypal email address</strong> - Enter your PayPal Business email address here. </p>
			<p><strong>Currency Code</strong> - Enter your currency code here. Valid choices are: </p>
				<ul>
					<li> USD (U.S. Dollar)</li>
					<li> EUR (Euro) </li>
					<li> GBP (Pound Sterling) </li>
					<li> CAD (Canadian Dollar) </li>
					<li> JPY (Yen). </li>
					<li> If omitted, all monetary fields will use default system setting Currency Code. </li>
				</ul>
			<p><strong>Not in Use</strong> - This field it\'s not in use. Leave it empty. </p>
	        <p><strong>IPN Url</strong> - If using recurring payment method, you need to set up and activate the IPN Url in your account: </p>' : '
			<p><a href="http://www.moneybookers.com/" title="http://www.moneybookers.net/" rel="nofollow">Click here to setup an account with MoneyBookers</a></p>
			<p><strong>Gateway Name</strong> - Enter the name of the payment provider here.</p>
			<p><strong>Active</strong> - Select Yes to make this payment provider active. <br />
			If this box is not checked, the payment provider will not show up in the payment provider list during checkout.</p>
			<p><strong>Set Live Mode</strong> - If you would like to test the payment provider settings, please select No. </p>
			<p><strong>MoneyBookers email address</strong> - Enter your MoneyBookers email address here. </p>
			<p><strong>Secret Passphrase</strong> - This field must be set at Moneybookers.com.</p>
	        <p><strong>IPN Url</strong> - If using recurring payment method, you need to set up and activate the IPN Url in your account: </p>' ;?></div>
<?php echo $core->doForm("processGateway");?>
<?php break;?>
<?php default: ?>
<?php $gaterow = $member->getGateways();?>
<h1><img src="../images/gate-lrg.png" alt="" />Manage Payment Gateways</h1>
<p class="info">Here you can manage your list of available gateways.</p>
<table cellpadding="0" cellspacing="0" class="display">
  <thead>
    <tr>
      <th width="20">#</th>
      <th class="left">Gateway Name</th>
      <th class="right">Edit</th>
    </tr>
  </thead>
  <tbody>
    <?php if(!$gaterow):?>
    <tr>
      <td colspan="3"><?php echo $core->msgError('<span>Error!</span>Your are missing all gateways. You need to reinstall them manually',false);?></td>
    </tr>
    <?php else:?>
    <?php foreach ($gaterow as $row):?>
    <tr>
      <th><?php echo $row['id'];?>.</th>
      <td><?php echo $row['displayname'];?></td>
      <td align="right"><a href="index.php?do=gateways&amp;action=edit&amp;id=<?php echo $row['id'];?>"><img src="../images/edit.png" alt="" class="tooltip img-wrap2" title="Edit: <?php echo $row['displayname'];?>"/></a></td>
    </tr>
    <?php endforeach;?>
    <?php unset($row);?>
    <?php endif;?>
  </tbody>
</table>
<?php break;?>
<?php endswitch;?>