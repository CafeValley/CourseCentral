<?php
require_once "config.php";
require_once "MainBarAfterLoginIn.php";
maincheck("reportshowunactive");
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
                            <h3>Unactive Groups</h3>
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
                                                                                            <th><center>No</center></th>
                                                                                            <th><center>Level Name</center></th>
                                                                                            <th><center>Group Time</center></th>
                                                                                            <th><center>Teacher Name</center></th>
                                                                                            <th><center>Day</center></th>
                                                                                            <th><center>Starting Date</center></th>
                                                                                            <th><center>Created on</center></th>

                                                                                        </tr>
                                                                                        </thead>
                                                                                        <tbody>
                                                                                        <?php

                                                                                        $resultGRR = mysqli_query($link, "SELECT `group_id`, `level_id`, `group_time`, `group_teacher`, `group_day`, `group_startday`, `group_C_date`, `feesforgroup`, `feesforbookgroup` FROM `groupunactive` ");
                                                                                        $x = 0;
                                                                                        while($rowGRR = mysqli_fetch_array($resultGRR))
                                                                                        {
                                                                                            $LevelId = $rowGRR['level_id'];
                                                                                            $resultLN = mysqli_query($link, "SELECT `level_name` FROM `levels` WHERE Level_id = $LevelId");
                                                                                            $rowLN = mysqli_fetch_array($resultLN);
                                                                                            $LevelName  = $rowLN['level_name'];
                                                                                            $GroupTime  = $rowGRR['group_time'];
                                                                                            $GroupTeNa  = $rowGRR['group_teacher'];

                                                                                            if ($rowGRR['group_day'] == "e")
                                                                                                $GroupDay = "Even";
                                                                                            if ($rowGRR['group_day']==  "d")
                                                                                                $GroupDay = "Odd" ;
                                                                                            if ($rowGRR['group_day']== "o")
                                                                                                $GroupDay = "Other";

                                                                                            $GroupStar  = $rowGRR['group_startday'];
                                                                                            $GroupCreaD = $rowGRR['group_C_date'];
                                                                                            $x = $x +1 ;
                                                                                            ?>
                                                                                            <tr>
                                                                                                <th><center><?php echo $x;?></center></th>
                                                                                                <th><center><?php echo $LevelName;?></center></th>
                                                                                                <th><center><?php echo $GroupTime;?></center></th>
                                                                                                <th><center><?php echo $GroupTeNa;?></center></th>
                                                                                                <th><center><?php echo $GroupDay;?></center></th>
                                                                                                <th><center><?php echo $GroupStar;?></center></th>
                                                                                                <th><center><?php echo $GroupCreaD;?></center></th>
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
