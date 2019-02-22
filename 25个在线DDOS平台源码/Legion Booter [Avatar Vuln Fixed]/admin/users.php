<?php
if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');
?>
<?php switch($core->action): case "edit": ?>
<?php $row = $core->getRowById("users", $user->userid);?>
<?php $memrow = $member->getMemberships();?>
<h1><img src="../images/user-lrg.png" alt="" />Manage Users</h1>
<p class="info">Here you can update your user's info. Fields marked <?php echo required();?> are required.</p>
<span id="avatar"><?php echo ($row['avatar']) ? '<img src="'.UPLOADURL . $row['avatar'].'" alt=""/>' : '<img src="'.UPLOADURL.'blank.png" alt=""/>';?></span>
<form action="" method="post" id="admin_form" name="admin_form"  enctype="multipart/form-data">
  <table cellpadding="0" cellspacing="0" class="forms">
    <thead>
      <tr>
        <th colspan="2" class="left">Editing Current User &rsaquo; <?php echo $row['username'];?></th>
      </tr>
    </thead>
    <tfoot>
      <tr>
        <td><input type="submit" name="douser" class="button" value="Update User" /></td>
        <td><a href="index.php?do=users" class="button-alt">Cancel</a></td>
      </tr>
    </tfoot>
    <tbody>
      <tr>
        <th width="200">Username: </th>
        <td><input name="username" type="text" disabled="disabled" class="inputbox" value="<?php echo $row['username'];?>" size="55" readonly="readonly" /></td>
      </tr>
      <tr>
        <th>Password:</th>
        <td><input name="password" type="text" class="inputbox" size="55" />
          <?php echo tooltip("Leave it empty unless changing the password");?></td>
      </tr>
      <tr>
        <th>Email: <?php echo required();?></th>
        <td><input name="email" type="text" class="inputbox" value="<?php echo $row['email'];?>" size="55" /></td>
      </tr>
      <tr>
        <th>First Name: <?php echo required();?></th>
        <td><input name="fname" type="text" class="inputbox" value="<?php echo $row['fname'];?>" /></td>
      </tr>
      <tr>
        <th>Last Name: <?php echo required();?></th>
        <td><input name="lname" type="text" class="inputbox" value="<?php echo $row['lname'];?>"  /></td>
      </tr>
      <tr>
        <th>Membership:</th>
        <td><select name="membership_id" class="select" style="width:300px">
            <option value="0">--- No Membership Required---</option>
            <?php if($memrow):?>
            <?php foreach ($memrow as $mlist):?>
            <?php $selected = ($row['membership_id'] == $mlist['id']) ? " selected=\"selected\"" : "";?>
            <option value="<?php echo $mlist['id'];?>"<?php echo $selected;?>><?php echo $mlist['title'];?></option>
            <?php endforeach;?>
            <?php unset($mlist);?>
            <?php endif;?>
          </select></td>
      </tr>
      <tr>
        <th>User Level:</th>
        <td><span class="input-out">
          <label for="userlevel-1">Administrator</label>
          <input name="userlevel" type="radio" id="userlevel-1" value="9" <?php getChecked($row['userlevel'], 9); ?> />
          <label for="userlevel-2">User</label>
          <input name="userlevel" type="radio" id="userlevel-2" value="1" <?php getChecked($row['userlevel'], 1); ?> />
          <?php echo tooltip('Admin has full rights.<br />User it\'s just registered user.');?></span></td>
      </tr>
      <tr>
        <th>User Status:</th>
        <td><span class="input-out">
          <label for="active-1">User Active</label>
          <input name="active" type="radio" id="active-1" value="y" <?php getChecked($row['active'], "y"); ?> />
          <label for="active-2">User Inactive</label>
          <input name="active" type="radio" id="active-2" value="n" <?php getChecked($row['active'], "n"); ?> />
          <label for="active-3">User Banned</label>
          <input name="active" type="radio" id="active-3" value="b" <?php getChecked($row['active'], "b"); ?> />
          <label for="active-4">User Pending</label>
          <input name="active" type="radio" id="active-4" value="t" <?php getChecked($row['active'], "t"); ?> />
          </span></td>
      </tr>
      <tr>
        <th>Newsletter Subscriber:</th>
        <td><span class="input-out">
          <label for="newsletter-1">Yes</label>
          <input name="newsletter" type="radio" id="newsletter-1" value="1" <?php getChecked($row['active'], 1); ?>/>
          <label for="newsletter-2">No</label>
          <input name="newsletter" type="radio" id="newsletter-2" value="0" <?php getChecked($row['active'], 0); ?> />
          </span></td>
      </tr>
      <tr>
        <th>Avatar:</th>
        <td><input name="avatar" id="imgfile" type="file" size="40" class="inputbox" /></td>
      </tr>
      <tr>
        <th>Registration Date:</th>
        <td><span class="input-out"><?php echo $row['created'];?></span></td>
      </tr>
      <tr>
        <th>Last Login:</th>
        <td><span class="input-out"><?php echo $row['lastlogin'];?></span></td>
      </tr>
      <tr>
        <th>Last Login IP:</th>
        <td><span class="input-out"><?php echo $row['lastip'];?></span></td>
      </tr>
    </tbody>
  </table>
  <input name="username" type="hidden" value="<?php echo $row['username'];?>" />
  <input name="userid" type="hidden" value="<?php echo $user->userid;?>" />
</form>
<?php echo $core->doForm("processUser");?>
<?php break;?>
<?php case"add": ?>
<?php $memrow = $member->getMemberships();?>
<h1><img src="../images/user-lrg.png" alt="" />Manage Users</h1>
<p class="info">Here you can add new user. Fields marked <?php echo required();?> are required.</p>
<form action="" method="post" id="admin_form" name="admin_form">
  <table cellpadding="0" cellspacing="0" class="forms">
    <thead>
      <tr>
        <th colspan="2" class="left">Adding New User </th>
      </tr>
    </thead>
    <tfoot>
      <tr>
        <td><input type="submit" name="adduser" class="button" value="Add User" /></td>
        <td><a href="index.php?do=users" class="button-alt">Cancel</a></td>
      </tr>
    </tfoot>
    <tbody>
      <tr>
        <th width="200">Username: <?php echo required();?></th>
        <td><span id="getusername">
          <input name="username" type="text" class="inputbox"  id="username" size="55" />
          <img src="../images/yes.png" alt="" id="yes" style="display:none" class="tooltip" title="Username Available" /> <img src="../images/no.png" alt="" id="no" style="display:none" class="tooltip" title="Username Not Available" /></span></td>
      </tr>
      <tr>
        <th>Password:<?php echo required();?></th>
        <td><input name="password" type="text" class="inputbox" size="55" /></td>
      </tr>
      <tr>
        <th>Email: <?php echo required();?></th>
        <td><input name="email" type="text" class="inputbox" size="55" /></td>
      </tr>
      <tr>
        <th>First Name: <?php echo required();?></th>
        <td><input name="fname" type="text" class="inputbox" size="55" /></td>
      </tr>
      <tr>
        <th>Last Name: <?php echo required();?></th>
        <td><input name="lname" type="text" class="inputbox" size="55" /></td>
      </tr>
      <tr>
        <th>Membership:</th>
        <td><select name="membership_id" class="select" style="width:300px">
            <option value="0">--- No Membership Required---</option>
            <?php if($memrow):?>
            <?php foreach ($memrow as $mlist):?>
            <option value="<?php echo $mlist['id'];?>"><?php echo $mlist['title'];?></option>
            <?php endforeach;?>
            <?php unset($mlist);?>
            <?php endif;?>
          </select></td>
      </tr>
      <tr>
        <th>User Level:</th>
        <td><span class="input-out">
          <label for="userlevel-1">Administrator</label>
          <input name="userlevel" type="radio" id="userlevel-1" value="9"  />
          <label for="userlevel-2">User</label>
          <input name="userlevel" type="radio" id="userlevel-2" value="1" checked="checked"  />
          <?php echo tooltip('Admin has full rights.<br />User it\'s just registered user.');?></span></td>
      </tr>
      <tr>
        <th>User Status:</th>
        <td><span class="input-out">
          <label for="active-5">User Active</label>
          <input name="active" type="radio" id="active-5" value="y" checked="checked" />
          <label for="active-6">User Inactive</label>
          <input name="active" type="radio" id="active-6" value="n" />
          <label for="active-7">User Banned</label>
          <input name="active" type="radio" id="active-7" value="b" />
          <label for="active-8">User Pending</label>
          <input name="active" type="radio" id="active-8" value="t" />
          </span></td>
      </tr>
      <tr>
        <th>Newsletter Subscriber:</th>
        <td><span class="input-out">
          <label for="newsletter-1">Yes</label>
          <input name="newsletter" type="radio" id="newsletter-1" value="1" />
          <label for="newsletter-2">No</label>
          <input name="newsletter" type="radio" id="newsletter-2" value="0" checked="checked"  />
          </span></td>
      </tr>
      <tr>
        <th>Avatar:</th>
        <td><input name="avatar" id="imgfile" type="file" size="40" class="inputbox" /></td>
      </tr>
      <tr>
        <th>Notify User:</th>
        <td><span class="input-out">
          <input type="checkbox" name="notify" value="1" />
          <?php echo tooltip('Send welcome email to this user.');?></span></td>
      </tr>
    </tbody>
  </table>
</form>
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
			url: "controller.php",
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
<?php echo $core->doForm("processUser");?>
<?php break;?>
<?php default:?>
<?php $userrow = $user->getUsers();?>
<h1><img src="../images/user-lrg.png" alt="" />Manage Users</h1>
<p class="info">Here you can manage your users. <br />
  You can email each user by clicking on username.</p>
<h2><span><a href="index.php?do=users&amp;action=add" class="button-alt-sml">Add User</a></span>Viewing Users</h2>
<div class="box" style="margin-bottom:10px">
  <table cellpadding="0" cellspacing="0" class="utility">
    <tr style="background-color:transparent">
      <td style="position:relative"><input name="search" type="text" class="inputbox-sml" id="search-input" size="40" style="width:240px" onclick="disAutoComplete(this);"/>
        <div id="suggestions"></div></td>
      <td align="center"><form action="" method="post" id="dForm">
          <strong> From</strong>
          <input name="fromdate" type="text" style="margin-right:3px" class="inputbox-sml" size="12" id="fromdate" />
          <strong> To</strong>
          <input name="enddate" type="text" class="inputbox-sml" size="12" id="enddate" />
          <input name="find" type="submit" class="button-alt-sml" value="Find" />
        </form></td>
      <td align="right"><form action="" method="get" name="filter_browse" id="filter_browse">
          <strong>User Filter:</strong>&nbsp;&nbsp;
          <select name="sort" onchange="if(this.value!='NA') window.location='index.php?do=users&amp;sort='+this[this.selectedIndex].value; else window.location='index.php?do=users';" style="width:200px">
            <option value="NA">--- Reset User Filter ---</option>
            <?php echo $user->getUserFilter();?>
          </select>
        </form></td>
    </tr>
    <tr style="background-color:transparent">
      <td colspan="2" class="border"><img src="../images/u_active.png" alt="" title="User Active"/> User Active <img src="../images/u_inactive.png" alt="" title="User Inactive"/> User Inactive <img src="../images/u_pending.png" alt="" title="User Pending"/> User Pending <img src="../images/u_banned.png" alt="" title="User Banned"/> User Banned</td>
      <td align="right" class="border"><?php echo $pager->items_per_page();?> &nbsp;&nbsp;
        <?php if($pager->num_pages >= 1) echo $pager->jump_menu();?></td>
    </tr>
  </table>
</div>
<table cellpadding="0" cellspacing="0" class="display">
  <thead>
    <tr>
      <th width="20" class="left">#</th>
      <th class="left">Username</th>
      <th class="left">Full Name</th>
      <th>User Status</th>
      <th>Membership</th>
      <th>Last Login</th>
      <th>Actions</th>
    </tr>
  </thead>
  <tbody>
    <?php if($userrow == 0):?>
    <tr>
      <td colspan="7"><?php echo $core->msgAlert("<span>Alert!</span>You don\'t have any users  yet...",false);?></td>
    </tr>
    <?php else:?>
    <?php foreach ($userrow as $row):?>
    <tr>
      <th><?php echo $row['id'];?>.</th>
      <td><a href="index.php?do=newsletter&amp;emailid=<?php echo urlencode($row['email']);?>"><?php echo $row['username'];?></a></td>
      <td><?php echo $row['name'];?></td>
      <td align="center"><?php echo userStatus($row['active']);?></td>
      <td align="center"><?php if($row['membership_id'] == 0):?>
        --/--
        <?php else:?>
        <a href="index.php?do=memberships&amp;action=edit&amp;id=<?php echo $row['mid'];?>"><?php echo $row['title'];?></a>
        <?php endif;?></td>
      <td align="center"><?php echo ($row['adate']) ? $row['adate'] : "-/-";?></td>
      <td align="center"><a href="index.php?do=users&amp;action=edit&amp;userid=<?php echo $row['id'];?>"><img src="../images/edit.png" class="tooltip img-wrap2"  alt="" title="Edit"/></a>
        <?php if($row['id'] == 1):?>
        <img src="../images/delete2.png" class="tooltip img-wrap2"  alt="" title="Super Admin"/>
        <?php else:?>
        <a href="javascript:void(0);" class="delete" rel="<?php echo $row['username'];?>" id="item_<?php echo $row['id'];?>"><img src="../images/delete.png" class="tooltip img-wrap2"  alt="" title="Delete"/></a>
        <?php endif;?></td>
    </tr>
    <?php endforeach;?>
    <?php unset($row);?>
    <?php if($pager->items_total >= $pager->items_per_page):?>
    <tr style="background-color:transparent">
      <td colspan="7"><div class="pagination"><span class="inner"><?php echo $pager->display_pages();?></span></div></td>
    </tr>
    <?php endif;?>
    <?php endif;?>
  </tbody>
</table>
<div id="dialog-confirm" style="display:none;" title="Delete User">
  <p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>Are you sure you want to delete this user?<br />
    <strong>This action cannot be undone!!!</strong></p>
</div>
<script type="text/javascript"> 
// <![CDATA[
$(document).ready(function () {
    $("#search-input").watermark("Search Username");
    $("#search-input").keyup(function () {
        var srch_string = $(this).val();
        var data_string = 'userSearch=' + srch_string;
        if (srch_string.length > 3) {
            $.ajax({
                type: "POST",
                url: "controller.php",
                data: data_string,
                beforeSend: function () {
                    $('#search-input').addClass('loading');
                },
                success: function (res) {
                    $('#suggestions').html(res).show();
                    $("input").blur(function () {
                        $('#suggestions').customFadeOut();
                    });
                    if ($('#search-input').hasClass("loading")) {
                        $("#search-input").removeClass("loading");
                    }
                }
            });
        }
        return false;
    });
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
                    data: 'deleteUser=' + id + '&username=' + title,
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
$(function () {
    var dates = $('#fromdate, #enddate').datepicker({
        defaultDate: "+1w",
        changeMonth: false,
        numberOfMonths: 2,
        dateFormat: 'yy-mm-dd',
        onSelect: function (selectedDate) {
            var option = this.id == "fromdate" ? "minDate" : "maxDate";
            var instance = $(this).data("datepicker");
            var date = $.datepicker.parseDate(instance.settings.dateFormat || $.datepicker._defaults.dateFormat, selectedDate, instance.settings);
            dates.not(this).datepicker("option", option, date);
        }
    });
});
// ]]>
</script>
<?php break;?>
<?php endswitch;?>
