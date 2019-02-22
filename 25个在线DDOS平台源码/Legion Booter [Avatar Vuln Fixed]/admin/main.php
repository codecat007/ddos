<?php
if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');
?>
<h1>Welcome!</h1>
<p class="info">Here you can view the latest user registration statistics.</p>
<?php $stats = $core->getStats();?>
<?php $monthly = $core->monthlyStats();?>
<dl id="chart">
  <dt>&nbsp;</dt>
  <dd class="bar1">Total Registrations</dd>
  <?php $i=0;?>
  <?php if($monthly):?>
  <?php foreach ($stats as $row):?>
  <?php $i++;?>
  <dt><?php echo $i;?></dt>
  <dd><span class="type1 p<?php barHeight($row['total']);?>" title="<?php echo $row['total'].' '.$row['day'];?>" style="left:<?php echo ($row['day']-1) * 28;?>px;"><em><?php echo $row['total'];?></em></span></dd>
  <dt><?php echo $i;?></dt>
  <?php endforeach;?>
  <?php endif;?>
</dl>
<br />
<div class="box">
<table cellspacing="0" cellpadding="0" class="utility">
  <tfoot>
    <tr style="background-color:transparent">
      <td colspan="2" nowrap="nowrap" class="border"><form method="get" action="" name="admin_form">
        <select name="month" class="select" style="width:120px">
          <?php echo $core->monthList();?>
          </select>
        <select name="year" class="select" style="width:90px">
          <?php echo $core->yearList(2010, strftime('%Y')); ?>
          </select>
        <input name="submit" value="Submit" type="submit" class="button-alt-sml"/>
      </form></td>
      </tr>
  </tfoot>
  <?php if(!$monthly):?>
  <tr>
    <td colspan="2"><?php $core->msgAlert('<span>Alert!</span>There are no statistics for selected Month/Year...',false);?></td>
  </tr>
  <?php else:?>
  <tr>
    <td width="300" class="left"><strong>Total User Registrations:</strong></td>
    <td><?php echo $monthly['total'];?></td>
  </tr>
  <?php endif;?>
</table>
</div>
<script type="text/javascript"> 
// <![CDATA[
$(document).ready(function () {
	animateResults();
});
function animateResults() {
	$("#chart").find('dt').hide().end().customFadeIn('fast', function () {
		$("dd span").each(function () {
			var percentage = $(this).css('height');
			$(this).css({
				height: "0%"
			}).animate({
				height: percentage
			}, 1500);
		});
	});
}
// ]]>
</script> 