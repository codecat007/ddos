<?php
if (!defined("_VALID_PHP"))
      die('Direct access to this location is not allowed.');
?>
<?php switch($core->action): case "salesyear": ?>
<h1><img src="../images/trans-lrg.png" alt="" />Viewing Sales Report</h1>
<p class="info">Here you can view your sales report</p>
<?php $reports = $member->yearlyStats();?>
<?php $row = $member->getYearlySummary();?>
<?php if($reports != 0):?>
<script language="javascript" type="text/javascript" src="../assets/jquery.jqplot.min.js"></script> 
<script language="javascript" type="text/javascript" src="../assets/jqplot.barRenderer.min.js"></script> 
<script language="javascript" type="text/javascript" src="../assets/jqplot.categoryAxisRenderer.min.js"></script> 
<script type="text/javascript" src="../assets/jqplot.pointLabels.min.js"></script> 
<!--[if lt IE 9]><script language="javascript" type="text/javascript" src="../assets/excanvas.min.js"></script><![endif]--> 
<script type="text/javascript">
  $(document).ready(function(){
    var s1 = [
	<?php
		$res = '';
		foreach($reports as $report) {
			if(strlen($res) > 0) {
				$res .= ",";
			}
			$res .= $report['total'];
		}
		echo $res;
		?>
	];
    var s2 = [
	<?php
		$res2 = '';
		foreach($reports as $report) {
			if(strlen($res2) > 0) {
				$res2 .= ",";
			}
			$res2 .= $report['totalprice'];
		}
		echo $res2;
		?>
	];
    var ticks = [
	<?php
		$res3 = '';
		foreach($reports as $rep) {
			if(strlen($res3) > 0) {
				$res3 .= "','";
			}
			$res3 .= date("M", mktime(0, 0, 0, $rep['month'], 10));
		}
		?>
		'<?php print $res3;?>'
	];
    <?php unset($res, $res2, $res3);?>
    plot1 = $.jqplot('chart', [s1, s2], {
      seriesDefaults:{
        renderer:$.jqplot.BarRenderer,
        rendererOptions: {fillToZero: true},
		pointLabels: {show: true}
      },
	  title: 'Sales Statistics For › <?php echo $core->year;?>',
      series:[
        {label:'Total Sales'},
        {label:'Total Revenue'}
      ],
      legend: {
        show: true,
		location: 'ne'
      },
      axes: {
        xaxis: {
          renderer: $.jqplot.CategoryAxisRenderer,
          ticks: ticks
        },
        yaxis: {
          autoscale: true
        }
      }
    });
  });
</script>
<?php endif;?>
<?php if($reports == 0):?>
<?php echo $core->msgAlert('<span>Alert!</span>There are no sales for selected Year...',false);?>
<?php else:?>
<div id="chart"></div>
<table cellpadding="0" cellspacing="0" class="display">
  <thead>
    <tr>
      <th width="150" nowrap="nowrap" class="left">Month / Year</th>
      <th>Total Sales</th>
      <th width="200" nowrap="nowrap">Total Revenue</th>
    </tr>
  </thead>
  <?php foreach($reports as $report):?>
  <tr>
    <td><?php echo date("M", mktime(0, 0, 0, $report['month'], 10));?> / <?php echo $core->year;?></td>
    <td align="center"><?php echo $report['total'];?></td>
    <td align="center"><?php echo $core->formatMoney($report['totalprice']);?></td>
  </tr>
  <?php endforeach ?>
  <?php unset($report);?>
  <tr>
    <td><strong>Total Year</strong></td>
    <td align="center"><strong><?php echo $row['total'];?></strong></td>
    <td align="center"><strong><?php echo $core->formatMoney($row['totalprice']);?></strong></td>
  </tr>
</table>
<?php endif;?>
<div class="box" style="margin-top:10px">
  <form method="get" action="" name="date">
    <table cellpadding="0" cellspacing="0" class="utility">
      <tr>
        <td class="right"><select name="year" class="select" style="width:80px">
            <?php echo $core->yearList(2010, strftime('%Y')); ?>
          </select>
          <input name="submit" value="Submit" type="submit" class="button-sml"/>
          <input name="do" type="hidden" value="transactions" />
          <input name="action" type="hidden" value="salesyear" /></td>
      </tr>
    </table>
  </form>
</div>
<?php break;?>
<?php default: ?>
<?php
  $search = (isset($_POST['search'])) ? intval($_POST['search']) : false;
  $transrow = $member->getPayments($search);
?>
<h1><img src="../images/trans-lrg.png" alt="" />Manage Payment Transactions</h1>
<p class="info">Here you can view all your payment transactions.</p>
<h2><span><a href="controller.php?exportTransactions" title="Export To Excel Format" class="tooltip"><img src="../images/xls.png" alt="" class="img-wrap2"/></a> <a href="index.php?do=transactions&amp;action=salesyear" title="View Sales Report" class="tooltip"><img src="../images/chart.png" alt="" class="img-wrap2"/></a></span>Viewing Transactions</h2>
<div class="box" style="margin-bottom:10px">
  <table cellpadding="0" cellspacing="0" class="utility">
    <tr>
      <td><form action="" method="post">
          <input name="search" type="text" class="inputbox" id="search-input" size="40"/>
          <input name="submit" type="submit" class="button-alt-sml" value="Find" />
        </form></td>
      <td align="right"><form action="" method="get" name="filter_browse" id="filter_browse">
          <strong>Payment Filter:</strong>&nbsp;&nbsp;
          <select name="select" class="select" onchange="if(this.value!='NA') window.location = 'index.php?do=transactions&amp;sort='+this[this.selectedIndex].value; else window.location = 'index.php?do=transactions';" style="width:180px">
            <option value="NA">-- Reset Payment Filter --</option>
            <?php echo $member->getPaymentFilter();?>
          </select>
        </form></td>
    </tr>
    <tr>
      <td class="border"><form action="" method="post" id="dForm">
          <strong> From </strong>
          <input name="fromdate" type="text" style="margin-right:3px" class="inputbox" size="10" id="fromdate" />
          <strong> To </strong>
          <input name="enddate" type="text" style="margin-right:3px" class="inputbox" size="10" id="enddate" />
          <input name="find" type="submit" class="button-alt-sml" value="Find" />
        </form></td>
      <td align="right" class="border"><?php echo $pager->items_per_page();?> &nbsp;&nbsp;
        <?php if($pager->num_pages >= 1) echo $pager->jump_menu();?></td>
    </tr>
  </table>
</div>
<table cellpadding="0" cellspacing="0" class="display">
  <thead>
    <tr>
      <th width="20">#</th>
      <th class="left">Membership Title</th>
      <th class="left">Username</th>
      <th class="left">Amount</th>
      <th class="left">Payment Date</th>
      <th>Processor</th>
      <th>Status</th>
      <th>Delete</th>
    </tr>
  </thead>
  <tbody>
    <?php if($transrow == 0):?>
    <tr>
      <td colspan="8"><?php echo $core->msgAlert('<span>Alert!</span>You don\'t have any transactions yet...',false);?></td>
    </tr>
    <?php else:?>
    <?php foreach ($transrow as $row):?>
    <?php $image = ($row['status'] == 0) ? "pending":"completed";?>
    <?php $status = ($row['status'] == 0) ? 1:0;?>
    <tr>
      <th><?php echo $row['id'];?>.</th>
      <td><?php echo $row['title'];?></td>
      <td><a href="index.php?do=users&amp;action=edit&amp;userid=<?php echo $row['user_id'];?>"><?php echo $row['username'];?></a></td>
      <td><?php echo $core->formatMoney($row['rate_amount']);?></td>
      <td><?php echo $row['created'];?></td>
      <td align="center"><img src="../images/<?php echo $row['pp'];?>.png" alt="" class="tooltip" title="<?php echo $row['pp'];?>"/></td>
      <td align="center"><img src="../images/<?php echo $image;?>.png" alt="" class="tooltip img-wrap2" title="Status: <?php echo ucfirst($image);?>"/></td>
      <td align="center"><a href="javascript:void(0);" class="delete" rel="<?php echo $row['created'];?>" id="item_<?php echo $row['id'];?>"><img src="../images/delete.png" class="tooltip img-wrap2"  alt="" title="Delete"/></a></td>
    </tr>
    <?php endforeach;?>
    <?php unset($row);?>
    <?php if($pager->items_total >= $pager->items_per_page):?>
    <tr style="background-color:transparent">
      <td colspan="8"><div class="pagination"><span class="inner"><?php echo $pager->display_pages();?></span></div></td>
    </tr>
    <?php endif;?>
    <?php endif;?>
  </tbody>
</table>
<div id="dialog-confirm" style="display:none;" title="Delete Transaction Record">
  <p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>Are you sure you want to delete this record?<br />
    <strong>This action cannot be undone!!!</strong></p>
</div>
<script type="text/javascript"> 
// <![CDATA[
$(document).ready(function () {
	$("#search-input").watermark("Payment Amount...");
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
                    data: 'deleteTransaction=' + id + '&posttitle=' + title,
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
$(function() {
	var dates = $('#fromdate, #enddate').datepicker({
		defaultDate: "+1w",
		changeMonth: false,
		numberOfMonths: 2,
		dateFormat: 'yy-mm-dd',
		onSelect: function(selectedDate) {
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