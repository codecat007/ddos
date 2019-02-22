<?php
if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');
?>
<?php $row = (isset($request->get['emailid'])) ? $core->getRowById("email_templates", 12) : $core->getRowById("email_templates", 4);?>
<h1><img src="../images/newsletter-lrg.png" alt="" />System Newsletter</h1>
<p class="info">Here you can send newsletter to all users or newsletter subscribers.</p>
<form action="" method="post" id="admin_form" name="admin_form">
  <table cellpadding="0" cellspacing="0" class="forms">
    <thead>
      <tr>
        <th colspan="2" class="left">Sending Newsletter</th>
      </tr>
    </thead>
    <tfoot>
      <tr>
        <td colspan="2"><input type="submit" name="submit" class="button" value="Send Mail" /></td>
      </tr>
    </tfoot>
    <tbody>
      <tr>
        <th>Recipients:</th>
        <td><?php if(isset($request->get['emailid'])):?>
          <input name="recipient" type="text" class="inputbox" size="45" value="<?php echo sanitize($request->get['emailid']);?>"/>
          <?php else:?>
          <select name="recipient" style="width:200px" class="select">
            <option value="all">All Users</option>
            <option value="free">Registered Members</option>
            <option value="paid">Paid Membership</option>
            <option value="newsletter">Newsletter Subscribers</option>
          </select>
          <?php endif;?></td>
      </tr>
      <tr>
        <th width="200">Newsletter Subject: <?php echo required();?></th>
        <td><input name="subject" type="text"  class="inputbox" value="<?php echo $row['subject'];?>" size="60"/></td>
      </tr>
      <tr>
        <td colspan="2" class="editor"><textarea id="bodycontent" name="body" rows="4" cols="30"><?php echo $row['body'];?></textarea></td>
      </tr>
      <tr>
        <td colspan="2"><strong>Do Not Replace Variables Between [ ]</strong></td>
      </tr>
    </tbody>
  </table>
</form>
<?php echo $core->doForm("processNewsletter");?> 
<script type="text/javascript">
  $(document).ready(function() {
	$("#bodycontent").cleditor({height:400});
  });
</script> 