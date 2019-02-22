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
<title><?php echo $title_prefix; ?>Plan Builder</title>
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
                <h3>Plan Builder</h3>
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
			$nameAdd = $_POST['nameAdd'];
			$descriptionAdd = $_POST['descriptionAdd'];
			$unitAdd = $_POST['unit'];
			$lengthAdd = $_POST['lengthAdd'];
			$mbtAdd = intval($_POST['mbt']);
			$priceAdd = floatval($_POST['price']);
			$errors = array();
			
			if (empty($priceAdd) || empty($nameAdd) || empty($descriptionAdd) || empty($unitAdd) || empty($lengthAdd) || empty($mbtAdd))
			{
				$errors[] = 'Fill in all fields';
			}
			if (empty($errors))
			{
				$SQLinsert = $odb -> prepare("INSERT INTO `plans` VALUES(NULL, :name, :description, :mbt, :unit, :length, :price)");
				$SQLinsert -> execute(array(':name' => $nameAdd, ':description' => $descriptionAdd, ':mbt' => $mbtAdd, ':unit' => $unitAdd, ':length' => $lengthAdd, ':price' => $priceAdd));
				echo '<div class="nNote nSuccess hideit"><p><strong>SUCCESS: </strong>Plan has been created</p></div>';
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
                    <div class="title"><img src="../images/icons/dark/list.png" alt="" class="titleIcon" /><h6>Create Plan</h6></div>
                    <div class="formRow">
                        <label>Name:</label>
                        <div class="formRight"><input type="text" name="nameAdd" maxlength="50" /></div>
                        <div class="clear"></div>
                    </div>
					<div class="formRow">
                        <label>Description:</label>
                        <div class="formRight"><textarea style="resize:none;" rows="4" cols="" name="descriptionAdd"></textarea></div>
                        <div class="clear"></div>
                    </div>
					<div class="formRow">
                        <label>Max Boot Time:</label>
                        <div class="formRight"><input type="text" name="mbt"/></div>
                        <div class="clear"></div>
                    </div>
                    <div class="formRow">
                        <label>Unit:</label>
                        <div class="formRight">
                            <select name="unit" >
                                <option value="Days">Days</option>
                                <option value="Weeks">Weeks</option>
                                <option value="Months">Months</option>
                                <option value="Years">Years</option>
                            </select>           
                        </div>             
                        <div class="clear"></div>
                    </div>                    
					<div class="formRow">
                        <label>Length:</label>
                        <div class="formRight"><input type="text" name="lengthAdd"/></div>
                        <div class="clear"></div>
                    </div>
					<div class="formRow">
                        <label>Price:</label>
                        <div class="formRight"><input type="text" name="price"/></div>
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
				$SQL = $odb -> prepare("DELETE FROM `plans` WHERE `ID` = :id LIMIT 1");
				$SQL -> execute(array(':id' => $delete));
			}
			echo '<div class="nNote nSuccess hideit"><p><strong>SUCCESS: </strong>Plan(s) Has Been Removed</p></div>';
		}
		?>
		<form action="" class = "form" method="POST">
		<div class="widget">
			<div class="title"><span class="titleIcon"><input type="checkbox" id="deleteCheck[]" name="deleteCheck" /></span><h6>Plan(s)</h6>
			<input type="submit" style="margin-top:5px; margin-right:5px;" value="Delete" name="deleteBtn" class="dblueB logMeIn" /></div>
			
			  <table cellpadding="0" cellspacing="0" width="100%" class="sTable withCheck" id="checkAll">
				  <thead>
					  <tr>
						  <td><img src="../images/icons/tableArrows.png" alt="" /></td>
						  <td>Name</td>
						  <td>Max Boot Time</td>
						  <td>Description</td>
					  </tr>
				  </thead>
				  <tbody>
				  <?php
				  $SQLSelect = $odb -> query("SELECT * FROM `plans` ORDER BY `price` ASC");
				  while ($show = $SQLSelect -> fetch(PDO::FETCH_ASSOC))
				  {
					$planName = $show['name'];
					$noteShow = $show['description'];
					$mbtShow = $show['mbt'];
					$rowID = $show['ID'];
					echo '<tr><td><input type="checkbox" name="deleteCheck[]" value="'.$rowID.'"/></td><td><center><a href="editplan.php?id='.$rowID.'">'.htmlentities($planName).'</a></center></td><td>'.$mbtShow.'</td><td>'.htmlentities($noteShow).'</td></tr>';
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
