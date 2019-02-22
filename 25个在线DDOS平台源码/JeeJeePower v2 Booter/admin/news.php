<?php
if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');
?>
<?php switch($core->action): case "edit": ?>
<?php $row = $core->getRowById("news", $core->id);?>
<h1><img src="../images/news-lrg.png" alt="" />Manage News Announcements</h1>
<p class="info">Here you can update your news announcement Fields marked <?php echo required();?> are required.</p>
<form action="" method="post" id="admin_form" name="admin_form">
  <table cellpadding="0" cellspacing="0" class="forms">
    <thead>
      <tr>
        <th colspan="2" class="left">Editing News Announcement &rsaquo; <?php echo $row['title'];?></th>
      </tr>
    </thead>
    <tfoot>
      <tr>
        <td><input type="submit" name="submit" class="button" value="Update News" /></td>
        <td><a href="index.php?do=news" class="button-alt">Cancel</a></td>
      </tr>
    </tfoot>
    <tbody>
      <tr>
        <th width="200">News Title: <?php echo required();?></th>
        <td><input name="title" type="text"  class="inputbox" value="<?php echo $row['title'];?>" size="45" /></td>
      </tr>
      <tr>
        <th>News Author:</th>
        <td><input name="author" type="text"  class="inputbox" value="<?php echo $row['author'];?>" size="55" /></td>
      </tr>
    <tr>
      <th>Created: <?php echo required();?></th>
      <td><input name="created" type="text" class="inputbox" id="date" size="25" value="<?php echo $row['created'];?>"/></td>
    </tr>
    <tr>
      <th>Published:</th>
      <td><span class="input-out">
        <input name="active" type="radio" id="active-1" value="1" <?php if ($row['active'] == 1) echo "checked=\"checked\""; ?>/>
        <label for="active-1">Yes</label>
        <input name="active" type="radio" id="active-2" value="0" <?php if ($row['active'] == 0) echo "checked=\"checked\""; ?> />
        <label for="active-2">No</label>
        </span></td>
    </tr>
      <tr>
        <td colspan="2" class="editor"><textarea id="bodycontent" name="body" rows="4" cols="30"><?php echo $row['body'];?></textarea></td>
      </tr>
    </tbody>
  </table>
  <input name="id" type="hidden" value="<?php echo $core->id;?>" />
</form>
<?php echo $core->doForm("processNews");?>
<script type="text/javascript">
  $(document).ready(function() {
	$("#bodycontent").cleditor({height:300});
  });
$(function () {
    $("#date").datepicker({
        showOn: 'button',
        buttonImage: '../images/calendar.png',
        buttonImageOnly: true,
        dateFormat: 'yy-mm-dd'
    });
});
</script>
<?php break;?>
<?php case "add":?>
<h1><img src="../images/news-lrg.png" alt="" />Manage News Announcements</h1>
<p class="info">Here you can add your news announcement. Fields marked <?php echo required();?> are required.</p>
<form action="" method="post" id="admin_form" name="admin_form">
  <table cellpadding="0" cellspacing="0" class="forms">
    <thead>
      <tr>
        <th colspan="2" class="left">Adding News Announcement</th>
      </tr>
    </thead>
    <tfoot>
      <tr>
        <td><input type="submit" name="submit" class="button" value="Add News" /></td>
        <td><a href="index.php?do=news" class="button-alt">Cancel</a></td>
      </tr>
    </tfoot>
    <tbody>
      <tr>
        <th width="200">News Title: <?php echo required();?></th>
        <td><input name="title" type="text"  class="inputbox" size="45" /></td>
      </tr>
      <tr>
        <th>News Author:</th>
        <td><input name="author" type="text"  class="inputbox"  /></td>
      </tr>
    <tr>
      <th>Created: <?php echo required();?></th>
      <td><input name="created" type="text" class="inputbox" id="date" value="<?php echo date('Y-m-d');?>" size="25" /></td>
    </tr>
    <tr>
      <th>Published:</th>
      <td><span class="input-out">
        <input name="active" type="radio" id="active-1" value="1" checked="checked" />
        <label for="active-1">Yes</label>
        <input name="active" type="radio" id="active-2" value="0" /> 
        <label for="active-2">No</label>
        </span></td>
    </tr>
      <tr>
        <td colspan="2" class="editor"><textarea id="bodycontent" name="body" rows="4" cols="30"><?php echo post('body');?></textarea></td>
      </tr>
    </tbody>
  </table>
</form>
<?php echo $core->doForm("processNews");?>
<script type="text/javascript">
  $(document).ready(function() {
	$("#bodycontent").cleditor({height:300});
  });
$(function () {
    $("#date").datepicker({
        showOn: 'button',
        buttonImage: '../images/calendar.png',
        buttonImageOnly: true,
        dateFormat: 'yy-mm-dd'
    });
});
</script>
<?php break;?>
<?php default: ?>
<?php $newsrow = $core->getNews();?>
<h1><img src="../images/news-lrg.png" alt="" />Manage News Announcements</h1>
<p class="info">Here you can manage you news announcements. Note only one news announcement will be visible to front end users at the time.</p>
<h2><span><a href="index.php?do=news&amp;action=add" class="button-sml">Add News</a></span>Viewing News Announcements</h2>
<table cellpadding="0" cellspacing="0" class="display">
  <thead>
    <tr>
      <th width="20" class="left">#</th>
      <th class="left">News Name</th>
      <th class="left">Created</th>
      <th class="left">Author</th>
      <th>Edit</th>
      <th>Delete</th>
    </tr>
  </thead>
  <tbody>
    <?php if(!$newsrow):?>
    <tr>
      <td colspan="6"><?php echo $core->msgAlert("<span>Alert!</span>You don't have any news announcements yet...",false);?></td>
    </tr>
    <?php else:?>
    <?php foreach ($newsrow as $row):?>
    <tr>
      <th align="center"><?php echo $row['id'];?>.</th>
      <td><?php echo $row['title'];?></td>
      <td><?php echo $row['cdate'];?></td>
      <td><?php echo $row['author'];?></td>
      <td align="center"><a href="index.php?do=news&amp;action=edit&amp;id=<?php echo $row['id'];?>"><img src="../images/edit.png" alt="" class="tooltip img-wrap2" title="Edit: <?php echo $row['title'];?>"/></a></td>
      <td align="center"><a href="javascript:void(0);" class="delete" rel="<?php echo $row['title'];?>" id="item_<?php echo $row['id'];?>"><img src="../images/delete.png" class="tooltip img-wrap2"  alt="" title="Delete"/></a></td>
    </tr>
    <?php endforeach;?>
    <?php unset($row);?>
    <?php endif;?>
  </tbody>
</table>
<div id="dialog-confirm" style="display:none;" title="Delete News">
  <p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>Are you sure you want to delete this item?<br />
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
                    data: 'deleteNews=' + id + '&newstitle=' + title,
                    beforeSend: function () {
                        parent.animate({
                            'backgroundColor': '#FFBFBF'
                        }, 400);
                    },
                    success: function (msg) {
                        parent.fadeOut(400, function () {
                            parent.remove();
                        });
                        $("html, body").animate({
                            scrollTop: 0
                        }, 600);
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