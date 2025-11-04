<?php
require_once "config.php";
require_once "MainBarAfterLoginIn.php";
require_once "SingleDataRecover.php";
maincheck ("Spayment");

// Handle payment submission securely
if (isset($_POST['InsideSubmit']))
{
	$StudentId    = safe_get('StudentCode', 0, 'int');
	$LevelIdToSql = safe_get('LevelIdInner', 0, 'int');
	$GroupIdToSql = safe_get('GroupIdInner', 0, 'int');
	$PaymentToSql = safe_get('RePayment', 0, 'float');

	if ($StudentId > 0 && $LevelIdToSql > 0 && $GroupIdToSql > 0 && $PaymentToSql >= 0) {
		$stmt = $link->prepare("INSERT INTO `paymenttwo`(`s_id`, `level_id`, `group_id`, `payment`, `P_created_date`) VALUES (?, ?, ?, ?, NOW())");
		if ($stmt) {
			$stmt->bind_param("iiid", $StudentId, $LevelIdToSql, $GroupIdToSql, $PaymentToSql);
			$stmt->execute();
			$stmt->close();
			// Open receipt in a new window
			$link2ndinstall = "<script>window.open('gatepass2ndinstall.php?', '_blank', 'toolbar=yes, scrollbars=yes, resizable=yes, top=500, left=500, width=400, height=400')</script>";
			echo $link2ndinstall;
			echo '<div class="modern-alert modern-alert-success" style="margin: 15px;">Second payment recorded successfully.</div>';
		} else {
			echo '<div class="modern-alert modern-alert-warning" style="margin: 15px;">Unable to record payment. Please try again.</div>';
		}
	} else {
		echo '<div class="modern-alert modern-alert-warning" style="margin: 15px;">Invalid input provided.</div>';
	}
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

    input:focus, textarea:focus {
        -moz-box-shadow: inset 0 0 3px #aaa;
        -webkit-box-shadow: inset 0 0 3px #aaa;
        box-shadow: inset 0 0 3px #aaa;
    }

    textarea {
        height: 100px;
    }

    ul {
        margin: 0;
    }
</style>
<div class = "main">
	<div class = "main-inner">
		<div class = "container">
			<div class = "row">
				<div class = "span12">
					<div class = "widget ">
						<div class = "widget-header">
							<i class = "icon-pinterest"></i>
							<h3>Second Installment</h3></div>
						<div class = "widget-content">
							<div class = "tabbable">
								<div class = "tab-content">
									<div class = "tab-pane active" id = "jscontrols">
										<form action = "SecondPayment.php" method = "POST">
											<?php if (isset($_POST['StudentCode'])) { ?>
												<ul style = "float: left">
													<label for = "group_id">Student ID</label>
													<button type = "submit" class = "btn btn-primary">+</button>
													&nbsp;&nbsp;&nbsp;&nbsp;
													<input type = "text" id = "StudentCode" name = "StudentCode"
													       value = "<?php echo escape_html(safe_get('StudentCode', '', 'string')); ?>"
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
										<?php
										if (isset($_POST['StudentCode'])) {
											$stCode = safe_get('StudentCode', 0, 'int');
											$Fname = '';
											$Sirname = '';
											$stmtS = $link->prepare("SELECT `s_id` , CONCAT(UCASE(LEFT(`S_firstname`, 1)), SUBSTRING(`S_firstname`, 2)) as S_firstname ,CONCAT(UCASE(LEFT(`S_midname1`, 1)), SUBSTRING(`S_midname1`, 2)) as S_midname1 ,CONCAT(UCASE(LEFT(`S_midname2`, 1)), SUBSTRING(`S_midname2`, 2)) as S_midname2 ,CONCAT(UCASE(LEFT(`S_lastname1`, 1)), SUBSTRING(`S_lastname1`, 2)) as S_lastname1 ,`S_phone1`, `S_phone2`, `S_Birthdate`, `ST_Gid` FROM `student` WHERE `ST_Gid` = ?");
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
										}
										?>
										<?php if (!empty($Fname)) { ?>
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
											$StudentId = $stCode;
											// Fetch registrations
											$stmtR = $link->prepare("SELECT `regis_id`, `level_id`, `group_id`, `paid_fees`, `discount`, `status`, `st_id`, `regis_date` FROM `registration` WHERE `st_id` = ?");
											$stmtR->bind_param("i", $StudentId);
											$stmtR->execute();
											$CheckRegisterSt = $stmtR->get_result();
											$stmtR->close();
											while($ReturnCRS = $CheckRegisterSt->fetch_assoc())
											{
												$GroupId = (int)$ReturnCRS['group_id'];
												$stmtG = $link->prepare("SELECT `group_id`, `level_id`, `group_time`, `group_startday` FROM `group` WHERE group_id = ?");
												$stmtG->bind_param("i", $GroupId);
												$stmtG->execute();
												$ReturnCHD = $stmtG->get_result()->fetch_assoc();
												$stmtG->close();
												$LevelId = $ReturnCHD ? (int)$ReturnCHD['level_id'] : 0;
												$stmtL = $link->prepare("SELECT `Level_id`, `level_name` FROM `levels` WHERE Level_id = ?");
												$stmtL->bind_param("i", $LevelId);
												$stmtL->execute();
												$ReturnCLD = $stmtL->get_result()->fetch_assoc();
												$stmtL->close();
												list($year, $month, $day) = $ReturnCHD && isset($ReturnCHD['group_startday']) ? explode("-", $ReturnCHD['group_startday']) : array('', '', '');
												$months_mapping = array("01" => "Jan","02" => "Feb","03" => "Mar","04" => "Apr","05" => "May","06" => "Jun","07" => "Jul","08" => "Aug","09" => "Sep","10" => "Oct","11" => "Nov","12" => "Dec");
												$MonthL = isset($months_mapping[$month]) ? $months_mapping[$month] : '';
												$AllowToGetMark =  (CalRem($StudentId,$GroupId));
												if (isset($AllowToGetMark['1']) && $AllowToGetMark['1'] != 0)
												{
													?>
													<form method="POST" action = "SecondPayment.php" >
														<input type = "hidden" value = "<?php echo escape_html($StudentId);?>" name = "StudentCode">
														<input type = "hidden" value = "<?php echo escape_html($LevelId);?>" name = "LevelIdInner">
														<input type = "hidden" value = "<?php echo escape_html($GroupId);?>" name = "GroupIdInner">
														<input type = "text" value = "<?php echo escape_html($ReturnCLD ? $ReturnCLD['level_name'] : ''); ?>" name = "LName">
														<input type = "text" value = "<?php echo escape_html(trim($day." ".$MonthL." ".$year));?>" name = "StartDay">
														<input type = "text" value = "<?php echo escape_html($ReturnCHD ? $ReturnCHD['group_time'] : ''); ?>" name = "GTime">
														<input type = "text" value = "<?php echo escape_html($AllowToGetMark['1']);?>" name = "RePayment">
														<button name = "InsideSubmit" type = "submit" class = "btn btn-primary">
															<i class = "icon-ok-circle"></i>
														</button>
													</form>
													<?php
												}
											}
											?>
										<?php } ?>
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