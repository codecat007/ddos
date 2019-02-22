<?php
if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');
	  
?>
<?php switch($core->action): case "edit": ?>
<?php $row = $core->getRowById("memberships", $core->id);?>
<h1><img src="../images/mems-lrg.png" alt="" />Manage Memberships</h1>
<p class="info">Here you can update your membership package. Fields marked <?php echo required();?> are required.</p>
<form action="" method="post" id="admin_form" name="admin_form">
  <table cellpadding="0" cellspacing="0" class="forms">
    <thead>
      <tr>
        <th colspan="2" class="left">Editing Membership &rsaquo; <?php echo $row['title'];?></th>
      </tr>
    </thead>
    <tfoot>
      <tr>
        <td><input type="submit" name="submit" class="button" value="Update Membership" /></td>
        <td><a href="index.php?do=memberships" class="button-alt">Cancel</a></td>
      </tr>
    </tfoot>
    <tbody>
      <tr>
        <td width="200">Membership Title: <?php echo required();?></td>
        <td><input name="title" type="text"  class="inputbox" value="<?php echo $row['title'];?>" size="55" /></td>
      </tr>
      <tr>
        <td>Membership Price: <?php echo required();?></td>
        <td><input name="price" type="text" class="inputbox" value="<?php echo $row['price'];?>" size="10" />
          <?php echo tooltip('Enter price in 0.00 format');?></td>
      </tr>
      <tr>
        <td>Membership Period: <?php echo required();?></td>
        <td><?php echo $member->getMembershipPeriod($row['period']);?>
          <input name="days" type="text" class="inputbox" value="<?php echo $row['days'];?>" size="10"/>
          <?php echo tooltip('Period before membership expires.<br />Valid values are:<br />
  	  Day(s) Allowable range is 1 to 90<br />
  	  Week(s) Allowable range is 1 to 52<br />
      Month(s) Allowable range is 1 to 24<br />
      Year(s) Allowable range is 1 to 5');?></td>
      </tr>
      <tr>
        <td>Trial Membership:</td>
        <td><span class="input-out">
          <label for="trial-1">Yes</label>
          <input name="trial" type="radio" id="trial-1" value="1" <?php getChecked($row['trial'], 1); ?> />
          <label for="trial-2">No</label>
          <input name="trial" type="radio" id="trial-2" value="0" <?php getChecked($row['trial'], 0); ?> />
          <?php echo tooltip('Trial Membership will be available for one time use only.<br /> You can only have one trial membership in total.');?></span></td>
      </tr>
      <tr>
        <td>Recurring Payment:</td>
        <td><span class="input-out">
          <label for="recurring-1">Yes</label>
          <input name="recurring" type="radio" id="recurring-1" value="1" <?php getChecked($row['recurring'], 1); ?> />
          <label for="recurring-2">No</label>
          <input name="recurring" type="radio" id="recurring-2" value="0" <?php getChecked($row['recurring'], 0); ?> />
          <?php echo tooltip('If Yes system will create recurring subscription.');?></span></td>
      </tr>
      <tr>
        <td>Private Membership:</td>
        <td><span class="input-out">
          <label for="private-1">Yes</label>
          <input name="private" type="radio" id="private-1" value="1" <?php getChecked($row['private'], 1); ?> />
          <label for="private-2">No</label>
          <input name="private" type="radio" id="private-2" value="0" <?php getChecked($row['private'], 0); ?> />
          <?php echo tooltip('Private memberships are not available to front end users.');?></span></td>
      </tr>
      <tr>
        <td>Active Membership:</td>
        <td><span class="input-out">
          <label for="active-1">Yes</label>
          <input name="active" type="radio" id="active-1" value="1" <?php getChecked($row['active'], 1); ?> />
          <label for="active-2">No</label>
          <input name="active" type="radio" id="active-2" value="0" <?php getChecked($row['active'], 0); ?> />
          <?php echo tooltip('Only active memberships will be available for purchase.');?></span></td>
      </tr>
      <tr>
        <td>Membership Description:</td>
        <td><textarea class="inputbox" cols="50" id="description" name="description" rows="5"><?php echo $row['description'];?></textarea></td>
      </tr>
    </tbody>
  </table>
  <input name="id" type="hidden" value="<?php echo $core->id;?>" />
</form>
<?php echo $core->doForm("processMembership");?>
<?php break;?>
<?php case"add": ?>
<h1><img src="../images/mems-lrg.png" alt="" />Manage Memberships</h1>
<p class="info">Here you can add new membership type. Fields marked <?php echo required();?> are required.</p>
<form action="" method="post" id="admin_form" name="admin_form">
  <table cellpadding="0" cellspacing="0" class="forms">
    <thead>
      <tr>
        <th colspan="2" class="left">Adding Membership</th>
      </tr>
    </thead>
    <tfoot>
      <tr>
        <td><input type="submit" name="submit" class="button" value="Add Membership" /></td>
        <td><a href="index.php?do=memberships" class="button-alt">Cancel</a></td>
      </tr>
    </tfoot>
    <tbody>
      <tr>
        <td width="200">Membership Title: <?php echo required();?></td>
        <td><input name="title" type="text"  class="inputbox"  size="55"/></td>
      </tr>
      <tr>
        <td>Membership Price: <?php echo required();?></td>
        <td><input name="price" type="text" class="inputbox" size="10" />
          <?php echo tooltip('Enter price in 0.00 format');?></td>
      </tr>
      <tr>
        <td>Membership Period: <?php echo required();?></td>
        <td><?php echo $member->getMembershipPeriod();?>
          <input name="days" type="text" class="inputbox" size="10" />
          <?php echo tooltip('Period before membership expires.<br />Valid values are:<br />
  	  Day(s) Allowable range is 1 to 90<br />
  	  Week(s) Allowable range is 1 to 52<br />
      Month(s) Allowable range is 1 to 24<br />
      Year(s) Allowable range is 1 to 5');?></td>
      </tr>
      <tr>
        <td>Trial Membership:</td>
        <td><span class="input-out">
          <label for="trial-1">Yes</label>
          <input name="trial" type="radio" id="trial-1" value="1" />
          <label for="trial-2">No</label>
          <input name="trial" type="radio" id="trial-2" value="0" checked="checked" />
          <?php echo tooltip('Trial Membership will be available for one time use only.<br /> You can only have one trial membership in total.');?></span></td>
      </tr>
      <tr>
        <td>Recurring Payment:</td>
        <td><span class="input-out">
          <label for="recurring-1">Yes</label>
          <input name="recurring" type="radio" id="recurring-1" value="1" />
          <label for="recurring-2">No</label>
          <input name="recurring" type="radio" id="recurring-2" value="0" checked="checked" />
          <?php echo tooltip('If Yes system will create recurring subscription.');?></span></td>
      </tr>
      <tr>
        <td>Private Membership:</td>
        <td><span class="input-out">
          <label for="private-1">Yes</label>
          <input name="private" type="radio" id="private-1" value="1" />
          <label for="private-2">No</label>
          <input name="private" type="radio" id="private-2" value="0" checked="checked" />
          <?php echo tooltip('Private memberships are not available to front end users.');?></span></td>
      </tr>
      <tr>
        <td>Active Membership:</td>
        <td><span class="input-out">
          <label for="active-1">Yes</label>
          <input name="active" type="radio" id="active-1" value="1" />
          <label for="active-2">No</label>
          <input name="active" type="radio" id="active-2" value="0" checked="checked" />
          <?php echo tooltip('Only active memberships will be available for purchase.');?></span></td>
      </tr>
      <tr>
        <td>Membership Description:</td>
        <td><textarea class="inputbox" cols="50" name="description" rows="5"></textarea></td>
      </tr>
    </tbody>
  </table>
</form>
<?php echo $core->doForm("processMembership");?>
<?php break;?>
<?php default: ?>
<?php $memrow = $member->getMemberships();?>
<h1><img src="../images/mems-lrg.png" alt="" />Manage Memberships</h1>
<p class="info">Here you can manage your membership packages.<br />
  <strong>Note: Make sure you are not deleting or deactivating memberships assigned to active users.</strong></p>
<h2><span><a href="index.php?do=memberships&amp;action=add" class="button-alt-sml">Add Membership</a></span>Viewing Membership Packages</h2>
<table cellpadding="0" cellspacing="0" class="display">
  <thead>
    <tr>
      <th width="20">#</th>
      <th class="left">Title</th>
      <th class="left">Price</th>
      <th class="left">Expiry</th>
      <th class="left">Description</th>
      <th>Active</th>
      <th>Edit</th>
      <th>Delete</th>
    </tr>
  </thead>
  <tbody>
    <?php if(!$memrow):?>
    <tr>
      <td colspan="8"><?php echo $core->msgAlert('<span>Alert!</span>You don\'t have any membership packages yet...',false);?></td>
    </tr>
    <?php else:?>
    <?php foreach ($memrow as $row):?>
    <tr>
      <th><?php echo $row['id'];?>.</th>
      <td><?php echo $row['title'];?></td>
      <td><?php echo $core->formatMoney($row['price']);?></td>
      <td><?php echo $row['days'] . ' ' . $member->getPeriod($row['period']);?></td>
      <td><?php echo $row['description'];?></td>
      <td align="center"><?php echo isActive($row['active']);?></td>
      <td align="center"><a href="index.php?do=memberships&amp;action=edit&amp;id=<?php echo $row['id'];?>"><img src="../images/edit.png" alt="" class="tooltip img-wrap2" title="Edit: <?php echo $row['title'];?>"/></a></td>
      <td align="center"><a href="javascript:void(0);" class="delete" rel="<?php echo $row['title'];?>" id="item_<?php echo $row['id'];?>"><img src="../images/delete.png" class="tooltip img-wrap2"  alt="" title="Delete"/></a></td>
    </tr>
    <?php endforeach;?>
    <?php unset($row);?>
    <?php endif;?>
  </tbody>
</table>
<div id="dialog-confirm" style="display:none;" title="Delete Membership">
  <p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>Are you sure you want to delete this membership?<br />
    <strong>This action cannot be undone!!!</strong></p>
</div>
<script type="text/javascript"> 
// <![CDATA[
$(document).ready(function () {
    $('a.delete').live('click', function () {
        var id = $(this).attr('id').replace('item_', '')
        var parent = $(this).parent().parent();
		var title = $(this).attr('rel');
        $("#dialog-confirm").data({
            'delid': id,
            'parent': parent,
			'title': title
        }).dialog('open');
        return false;
    });

    $("#dialog-confirm").dialog({
        resizable: false,
        bgiframe: true,
        autoOpen: false,
        width: 400,
        height: "auto",
        zindex: 9998,
        modal: false,
        buttons: {
            'Delete': function () {
                var parent = $(this).data('parent');
                var id = $(this).data('delid');
				var title = $(this).data('title');

                $.ajax({
                    type: 'post',
                    url: "controller.php",
                    data: 'deleteMembership=' + id + '&posttitle=' + title,
                    beforeSend: function () {
                        parent.animate({
                            'backgroundColor': '#FFBFBF'
                        }, 400);
                    },
                    success: function (msg) {
                        parent.fadeOut(400, function () {
                            parent.remove();
                        });
						$("html, body").animate({scrollTop:0}, 600);
						$("#msgholder").html(msg);
                    }
                });

                $(this).dialog('close');
            },
            'Cancel': function () {
                $(this).dialog('close');
            }
        }
    });
});
// ]]>
</script>
<?php break;?>
<?php endswitch;?>