<?php
require_once "config.php";
require_once "MainBarAfterLoginIn.php";
maincheck("ReportForAllTeacherData");
?>
<?php 

function teachergroupsno($teacher_Id)
{
    global $link;
    $resultSNC = mysqli_query($link, "SELECT count(*) as x FROM `group` where `group_teacher` = '$teacher_Id' ");
    $count = $resultSNC -> num_rows;
    if ($count > 0)
    {
    $rowSNC = mysqli_fetch_array($resultSNC);
    $Fname = $rowSNC['x'];
    return ($Fname);
}
else 
{
    return (0);
}
}
?>
<style type="text/css">
    label {
        display: block;
        line-height: 1.75em;
    }

    input,
    textarea {
        width: 120px;
        display: inline-block;
        margin-bottom: 2em;
        padding: .75em .5em;
        color: #999;
        border: 1px solid #e9e9e9;
        outline: none;
    }

    input:focus,
    textarea:focus {
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
                            <h3>Teachers</h3>
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
                                                                                            <th>
                                                                                                <center>No</center>
                                                                                            </th>
                                                                                            <th>
                                                                                                <center>Teacher Name</center>
                                                                                            </th>
                                                                                            <th>
                                                                                                <center>Teacher Age</center>
                                                                                            </th>
                                                                                            <th>
                                                                                                <center>Teacher Tel</center>
                                                                                            </th>
                                                                                            <th>
                                                                                                <center>Appointed Date</center>
                                                                                            </th>
                                                                                            <th>
                                                                                                <center>Interview Comment </center>
                                                                                            </th>
                                                                                            <th>
                                                                                                <center>Groups</center>
                                                                                            </th>
                                                                                            

                                                                                        </tr>
                                                                                    </thead>
                                                                                    <tbody>
                                                                                        <?php
                                                                                        $resultGRR = false;
                                                                                        try {
                                                                                            $resultGRR = mysqli_query($link, "SELECT `id`, `name`, `name2`, `name3`, `age`, `tel`, `tel2`, `appointeddate`, `interviewcomment`, `whenwasit`, `whodidthis` FROM `teachers` ");
                                                                                        } catch (Throwable $e) {
                                                                                            $resultGRR = false;
                                                                                        }
                                                                                        if (!$resultGRR) {
                                                                                            echo '<tr><td colspan="7"><div class="modern-alert modern-alert-warning">Teachers table is not available.</div></td></tr>';
                                                                                        } else {
                                                                                            $x = 0;
                                                                                            while ($rowGRR = mysqli_fetch_array($resultGRR)) {
                                                                                                $var1  = $rowGRR['id'];
                                                                                                $var2  = $rowGRR['name'];
                                                                                                $var3  = $rowGRR['name2'];
                                                                                                $var4  = $rowGRR['name3'];
                                                                                                $var5  = $rowGRR['age'];
                                                                                                $var6  = $rowGRR['tel'];
                                                                                                $var7  = $rowGRR['tel2'];
                                                                                                $var8  = $rowGRR['appointeddate'];
                                                                                                $var9  = $rowGRR['interviewcomment'];
                                                                                                $x = $x + 1;
                                                                                        ?>
                                                                                            <tr>
                                                                                                <th>
                                                                                                    <center><?php echo $x; ?></center>
                                                                                                </th>
                                                                                                <th>
                                                                                                    <center><?php echo $var2." ".$var3." ".$var4; ?></center>
                                                                                                </th>
                                                                                                <th>
                                                                                                    <center><?php echo $var5; ?></center>
                                                                                                </th>
                                                                                                <th>
                                                                                                    <center><?php echo $var6." - ".$var7; ?></center>
                                                                                                </th>
                                                                                                <th>
                                                                                                    <center><?php echo $var8; ?></center>
                                                                                                </th>
                                                                                                <th>
                                                                                                    <center><?php echo $var9; ?></center>
                                                                                                </th>
                                                                                                <th>
                                                                                                    <center><?php echo teachergroupsno($var1); ?></center>
                                                                                                </th>
                                                                                            </tr>
                                                                                        <?php
                                                                                            }
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
                                            <input type="button" class="btn btn-primary" onclick="printDiv('printableArea')" value="Print!" />
                                        </div> <!-- /form-actions -->
                                    </div>
                                   
                                   
                                  
                                    </body>

                                    </html>

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
<?php require_once "common_scripts.php"; ?>
</body>

</html>
            </div> <!-- /row -->
        </div> <!-- /container -->
    </div> <!-- /footer-inner -->
</div> <!-- /footer -->
</body>

</html>