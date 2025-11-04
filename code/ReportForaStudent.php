<?php
require_once "config.php";
require_once "MainBarAfterLoginIn.php";
require_once "SingleDataRecover.php";
maincheck ("ReportForaStudent");
/*/this method from the after login file to make sure in 
 which page you are right now/*/
?>
<script>
	function printDiv(divName) {
		var printContents = document.getElementById(divName).innerHTML;
		var originalContents = document.body.innerHTML;

		document.body.innerHTML = printContents;

		window.print();

		document.body.innerHTML = originalContents;
	}
</script>
<div class = "main">
	<div class = "main-inner">
		<div class = "container">
			<div class = "row">
				<div class = "span12">
					<div class = "widget ">
						<div class = "widget-header">
							<i class = "icon-user"></i>
							<h3>Certain Student</h3></div>
						<div class = "widget-content">
							<div class = "tabbable">
								<div class = "tab-content">
									<div class = "tab-pane active" id = "jscontrols">
										<form action = "ReportForaStudent.php" method = "POST">
											<?php if (isset($_POST['StudentCode'])) { ?>
												<input type="button" class="btn btn-primary" onclick="printDiv('printableArea')" value="Print!"/>
													<br>
												<ul style = "float: left">
													<label for = "group_id">Student Code</label>
													<button type = "submit" class = "btn btn-primary">+</button>
													&nbsp;&nbsp;&nbsp;&nbsp;
													<input type = "text" id = "StudentCode" name = "StudentCode"
													       value = "<?php echo htmlspecialchars($_POST['StudentCode']); ?>"
													       class = "login"/>
												</ul>
											<?php }
											else {
												?>
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
												$StudentId = (int)$_POST['StudentCode'];
												$resultSNC = mysqli_query ($link , "SELECT `s_id` , CONCAT(UCASE(LEFT(`S_firstname`, 1))
												, SUBSTRING(`S_firstname`, 2)) as S_firstname ,CONCAT(UCASE(LEFT(`S_midname1`, 1)), SUBSTRING(`S_midname1`, 2)) as S_midname1 ,CONCAT(UCASE(LEFT(`S_midname2`, 1)),
 												  SUBSTRING(`S_midname2`, 2)) as S_midname2 ,CONCAT(UCASE(LEFT(`S_lastname1`, 1)), SUBSTRING(`S_lastname1`, 2)) as S_lastname1 ,`S_phone1`, `S_phone2`, `S_Birthdate`, `ST_Gid` FROM `student` WHERE `ST_Gid` = "
													                                   . $StudentId . " ");
												$rowSNC    = ($resultSNC instanceof mysqli_result) ? mysqli_fetch_array ($resultSNC) : null;
												if ($rowSNC) {
													$Fname     = $rowSNC['S_firstname'] . " " . $rowSNC['S_midname1'];
													$Sirname   = " " . $rowSNC['S_midname2'] . " " . $rowSNC['S_lastname1'];
												}
										} ?>

										<?php //here to display Name
										if (isset($Fname)) {
											?>
											<div class = "controls">
												<div class = "input-append"><label class = "control-label"
												                                   for = "radiobtns">Student
													Name</label>
													<input type = "text" id = "StudentName" readonly
													       name = "StudentName" value = "<?php echo htmlspecialchars($Fname); ?>"
													       class = "login"/>
													<input type = "text" id = "StudentName" readonly
													       name = "StudentName" value = "<?php echo htmlspecialchars($Sirname); ?>"
													       class = "login"/>
												</div>
											</div>
											<?php
												$SqlCerStudent = "SELECT `regis_id`, `level_id`, `group_id`, `paid_fees`, `discount`, `status`, `st_id`, `regis_date` 
												FROM `registration` WHERE `st_id` = "
													. $StudentId . " ";
												$regissql  = mysqli_query ($link ,$SqlCerStudent);
												$num_rows  = ($regissql instanceof mysqli_result) ? mysqli_num_rows ($regissql) : 0;
											 ?>
										<div id="printableArea" class="container">
										<center>
										<?php 
										echo "This is for<strong>".htmlspecialchars(StudentName($StudentId))."</strong>";
										echo "-".htmlspecialchars(StudentBirthday($StudentId));
										?>
										</center>
										<table border = "2" class="table table-striped table-bordered">
											<thead>
											<tr>
												<th>No</th>
												<th>Level</th>
												<th>Period</th>
												<th>Start</th>
												<th>Time</th>
												<th>Mark</th>
												<th>Rem Fees</th>
												<th>States</th>
											</tr>
											</thead>
											<tbody>
										<?php
										$n = 1;
										if ($regissql instanceof mysqli_result) while ( $regissqlarray = mysqli_fetch_array ($regissql))
										{
											$levelid = (int)$regissqlarray['level_id'];
											$Groupid = (int)$regissqlarray['group_id'];
											$levelsql        = "SELECT `Level_id`, `level_name`, `level_period`, `level_fees`, `level_book`, `level_C_date` 
                                               FROM `levels` 
                                               WHERE `Level_id` = " . $levelid;
											$sqlReturnlevel  = mysqli_query ($link ,$levelsql);
											$returnlevelarray = ($sqlReturnlevel instanceof mysqli_result) ? mysqli_fetch_array ($sqlReturnlevel) : null;
											$LevelName = $returnlevelarray ? $returnlevelarray['level_name'] : '';
											$LevelSpace = $returnlevelarray ? $returnlevelarray['level_period'] : '';
											$groupsql        = "SELECT `group_id`, `level_id`, `group_time`, `group_teacher`, `group_day`, `group_startday`, `group_C_date` 
												FROM `group`  
                                               WHERE `group_id` = " . $Groupid;
											$sqlReturnGroup  = mysqli_query ($link ,$groupsql);
											$sqlGrouparray = ($sqlReturnGroup instanceof mysqli_result) ? mysqli_fetch_array ($sqlReturnGroup) : null;
											$GroupStartedDay = $sqlGrouparray ? $sqlGrouparray['group_startday'] : '';
											$GroupTime = $sqlGrouparray ? $sqlGrouparray['group_time'] : '';
											?>
											<tr>
												<td width="2%"><?php echo $n . "."; $n = $n + 1; ?> </td>
												<td><?php echo htmlspecialchars($LevelName); ?></td>
												<td width="8%"><?php echo htmlspecialchars($LevelSpace); ?></td>
												<td><?php echo htmlspecialchars($GroupStartedDay); ?></td>


												<td><?php echo htmlspecialchars($GroupTime);?></td>
												<td><?php

													$mark = GetMark($levelid,$Groupid,$StudentId);
													if ($mark == -1)
														echo "Not Set";
													else
														echo $mark;
													?></td>


												<td><?php
													
													$AllowToGetMark = (CalRemFromSelectedGroup($StudentId, $Groupid));
													echo htmlspecialchars($AllowToGetMark[1]);
													//print_r($AllowToGetMark);
													?></td>

												<td><?php
													if(isset($regissqlarray['status']) && $regissqlarray['status'] == 1) echo "Active";
													if(isset($regissqlarray['status']) && $regissqlarray['status'] == 0) echo "No Active"; ?>
												</td>
											</tr>
										<?php } ?>
											</tbody>
											</table>
											</div>
											<?php } ?>
										</form></div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<?php require_once "common_scripts.php"; ?>
</body>
</html>