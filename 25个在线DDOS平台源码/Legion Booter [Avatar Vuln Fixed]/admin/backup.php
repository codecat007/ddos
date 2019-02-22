<?php
if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');
?>
<?php
  require_once(BASEPATH . "lib/class_dbtools.php");
  $tools = new dbTools();
  
  if (isset($_GET['backupok']) && $_GET['backupok'] == "1")
      $core->msgOk('<span>Success!</span>Backup created successfully!',1,1);

  if (isset($_GET['restore']) && $_GET['restore'] == "1")
      $core->msgOk('<span>Success!</span>Database restored successfully!',1,1);
	    
  if (isset($_GET['create']) && $_GET['create'] == "1")
      $tools->doBackup('',false);

  if (isset($_POST['backup_file']))
      $tools->doRestore($_POST['backup_file']);
?>

<h1><img src="../images/system-lrg.png" alt="" />Database Maintenance</h1>
<p class="info">Make sure your database is backed up frequently. Click on Create backup to manually backup your database.<br />
  The backups are stored in the [<strong>/admin/backups/</strong>] folder and can be downloaded from the list below. <br />
  Your most recent backup is highlighted. Make sure you download your most recent backup, and delete the rest.</p>
<h2><span>
  <button onclick="window.location='index.php?do=backup&amp;create=1';" type="button" class="button-alt-sml">Create Backup</button>
  </span>Viewing Most Recent Backups</h2>
<div id="backup">
  <?php
        $dir = BASEPATH . 'admin/backups/';
        if (is_dir($dir))
            : $getDir = dir($dir);
        while (false !== ($file = $getDir->read()))
            : if ($file != "." && $file != ".." && $file != "index.php")
            : if ($file == $core->backup)
            : echo '<div class="db-backup new">';
        echo '<span class="filename">';
        echo str_replace(".sql", "", $file) . '</span>';
        echo '<a href="' . ADMINURL . '/backups/' . $file . '" title="Download: ' . $file . '" class="download tooltip">Download</a>';
		echo '<a href="javascript:void(0);" title="Delete: ' . $file . '" class="delete tooltip">Delete</a>';
        echo '</div>';
        else
            : echo '<div class="db-backup" id="item_' . $file . '">';
        echo '<span class="filename">' . str_replace(".sql", "", $file) . '</span>';
        echo ' <a href="' . ADMINURL . '/backups/' . $file . '" title="Download: ' . $file . '" class="download tooltip">Download</a>';
        echo '<a href="javascript:void(0);" title="Delete: ' . $file . '" class="delete tooltip">Delete</a>';
        echo '</div>';
        
        endif;
        endif;
        endwhile;
        $getDir->close();
        endif;
      ?>
  <br clear="left" />
</div>
<div class="box" style="margin-top:10px">
  <form action="" method="post" id="admin_form" name="admin_form">
    <table class="utility" cellspacing="0">
      <tr>
        <td><strong>Restore Database:</strong>
          <?php
        if (is_dir($dir))
            : $getDir = dir($dir);
			echo '&nbsp;&nbsp;<select name="backup_file" class="select" style="width:250px">';
        while (false !== ($file = $getDir->read()))
            : if ($file != "." && $file != ".." && $file != "index.php"): 
        echo '<option value="' . $file . '">' . $file . '</option>';
        endif;
        endwhile;
		echo '</select>';
        $getDir->close();
        endif;
      ?>
          &nbsp;&nbsp;
          <button type="submit" class="button-sml">Restore Backup</button></td>
      </tr>
    </table>
  </form>
</div>
<div id="dialog-confirm" style="display:none;" title="Delete Database Backup">
  <p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>'Are you sure you want to delete this record?<br />
    <strong>This action cannot be undone!!!</strong>'</p>
</div>
<script type="text/javascript"> 
// <![CDATA[
$(document).ready(function () {
    $('a.delete').live('click', function () {
        var parent = $(this).parent();
		var id = parent.attr('id').replace('item_', '')
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
                    data: 'deleteBackup=' + id,
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