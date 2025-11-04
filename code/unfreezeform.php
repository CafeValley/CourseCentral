<?php
require_once "config.php";
require_once "MainBarAfterLoginIn.php";
require_once "SingleDataRecover.php";
maincheck ("unFreeze");
/*/this method from the after login file to make sure in 
 which page you are right now/*/
if (isset($_POST['DeathitSelf']))
{
	$oldGroup   = safe_get('OldGroup', 0, 'int');
	$oldlevel   = safe_get('OldLevel', 0, 'int');
	$WGroupId   = safe_get('groupid', 0, 'int');
	$WLevelId   = safe_get('level_id', 0, 'int');
	$WStudentId = safe_get('StudentCode', 0, 'int');
	$WFees      = safe_get('NeedToPay', 0, 'float');

	if ($oldGroup > 0 && $oldlevel > 0 && $WGroupId > 0 && $WLevelId > 0 && $WStudentId > 0) {
		// update registration
		$stmt1 = $link->prepare("UPDATE `registration` SET `level_id`=?, `group_id`=?, `status`=1 WHERE `level_id`=? AND `group_id`=? AND `st_id`=?");
		if ($stmt1) { $stmt1->bind_param("iiiii", $WLevelId, $WGroupId, $oldlevel, $oldGroup, $WStudentId); $stmt1->execute(); $stmt1->close(); }
		// update freeze
		$stmt2 = $link->prepare("UPDATE `freeze` SET `status`=0 WHERE `s_id`=? AND `level_id`=? AND `group_id`=?");
		if ($stmt2) { $stmt2->bind_param("iii", $WStudentId, $oldlevel, $oldGroup); $stmt2->execute(); $stmt2->close(); }
		// insert unfreeze
		$stmt3 = $link->prepare("INSERT INTO `unfreeze`(`s_id`, `level_id`, `group_id`, `unFreeze_fees`, `UnF_created_date`) VALUES (?, ?, ?, ?, NOW())");
		if ($stmt3) { $stmt3->bind_param("iiid", $WStudentId, $oldlevel, $oldGroup, $WFees); $stmt3->execute(); $stmt3->close(); }
	}
	unset($_POST['insideUnfreezesubmit']);
}
?>

<div class = "main">
	<div class = "main-inner">
		<div class = "container">
			<div class = "row">
				<div class = "span12">
					<div class = "widget ">
						<div class = "widget-header">
							<i class = "icon-tint"></i>
							<h3>UnFreeze</h3></div>
						<div class = "widget-content" style="padding:25px;">
							<div class = "tabbable">
								<div class = "tab-content">
									<div class = "tab-pane active" id = "jscontrols">
										<form action = "unfreezeform.php" method = "POST">
											<?php if (isset($_POST['StudentCode'])) { ?>
												<ul style = "float: left">
													<label for = "group_id">Student Code</label>
													<button type = "submit" class = "btn btn-primary">+</button>
													&nbsp;&nbsp;&nbsp;&nbsp;
													<input type = "text" id = "StudentCode" name = "StudentCode"
													       value = "<?php echo escape_html($_POST['StudentCode']); ?>"
													       class = "login"/>
												</ul>
											<?php }
											else { ?>
												<div class = "controls">
													<div class = "input-append"><label class = "control-label"
													                                   for = "radiobtns">Student
														Code</label>
														<input type = "text" id = "StudentCode" required
														       name = "StudentCode" placeholder = "Student Code"
														       value = '' class = "login"/>
														<button type = "submit" class = "btn btn-primary">+</button>
													</div>
												</div>
											<?php } ?>
										</form>
										<!--
										**********************************
										Querying to get Name
										**********************************
										-->
										<?php if (isset($_POST['StudentCode'])) {
											$stCode = safe_get('StudentCode', 0, 'int');
											$stmt = $link->prepare("SELECT `s_id` , CONCAT(UCASE(LEFT(`S_firstname`, 1)), SUBSTRING(`S_firstname`, 2)) as S_firstname ,CONCAT(UCASE(LEFT(`S_midname1`, 1)), SUBSTRING(`S_midname1`, 2)) as S_midname1 ,CONCAT(UCASE(LEFT(`S_midname2`, 1)), SUBSTRING(`S_midname2`, 2)) as S_midname2 ,CONCAT(UCASE(LEFT(`S_lastname1`, 1)), SUBSTRING(`S_lastname1`, 2)) as S_lastname1 ,`S_phone1`, `S_phone2`, `S_Birthdate`, `ST_Gid` FROM `student` WHERE `ST_Gid` = ?");
											$stmt->bind_param("i", $stCode);
											$stmt->execute();
											$res = $stmt->get_result();
											$rowSNC = $res ? $res->fetch_assoc() : null;
											$stmt->close();
											if ($rowSNC) {
												$Fname = $rowSNC['S_firstname'] . " " . $rowSNC['S_midname1'];
												$Sirname = " " . $rowSNC['S_midname2'] . " " . $rowSNC['S_lastname1'];
											}
										} ?>

										<?php //here to display Name
										if (isset($Fname)) { ?>
											<div class = "controls">
												<div class = "input-append"><label class = "control-label"
												                                   for = "radiobtns">Student
														Name</label>
													<input type = "text" id = "StudentName" readonly
													       name = "StudentName" value = "<?php echo escape_html($Fname); ?>"
													       class = "login"/>
													<input type = "text" id = "StudentName" readonly
													       name = "StudentName" value = "<?php echo escape_html($Sirname); ?>"
													       class = "login"/>
												</div>
											</div>
											<?php
											DisplayalldatatStudent ("unFreeze" , "void");
										}
										?>

										<?php
										if (false) {}
										?>
										<?php if (isset($_POST['insideUnfreezesubmit']) || isset($_POST['DeathCall'])): ?>
											$studnetid = safe_get('StudentCode', 0, 'int');
											$daysSpent = safe_get('dayleft', 0, 'int');
											$levelid = safe_get('Level_Id', 0, 'int');
											$OldLevel = isset($_POST['OldLevel']) ? safe_get('OldLevel', $levelid, 'int') : $levelid;
											$OldGroup = isset($_POST['OldGroup']) ? safe_get('OldGroup', 0, 'int') : safe_get('Group_Id', 0, 'int');
											$SqlLevel = mysqli_query($link, "SELECT `Level_id`, `level_name`, `level_period`, `level_fees`, `level_book`, `level_C_date` FROM `levels` WHERE Level_id = $levelid");
											$ReturnSqlLevel = mysqli_fetch_array($SqlLevel);
											$LevelPeriod = $ReturnSqlLevel['level_period'];
											$levelfeesNow   = $ReturnSqlLevel['level_fees'];
											$LevelPeriodinnumbers = preg_replace("/[^0-9]/", "", $LevelPeriod);
											if ($LevelPeriodinnumbers == 1) $LevelPeriodinnumbers = 30;
											if ($LevelPeriodinnumbers == 2) $LevelPeriodinnumbers = 60;
											$NeedToPay = ($daysSpent /$LevelPeriodinnumbers)* $levelfeesNow;
											if (isset($_POST['NeedToPay'])) $NeedToPay = safe_get('NeedToPay', (float)$NeedToPay, 'float'); else $NeedToPay = truncate($NeedToPay);
											$LevelNamePass = isset($_POST['Level_Id']) ? LevelName($_POST['Level_Id']) : LevelName($ReturnSqlLevel['Level_id']);
										?>
										<ul style="float: left">
											<label for="group_id">Frozen Level</label>
											<input type = "text" id = "StudentCode" name = "StudentCode" value = "<?php echo escape_html($LevelNamePass); ?>" class = "login"/>
										</ul>
										<label for="group_id">Fees to be Paid</label>
										<input type = "text" id = "StudentCode" name = "StudentCode" value = "<?php echo escape_html($NeedToPay); ?>" class = "login"/>

										<?php echo "<br><br>"; ?>
										<form action = "unfreezeform.php" method = "POST">
											<ul style="float: left">
												<label for="group_id">Which Level</label>
												<select id="level_id" name="level_id" class="icon-pencil">
													<?php
													if (!isset($_POST['level_id'])) { echo '<option value = "nothing">Level Name</option>'; }
													$result = mysqli_query($link, "SELECT `Level_id`, `level_name` ,`level_fees`, `level_book`  FROM `levels`");
													while ($row = mysqli_fetch_assoc($result)) {
														if (isset($_POST['level_id']) && $row['Level_id'] == $_POST['level_id']) {
															echo "<option selected value='$row[Level_id]'>$row[level_name]</option>";
															$WantedLevelFees = $row[level_fees];
															$WantedLevelBookFees = $row[level_book];
														} else {
															echo "<option value='$row[Level_id]'>$row[level_name]</option>";
														}
													} ?>
												</select>
											</ul>
											<div class="control-group">
												<label class="control-label" for="radiobtns">Group Time</label>
												<div class="controls">
													<div class="input-append">
														<?php $postedGroupTime = isset($_POST['GroupTime']) ? GetTimefromID($_POST['GroupTime']) : NULL; DisplayInterval($postedGroupTime); ?>
														<select id="GroupDay" name="GroupDay" class="icon-pencil">
															<?php
															if (!isset($_POST['GroupDay']) || $_POST['GroupDay'] == 'nothing') {
																echo "<option selected value='nothing'>Group Day</option><option value=1>1st</option><option value=15>15th</option>";
															} elseif ($_POST['GroupDay'] == 1) {
																echo "<option value='nothing'>Group Day</option><option selected value=1>1st</option><option value=15>15th</option>";
															} elseif ($_POST['GroupDay'] == 15) {
																echo "<option value='nothing'>Group Day</option><option value=1>1st</option><option selected value=15>15th</option>";
															}
														?>
													</select>
													<select id="GroupMonth" name="GroupMonth" class="icon-pencil">
														<option value = "nothing">Group Month</option>
														<?php
														$months = array(
															date('m', strtotime('first day of last month')),
															date('m', strtotime('first day of this month')),
															date('m', strtotime('first day of +1 months')),
															date('m', strtotime('first day of +2 months')),
															date('m', strtotime('first day of +3 months')),
															date('m', strtotime('first day of +4 months')),
															date('m', strtotime('first day of +5 months')),
															date('m', strtotime('first day of +6 months'))
														);
														foreach ($months as $m) {
															$sel = (isset($_POST['GroupMonth']) && $_POST['GroupMonth'] == $m) ? 'selected' : '';
															echo "<option value='".$m."' $sel>".NameToMonth($m)."</option>";
														}
														?>
													</select>
													<select id="GroupYear" name="GroupYear" class="icon-pencil">
														<option value = "nothing">Group Year</option>
														<?php for ($i=2017;$i <= date("Y")+3;$i++) { $sel = (isset($_POST['GroupYear']) && $_POST['GroupYear'] == $i) ? 'selected' : ''; echo "<option $sel>$i</option>"; } ?>
													</select>
													<button name = "DeathCall" type="submit" class="btn btn-primary">+</button></div></div></div>
												<input name = "insideUnfreezesubmit" type="hidden" >
												<input type = "hidden" name = "StudentCode" value = "<?php echo escape_html($studnetid); ?>">
												<input type = "hidden" name = "NeedToPay" value = "<?php echo escape_html($NeedToPay); ?>">
												<input type = "hidden" name = "Level_Id" value = "<?php echo escape_html($_POST['Level_Id']); ?>">
												<input type = "hidden" name = "OldLevel" value = "<?php echo escape_html($OldLevel); ?>">
												<input type = "hidden" name = "OldGroup" value = "<?php echo escape_html($OldGroup); ?>">
										<?php
										if (isset($_POST['DeathCall']))
										{
											$GT = isset($_POST['GroupTime']) ? GetTimefromID($_POST['GroupTime']) : '';
											$levelcode = isset($_POST['level_id']) ? (int)$_POST['level_id'] : 0;
											$Studocode = isset($_POST['StudentCode']) ? $_POST['StudentCode'] : '';
											$datafromfrom = '';
											if (isset($_POST['GroupDay'], $_POST['GroupMonth'], $_POST['GroupYear']) && $_POST['GroupDay'] !== 'nothing' && $_POST['GroupMonth'] !== 'nothing' && $_POST['GroupYear'] !== 'nothing') {
												$gd = $_POST['GroupDay']; if (strlen($gd) == 1) { $gd = "0".$gd; }
												$datafromfrom = $_POST['GroupYear'] . "-" . $_POST['GroupMonth'] . "-" . $gd;
											}
											if (!empty($GT) && $levelcode > 0 && !empty($datafromfrom)) {
												$resultTGT = mysqli_query($link, "SELECT `group_id`,`group_teacher` ,`group_startday` FROM `group` where `group_time` like '". $GT . "' and `level_id` =" . $levelcode . " and `group_startday` = '" . $datafromfrom . "' order by `group_C_date` ");
												$rowTGT = $resultTGT ? mysqli_fetch_assoc($resultTGT) : null;
												$rcount = mysqli_query($link, "SELECT count(*) as countthis FROM `group` where `group_time` = '". $GT . "' and `level_id` =" . $levelcode . " and `group_startday` = '" . $datafromfrom . "' order by `group_C_date` ");
												$rowcount = $rcount ? mysqli_fetch_assoc($rcount) : ['countthis' => 0];
												if ((int)$rowcount['countthis'] == 1 && $rowTGT) {
													?>
													<ul style="float: left">
														<label for="CoruseStartDate">Coruse Start Date</label>
														<input type="text" id="CoruseStartDate" name="CoruseStartDate" value="<?php echo escape_html($rowTGT['group_startday']); ?>" class="login"/>
													</ul>
													<div class="control-group"><label class="control-label" for="radiobtns">Teacher</label>
														<div class="controls">
															<div class="input-append">
																<input type="text" id="GroupTeacher" name="GroupTeacher" value="<?php echo escape_html($rowTGT['group_teacher']); ?>" required class="login"/>
															</div>
														</div>
													</div> <!-- /control-group -->
													<button name = "DeathitSelf" type="submit" class="btn btn-warning">Unfreeze To this Group</button>
													<?php
												} else {
													echo "<h3>Sorry, We Dont have Registered Group This Time</h3>";
												}
											}
										}
										?>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<?php endif; // close pending alternative if if any ?>
<?php require_once "common_footer.php"; ?>
<?php require_once "common_scripts.php"; ?>