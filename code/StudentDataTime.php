<?php
require_once "config.php";
require_once "MainBarAfterLoginIn.php";
maincheck("StudentChangeTime");
require_once "SingleDataRecover.php";

// Handle change submission securely
if (isset($_POST['DeathitSelf']))
{
	$oldGroup   = safe_get('OldGroup', 0, 'int');
	$oldlevel   = safe_get('OldLevel', 0, 'int');
	$WGroupId   = safe_get('groupid', 0, 'int');
	$WStudentId = safe_get('StudentCode', 0, 'int');

	if ($oldGroup > 0 && $oldlevel > 0 && $WGroupId > 0 && $WStudentId > 0) {
		$stmt = $link->prepare("UPDATE `registration` SET `group_id` = ?, `status` = 1 WHERE `level_id` = ? AND `group_id` = ? AND `st_id` = ?");
		if ($stmt) {
			$stmt->bind_param("iiii", $WGroupId, $oldlevel, $oldGroup, $WStudentId);
			$stmt->execute();
			$stmt->close();
			echo '<div class="modern-alert modern-alert-success" style="margin: 15px;">Group Changed successfully.</div>';
		}
	}
	unset($_POST['insideUnfreezesubmit']);
}
?>
<link href="css/modern-forms.css" rel="stylesheet" type="text/css">
<style type="text/css">
	label {
		display: block;
		line-height: 1.75em;
	}
	input[type="text"] {
		width: 120px;
		height: 34px;
		display: inline-block;
		margin-bottom: 2em;
		padding: .75em .5em;
		color: #999;
		border: 1px solid #e9e9e9;
		outline: none;
	}
	input:focus, textarea:focus { box-shadow: inset 0 0 3px #aaa; }
	textarea { height: 100px; }
	ul { margin: 0; }
</style>
<div class="main">
	<div class="main-inner">
		<div class="container">
			<div class="row">
				<div class="span12">
					<div class="widget ">
						<div class="widget-header">
							<i class="icon-calendar"></i>
							<h3>Time Changer</h3>
						</div>
						<div class="widget-content" style="padding: 25px;">
							<div class="tabbable">
								<div class="tab-content">
									<div class="tab-pane active" id="jscontrols">
										<form action="StudentDataTime.php" method="POST" class="group-form-container">
											<?php if (isset($_POST['StudentCode'])): ?>
												<ul style="float: left">
													<label for="group_id">Student Code</label>
													<button type="submit" class="btn btn-primary">+</button>
													&nbsp;&nbsp;&nbsp;&nbsp;
													<input type="text" id="StudentCode" name="StudentCode"
														value="<?php echo escape_html(safe_get('StudentCode', '', 'string')); ?>"
														class="login"/>
												</ul>
											<?php else: ?>
												<div class="controls">
													<div class="input-append">
														<label class="control-label" for="radiobtns">Student Code</label>
														<input type="text" id="StudentCode" required name="StudentCode" placeholder="Student Code" value='' class="login"/>
														<button type="submit" class="btn btn-primary">+</button>
													</div>
												</div>
											<?php endif; ?>
										</form>
										<?php if (isset($_POST['StudentCode'])): ?>
										<?php
										// Query student safely
										// (Inside StudentCode block)
										$stCode = safe_get('StudentCode', 0, 'int');
										$Fname = '';
										$Sirname = '';
										$stmtS = $link->prepare("SELECT `s_id`, CONCAT(UCASE(LEFT(`S_firstname`, 1)), SUBSTRING(`S_firstname`, 2)) as S_firstname, CONCAT(UCASE(LEFT(`S_midname1`, 1)), SUBSTRING(`S_midname1`, 2)) as S_midname1, CONCAT(UCASE(LEFT(`S_midname2`, 1)), SUBSTRING(`S_midname2`, 2)) as S_midname2, CONCAT(UCASE(LEFT(`S_lastname1`, 1)), SUBSTRING(`S_lastname1`, 2)) as S_lastname1, `S_phone1`, `S_phone2`, `S_Birthdate`, `ST_Gid` FROM `student` WHERE `ST_Gid` = ?");
										if ($stmtS) {
											$stmtS->bind_param("i", $stCode);
											$stmtS->execute();
											$resS = $stmtS->get_result();
											if ($rowSNC = $resS->fetch_assoc()) {
												$Fname = $rowSNC['S_firstname'] . " " . $rowSNC['S_midname1'];
												$Sirname = " " . $rowSNC['S_midname2'] . " " . $rowSNC['S_lastname1'];
											}
											$stmtS->close();
										}
										?>
										<?php if (!empty($Fname)) : ?>
										<div class="controls">
											<div class="input-append">
												<label class="control-label" for="radiobtns">Student Name</label>
												<input type="text" id="StudentName" readonly name="StudentName" value="<?php echo escape_html($Fname); ?>" class="login"/>
												<input type="text" id="StudentName" readonly name="StudentName" value="<?php echo escape_html($Sirname); ?>" class="login"/>
											</div>
										</div>
										<?php
											$StudentId = $stCode;
											// Get registrations
											$stmtReg = $link->prepare("SELECT `regis_id`, `level_id`, `group_id`, `paid_fees`, `discount`, `status`, `st_id`, `regis_date` FROM `registration` WHERE `st_id` = ?");
											$stmtReg->bind_param("i", $StudentId);
											$stmtReg->execute();
											$regissql = $stmtReg->get_result();
											$num_rows = $regissql->num_rows;
											$stmtReg->close();
											if ($num_rows > 0) {
										?>
										<table border="2" class="table table-striped table-bordered">
											<thead>
											<tr>
												<th>No</th>
												<th>Level</th>
												<th>Period</th>
												<th>Start Date</th>
												<th>Time</th>
												<th>Teacher</th>
												<th></th>
											</tr>
											</thead>
											<tbody>
											<?php
												$n = 1;
												while ($regisreturn = $regissql->fetch_assoc()) {
													$studnetid = $StudentId;
													$levelid = (int)$regisreturn['level_id'];
													$groupid = (int)$regisreturn['group_id'];
													// Level
													$stmtLevel = $link->prepare("SELECT `Level_id`, `level_name`, `level_period`, `level_fees`, `level_book`, `level_C_date` FROM `levels` WHERE `Level_id` = ?");
													$stmtLevel->bind_param("i", $levelid);
													$stmtLevel->execute();
													$levelreturn = $stmtLevel->get_result()->fetch_assoc();
													$stmtLevel->close();
													// Group
													$stmtGroup = $link->prepare("SELECT `group_id`, `level_id`, `group_time`, `group_teacher`, `group_day`, `group_startday`, `group_C_date` FROM `group` WHERE `group_id` = ?");
													$stmtGroup->bind_param("i", $groupid);
													$stmtGroup->execute();
													$groupreturn = $stmtGroup->get_result()->fetch_assoc();
													$stmtGroup->close();
													$LevelName = $levelreturn ? $levelreturn['level_name'] : '';
													$LevelSpace = $levelreturn ? $levelreturn['level_period'] : '';
													$GroupTime = $groupreturn ? $groupreturn['group_time'] : '';
													$GroupTeacher = $groupreturn ? $groupreturn['group_teacher'] : '';
													$GroupStartedDay = $groupreturn ? $groupreturn['group_startday'] : '';
													$GroupDay = '';
													if ($groupreturn) {
														if ($groupreturn['group_day'] == 'e') $GroupDay = "Even";
														if ($groupreturn['group_day'] == 'd') $GroupDay = "Odd";
														if ($groupreturn['group_day'] == 'o') $GroupDay = "Other";
													}
												?>
												<tr>
													<td width="2%"><?php echo $n . "."; $n++; ?></td>
													<td><?php echo escape_html($LevelName); ?></td>
													<td width="8%"><?php echo escape_html($LevelSpace); ?></td>
													<td><?php echo escape_html($GroupStartedDay); ?></td>
													<td><?php echo escape_html($GroupTime); ?></td>
													<td><?php echo escape_html($GroupTeacher); ?></td>
													<td width="5%">
														<form action="StudentDataTime.php" method="POST">
															<button name="insideUnfreezesubmit" type="submit" class="btn btn-primary">change time</button>
															<input type="hidden" name="StudentCode" value="<?php echo escape_html($studnetid); ?>">
															<input type="hidden" name="Level_Id" value="<?php echo escape_html($levelid); ?>">
															<input type="hidden" name="Group_Id" value="<?php echo escape_html($groupid); ?>">
														</form>
													</td>
												</tr>
												<?php } // while
												?>
											</tbody>
										</table>
										<?php } else { ?>
											<div class="alert alert-success">
												<button name="PressedUnF" type="button" class="close" data-dismiss="alert">&times;</button>
												This student is not registered.
											</div>
										<?php } ?>
										<?php
										if (isset($_POST['insideUnfreezesubmit']) || isset($_POST['DeathCall'])){
											$studnetid = safe_get('StudentCode', 0, 'int');
											$levelid = safe_get('Level_Id', 0, 'int');
											$OldLevel = isset($_POST['OldLevel']) ? safe_get('OldLevel', $levelid, 'int') : $levelid;
											$OldGroup = isset($_POST['OldGroup']) ? safe_get('OldGroup', 0, 'int') : safe_get('Group_Id', 0, 'int');
											$levelDatePass = isset($_POST['DateofGroup']) ? escape_html($_POST['DateofGroup']) : '';
										?>
										<form action="StudentDataTime.php" method="POST" class="group-form-container">
											<div class="control-group">
												<label class="control-label" for="radiobtns">Group Time</label>
												<div class="controls">
													<div class="input-append">
														<?php DisplayInterval(isset($_POST['GroupTime']) ? GetTimefromID($_POST['GroupTime']) : NULL); ?>
														<button name="DeathCall" type="submit" class="btn btn-primary">+</button>
													</div>
												</div>
											</div>
											<input name="insideUnfreezesubmit" type="hidden">
											<input type="hidden" name="StudentCode" value="<?php echo escape_html($studnetid); ?>">
											<input type="hidden" name="Level_Id" value="<?php echo escape_html($levelid); ?>">
											<input type="hidden" name="OldLevel" value="<?php echo escape_html($OldLevel); ?>">
											<input type="hidden" name="OldGroup" value="<?php echo escape_html($OldGroup); ?>">
											<input type="hidden" name="DateofGroup" value="<?php echo $levelDatePass; ?>">
										</form>
										<?php
										if (isset($_POST['DeathCall']))
										{
											$GT = GetTimefromID($_POST['GroupTime']);
											$levelcode = safe_get('Level_Id', 0, 'int');
											$levelDatePass = isset($_POST['DateofGroup']) ? $_POST['DateofGroup'] : '';
											// Find the exact group matching the criteria
											$stmtT = $link->prepare("SELECT `group_id`, `group_teacher`, `group_startday` FROM `group` WHERE `group_time` = ? AND `level_id` = ? AND `group_startday` = ? ORDER BY `group_C_date`");
											if ($stmtT) {
												$stmtT->bind_param("sis", $GT, $levelcode, $levelDatePass);
												$stmtT->execute();
												$resultTGT = $stmtT->get_result();
												$rowTGT = $resultTGT ? $resultTGT->fetch_assoc() : null;
												$stmtT->close();
											}
											// Count to ensure exactly one
											$stmtC = $link->prepare("SELECT COUNT(*) as countthis FROM `group` WHERE `group_time` = ? AND `level_id` = ? AND `group_startday` = ?");
											$stmtC->bind_param("sis", $GT, $levelcode, $levelDatePass);
											$stmtC->execute();
											$rcount = $stmtC->get_result();
											$rowcount = $rcount->fetch_assoc();
											$stmtC->close();
											if ($rowcount && (int)$rowcount['countthis'] === 1 && $rowTGT) {
												?>
												<form action="StudentDataTime.php" method="post" class="group-form-container" style="margin-top: 10px;">
													<input type="hidden" id="levelcode" name="levelcode" value="<?php echo escape_html($levelcode); ?>" class="login"/>
													<input type="hidden" id="fromtotime" name="fromtotime" value="<?php echo escape_html($GT); ?>" class="login"/>
													<input type="hidden" id="groupid" name="groupid" value="<?php echo escape_html($rowTGT['group_id']); ?>" class="login"/>
													<input type="hidden" id="StudentCode" name="StudentCode" value="<?php echo escape_html($studnetid); ?>" class="login"/>
													<input type="hidden" name="DateofGroup" value="<?php echo escape_html($levelDatePass); ?>">
													<input type="hidden" name="OldLevel" value="<?php echo escape_html($OldLevel); ?>">
													<input type="hidden" name="OldGroup" value="<?php echo escape_html($OldGroup); ?>">
													<button name="DeathitSelf" type="submit" class="btn btn-warning">After this time and date will change</button>
												</form>
												<?php
												} else {
													echo '<div class="modern-alert modern-alert-info" style="margin-top: 10px;">Sorry, We don\'t have Groups at This Time</div>';
												}
										}
										}
										?>
<?php endif; // end if (!empty($Fname)) ?>
<?php endif; // end if (isset($_POST['StudentCode'])) ?>
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
<?php require_once "common_footer.php"; ?>
<?php require_once "common_scripts.php"; ?>