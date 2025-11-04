<?php
require_once "config.php";
require_once "MainBarAfterLoginIn.php";
maincheckRegis("ReportOfPaymentOfSDate");
//here is to solove it later on !
//(select regis_id, 'Regis' as type, regis_date as dt from registration where DATE (regis_date) = '2017-10-28')
if (isset($_POST['AfterDate'])) {

    list($Pday, $Pmonth,$Pyear ) = explode(" ", $_POST['PostedDate']);
    // echo  $Pday." ".$Pmonth." ".$Pyear ;

    $Postmonth = MonthToNumber($Pmonth);
    if ($Postmonth < 10)
        $Postmonth = "0".$Postmonth;


    $PostedDate =  $Pyear."-".$Postmonth."-".$Pday;
    $PostedDisplayedDate = $Pday."/".$Postmonth."/".$Pyear;

    if ($today <= $PostedDate) {
        echo "Sorry We cant get the future data ";
    }else {
        $today = $PostedDate;
    }
}

$QueryAllDataTimeOrdered = "(select regis_id, 'Regis' as type, regis_date as dt from registration where DATE(regis_date) = '$today' )
    union (SELECT `payment_id` , 'Payment2' as type, `P_created_date` as dt FROM `paymenttwo` where DATE(P_created_date)  = '$today' )
    union (SELECT `Freeze_id` , 'Freeze' as type, `F_created_date` as dt FROM `freeze` where DATE(F_created_date)  = '$today' )
    union (SELECT `s_id` , 'Student' as type, `S_date_On` as dt FROM `student` where DATE(S_date_On) = '$today')
    union (SELECT `payment_id` , 'Paymentttf' as type, `P_created_date` as dt FROM `paymentttf` where DATE(P_created_date) = '$today' )
    order by dt ASC";
$CheckAllDataTimeOrdered = mysqli_query($link, $QueryAllDataTimeOrdered);

$HolderOfAll  = array();
$numberOfEntry = 0;

if ($CheckAllDataTimeOrdered instanceof mysqli_result) while ($ReturnAllDataTimeOrdered   = mysqli_fetch_array ($CheckAllDataTimeOrdered))
{
    if ($ReturnAllDataTimeOrdered['type'] == "Regis")
    {
        $regisID = (int)$ReturnAllDataTimeOrdered['regis_id'];
        $sqlRin = "select level_id,`paid_fees`, `discount`, `st_id` from registration 
                   where regis_id = $regisID";
        $RetRegis = mysqli_query($link, $sqlRin);
        $FetchRetRegis   = ($RetRegis instanceof mysqli_result) ? mysqli_fetch_array ($RetRegis) : null;

        //here for the early fees or /for the penalty fees
        $sqlEarly = "SELECT `EFH_id`, `Regis_id`, `type`, `Amount`, `WhenEFH` FROM `extra_fees_holder`  
                   where Regis_id = $regisID";
        $RetEarly = mysqli_query($link, $sqlEarly);
        $FetchRetEarly   = ($RetEarly instanceof mysqli_result) ? mysqli_fetch_array ($RetEarly) : null;
        $ExFee = 0;
        if ($FetchRetEarly && isset($FetchRetEarly['type']))
        switch ($FetchRetEarly['type'])
        {
            /*/
            case "Early" :
                $ExFee = $FetchRetEarly['Amount'];
                break;
            /*/
        case "Penalty":
            $ExFee = $FetchRetEarly['Amount'];
        break;

        default:
            $ExFee = 0;
        }


        $sqlBookFees = "SELECT `level_book`FROM `levels` WHERE `Level_id` =".($FetchRetRegis ? (int)$FetchRetRegis['level_id'] : 0)." ";
        $RetBookFees = mysqli_query($link, $sqlBookFees);
        $FetchRetBookFees   = ($RetBookFees instanceof mysqli_result) ? mysqli_fetch_array ($RetBookFees) : null;

        $cashSPayed = ($FetchRetRegis ? (int)$FetchRetRegis['paid_fees'] : 0) - ($FetchRetBookFees ? (int)$FetchRetBookFees['level_book'] : 0);;

        $discountvalue = discountfromnametonumber($FetchRetRegis ? $FetchRetRegis['discount'] : 0);

        $HolderOfAll[$numberOfEntry]["Name"] = $FetchRetRegis ? StudentName1to2($FetchRetRegis['st_id']) : '';
        $HolderOfAll[$numberOfEntry]["1st"] = CalaDiscount($cashSPayed , $discountvalue) + $ExFee;
        $HolderOfAll[$numberOfEntry]["2st"] = 0;
        $HolderOfAll[$numberOfEntry]["book"]= $FetchRetBookFees ? (int)$FetchRetBookFees['level_book'] : 0;
        $HolderOfAll[$numberOfEntry]["Freeze"]= 0;
        $HolderOfAll[$numberOfEntry]["discount"]= $discountvalue;
        $HolderOfAll[$numberOfEntry]["Regis_fees"]= 0;
        $HolderOfAll[$numberOfEntry]["Pace_testif"]= 0;
        $HolderOfAll[$numberOfEntry]["Pace_cert"]= 0;

        $numberOfEntry = $numberOfEntry + 1 ;
    }

    if ($ReturnAllDataTimeOrdered['type'] == "Student")
    {
        $regisID = (int)$ReturnAllDataTimeOrdered['regis_id'];
        $sqlStud = "SELECT `s_id` , `S_Regis_Fees`, `ST_Gid` FROM `student` 
                   WHERE s_id = $regisID";
        $RetStud = mysqli_query($link, $sqlStud);
        $FetchRetStud   = ($RetStud instanceof mysqli_result) ? mysqli_fetch_array ($RetStud) : null;

        $HolderOfAll[$numberOfEntry]["Name"] = $FetchRetStud ? StudentName1to2($FetchRetStud['ST_Gid']) : '';
        $HolderOfAll[$numberOfEntry]["1st"] = 0;
        $HolderOfAll[$numberOfEntry]["2st"] = 0;
        $HolderOfAll[$numberOfEntry]["book"]= 0;
        $HolderOfAll[$numberOfEntry]["Freeze"]= 0;
        $HolderOfAll[$numberOfEntry]["discount"]= 0;
        $HolderOfAll[$numberOfEntry]["Regis_fees"]= $FetchRetStud ? (int)$FetchRetStud['S_Regis_Fees'] : 0;
        $HolderOfAll[$numberOfEntry]["Pace_testif"]= 0;
        $HolderOfAll[$numberOfEntry]["Pace_cert"]= 0;

        $numberOfEntry = $numberOfEntry + 1 ;
    }

        if ($ReturnAllDataTimeOrdered['type'] == "Payment2")
        {
            $regisID = (int)$ReturnAllDataTimeOrdered['regis_id'];
            $sqlPay2 = "SELECT `payment_id`, `s_id` , `payment` FROM `paymenttwo`  
                        WHERE payment_id = $regisID";
            $RetPay2 = mysqli_query($link, $sqlPay2);
            $FetchRetPay2   = ($RetPay2 instanceof mysqli_result) ? mysqli_fetch_array ($RetPay2) : null;

            $HolderOfAll[$numberOfEntry]["Name"] = $FetchRetPay2 ? StudentName1to2($FetchRetPay2['s_id']) : '';
            $HolderOfAll[$numberOfEntry]["1st"] = 0;
            $HolderOfAll[$numberOfEntry]["2st"] = $FetchRetPay2 ? (int)$FetchRetPay2['payment'] : 0;
            $HolderOfAll[$numberOfEntry]["book"]= 0;
            $HolderOfAll[$numberOfEntry]["Freeze"]= 0;
            $HolderOfAll[$numberOfEntry]["discount"]= 0;
            $HolderOfAll[$numberOfEntry]["Regis_fees"]= 0;
            $HolderOfAll[$numberOfEntry]["Pace_testif"]= 0;
            $HolderOfAll[$numberOfEntry]["Pace_cert"]= 0;

            $numberOfEntry = $numberOfEntry + 1 ;
        }
        if ($ReturnAllDataTimeOrdered['type'] == "Freeze")
        {
        $regisID = (int)$ReturnAllDataTimeOrdered['regis_id'];
        $sqlFreez = "SELECT `s_id` , `Freeze_fees` FROM `freeze` 
                   WHERE Freeze_id = $regisID";
        $RetFreez = mysqli_query($link, $sqlFreez);
        $FetchRetFreez   = ($RetFreez instanceof mysqli_result) ? mysqli_fetch_array ($RetFreez) : null;

        $HolderOfAll[$numberOfEntry]["Name"] = $FetchRetFreez ? StudentName1to2($FetchRetFreez['s_id']) : '';
        $HolderOfAll[$numberOfEntry]["1st"] = 0;
        $HolderOfAll[$numberOfEntry]["2st"] = 0;
        $HolderOfAll[$numberOfEntry]["book"]= 0;
        $HolderOfAll[$numberOfEntry]["Freeze"]= $FetchRetFreez ? (int)$FetchRetFreez['Freeze_fees'] : 0;
        $HolderOfAll[$numberOfEntry]["discount"]= 0;
        $HolderOfAll[$numberOfEntry]["Regis_fees"]= 0;
        $HolderOfAll[$numberOfEntry]["Pace_testif"]= 0;
        $HolderOfAll[$numberOfEntry]["Pace_cert"]= 0;

        $numberOfEntry = $numberOfEntry + 1 ;
        }
        if ($ReturnAllDataTimeOrdered['type'] == "Paymentttf")
        {

        $regisID = (int)$ReturnAllDataTimeOrdered['regis_id'];
        $sqlPayttf = "SELECT `Studentname` , `type` , `Fees` FROM `paymentttf` 
                   WHERE payment_id = $regisID";
        $RetPayttf = mysqli_query($link, $sqlPayttf);
        $FetchRetPayttf   = ($RetPayttf instanceof mysqli_result) ? mysqli_fetch_array ($RetPayttf) : null;

        $HolderOfAll[$numberOfEntry]["Name"] = $FetchRetPayttf ? $FetchRetPayttf['Studentname'] : '';
        $HolderOfAll[$numberOfEntry]["1st"] = 0;
        $HolderOfAll[$numberOfEntry]["2st"] = 0;
        $HolderOfAll[$numberOfEntry]["book"]= 0;
        $HolderOfAll[$numberOfEntry]["Freeze"]= 0;
        $HolderOfAll[$numberOfEntry]["discount"]= 0;
        $HolderOfAll[$numberOfEntry]["Regis_fees"]= 0;
            
            if ($FetchRetPayttf && isset($FetchRetPayttf['type'])) switch($FetchRetPayttf['type'])
            {
                case "PorT":
                    $HolderOfAll[$numberOfEntry]["Pace_testif"]= (int)$FetchRetPayttf['Fees'];
                    $HolderOfAll[$numberOfEntry]["Pace_cert"]= 0;
                    break;
                case "Cert":
                    $HolderOfAll[$numberOfEntry]["Pace_testif"]= 0;
                    $HolderOfAll[$numberOfEntry]["Pace_cert"]= (int)$FetchRetPayttf['Fees'];
                    break;
                default:
                    $HolderOfAll[$numberOfEntry]["Pace_testif"]= 0;
                    $HolderOfAll[$numberOfEntry]["Pace_cert"]= 0;
            }
            $numberOfEntry = $numberOfEntry + 1 ;
        }
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
                            <i class="icon-money"></i>
                            <h3>Past Date Payment</h3>
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
                                                                <form action = "ReportOfPaymentOfSelectedDate.php" method = "POST">
                                                                <!--
                                                                **********************************
                                                                Here for the for input
                                                                **********************************
                                                                -->
                                                                <div class="widget-content">
                                                                    <div class="tabbable">
                                                                        <div class="tab-content">
                                                                            <div class="tab-pane active" id="jscontrols">
                                                                                <form action="ReportOfPaymentOfSelectedDate.php.php" method="POST">
                                                                                    <div class="input-group date form_date col-md-5" data-date="" data-date-format="dd MM yyyy" data-link-field="dtp_input2" data-link-format="yyyy-mm-dd">
                                                                                        <input class="form-control" name = "PostedDate" size="16" type="text" value="" readonly>
                                                                                        <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                                                                                        <?php
                                                                                        if (isset($PostedDate))
                                                                                            echo htmlspecialchars($PostedDisplayedDate);
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
                                                                                            <th><center>1st Installemt</center></th>
                                                                                            <th><center>2nd Installemt</center></th>
                                                                                            <th><center>books</center></th>
                                                                                            <th><center>Freeze</center></th>
                                                                                            <th width = '5%'><center>discount</center></th>
                                                                                            <th width = '8%'><center>Reg. Fees</center></th>
                                                                                            <th width = '5%'><center>Plc/Tes </center></th>
                                                                                            <th><center>Cert</center></th>


                                                                                        </tr>
                                                                                        </thead>
                                                                                        <tbody>
                                                                                        <?php

                                                                                        $x = 0;
                                                                                        $max = $numberOfEntry -1;
                                                                                        $subtotal1st          = 0;
                                                                                        $subtotal2st          = 0;
                                                                                        $subtotalbook         = 0;
                                                                                        $subtotalfreeze       = 0;
                                                                                        $subtotaldiscount     = 0;
                                                                                        $subtotalregisfees    = 0;
                                                                                        $subtotalplace_testif = 0;
                                                                                        $subtotalpace_cert    = 0;
                                                                                        while ($x <= $max)
                                                                                        {
                                                                                            echo "<tr><th><center>". ($x+1)."</center></th>";
                                                                                            echo "<th>".htmlspecialchars($HolderOfAll[$x]['Name'])."</th>";
                                                                                            echo "<th><center>".(int)$HolderOfAll[$x]['1st']."</center></th>";
                                                                                            echo "<th><center>".(int)$HolderOfAll[$x]['2st']."</center></th>";
                                                                                            echo "<th><center>".(int)$HolderOfAll[$x]['book']."</center></th>";
                                                                                            echo "<th><center>".(int)$HolderOfAll[$x]['Freeze']."</center></th>";
                                                                                            if (isset($HolderOfAll[$x]['discount']))
                                                                                                echo "<th><center>".(int)$HolderOfAll[$x]['discount']."</center></th>";
                                                                                            else
                                                                                                echo "<th><center>0%</center></th>";
                                                                                            echo "<th><center>".(int)$HolderOfAll[$x]['Regis_fees']."</center></th>";
                                                                                            echo "<th><center>".(int)$HolderOfAll[$x]['Pace_testif']."</center></th>";
                                                                                            echo "<th><center>".(int)$HolderOfAll[$x]['Pace_cert']."</center></th>";
                                                                                            echo"</tr>";
                                                                                            $subtotal1st          += (int)$HolderOfAll[$x]['1st'];
                                                                                            $subtotal2st          += (int)$HolderOfAll[$x]['2st'];
                                                                                            $subtotalbook         += (int)$HolderOfAll[$x]['book'];
                                                                                            $subtotalfreeze       += (int)$HolderOfAll[$x]['Freeze'];
                                                                                            $subtotaldiscount     += (int)$HolderOfAll[$x]['discount'];
                                                                                            $subtotalregisfees    += (int)$HolderOfAll[$x]['Regis_fees'];
                                                                                            $subtotalplace_testif += (int)$HolderOfAll[$x]['Pace_testif'];
                                                                                            $subtotalpace_cert    += (int)$HolderOfAll[$x]['Pace_cert'];
                                                                                            $x = $x + 1;
                                                                                        }
                                                                                        echo "<tr>";
                                                                                        echo "<th><center></center></th>";
                                                                                        echo "<th><center>Total</center></th>";
                                                                                        echo "<th><center>".number_format($subtotal1st, 0)."</center></th>";
                                                                                        echo "<th><center>".number_format($subtotal2st, 0)."</center></th>";
                                                                                        echo "<th><center>".number_format($subtotalbook, 0)."</center></th>";
                                                                                        echo "<th><center>".number_format($subtotalfreeze, 0)."</center></th>";
                                                                                        echo "<th><center></center></th>";
                                                                                        echo "<th><center>".number_format($subtotalregisfees, 0)."</center></th>";
                                                                                        echo "<th><center>".number_format($subtotalplace_testif, 0)."</center></th>";
                                                                                        echo "<th><center>".number_format($subtotalpace_cert, 0)."</center></th>";
                                                                                        echo"</tr>";
                                                                                        $totalwith    = $subtotal1st + $subtotal2st + $subtotalbook + $subtotalfreeze + $subtotalregisfees + $subtotalplace_testif + $subtotalpace_cert;
                                                                                        $totalwithout = $subtotal1st + $subtotal2st  + $subtotalfreeze + $subtotalregisfees + $subtotalplace_testif + $subtotalpace_cert;;

                                                                                        echo "</table>";

                                                                                        echo "<table class='table table-striped table-bordered'>";
                                                                                        echo "<thead><th>Expenses:</th><th>Amount</th></thead>";
                                                                                        $expemsesTotal = 0 ;
                                                                                        $Resuexpenses = mysqli_query($link, "SELECT `expenses_name`, `expenses_cost` FROM `expenses` WHERE  DATE(expenses_date) = '$today'");
                                                                                        echo "<tr>";
                                                                                        if ($Resuexpenses instanceof mysqli_result) while ($rawexpenses    = mysqli_fetch_array($Resuexpenses))
                                                                                        {
                                                                                            echo "<td>";
                                                                                            echo htmlspecialchars($rawexpenses['expenses_name']);
                                                                                            echo "</td><td>";
                                                                                            echo (int)$rawexpenses['expenses_cost'];
                                                                                            $expemsesTotal += (int)$rawexpenses['expenses_cost'];
                                                                                            echo "</td>";
                                                                                            echo "</tr>";
                                                                                        }
                                                                                        echo "<tr><td>Total</td><td>";
                                                                                        echo number_format($expemsesTotal, 0);
                                                                                        echo "</td></tr></table>";

                                                                                        echo "<table class='table table-striped table-bordered'>";
                                                                                        echo "<tr>";
                                                                                        //here to hold the vaules for the
                                                                                        //total without the expensese
                                                                                        $totalimage    = $totalwith;
                                                                                        $totalwithoutimage = $totalwithout;


                                                                                        //here to subtruck ^^
                                                                                        //..
                                                                                        //and have to final total
                                                                                        //of the Cash !
                                                                                        $totalwith    -= $expemsesTotal;
                                                                                        $totalwithout -= $expemsesTotal;

                                                                                        echo "<th width = '20%'><center>Grand Total Without Expenses</center></th>";
                                                                                        echo "<th><center>".number_format($totalimage, 0)."</center></th>";
                                                                                        echo "<th width = '20%'><center>Grand Total without Books or Expenses</center></th>";
                                                                                        echo "<th><center>".number_format($totalwithoutimage, 0)."</center></th>";
                                                                                        echo "<tr>";
                                                                                        echo "<th width = '20%'><center>Grand Total</center></th>";
                                                                                        echo "<th><center>".number_format($totalwith, 0)."</center></th>";
                                                                                        echo "<th width = '20%'><center>Grand Total without Books</center></th>";
                                                                                        echo "<th><center>".number_format($totalwithout, 0)."</center></th>";

                                                                                        echo"</tr>";
                                                                                        echo "<tr>";

                                                                                        //here will display the array
                                                                                            ?>

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
