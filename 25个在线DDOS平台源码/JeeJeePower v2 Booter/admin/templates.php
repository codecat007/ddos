<?php
if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');
?>
<?php switch($core->action): case "edit": ?>
<?php $row = $core->getRowById("email_templates", $core->id);?>
<h1><img src="../images/email-lrg.png" alt="" />Manage Email Templates</h1>
<p class="info">Here you can update your email template. Fields marked <?php echo required();?> are required.</p>
<form action="" method="post" id="admin_form" name="admin_form">
  <table cellpadding="0" cellspacing="0" class="forms">
    <thead>
      <tr>
        <th colspan="2" class="left">Editing Email Template &rsaquo; <?php echo $row['name'];?></th>
      </tr>
    </thead>
    <tfoot>
      <tr>
        <td><input type="submit" name="submit" class="button" value="Update Template" /></td>
        <td><a href="index.php?do=templates" class="button-alt">Cancel</a></td>
      </tr>
    </tfoot>
    <tbody>
      <tr>
        <th width="200">Template Title: <?php echo required();?></th>
        <td><input name="name" type="text"  class="inputbox required" value="<?php echo $row['name'];?>" size="55" /></td>
      </tr>
      <tr>
        <th>Email Subject: <?php echo required();?></th>
        <td><input name="subject" type="text" class="inputbox required" value="<?php echo $row['subject'];?>" size="55" /></td>
      </tr>
      <tr>
        <td colspan="2" class="editor"><textarea id="bodycontent" name="body" rows="4" cols="30"><?php echo $row['body'];?></textarea></td>
      </tr>
      <tr>
        <td colspan="2"><textarea name="help" cols="80" rows="3"><?php echo $row['help'];?></textarea></td>
      </tr>
      <tr>
        <td colspan="2"><strong>Do Not Replace Variables Between [ ]</strong></td>
      </tr>
    </tbody>
  </table>
  <input name="id" type="hidden" value="<?php echo $core->id;?>" />
</form>
<?php echo $core->doForm("processEmailTemplate");?> 
<script type="text/javascript">
  $(document).ready(function() {
	$("#bodycontent").cleditor({height:400});
  });
</script>
<?php break;?>
<?php default: ?>
<?php $temprow = $core->getEmailTemplates();?>
<h1><img src="../images/email-lrg.png" alt="" />Manage Email Templates</h1>
<p class="info">Below are your email templates. You can modify content of template(s) to suit your needs.</p>
<h2>Viewing Email Templates</h2>
<table cellpadding="0" cellspacing="0" class="display">
  <thead>
    <tr>
      <th width="20" class="left">#</th>
      <th class="left">Template Name</th>
      <th width="25" class="right">Edit</th>
    </tr>
  </thead>
  <tbody>
    <?php if(!$temprow):?>
    <tr>
      <td colspan="3"><?php echo $core->msgError("<span>Error!</span>Your are missing all email templates. You need to reinstall them manually",false);?></td>
    </tr>
    <?php else:?>
    <?php foreach ($temprow as $row):?>
    <tr>
      <th><?php echo $row['id'];?>.</th>
      <td><?php echo $row['name'];?></td>
      <td align="right"><a href="index.php?do=templates&amp;action=edit&amp;id=<?php echo $row['id'];?>"><img src="../images/edit.png" alt="" class="tooltip img-wrap2" title="Edit: <?php echo $row['name'];?>"/></a></td>
    </tr>
    <?php endforeach;?>
    <?php unset($row);?>
    <?php endif;?>
  </tbody>
</table>
<?php break;?>
<?php endswitch;?>