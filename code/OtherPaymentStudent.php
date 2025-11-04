<?php
require_once "config.php";
require_once "MainBarAfterLoginIn.php";
require_once "SingleDataRecover.php";
maincheck ("Freeze");
/*/this method from the after login file to make sure in 
 which page you are right now/*/
?>
<div class = "main">
	<div class = "main-inner">
		<div class = "container">
			<div class = "row">
				<div class = "span12">
					<div class = "widget ">
						<div class = "widget-header">
							<i class = "icon-user"></i>
							<h3>Your Form</h3></div>
						<div class = "widget-content">
							<div class = "tabbable">
								<div class = "tab-content">
									<div class = "tab-pane active" id = "jscontrols">
										<form action = "freezeform.php" method = "POST">
											<?php if (isset($_POST['StudentCode'])) { ?>
												<ul style = "float: left">
													<label for = "group_id">Student Code</label>
													<button type = "submit" class = "btn btn-primary">+</button>
													&nbsp;&nbsp;&nbsp;&nbsp;
													<input type = "text" id = "StudentCode" name = "StudentCode"
													       value = "<?php echo $_POST['StudentCode']; ?>"
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
											$resultSNC = mysqli_query ($link , "SELECT `s_id` , CONCAT(UCASE(LEFT(`S_firstname`, 1))
											, SUBSTRING(`S_firstname`, 2)) as S_firstname ,CONCAT(UCASE(LEFT(`S_midname1`, 1)), SUBSTRING(`S_midname1`, 2)) as S_midname1 ,CONCAT(UCASE(LEFT(`S_midname2`, 1)),
 											  SUBSTRING(`S_midname2`, 2)) as S_midname2 ,CONCAT(UCASE(LEFT(`S_lastname1`, 1)), SUBSTRING(`S_lastname1`, 2)) as S_lastname1 ,`S_phone1`, `S_phone2`, `S_Birthdate`, `ST_Gid` FROM `student` WHERE `ST_Gid` = "
											                                   . $_POST['StudentCode'] . "");
											$rowSNC    = mysqli_fetch_array ($resultSNC);
											$Fname     = $rowSNC['S_firstname'] . " " . $rowSNC['S_midname1'];
											$Sirname   = " " . $rowSNC['S_midname2'] . " " . $rowSNC['S_lastname1'];
										} ?>

										<?php //here to display Name
										if (isset($Fname)) {
											?>
											<div class = "controls">
												<div class = "input-append"><label class = "control-label"
												                                   for = "radiobtns">Student
														Name</label>
													<input type = "text" id = "StudentName" readonly
													       name = "StudentName" value = "<?php echo $Fname; ?>"
													       class = "login"/>
													<input type = "text" id = "StudentName" readonly
													       name = "StudentName" value = "<?php echo $Sirname; ?>"
													       class = "login"/>
												</div>
											</div>
											<?php
											DisplayalldatatStudent (Freeze , void);

										}
										?>
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
<div class = "extra">
	<div class = "extra-inner">
		<div class = "container">
			<div class = "row"></div>
		</div>
	</div>
</div>
<div class = "footer">
	<div class = "footer-inner">
		<div class = "container">
			<div class = "row">
				<div class = "span12">&copy; 2015 <a href = 'http://cafavalley.comoj.com/'>Cafavalley</a></div>
			</div>
		</div>
	</div>
</div>
<?php require_once "common_scripts.php"; ?>
</body>
</html>