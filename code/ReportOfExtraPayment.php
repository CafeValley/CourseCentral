<?php
require_once "config.php";
require_once "MainBarAfterLoginIn.php";
maincheck("ReportOfPaymentOfToday");


if (isset($_POST['AfterDate'])) {

    list($Pday, $Pmonth,$Pyear ) = explode(" ", $_POST['PostedDate']);
    // echo  $Pday." ".$Pmonth." ".$Pyear ;

    $Postmonth = MonthToNumber($Pmonth);
    if ($Postmonth < 10)
        $Postmonth = "0".$Postmonth;


    $PostedDate =  $Pyear."-".$Postmonth."-".$Pday;
    $PostedDisplayedDate = $Pday."/".$Postmonth."/".$Pyear;

  
	
	
	   list($Pday2, $Pmonth2,$Pyear2 ) = explode(" ", $_POST['PostedDate2']);
    // echo  $Pday." ".$Pmonth." ".$Pyear ;

    $Postmonth2 = MonthToNumber($Pmonth2);
    if ($Postmonth2 < 10)
        $Postmonth2 = "0".$Postmonth2;


    $PostedDate2 =  $Pyear2."-".$Postmonth2."-".$Pday2;
    $PostedDisplayedDate2 = $Pday2."/".$Postmonth2."/".$Pyear2;

  
}





 echo $QueryAllDataTimeOrdered = "select `Studentname` , `Fees` , `type` , DATE(P_created_date) as Datein FROM paymentttf where `type` = 'dele' and DATE(P_created_date) between '$PostedDate' and '$PostedDate2' 
    order by P_created_date ASC";
$CheckAllDataTimeOrdered = mysqli_query($link, $QueryAllDataTimeOrdered);

$HolderOfAll  = array();
$numberOfEntry = 0;

while ($ReturnAllDataTimeOrdered   = mysqli_fetch_array ($CheckAllDataTimeOrdered))
{
	$HolderOfAll[$numberOfEntry]["Name"] = $ReturnAllDataTimeOrdered['Studentname'];  
		   switch($ReturnAllDataTimeOrdered['type'])
            {
                case "PorT":
                    $HolderOfAll[$numberOfEntry]["Pace_testif"]= $ReturnAllDataTimeOrdered['Fees'];
                    $HolderOfAll[$numberOfEntry]["Pace_cert"]= 0;
                    break;
                case "Cert":
                    $HolderOfAll[$numberOfEntry]["Pace_testif"]= $ReturnAllDataTimeOrdered['Fees'];
                    $HolderOfAll[$numberOfEntry]["Pace_cert"]= 0;
                    break;
				case "dele":
                    $HolderOfAll[$numberOfEntry]["Pace_testif"]= 0;
                    $HolderOfAll[$numberOfEntry]["Pace_cert"]= $ReturnAllDataTimeOrdered['Fees'];
                    break;
                default:
                    $HolderOfAll[$numberOfEntry]["Pace_testif"]= 0;
                    $HolderOfAll[$numberOfEntry]["Pace_cert"]= 0;
            }
       
$HolderOfAll[$numberOfEntry]["Datein"] = $ReturnAllDataTimeOrdered['Datein'];
 $numberOfEntry = $numberOfEntry + 1 ;
}

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
                            <i class="icon-book"></i>
                            <h3>Dele Exam</h3>
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
                                                              <?php echo $Tday."/".$Tmonth."/".$Tyear;?>
                                                                <!--
                                                                **********************************
                                                                Here for the for input
                                                                **********************************
                                                                -->
                                                                <div class="widget-content">
                                                                    <div class="tabbable">
                                                                        <div class="tab-content">
                                                                            <div class="tab-pane active" id="jscontrols">
                                                                                <form action="ReportOfExtraPayment.php" method="POST">
                                                                                    From:<div class="input-group date form_date col-md-5" data-date="" data-date-format="dd MM yyyy" data-link-field="dtp_input2" data-link-format="yyyy-mm-dd">
                                                                                        <input class="form-control" name = "PostedDate" size="16" type="text" value="" readonly>
                                                                                        <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                                                                                        <?php
                                                                                        if (isset($PostedDate))
                                                                                            echo $PostedDisplayedDate;
                                                                                        ?>
                                                                                    </div>
																					
																					 To:<div class="input-group date form_date col-md-5" data-date="" data-date-format="dd MM yyyy" data-link-field="dtp_input2" data-link-format="yyyy-mm-dd">
                                                                                        <input class="form-control" name = "PostedDate2" size="16" type="text" value="" readonly>
                                                                                        <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                                                                                        <?php
                                                                                        if (isset($PostedDate2))
                                                                                            echo $PostedDisplayedDate2;
                                                                                        ?>
                                                                                    </div>

                                                                                        <input type="submit" name="AfterDate" class="btn btn-primary"  value="Display"/>

                                                                                </form>
																				
                                                                                    <?php
                                                                                    /*
                                                                                    here to puf data in the form
                                                                                    */
                                                                                    ?>
                                                                                    <table class="table table-striped table-bordered">
                                                                                        <thead>
                                                                                        <tr>
                                                                                            <th width = '3%'><center>No</center></th>
                                                                                            <th width = '20%'>Name</th>
                                                                                            <th><center>Dele</center></th>
                                                                                            <th><center>Date</center></th>


                                                                                        </tr>
                                                                                        </thead>
                                                                                        <tbody>
                                                                                        <?php

                                                                                        $x = 0;
                                                                                        $max = $numberOfEntry -1;
                                                                                        $subtotal1st=0;
                                                                                        $subtotal2st=0;
                                                                                        $subtotalbook=0;
                                                                                        $subtotalfreeze=0;
                                                                                        $subtotaldiscount=0;
                                                                                        $subtotalregisfees=0;
                                                                                        $subtotalplace_testif=0;
                                                                                        $subtotalpace_cert=0;
                                                                                        while ($x <= $max)
                                                                                        {
                                                                                            echo "<tr><th><center>". ($x+1)."</center></th>";
                                                                                            echo "<th>".$HolderOfAll[$x]['Name']."</th>";
                                                                                            echo "<th><center>".$HolderOfAll[$x]['Pace_cert']."</center></th>";
                                                                                            echo "<th><center>".$HolderOfAll[$x]['Datein']."</center></th>";
                                                                                            echo"</tr>";
                                                                                            $subtotalpace_cert    += $HolderOfAll[$x]['Pace_cert'];
                                                                                            $x = $x + 1;

                                                                                        }
                                                                                        echo "<tr>";
                                                                                        echo "<th><center></center></th>";
                                                                                        echo "<th><center>Total</center></th>";
                                                                                        echo "<th><center>".number_format($subtotalpace_cert, 0)."</center></th>";
                                                                                        echo"</tr>";
                                                                                        $totalwith    = $subtotal1st + $subtotal2st + $subtotalbook + $subtotalfreeze + $subtotalregisfees + $subtotalplace_testif + $subtotalpace_cert;
                                                                                        $totalwithout = $subtotal1st + $subtotal2st  + $subtotalfreeze + $subtotalregisfees + $subtotalplace_testif + $subtotalpace_cert;;

                                                                                        echo "</table>";

                                                                                      
?>
                                                                                       
                                                                               
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

<script type="text/javascript" src="jquery/jquery-1.8.3.min.js" charset="UTF-8"></script>

<script type="text/javascript" src="bootstrap/js/bootstrap-datetimepicker.js" charset="UTF-8"></script>

<script type="text/javascript">

    $('.form_date').datetimepicker({
        // language:  'fr',
        weekStart: 1,
        todayBtn:  1,
        autoclose: 1,
        todayHighlight: 1,
        startView: 2,
        minView: 2,
        forceParse: 0
    });

</script>
