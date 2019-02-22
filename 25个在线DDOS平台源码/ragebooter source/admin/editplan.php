<?php
ob_start();
require_once '../includes/db.php';
require_once '../includes/init.php';
if (!($user -> LoggedIn()))
{
	header('location: ../login.php');
	die();
}
if (!($user -> isAdmin($odb)))
{
	die('You are not admin');
}
if (!($user -> notBanned($odb)))
{
	header('location: login.php');
	die();
}
if (!isset($_GET['id']))
{
	die('Please input an ID');
}
$SQLGetInfo = $odb -> prepare("SELECT * FROM `plans` WHERE `ID` = :id LIMIT 1");
$SQLGetInfo -> execute(array(':id' => $_GET['id']));
$planInfo = $SQLGetInfo -> fetch(PDO::FETCH_ASSOC);
$currentName = $planInfo['name'];
$currentDescription = $planInfo['description'];
$currentMbt = $planInfo['mbt'];
$currentUnit = $planInfo['unit'];
$currentPrice = $planInfo['price'];
$currentLength = $planInfo['length'];
function selectedUnit($check, $currentUnit)
{
	if ($currentUnit == $check)
	{
		return 'selected="selected"';
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo $title_prefix; ?>Edit Plan</title>
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
                <h3>Edit Plan</h3>
            </div>
            <div class="clear"></div>
        </div>
    </div>
    
    <div class="line"></div>
    

    
    <!-- Main content wrapper -->
    <div class="wrapper">
       
        <!-- Form -->
		<?php
		if (isset($_POST['updateBtn']))
		{
			$updateName = $_POST['nameAdd'];
			$updateDescription = $_POST['descriptionAdd'];
			$updateUnit = $_POST['unit'];
			$updateLength = $_POST['lengthAdd'];
			$updateMbt = intval($_POST['mbt']);
			$updatePrice = floatval($_POST['price']);
			$errors = array();
			
			if (empty($updatePrice) || empty($updateName) || empty($updateDescription) || empty($updateUnit) || empty($updateLength) || empty($updateMbt))
			{
				$errors[] = 'Fill in all fields';
			}
			if (empty($errors))
			{
				$SQLinsert = $odb -> prepare("UPDATE `plans` SET `name` = :name, `description` = :description, `mbt` = :mbt, `unit` = :unit, `length` = :length, `price` = :price WHERE `ID` = :id");
				$SQLinsert -> execute(array(':name' => $updateName, ':description' => $updateDescription, ':mbt' => $updateMbt, ':unit' => $updateUnit, ':length' => $updateLength, ':price' => $updatePrice, ':id' => $_GET['id']));
				echo '<div class="nNote nSuccess hideit"><p><strong>SUCCESS: </strong>Plan has been updated</p></div>';
				$currentName = $updateName;
				$currentDescription = $updateDescription;
				$currentUnit = $updateUnit;
				$currentMbt = $updateMbt;
				$currentPrice = $updatePrice;
				$currentLength = $updateLength;
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
                    <div class="title"><img src="../images/icons/dark/list.png" alt="" class="titleIcon" /><h6>Edit Plan</h6></div>
                    <div class="formRow">
                        <label>Name:</label>
                        <div class="formRight"><input type="text" name="nameAdd" maxlength="50" value="<?php echo htmlentities($currentName);?>" /></div>
                        <div class="clear"></div>
                    </div>
					<div class="formRow">
                        <label>Description:</label>
                        <div class="formRight"><textarea style="resize:none;" rows="4" cols="" name="descriptionAdd"><?php echo htmlentities($currentDescription);?></textarea></div>
                        <div class="clear"></div>
                    </div>
					<div class="formRow">
                        <label>Max Boot Time:</label>
                        <div class="formRight"><input type="text" name="mbt" value="<?php echo htmlentities($currentMbt);?>"/></div>
                        <div class="clear"></div>
                    </div>
                    <div class="formRow">
                        <label>Unit:</label>
                        <div class="formRight">
                            <select name="unit" >
                                <option value="Days" <?php echo selectedUnit('Days',$currentUnit); ?> >Days</option>
                                <option value="Weeks" <?php echo selectedUnit('Weeks', $currentUnit); ?> >Weeks</option>
                                <option value="Months" <?php echo selectedUnit('Months', $currentUnit); ?> >Months</option>
                                <option value="Years" <?php echo selectedUnit('Years', $currentUnit); ?> >Years</option>
                            </select>           
                        </div>             
                        <div class="clear"></div>
                    </div>                    
					<div class="formRow">
                        <label>Length:</label>
                        <div class="formRight"><input type="text" name="lengthAdd" value="<?php echo htmlentities($currentLength);?>"/></div>
                        <div class="clear"></div>
                    </div>
					<div class="formRow">
                        <label>Price:</label>
                        <div class="formRight"><input type="text" name="price" value="<?php echo htmlentities($currentPrice);?>"/></div>
                        <div class="clear"></div>
                    </div>
					<div class="formRow">
						<input type="submit" value="Update" name="updateBtn" class="dblueB logMeIn" />
						 <div class="clear"></div>
                    </div>
                </div>
            </fieldset>
		</form>
	</form>
    </div>
    <!-- Footer line -->
    <?php include '../footer.php';?>

</div>

<div class="clear"></div>
</body>

</html>
