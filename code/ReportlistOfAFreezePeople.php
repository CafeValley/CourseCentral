<?php
require_once "config.php";
require_once "MainBarAfterLoginIn.php";
maincheck("ReportAllAFreezeStudents");
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
                            <i class="icon-eye-close"></i>
                            <h3>All Freeze</h3>
                        </div> <!-- /widget-header -->
                        <!-- here code-->
                        <div class="widget-content">

                                    <?php require_once "common_scripts.php"; ?>
                                </body>
                            </html>

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
                                                            <div class="widget-content">
                                                                <div class="tabbable">
                                                                    <div class="tab-content">
                                                                        <div class="tab-pane active" id="jscontrols">

                                                                                <?php
                                                                                /*
                                                                                here to puf data in the form
                                                                                */
                                                                                ?>
                                                                                <form action="ReportlistOfAFreezePeople.php" method="POST">
                                                                                    <ul style="float: left">
                                                                                        <label for="group_id">Which Level</label>
                                                                                        <select id="level_id" name="level_id" class="icon-pencil">
                                                                                            <?php
                                                                                            if (!isset($_POST['level_id']))
                                                                                            {
                                                                                                ?>
                                                                                                <option value = "nothing">Level Name</option>
                                                                                                <?php
                                                                                            }
                                                                                            $result = mysqli_query($link, "SELECT `Level_id`, `level_name` ,`level_fees`, `level_book`  FROM `levels`");
                                                                                            if ($result instanceof mysqli_result) while ($row = mysqli_fetch_assoc($result)) {
                                                                                                $selected = (isset($_POST['level_id']) && (int)$_POST['level_id'] == (int)$row['Level_id']) ? 'selected' : '';
                                                                                                echo "<option $selected value='".htmlspecialchars($row['Level_id'])."'>".htmlspecialchars($row['level_name'])."</option>";
                                                                                            } ?>
                                                                                        </select>
                                                                                        <button name = "Deathside" type="submit" class="btn btn-primary">+</button>
                                                                                    </ul>

                                                                                    </form>

                                                                                <table class="table table-striped table-bordered">
                                                                                    <thead>
                                                                                    <tr>
                                                                                        <th width="2%"><center>No</center></th>
                                                                                        <th>Student</></th>
                                                                                        <th>Phone</></th>
                                                                                        <th>Level</th>
                                                                                        <th><center>When</center></th>

                                                                                    </tr>
                                                                                    </thead>
                                                                                    <tbody>
                                                                                    <?php

                                                                                    if (isset($_POST['Deathside']))
                                                                                    {
                                                                                        $Postedlevelid = (int)$_POST['level_id'];
                                                                                        $resultGRR = mysqli_query($link, "SELECT `s_id`, `level_id`, `group_id`, `dayleft`, `Freeze_fees`, `status`, `F_created_date` 
                                                                                                                          FROM `freeze` where status = 1 and level_id = $Postedlevelid  ");
                                                                                         $x = 0;
                                                                                    if ($resultGRR instanceof mysqli_result) while($rowGRR = mysqli_fetch_array($resultGRR))
                                                                                    {

                                                                                        $StudentID = $rowGRR['s_id'];
                                                                                        $LevelId = $rowGRR['level_id'];
                                                                                        $GroupId = $rowGRR['group_id'];
                                                                                        $FreezeDate = $rowGRR['F_created_date'];

                                                                                        $resultSD = mysqli_query($link, "SELECT  `S_phone1` FROM `student` WHERE `ST_Gid`= $StudentID");
                                                                                        $rowSD = ($resultSD instanceof mysqli_result) ? mysqli_fetch_array($resultSD) : null;
                                                                                        $StudentFirstPhone  = $rowSD ? $rowSD['S_phone1'] : '';


                                                                                        $resultLD = mysqli_query($link, "SELECT `level_name` FROM `levels` WHERE Level_id = $LevelId");
                                                                                        $rowLD = ($resultLD instanceof mysqli_result) ? mysqli_fetch_array($resultLD) : null;
                                                                                        $LevelName  = $rowLD ? $rowLD['level_name'] : '';
                                                                                        
                                                                                        // duplicate query removed; $LevelName already set
                                                                                         /*/
                                                                                         $resultGD = mysqli_query($link, "SELECT `group_time`, `group_teacher`, `group_day`, `group_startday` FROM `group`  WHERE group_id = $GroupId");
                                                                                         $rowGD = mysqli_fetch_array($resultGD);

                                                                                         $GroupTime  = $rowGD['group_time'];
                                                                                         $GroupTeNa  = $rowGD['group_teacher'];
                                                                                         $GroupStar  = $rowGD['group_startday'];
                                                                                         $GroupCreaD = $rowGD['group_C_date'];
                                                                                         /*/
                                                                                        $x = $x +1 ;
                                                                                        ?>
                                                                                        <tr>
                                                                                            <th><center><?php echo $x;?></center></th>
                                                                                            <th><?php echo htmlspecialchars(StudentName($StudentID));?></th>
                                                                                            <th><?php echo htmlspecialchars($StudentFirstPhone);?></th>
                                                                                            <th><?php echo htmlspecialchars($LevelName);?></th>
                                                                                            <th><center><?php echo htmlspecialchars($FreezeDate);?></center></th>

                                                                                        </tr>
                                                                                        <?php
                                                                                    }} ?>

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
                                    <div class="extra">
                                        <div class="extra-inner">
                                            <div class="container">
                                                <div class="row"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="footer">
                                        <div class="footer-inner">
                                            <div class="container">
                                            <div class="row">
                                                <div class="span12">&copy; 2015 <a href='http://cafavalley.comoj.com/'>Cafavalley</a></div>
                                            </div>
                                            </div>
                                        </div>
                                    </div>
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
