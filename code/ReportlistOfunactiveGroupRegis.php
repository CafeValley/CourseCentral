<?php
require_once "config.php";
require_once "MainBarAfterLoginIn.php";
maincheck("StudentsunactivePool");
?>
<style type="text/css">
    label {
        display: block;
        line-height: 1.75em;
    }

    input, textarea {
        width: 120px;
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
<div class="main">
    <div class="main-inner">
        <div class="container">
            <div class="row">
                <div class="span12">
                    <div class="widget ">
                        <div class="widget-header">
                            <i class="icon-group"></i>
                            <h3>Students unactive Pool</h3>
                        </div> <!-- /widget-header -->
                        <!-- here code-->
                        <div class="widget-content">

                            <div class="tabbable">
                                <ul class="nav nav-tabs">

                                </ul>
                                <div class="tab-content">

                                        <div class="main">
                                            <div class="main-inner">
                                                <div id="printableArea" class="container">
                                                    <div class="row">
                                                        <div class="span12">
                                                            <div class="widget ">
                                                                <!--
                                                                **********************************
                                                                Here for the for input
                                                                **********************************
                                                                -->
																<?php
																if (isset($_POST['activethissure']))
																{
																	 if ($_POST['Month'] == 'Month') {
																		  $month = 1;
																		 } else 
																		 {
																		$month = $_POST['Month'];
																			 }
																			 if ($_POST['Day'] == 'Day') {
																				 $day = 1;
																				 } else {
																					 $day = $_POST['Day'];
																					 }
																					 
																if (strlen($month) == 1) $month = "0".$month;
																if (strlen($day) == 1) $day = "0".$day;
																
																
																	$GSD = $_POST['Year'] . "-" . $month . "-" . $day;
																	$GT = GetTimefromID($_POST['GroupTime']);
																	
																//print_r($_POST);
																
																$levelidsone = $_POST['LevelId'];
																
																$theinnersql = "SELECT `group_id`, `level_id`, `group_time`, `group_teacher`, `group_day`, `group_startday`, `group_C_date`, `feesforgroup`, `feesforbookgroup` FROM `group` WHERE `level_id` = '$levelidsone' and `group_time` = '$GT' and `group_startday` = '$GSD' ";
																$resulttogetGID = mysqli_query($link,$theinnersql );
                                                                $rowtogetGID = mysqli_fetch_array($resulttogetGID);
                                                                //echo "this is the new G id name ->";
																$newGroupid  = $rowtogetGID['group_id'];
																
																if (empty($newGroupid))
																	echo "there is no group open this time";
																else 
																{
																	$regis_id   = $_POST['regis_id'];
																	$paid_fees  = $_POST['paid_fees'];
																	$discount   = $_POST['discount'];
																	$st_id      = $_POST['st_id'];
																	$regis_date = $_POST['regis_date'];
																
																$sqlininreg = "INSERT INTO `registration`(`regis_id`, `level_id`, `group_id`, `paid_fees`, `discount`, `status`, `st_id`, `regis_date`) VALUES ('$regis_id','$levelidsone','$newGroupid','$paid_fees','$discount','1','$st_id','$regis_date')";
																
																$sqldeleteregisunactiv = "DELETE FROM `registrationunactive` WHERE `regis_id` = $regis_id";
																																			
																mysqli_query($link,$sqlininreg );
																mysqli_query($link,$sqldeleteregisunactiv );
																echo "Transfer complete";
																}
																
																}
																
																if (isset($_POST['activethis']))
																{
																	$paid_fees = $_POST['paid_fees'];
																	$discount = $_POST['discount'];
																	$st_id = $_POST['st_id'];
																	$regis_date = $_POST['regis_date'];
																	
																	 $Sid = $_POST['st_id']; 
																	 $levelname = $_POST['LevelName'];
																	 $LevelId = $_POST['LevelId'];
																	 $regis_id = $_POST['regis_id'];
																	
																echo "you want to active this ?";	
																//print_r($_POST);
																//select for date 
																//select for time
																
																?>
																<form action = "ReportlistOfunactiveGroupRegis.php" method = "POST">
																<input type = "hidden" value = "<?php echo $Sid;?>" name = "Sid" ">
																<input type = "hidden" value = "<?php echo $levelname;?>" name = "levelname" ">
																<input type = "hidden" value = "<?php echo $LevelId;?>" name = "LevelId" ">
																<input type= "hidden" name = "regis_id" value = "<?php echo $regis_id;?>">
																
																<input type= "hidden" name = "paid_fees" value = "<?php echo $paid_fees;?>">
                                                                <input type= "hidden" name = "discount" value = "<?php echo $discount;?>">
                                                                <input type= "hidden" name = "st_id" value = "<?php echo $st_id;?>">
                                                                <input type= "hidden" name = "regis_date" value = "<?php echo $regis_date;?>">
																
																
																
																<div class="controls">
                                                <label class="control-label" for="radiobtns">Group Start Day</label>
                                                <div class="input-append">
                                                    <select id="Day" name="Day" class="icon-pencil">
                                                        <option value="Day" selected>Day</option>
                                                        <option value="1">1st</option>
                                                        <option value="15">15th</option>
                                                    </select>
                                                    <select id="Month" name="Month" class="icon-pencil">
                                                        <option value="Month" selected> Month</option>
                                                        <?php for ($i = 01; $i <= 12; $i++) echo "<option value = $i> $i</option>"; ?>
                                                    </select>
                                                    <select id="Year" name="Year" class="icon-pencil">
                                                        <option value="Year" selected> Year</option>
                                                        <?php for ($i = date("Y")+1; $i >= 1970; $i--) echo "<option value = $i> $i</option>"; ?>
                                                    </select>
                                                   </div>
                                            </div>
																 <label class="control-label" for="radiobtns">Group Time</label>
                                                <div class="controls">
                                                    <div class="input-append">
                                                      <?php
                                                      DisplayInterval();
                                                      ?>

                                                    </div>
                                                </div>
												<input type="submit" class="btn btn-warrning"  name ="activethissure" value="set active!" />
												</form>
												
																<?php
																}
																?>
                                                                <div class="widget-content">
                                                                    <div class="tabbable">
                                                                        <div class="tab-content">
                                                                            <div class="tab-pane active" id="jscontrols">
                                                                              
                                                                                    <?php
                                                                                    /*
                                                                                    here to puf data in the form
                                                                                    */
                                                                                    ?>
                                                                                    <table class="table table-striped table-bordered">
                                                                                        <thead>
                                                                                        <tr>
                                                                                            <th><center>No</center></th>
                                                                                            <th><center>Date of Registered</center></th>
                                                                                            <th><center>Name</center></th>
                                                                                            <th><center>Telephone</center></th>
                                                                                            <th><center>ID</center></th>
                                                                                            <th><center>Level Name</center></th>
                                                                                            <th><center>Group Time</center></th>
                                                                                            <th><center></center></th>

                                                                                        </tr>
                                                                                        </thead>
                                                                                        <tbody>
                                                                                        <?php

                                                                                        $resultGRR = mysqli_query($link, "SELECT `regis_id`, `level_id`, `group_id`, `paid_fees`, `discount`, `status`, `st_id`, Date(regis_date) as regis_date FROM `registrationunactive` ");
                                                                                        $x = 0;
                                                                                        while($rowGRR = mysqli_fetch_array($resultGRR))
                                                                                        {
																							$paid_fees = $rowGRR['paid_fees'];
																							$discount = $rowGRR['discount'];
																							$st_id = $rowGRR['st_id'];
																							$regis_date = $rowGRR['regis_date'];
																							
																							$LevelId = $rowGRR['level_id'];
																							$group_id = $rowGRR['group_id'];
																							$st_id = $rowGRR['st_id'];
																							$regis_date = $rowGRR['regis_date'];
																							$regis_id = $rowGRR['regis_id'];
																							
																							
																							
                                                                                            $resultLN = mysqli_query($link, "SELECT `level_name` FROM `levels` WHERE Level_id = $LevelId");
                                                                                            $rowLN = mysqli_fetch_array($resultLN);
                                                                                            $LevelName  = $rowLN['level_name'];
                                                                                           


																						    
																							$resultGT = mysqli_query($link, "SELECT `group_id`, `level_id`, `group_time`, `group_teacher`, `group_day`, `group_startday`, `group_C_date`, `feesforgroup`, `feesforbookgroup` FROM `groupunactive` WHERE `group_id` = '$group_id' ");
                                                                                            $rowGT = mysqli_fetch_array($resultGT);
                                                                                            $Grouptime  = $rowGT['group_time'];

																							
                                                                                            $x = $x +1 ;
                                                                                            ?>
                                                                                            <tr>
																							<form action = "ReportlistOfunactiveGroupRegis.php" method = "POST">
                                                                                                
																								<th><center><?php echo $x;?></center></th>
                                                                                                
                                                                                                <th><center><?php echo $regis_date;?></center></th>
                                                                                                <th><?php echo StudentName($st_id);?></th>
                                                                                                <th><center><?php echo Studenttelephone($st_id);?></center></th>
                                                                                                <th><center><?php echo $st_id;?></center></th>
																								<th><center><?php echo $LevelName;?></center></th>
                                                                                                <th><center><?php echo $Grouptime;?></center></th>
																								
                                                                                                <input type= "hidden" name = "st_id" value = "<?php echo $st_id;?>">
                                                                                                <input type= "hidden" name = "LevelName" value = "<?php echo $LevelName;?>">
                                                                                                <input type= "hidden" name = "LevelId" value = "<?php echo $LevelId;?>">
                                                                                                <input type= "hidden" name = "regis_id" value = "<?php echo $regis_id;?>">
																								
                                                                                                <input type= "hidden" name = "paid_fees" value = "<?php echo $paid_fees;?>">
                                                                                                <input type= "hidden" name = "discount" value = "<?php echo $discount;?>">
                                                                                                <input type= "hidden" name = "st_id" value = "<?php echo $st_id;?>">
                                                                                                <input type= "hidden" name = "regis_date" value = "<?php echo $regis_date;?>">
																								
																								<th>

																								<input type="submit" class="btn btn-warrning"  name ="activethis" value="this one!" />
																								
																								</form>
																								</center>
																								</th>
                                                                                            </tr>
                                                                                            <?php
                                                                                        } ?>

                                                                                        </tbody>
                                                                                    </table>
                                                                                </form>
                                                                                </fieldset>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                           
                                               <div class="form-actions">
                                                <script>
                                                    function printDiv(divName) {
                                                        var printContents = document.getElementById(divName).innerHTML;
                                                        var originalContents = document.body.innerHTML;

                                                        document.body.innerHTML = printContents;

                                                        window.print();

                                                        document.body.innerHTML = originalContents;
                                                    }
                                                </script>
                                                <input type="button" class="btn btn-primary" onclick="printDiv('printableArea')" value="Print!"/>
                                            </div> <!-- /form-actions --></div>
                                              
                                            <!-- /form-actions --></div>
                                       
                                       
                                        <?php require_once "common_scripts.php"; ?>

                                </div>
                            </div>
                        </div> <!-- /widget-content -->
                    </div> <!-- /widget -->
                </div> <!-- /span8 -->
            </div> <!-- /row -->
        </div> <!-- /container -->
    </div> <!-- /main-inner -->
</div> <!-- /main -->
<div class="extra">
    <div class="extra-inner">
        <div class="container">
            <div class="row">
            </div> <!-- /row -->
        </div> <!-- /container -->
    </div> <!-- /extra-inner -->
</div> <!-- /extra -->
<div class="footer">
    <div class="footer-inner">
        <div class="container">
            <div class="row">
                <div class="span12">
                    &copy; 2015 <a href='http://cafavalley.comoj.com/'>Cafavalley</a>
                </div> <!-- /span12 -->
            </div> <!-- /row -->
        </div> <!-- /container -->
    </div> <!-- /footer-inner -->
</div> <!-- /footer -->
</body>
</html>
