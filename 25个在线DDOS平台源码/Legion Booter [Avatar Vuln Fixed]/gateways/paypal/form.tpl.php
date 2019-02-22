<?php
if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');
?>
<?php $url = ($row2['demo'] == '0') ? 'www.sandbox.paypal.com' : 'www.paypal.com';?>
<br />
<div class="box">
  <form action="https://<?php echo $url;?>/cgi-bin/webscr" method="post" id="pp_form" name="pp_form">
    <table cellpadding="0" cellspacing="0" class="display">
      <thead>
        <tr>
          <th colspan="2">Purchase Summary - <?php echo $row2['displayname'];?></th>
        </tr>
      </thead>
      <tr>
        <th width="200"><strong>Membership Title:</strong></th>
        <td><strong style="color:#09F"><?php echo $row['title'];?></strong></td>
      </tr>
      <tr>
        <th><strong>Membership Price:</strong></th>
        <td><strong style="color:#09F"><?php echo $core->formatMoney($row['price']);?></strong></td>
      </tr>
      <tr>
        <th><strong>Membership Period:</strong></th>
        <td><strong style="color:#09F"><?php echo $row['days'] . ' ' .$member->getPeriod($row['period']);?></strong></td>
      </tr>
      <tr>
        <th><strong>Recurring Payment:</strong></th>
        <td><strong style="color:#09F"><?php echo ($row['recurring'] == 1) ? 'Yes' : 'No';?></strong></td>
      </tr>
      <tr>
        <th><strong>Valid Until:</strong></th>
        <td><strong style="color:#09F"><?php echo $member->calculateDays($row['period'], $row['days']);?></strong></td>
      </tr>
      <tr>
        <th><strong>Membership Description:</strong></th>
        <td><?php echo $row['description'];?></td>
      </tr>
      <tr>
        <td colspan="2"><input type="image" src="<?php echo SITEURL.'/gateways/'.$row2['dir'].'/'.$row2['displayname'].'_big.png';?>" name="submit" class="tooltip" title="Pay With Paypal" alt="" onclick="document.pp_form.submit();"/></td>
      </tr>
    </table>
    <?php if($row['recurring'] == 1):?>
    <input type="hidden" name="cmd" value="_xclick-subscriptions" />
    <input type="hidden" name="a3" value="<?php echo $row['price'];?>" />
    <input type="hidden" name="p3" value="<?php echo $row['days'];?>" />
    <input type="hidden" name="t3" value="<?php echo $row['period'];?>" />
    <input type="hidden" name="src" value="1" />
    <input type="hidden" name="sr1" value="1" />
    <?php else:?>
    <input type="hidden" name="cmd" value="_xclick" />
    <input type="hidden" name="amount" value="<?php echo $row['price'];?>" />
    <?php endif;?>
    <input type="hidden" name="business" value="<?php echo $row2['extra'];?>" />
    <input type="hidden" name="item_name" value="<?php echo $row['title'];?>" />
    <input type="hidden" name="item_number" value="<?php echo $row['id'] . '_' . $user->uid;?>" />
    <input type="hidden" name="return" value="<?php echo SITEURL;?>/account.php" />
    <input type="hidden" name="rm" value="2" />
    <input type="hidden" name="notify_url" value="<?php echo SITEURL.'/gateways/'.$row2['dir'];?>/ipn.php" />
    <input type="hidden" name="cancel_return" value="<?php echo SITEURL;?>/account.php" />
    <input type="hidden" name="no_note" value="1" />
    <input type="hidden" name="currency_code" value="<?php echo ($row2['extra2']) ? $row2['extra2'] : $core->currency;?>" />
  </form>
</div>