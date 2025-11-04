<?php
require_once "config.php";
require_once "MainBarAfterLoginIn.php";
require_once "SingleDataRecover.php";
maincheck ("Freeze");
/*/this method from the after login file to make sure in 
 which page you are right now/*/
?>
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
							<i class = "icon-exclamation-sign"></i>
							<h3>Freeze</h3></div>
						<div class = "widget-content" style="padding: 25px;">
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
										<?php
										$Fname = '';
										$Sirname = '';
										if (isset($_POST['StudentCode'])) {
											$stCode = safe_get('StudentCode', 0, 'int');
											$stmt = $link->prepare("SELECT `s_id` , CONCAT(UCASE(LEFT(`S_firstname`, 1)), SUBSTRING(`S_firstname`, 2)) as S_firstname ,CONCAT(UCASE(LEFT(`S_midname1`, 1)), SUBSTRING(`S_midname1`, 2)) as S_midname1 ,CONCAT(UCASE(LEFT(`S_midname2`, 1)), SUBSTRING(`S_midname2`, 2)) as S_midname2 ,CONCAT(UCASE(LEFT(`S_lastname1`, 1)), SUBSTRING(`S_lastname1`, 2)) as S_lastname1 ,`S_phone1`, `S_phone2`, `S_Birthdate`, `ST_Gid` FROM `student` WHERE `ST_Gid` = ?");
											if ($stmt) {
												$stmt->bind_param("i", $stCode);
												$stmt->execute();
												$res = $stmt->get_result();
												if ($rowSNC = $res->fetch_assoc()) {
													$Fname = $rowSNC['S_firstname'] . " " . $rowSNC['S_midname1'];
													$Sirname = " " . $rowSNC['S_midname2'] . " " . $rowSNC['S_lastname1'];
												}
												$stmt->close();
											}
										}
										?>

										<?php //here to display Name
										if (!empty($Fname)) { ?>
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
											// The following function expects identifiers for context; quote to avoid undefined constant
											DisplayalldatatStudent ("Freeze" , "void");
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

<?php require_once "common_footer.php"; ?>
<?php require_once "common_scripts.php"; ?>
