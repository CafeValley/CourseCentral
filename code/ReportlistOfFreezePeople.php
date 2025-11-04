<?php
require_once "config.php";
require_once "MainBarAfterLoginIn.php";
maincheck("ReportAllFreezeStudents");
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
                                                                <div class="widget-content">
                                                                    <div class="tabbable">
                                                                        <div class="tab-content">
                                                                            <div class="tab-pane active" id="jscontrols">
                                                                                <form action="markentryform.php" method="POST">
                                                                                    <?php
                                                                                    /*
                                                                                    here to puf data in the form
                                                                                    */
                                                                                    ?>
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

                                                                                        $resultGRR = mysqli_query($link, "SELECT `s_id`, `level_id`, `group_id`, `dayleft`, `Freeze_fees`, `status`, `F_created_date` 
                                                                                                                          FROM `freeze` where status = 1 order by `level_id` ");
                                                                                        $x = 0;
                                                                                        while($rowGRR = mysqli_fetch_array($resultGRR))
                                                                                        {

                                                                                            $StudentID = $rowGRR['s_id'];
                                                                                            $LevelId = $rowGRR['level_id'];
                                                                                            $GroupId = $rowGRR['group_id'];
                                                                                            $FreezeDate = $rowGRR['F_created_date'];

                                                                                            $resultSD = mysqli_query($link, "SELECT  `S_phone1` FROM `student` WHERE `ST_Gid`= $StudentID");
                                                                                            $rowSD = mysqli_fetch_array($resultSD);
                                                                                            $StudentFirstPhone  = $rowSD['S_phone1'];


                                                                                            $resultLD = mysqli_query($link, "SELECT `level_name` FROM `levels` WHERE Level_id = $LevelId");
                                                                                            $rowLD = mysqli_fetch_array($resultLD);
                                                                                            $LevelName  = $rowLD['level_name'];

                                                                                            $resultLD = mysqli_query($link, "SELECT `level_name` FROM `levels` WHERE Level_id = $LevelId");
                                                                                            $rowLD = mysqli_fetch_array($resultLD);
                                                                                            $LevelName  = $rowLD['level_name'];
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
                                                                                                <th><?php echo StudentName($StudentID);?></th>
                                                                                                <th><?php echo $StudentFirstPhone;?></th>
                                                                                                <th><?php echo $LevelName;?></th>
                                                                                                <th><center><?php echo $FreezeDate;?></center></th>

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
