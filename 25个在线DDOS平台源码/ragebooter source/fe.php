<?php
ob_start();
require_once 'includes/db.php';
require_once 'includes/init.php';
if (!($user -> LoggedIn()))
{
	header('location: login.php');
	die();
}
if (!($user->hasMembership($odb)))
{
	header('location: purchase.php');
	die();
}
if (!($user -> notBanned($odb)))
{
	header('location: login.php');
	die();
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo $title_prefix; ?>Friends/Enemy</title>
<?php include 'includes/css.php';?>
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
                <h3>Friends and Enemy</h3>
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
			$ipAdd = $_POST['ipAdd'];
			$noteAdd = $_POST['noteAdd'];
			$type = $_POST['type'];
			$errors = array();
			if (!filter_var($ipAdd, FILTER_VALIDATE_IP))
			{
				$errors[] = 'IP is invalid';
			}
			if (empty($ipAdd) || empty($type))
			{
				$errors[] = 'Please verify all fields';
			}
			$allowedTypes = array('f', 'e');
			if (!in_array($type,$allowedTypes))
			{
				$errors[] = 'Type is invalid';
			}
			if (empty($errors))
			{
				$SQLinsert = $odb -> prepare("INSERT INTO `fe` VALUES(NULL, :userID, :type, :ip, :note)");
				$SQLinsert -> execute(array(':userID' => $_SESSION['ID'], ':type' => $type, ':ip' => $ipAdd, ':note' => $noteAdd));
				echo '<div class="nNote nSuccess hideit"><p><strong>SUCCESS: </strong>IP has been added</p></div>';
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
                    <div class="title"><img src="images/icons/dark/list.png" alt="" class="titleIcon" /><h6>Add IP:</h6></div>
                    <div class="formRow">
                        <label>IP:</label>
                        <div class="formRight"><input type="text" name="ipAdd" maxlength="15" /></div>
                        <div class="clear"></div>
                    </div>
                    <div class="formRow">
                        <label>Note:</label>
                        <div class="formRight"><textarea style="resize:none;" rows="4" cols="" name="noteAdd" class="autoGrow"></textarea></div>
                        <div class="clear"></div>
                    </div>
					<div class="formRow">
                        <label>Type:</label>
                        <div class="formRight">
                            <select name="type" >
                                <option selected = "selected">Choose a type....</option>
                                <option value="f">Friend</option>
                                <option value="e">Enemy</option>
                            </select>           
                        </div>             
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
				$SQL = $odb -> prepare("DELETE FROM `fe` WHERE `ID` = :id AND `userID` = :uid LIMIT 1");
				$SQL -> execute(array(':id' => $delete, ':uid' => $_SESSION['ID']));
			}
			echo '<div class="nNote nSuccess hideit"><p><strong>SUCCESS: </strong>IP(s) Has Been Removed</p></div>';
		}
		?>
		<form action="" class = "form" method="POST">
		<div class="widget">
			<div class="title"><span class="titleIcon"><input type="checkbox" id="deleteCheck[]" name="deleteCheck" /></span><h6>Friends/Enemy</h6>
			<input type="submit" style="margin-top:5px; margin-right:5px;" value="Delete" name="deleteBtn" class="dblueB logMeIn" /></div>
			
			  <table cellpadding="0" cellspacing="0" width="100%" class="sTable withCheck" id="checkAll">
				  <thead>
					  <tr>
						  <td><img src="images/icons/tableArrows.png" alt="" /></td>
						  <td>IP</td>
						  <td>Type</td>
						  <td>Note</td>
					  </tr>
				  </thead>
				  <tbody>
				  <?php
				  $SQLSelect = $odb -> prepare("SELECT * FROM `fe` WHERE `userID` = :user ORDER BY `ID` DESC");
				  $SQLSelect -> execute(array(':user' => $_SESSION['ID']));
				  while ($show = $SQLSelect -> fetch(PDO::FETCH_ASSOC))
				  {
					$ipShow = $show['ip'];
					$noteShow = $show['note'];
					$rowID = $show['ID'];
					$type = ($show['type'] == 'f') ? 'Friend' : 'Enemy';
					echo '<tr><td><input type="checkbox" name="deleteCheck[]" value="'.$rowID.'"/></td><td>'.$ipShow.'</td><td>'.$type.'</td><td>'.htmlentities($noteShow).'</td></tr>';
				  }
				  ?>
				  </tbody>
			  </table>
        </div>
	</form>
    </div>
    <!-- Footer line -->
    <?php include 'footer.php';?>

</div>

<div class="clear"></div>
</body>

</html>
