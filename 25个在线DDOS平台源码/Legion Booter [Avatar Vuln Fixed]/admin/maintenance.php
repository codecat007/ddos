<?php
if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');
?>
<h1><img src="../images/config-lrg.png" alt="" />System Maintenance</h1>
<p class="info">Here you can perform site maintenance, such as deleting inctive and banned users.</p>
<form action="" method="post" id="admin_form" name="admin_form">
  <table cellpadding="0" cellspacing="0" class="forms">
    <thead>
      <tr>
        <th colspan="2" class="left">Delete Inactive Users</th>
      </tr>
    </thead>
    <tfoot>
      <tr>
        <td colspan="2"><input type="submit" name="inactive" class="button" value="Delete Inactive" /></td>
      </tr>
    </tfoot>
    <tbody>
      <tr>
        <td colspan="2">This will delete all users (not administrators), who have not logged in to the site within a certain time period. It will not delete users pending verification proccess. You specify the days spent inactive.</td>
      </tr>
      <tr>
        <th width="200">Inactive Days:</th>
        <td><select name="days">
            <option value="3">3</option>
            <option value="7">7</option>
            <option value="14">14</option>
            <option value="30">30</option>
            <option value="60">60</option>
            <option value="100">100</option>
            <option value="180">180</option>
            <option value="365">365</option>
          </select></td>
      </tr>
    </tbody>
  </table>
  <br />
  <table cellpadding="0" cellspacing="0" class="forms">
    <thead>
      <tr>
        <th colspan="2" class="left">Delete Banned Users</th>
      </tr>
    </thead>
    <tfoot>
      <tr>
        <td colspan="2"><input type="submit" name="banned" class="button" value="Delete Banned"/></td>
      </tr>
    </tfoot>
    <tbody>
      <tr>
        <td colspan="2">This will delete all (<span style="color:red"><?php echo countEntries("users","active","b");?></span>) banned user(s).</td>
      </tr>
    </tbody>
  </table>
</form>
<?php echo $core->doForm("processMaintenance");?>
