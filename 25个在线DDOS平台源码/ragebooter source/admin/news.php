<?php
ob_start();
require_once '../includes/db.php';
require_once '../includes/init.php';
if (!($user -> LoggedIn()))
{
	header('location: ../login.php');
	die();
}
if (!($user -> notBanned($odb)))
{
	header('location: login.php');
	die();
}
if (!($user -> isAdmin($odb)))
{
	die('You are not admin');
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo $title_prefix; ?>News</title>
<?php include '../includes/cssAdmin.php';?>
</head>
<body>
<?php
include 'sidebar.php';
?>
<!-- Right side -->
<div id="rightSide">
<?php include 'header.php';?>
    
    

    
    <!-- Title area -->
    <div class="titleArea">
        <div class="wrapper">
            <div class="pageTitle">
                <h3>News</h3>
            </div>
            <div class="clear"></div>
        </div>
    </div>
    
    <div class="line"></div>
    

    
    <!-- Main content wrapper -->
    <div class="wrapper">
       
        <!-- Form -->
		<?php
		if (isset($_POST['addBtn']))
		{
			$titleAdd = $_POST['titleAdd'];
			$detailAdd = $_POST['detailAdd'];
			$errors = array();
			if (empty($titleAdd) || empty($detailAdd))
			{
				$errors[] = 'Please verify all fields';
			}
			if (empty($errors))
			{
				$SQLinsert = $odb -> prepare("INSERT INTO `news` VALUES(NULL, :title, :detail, UNIX_TIMESTAMP())");
				$SQLinsert -> execute(array(':title' => $titleAdd, ':detail' => $detailAdd));
				echo '<div class="nNote nSuccess hideit"><p><strong>SUCCESS: </strong>News has been posted!</p></div>';
			}
			else
			{
				echo '<div class="nNote nFailure hideit"><p><strong>ERROR:</strong><br />';
				foreach($errors as $error)
				{
					echo '-'.$error.'<br />';
				}
				echo '</div>';
			}
		}
		?>
        <form action="" class="form" method="POST">
            <fieldset>
                <div class="widget">
                    <div class="title"><img src="../images/icons/dark/list.png" alt="" class="titleIcon" /><h6>Post News:</h6></div>
                    <div class="formRow">
                        <label>Title</label>
                        <div class="formRight"><input type="text" name="titleAdd" maxlength="50" /></div>
                        <div class="clear"></div>
                    </div>
                    <div class="formRow">
                        <label>Detail</label>
                        <div class="formRight"><textarea style="resize:none;" rows="4" cols="" name="detailAdd" class="autoGrow"></textarea></div>
                        <div class="clear"></div>
                    </div>
					<div class="formRow">
						<input type="submit" value="Add" name="addBtn" class="dblueB logMeIn" />
						 <div class="clear"></div>
                    </div>
                </div>
            </fieldset>
		</form>
		
		<?php
		if (isset($_POST['deleteBtn']))
		{
			$deletes = $_POST['deleteCheck'];
			foreach($deletes as $delete)
			{
				$SQL = $odb -> prepare("DELETE FROM `news` WHERE `ID` = :id LIMIT 1");
				$SQL -> execute(array(':id' => $delete));
			}
			echo '<div class="nNote nSuccess hideit"><p><strong>SUCCESS: </strong>New(s) Has Been Removed</p></div>';
		}
		?>
		<form action="" class = "form" method="POST">
		<div class="widget">
			<div class="title"><span class="titleIcon"><input type="checkbox" id="deleteCheck[]" name="deleteCheck" /></span><h6>News</h6>
			<input type="submit" style="margin-top:5px; margin-right:5px;" value="Delete" name="deleteBtn" class="dblueB logMeIn" /></div>
			
			  <table cellpadding="0" cellspacing="0" width="100%" class="sTable withCheck" id="checkAll">
				  <thead>
					  <tr>
						  <td><img src="../images/icons/tableArrows.png" alt="" /></td>
						  <td>Title</td>
						  <td>Details</td>
					  </tr>
				  </thead>
				  <tbody>
				  <?php
				  $SQLSelect = $odb -> query("SELECT * FROM `news` ORDER BY `date` DESC");
				  while ($show = $SQLSelect -> fetch(PDO::FETCH_ASSOC))
				  {
					$titleShow = $show['title'];
					$detailShow = $show['detail'];
					$rowID = $show['ID'];
					echo '<tr><td><input type="checkbox" name="deleteCheck[]" value="'.$rowID.'"/></td><td>'.htmlentities($titleShow).'</td><td>'.htmlentities($detailShow).'</td></tr>';
				  }
				  ?>
				  </tbody>
			  </table>
        </div>
	</form>
    </div>
    <!-- Footer line -->
    <?php include '../footer.php';?>

</div>

<div class="clear"></div>
</body>

</html>
