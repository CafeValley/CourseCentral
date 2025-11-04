<?php
function DisplayalldatatStudent ($Form , $ElementForSearch) {

global $link;
global $Fname;
global $Sirname;

$today = date("Y-m-d");

//testing number = 17810

if ($Form == 'Freeze' ) {

	$StudentId = $_POST['StudentCode'];
	$SqlFreeze = "SELECT `regis_id`, `level_id`, `group_id`, `paid_fees`, `discount`, `status`, `st_id`, `regis_date` FROM `registration` WHERE `st_id` = "
		. $StudentId . " and `status` = 1";
	$regissql  = mysqli_query ($link , $SqlFreeze);
	$num_rows  = mysqli_num_rows ($regissql);
}
if ($Form == 'unFreeze')
{
	$StudentId = $_POST['StudentCode'];
	$SqlUnFreeze = " SELECT `Freeze_id`, `s_id`, `level_id`, `group_id`, `dayleft`, `Freeze_fees`, `F_created_date` FROM `freeze` WHERE status = 1 and `s_id` =$StudentId ";
	$regissql  = mysqli_query ($link ,$SqlUnFreeze );
	$num_rows  = mysqli_num_rows ($regissql);

}

if ($num_rows > 0) {
if ($Form == 'Freeze') {
$FeesFreeze = FeesData("Freeze");
echo "Fees:";
echo "<input type = 'text' name = 'FreezeFees' readonly value = '$FeesFreeze[1]'>";
echo "<br>";

?>
<table border = "2" class="table table-striped table-bordered">
	<thead>
	<tr>
		<th>No</th>
		<th> Level</th>
		<th>Period</th>
		<th>Rem Fees</th>
		<th>Start Date</th>
		<th>Time</th>
		<th>Days Spent</th>
		<th></th>
	</tr>
	</thead>
	<tbody>

	<?php
	}
if ($Form == 'unFreeze') {
	//$UnFeesFreeze = FeesData("Unfreeze");
	//echo "Fees:";
	//echo "<input type = 'text' name = 'UnFreezeFees' readonly value = '$UnFeesFreeze[1]'>";
	//echo "<br>";

	?>
	<table border = "2" class="table table-striped table-bordered">
		<thead>
		<tr>
			<th>No</th>
			<th> Level</th>
			<th>Period</th>
			<th>Start Date</th>
			<th>Time</th>
			<th>Days Spent</th>
			<th></th>
		</tr>
		</thead>
		<tbody>
		<?php
		}
	$n = 1;
	while ($regisreturn = mysqli_fetch_array ($regissql)) {

		if ($Form == 'Freeze' ) { ?>
			<form action = "freezeform.php" method = "POST"> <?php }
				if ($Form == 'unFreeze' ) { ?>
		<form action = "unfreezeform.php" method = "POST">
	<?php }
		$studnetid       = $_POST['StudentCode'];
		$levelid         = $regisreturn['level_id'];
		$groupid         = $regisreturn['group_id'];
		$levelsql        = mysqli_query ($link , "SELECT `Level_id`, `level_name`, `level_period`, `level_fees`, `level_book`, `level_C_date` 
                                                FROM `levels` 
                                                WHERE `Level_id` = " . $levelid);
		$levelreturn     = mysqli_fetch_array ($levelsql);
		$paymentsql      = mysqli_query ($link , "SELECT sum(payment) as payment 
                                                  FROM `paymenttwo` 
                                                  WHERE `Level_id` = " . $levelid . " and `s_id` =" . $studnetid
			. " and `group_id` = " . $groupid);
		$paymentreturn   = mysqli_fetch_array ($paymentsql);
		$groupsql        = mysqli_query ($link , "SELECT `group_id`, `level_id`, `group_time`,
                                                  CONCAT(UCASE(LEFT(`group_teacher`, 1)), SUBSTRING(`group_teacher`, 2)) as group_teacher ,
                                                   `group_day`, `group_startday`, `group_C_date` 
                                                   FROM `group` 
                                                   WHERE  `group_id` = " . $groupid);
		$Markssql        = mysqli_query ($link , "SELECT `mark` FROM `mark` Where `s_id` = $studnetid and `level_id` = $levelid and `group_id` = $groupid ");
		$Markssqlreturn   = mysqli_fetch_array ($Markssql);
		$groupreturn     = mysqli_fetch_array ($groupsql);
		$FirstPaid       = $regisreturn['paid_fees'];
		$StudnetDiscount = $regisreturn['discount'];
		$LevelName       = $levelreturn['level_name'];
		$LevelSpace      = $levelreturn['level_period'];
		$completeFees    = $levelreturn['level_fees'] + $levelreturn['level_book'];
		$completeFees    = $completeFees - $StudnetDiscount;
		$GroupTime       = $groupreturn['group_time'];
		$GroupTeacher    = $groupreturn['group_teacher'];
		$GroupStartedDay = $groupreturn['group_startday'];
		$Mark            = $Markssqlreturn['mark'];

		$NumberOfMonth = preg_replace("/[^0-9]/", "", $LevelSpace);
		$DaysSpentAF = dateDifference($today , $GroupStartedDay , $differenceFormat = '%a');
		if ($Form == 'unFreeze') {
			$whyfreeze   = $regisreturn['Why_freeze'];
			$dayleft     = $regisreturn['dayleft'];
		}
		if ($paymentreturn['payment'] > 0) $TotlaPaymentPayed = $paymentreturn['payment'] + $FirstPaid;
		else
			$TotlaPaymentPayed = $FirstPaid;
		if ($groupreturn['group_day'] == 'e') $GroupDay = "Even";
		if ($groupreturn['group_day'] == 'd') $GroupDay = "Odd";
		if ($groupreturn['group_day'] == 'o') $GroupDay = "Other";

		if ($Form == 'unFreeze') {
			?>
			<tr>
				<td width="2%"><?php echo $n . ".";
					$n = $n + 1; ?></td>
				<td><?php echo $LevelName; ?></td>
				<td width="8%"><?php echo $LevelSpace; ?></td>
				<td><?php echo $GroupStartedDay; ?></td>
				<td><?php echo $GroupTime; ?></td>
				<td width="8%"><?php echo $dayleft;?></td>
				<td width="5%">
					<button name="insideUnfreezesubmit" type="submit" class="btn btn-primary">UnFreeze</button>
				</td>
			</tr>

			<?php
		}
	if ($Form == 'Freeze') {
		?>
		<tr>
			<td width="2%"><?php echo $n . ".";
				$n = $n + 1; ?></td>
			<td><?php echo $LevelName; ?></td>
			<td width="8%"><?php echo $LevelSpace; ?></td>
			<td><?php $AllowToGetMark = (CalRem($studnetid, $groupid));
				echo $AllowToGetMark[1]; ?></td>
			<td><?php echo $GroupStartedDay; ?></td>
			<td><?php echo $GroupTime; ?></td>
			<td width="8%"><?php
				if ($NumberOfMonth == 1) {
					if ($DaysSpentAF > 30)
						echo "Sorry Cant Freeze";
					else
						echo $DaysSpentAF;
				}
				if ($NumberOfMonth == 2) {
					if ($DaysSpentAF > 60)
						echo "Sorry Cant Freeze";
					else
						echo $DaysSpentAF;
				}
				?></td>
			<td width="5%">
				<button name="insidefreezesubmit" type="submit" class="btn btn-primary">Freeze</button>
			</td>
		</tr>

		<?php
	}
	 ?>


		<input type = "hidden" name = "StudentCode" value = "<?php echo $studnetid; ?>">
		<input type = "hidden" name = "Level_Id" value = "<?php echo $levelid; ?>">
		<input type = "hidden" name = "Group_Id" value = "<?php echo $groupid; ?>">
		<input type = "hidden" name = "S_first" value = "<?php echo $Fname; ?>">
		<input type = "hidden" name = "S_sir" value = "<?php echo $Sirname; ?>">
		<input type = "hidden" name = "daysSpent" value = <?php echo $DaysSpentAF;?>>
		<input type = "hidden" name = "DateofFreeze" value = <?php echo $today;?>>
		<input type = "hidden" name = "Freeze_fees" value = <?php echo $FeesFreeze[1];?>>
			<input type = "hidden" name = "UnFreeze_fees" value = <?php //echo $UnFeesFreeze[1];?>>
			<input type = "hidden" name = "dayleft" value = "<?php echo $dayleft; ?>">
		</form>
		<?php
	}

	if ($Form == 'Freeze') {

		if (isset($_POST['insidefreezesubmit'])) {
			echo "The Registration was Feezed for:->";
			echo $_POST['S_first'] . " " . $_POST['S_sir'];
			$studentid = $_POST['StudentCode'];
			$levelid   = $_POST['Level_Id'];
			$groupid   = $_POST['Group_Id'];
			$daysSpent   = $_POST['daysSpent'];
			$Freeze_fees  = $_POST['Freeze_fees'];


			$insertsqlfreeze = "INSERT INTO `freeze`(`Freeze_id`, `s_id`, `level_id`, `group_id`,`dayleft`, `Freeze_fees`, `status`, `F_created_date`) 
								VALUES (null,$studentid,$levelid,$groupid,'$daysSpent',$Freeze_fees,1,NOW())";
			mysqli_query ($link , $insertsqlfreeze);
			$updatesqlregisteration = "UPDATE `registration` SET `status`= '0' WHERE `level_id` = '{$levelid}' and `group_id` = '{$groupid}' and `st_id` ='{$studentid}'";
			mysqli_query ($link , $updatesqlregisteration);
		}
	}
	if ($Form == 'unFreeze') {
		if (isset($_POST['insideUnfreezesubmit'])) {
			//echo "The Registration was unFeezed for:->";
			//echo $_POST['S_first'] . " " . $_POST['S_sir'];
			$studentid = $_POST['StudentCode'];
			$levelid   = $_POST['Level_Id'];
			$groupid   = $_POST['Group_Id'];
			$UnFreeze_fees = $_POST['UnFreeze_fees'];
			//echo "reminding days -> ".$daysSpent   = $_POST['daysSpent'];
			//UnFreeze_fees
			echo "<br>";

			//print_r($_POST);
			$insertsqlunfreeze = "INSERT INTO `unfreeze`(`unFreeze_id`, `s_id`, `level_id`, `group_id`, `unFreeze_fees`, `UnF_created_date`) 
                                  VALUES  (null,$studentid,$levelid,$groupid,$UnFreeze_fees,NOW())";
			//mysqli_query ($link , $insertsqlunfreeze);

			//$updatesqlregisteration = "UPDATE `registration` SET `status`= '1' WHERE `level_id` = '{$levelid}' and `group_id` = '{$groupid}' and `st_id` ='{$studentid}'";
			//mysqli_query ($link , $updatesqlregisteration);
		}
	}
	}
	else
	{
		if ($Form == 'unFreeze') { ?>
			<div class = "alert alert-success">
				<button name = "PressedUnF" type = "button" class = "close" data-dismiss = "alert">&times;</button>
				Nothing to unFreeze.
			</div>
		<?php }
		if ($Form == 'Freeze') { ?>

			<div class = "alert alert-success">
				<button type = "button" class = "close" data-dismiss = "alert">&times;</button>
				Nothing to Freeze.
			</div>
		<?php }
		if ($Form == 'SearchByID') { ?>

			<div class = "alert alert-success">
				<button type = "button" class = "close" data-dismiss = "alert">&times;</button>
				There is no Student with that ID.
			</div>

			<?php
		}
		if ($Form == 'SearchByName') { ?>

			<div class = "alert alert-success">
				<button type = "button" class = "close" data-dismiss = "alert">&times;</button>
				There is no Student with that Name.
			</div>


			<?php
		}
		if ($Form == 'SearchByPhone') { ?>

			<div class = "alert alert-success">
				<button type = "button" class = "close" data-dismiss = "alert">&times;</button>
				There is no Student with that Phone Number.
			</div>


			<?php
		}
		if ($Form == 'SearchByYear') { ?>

			<div class = "alert alert-success">
				<button type = "button" class = "close" data-dismiss = "alert">&times;</button>
				There is no Student with that Birth Year.
			</div>

			<?php
		}
	}
	}
	?>
