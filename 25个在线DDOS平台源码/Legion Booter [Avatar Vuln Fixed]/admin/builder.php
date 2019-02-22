<?php
if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');
?>
<?php $memrow = $member->getMemberships();?>
<h1><img src="../images/config-lrg.png" alt="" />Page Builder</h1>
<p class="info">Here you can build your own custom protected page based on a user membership. Fields marked <?php echo required();?> are required.</p>
<h2>Protecting pages based on user membership package</h2>
<div class="box">
  <form action="" method="post" id="admin_form" name="admin_form">
    <table cellpadding="0" cellspacing="0" class="utility">
      <tr>
        <td width="200">Page Name: <?php echo required();?></td>
        <td><input name="pagename" type="text" class="inputbox" size="55" />
          <?php echo tooltip("This is the actual file name of the page.<br />You can name it anything you want, such as platinum_members");?></td>
      </tr>
      <tr>
        <td class="border">Add Header/Footer:</td>
        <td class="border"><span class="input-out">
          <label for="header-1">Yes</label>
          <input name="header" type="radio" id="header-1" value="1" checked="checked" />
          <label for="header-2">No</label>
          <input name="header" type="radio" id="header-2" value="0"  />
          <?php echo tooltip("If yes default header and footer will be added to this page.<br />You can always manually modify this page content later.");?></span></td>
      </tr>
      <tr>
        <td class="border">Select Memberships: <?php echo required();?></td>
        <td class="border"><select name="membership_id[]" size="5" multiple="multiple" style="width:250px">
            <?php if($memrow):?>
            <?php foreach ($memrow as $mlist):?>
            <option value="<?php echo $mlist['id'];?>"><?php echo $mlist['title'];?></option>
            <?php endforeach;?>
            <?php unset($mlist);?>
            <?php endif;?>
          </select> 
		  <?php echo tooltip('Click and hold to select Multiple Memberships');?></td>
      </tr>
      <tr>
        <td colspan="2" class="border"><p class="info">Your new page will be created inside <strong>uploads/</strong> directory. System assumes that you will be placing this page within the root of your initial install, and therefore all the paths and the necessary files will be included inside the page structure.<br />
        Otherwize you will need to manualy adjust paths inside this page if you are placing it outside your script directory.</p></td>
      </tr>
      <tr>
        <td colspan="2" class="border"><input type="submit" name="submit" class="button" value="Build Page" /></td>
      </tr>
    </table>
  </form>
</div>
<?php echo $core->doForm("processBuilder");?> 