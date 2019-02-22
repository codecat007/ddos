<?php
define("_VALID_PHP", true);
  require_once("init.php");
	  
  $listpackrow = $member->getMembershipListFrontEnd();
?>
<?php include("header.php");?>
    <h1>Membership Packages</h1>
    <p class="info">Below are all the membership packages available. Please <a href="index.php">login</a> to select desired membership.</p>
    <div class="box">
      <table border="0" cellpadding="3" cellspacing="0" class="display">
        <thead>
          <tr>
            <th colspan="2" class="left">Mebmbership Price List</th>
          </tr>
        </thead>
        <tr>
          <th width="200"><strong>Membership Title:</strong></th>
          <?php foreach ($listpackrow as $prow):?>
          <td class="center" style="color:#09F"><strong><?php echo $prow['title'];?></strong></td>
          <?php endforeach;?>
        </tr>
        <tr>
          <th><strong>Membership Price:</strong></th>
          <?php foreach ($listpackrow as $prow):?>
          <td class="center" style="color:#09F"><?php echo $core->formatMoney($prow['price']);?></td>
          <?php endforeach;?>
        </tr>
        <tr>
          <th><strong>Membership Period:</strong></th>
          <?php foreach ($listpackrow as $prow):?>
          <td class="center" style="color:#09F"><?php echo $prow['days'] . ' ' .$member->getPeriod($prow['period']);?></td>
          <?php endforeach;?>
        </tr>
        <tr>
          <th><strong>Recurring Payment:</strong></th>
          <?php foreach ($listpackrow as $prow):?>
          <td class="center" style="color:#09F"><?php echo ($prow['recurring']) ? 'Yes' : 'No';?></td>
          <?php endforeach;?>
        </tr>
        <tr>
          <th valign="top"><strong>Membership Description:</strong></th>
          <?php foreach ($listpackrow as $prow):?>
          <td class="center"><span style="font-size:11px"><?php echo $prow['description'];?></span></td>
          <?php endforeach;?>
        </tr>
      </table>
    </div>
<?php include("footer.php");?>